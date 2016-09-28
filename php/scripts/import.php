<?php
############################################################################
#	import.php
#
#	Tim Traver
#	2/23/15
#	This is the script to handle importing of events
#
############################################################################
$GLOBALS['current_menu']='import';

include_library("event.class");

if(isset($_REQUEST['function']) && $_REQUEST['function']!='') {
	$function=$_REQUEST['function'];
}else{
	$function="import_view";
}

$need_login=array(
	"import_view",
	"import_verify",
	"import_import"
);
if(check_user_function($function)){
	if($GLOBALS['user_id']==0 && in_array($function, $need_login)){
		# The user is not logged in, so send the feature template
		user_message("Sorry, but you must be logged in as a user to use this feature.",1);
		$smarty->assign("redirect_action",$_REQUEST['action']);
		$smarty->assign("redirect_function",$_REQUEST['function']);
		$smarty->assign("request",$_REQUEST);
		$maintpl=find_template("feature_requires_login.tpl");
		$actionoutput=$smarty->fetch($maintpl);
	}else{
		# They are allowed
		eval("\$actionoutput=$function();");
	}
}else{
	 $actionoutput= show_no_permission();
}

function import_view() {
	global $user;
	global $smarty;
	
	$event_id=intval($_REQUEST['event_id']);
	$event=array();
	if($event_id!=0){
		$event=New Event();
	}
	$smarty->assign("event",$event);
	$smarty->assign("event_types",$event_types);
	$maintpl=find_template("import/import_view.tpl");
	return $smarty->fetch($maintpl);
}
function import_verify() {
	global $smarty;

	$event=array();
	$event_id=intval($_REQUEST['event_id']);
	if(isset($_FILES['import_file'])){
		$import_file=$_FILES['import_file']['tmp_name'];
	}
	# If they sent it directly as content instead of an uploaded file
	if(isset($_REQUEST['file_contents'])){
		# Write out the file
		# First lets base64 decode it
		$contents=base64_decode($_REQUEST['file_contents']);
		$name=sha1($contents);
		$handle=fopen("/tmp/$name", 'w');
		fwrite($handle,$contents);
		fclose($handle);
		$import_file="/tmp/$name";
	}
	if($import_file==''){
		return import_view();
	}
	if(isset($_REQUEST['field_separator']) && $_REQUEST['field_separator']!=''){
		$field_separator=$_REQUEST['field_separator'];
	}else{
		$field_separator=',';
	}
	if(isset($_REQUEST['decimal_type']) && $_REQUEST['decimal_type']!=''){
		$decimal_type=$_REQUEST['decimal_type'];
	}else{
		$decimal_type='.';
	}

	# Lets import the file lines using the csv method
	$lines=array();
	$file = new SplFileObject($import_file);
	$file->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);
	$file->setCsvControl($field_separator);
	$l=1;
	while (!$file->eof()) {
		$temparray=$file->fgetcsv();
		if($temparray){
			$lines[$l]=$temparray;
		}
		$l++;
	}
	$file = null;
	
	$line=1;
	$event_id=$lines[$line][0];
	$event_name=$lines[$line][1];
	$event_start_date=$lines[$line][2];
	$event_end_date=$lines[$line][3];
	$event_type_name=$lines[$line][4];
		
	# Lets set the dates to a usable format
	# Lets replace the date dashes with slashes so strtotime works
	$event_start_date=preg_replace("/\-/", '/', $event_start_date);
	$event_end_date=preg_replace("/\-/", '/', $event_end_date);	
	$event_start_date=date("Y-m-d H:i:s",strtotime($event_start_date));
	$event_end_date=date("Y-m-d H:i:s",strtotime($event_end_date));
	# Lets check if this event exists if they sent an event id
	if($event_id!=0){
		# This is an existing event that we are importing in to
		# Lets first see if it even exists
		$stmt=db_prep("
			SELECT *
			FROM event e
			LEFT JOIN location l ON e.location_id=l.location_id
			WHERE e.event_id=:event_id
		");
		$result=db_exec($stmt,array("event_id"=>$event_id));
		if(!isset($result[0])){
			# Event does not exist
			$event_id=0;
		}else{
			$e=$result[0];
		}
	}
	if($event_id==0){
		# Lets check to make sure there isn't an event with the exact name and dates, and use its id
		$stmt=db_prep("
			SELECT *
			FROM event e
			LEFT JOIN location l ON e.location_id=l.location_id
			WHERE e.event_name=:event_name
		");
		$result=db_exec($stmt,array(
			"event_name"=>$event_name
		));
		if(isset($result[0])){
			$event_id=$result[0]['event_id'];
			$e=$result[0];
		}
	}
	
	# Lets check for permission by this user to edit the event if the event exists
	if($event_id!=0){
		# Check the user access
		if(check_event_permission($event_id)==0){
			user_message("You do not have permissions to import over this existing event. You must be the original creator, or the CD, or have been given admin access to this event.",1);
			return import_view();
		}
	}
	
	# Lets get the event type id
	$event_type_code='';
	$f3f_group=0;
	if($event_type_name!=''){
		if($event_type_name == 'F3K Multi Task'){
			$event_type_name = 'f3k';
		}
		if($event_type_name == 'f3f_group'){
			$event_type_name = 'f3f';
			$f3f_group=1;
		}
		$stmt=db_prep("
			SELECT *
			FROM event_type
			WHERE event_type_name=:event_type_name
				OR event_type_code=:event_type_code
		");
		$result=db_exec($stmt,array("event_type_name"=>$event_type_name,"event_type_code"=>$event_type_name));
		if(!isset($result[0])){
			$event_type_id=0;
		}else{
			$event_type_id=$result[0]['event_type_id'];
			$event_type_code=$result[0]['event_type_code'];
			$event_type_name=$result[0]['event_type_name'];
		}
	}
	if($event_type_code == ''){
		# Didn't find the event type
		user_message("Event type code was not found. Make sure that in the first line of the export that the event type code is correct.",1);
		return import_view();
	}
	
	# Get classes to choose for the pilots
	$stmt=db_prep("
		SELECT *
		FROM class
		ORDER BY class_view_order
	");
	$result=db_exec($stmt,array());
	foreach($result as $row){
		$class_name=$row['class_name'];
		$classes[$class_name]=$row;
	}
	$smarty->assign("classes",$classes);
	
	# Spit out the results to review
	if($event_type_code=='f3k'){
		# Lets get all the flight types and the round types
		$stmt=db_prep("
			SELECT *
			FROM flight_type
			WHERE flight_type_code LIKE :flight_type_code
		");
		$result=db_exec($stmt,array("flight_type_code"=>$event_type_code."%"));
		foreach($result as $row){
			$flight_type_code=$row['flight_type_code'];
			$flight_types[$flight_type_code]=$row;
		}
		# Lets read in the second line which are the round designations
		$line++;
		$x=1;
		$rounds=array();
		foreach($lines[$line] as $r){
			$rounds[$x]=$flight_types[$r];
			$x++;
		}
	}elseif($event_type_code=='f3j' || $event_type_code=='td'){
		# Lets get all the flight types and the round types
		$stmt=db_prep("
			SELECT *
			FROM flight_type
			WHERE flight_type_code LIKE :flight_type_code
		");
		$result=db_exec($stmt,array("flight_type_code"=>$event_type_code."%"));
		foreach($result as $row){
			$flight_type_code=$row['flight_type_code'];
			$flight_types[$flight_type_code]=$row;
		}
		# Lets read in the second line which are the round target times
		$line++;
		$x=1;
		$rounds=array();
		foreach($lines[$line] as $r){
			if($r!=''){
				$rounds[$x]=array_merge($flight_types[$flight_type_code],array("target"=>$r));
				$x++;
			}
		}
	}else{
		# Lets get the flight types for this discipline
		$stmt=db_prep("
			SELECT *
			FROM flight_type
			WHERE flight_type_code LIKE :flight_type_code
			ORDER BY flight_type_order
		");
		$result=db_exec($stmt,array("flight_type_code"=>$event_type_code."%"));
		foreach($result as $row){
			$flight_type_code=$row['flight_type_code'];
			if($f3f_group == 1){
				$row['flight_type_group'] = 1;
			}
			$flight_types[$flight_type_code]=$row;
		}
	}
	$pilots=array();
	$line++;
	for($l=$line;$l<=count($lines);$l++){
		$temp_pilot=array();
		$temp_pilot['pilot_id']=$lines[$l][0];
		$temp_pilot['pilot_name']=$lines[$l][1];
		$temp_pilot['pilot_class']=$lines[$l][2];
		$temp_pilot['pilot_freq']=$lines[$l][3];
		$temp_pilot['pilot_team']=$lines[$l][4];
		$x=5;
		$r=1;
		if($temp_pilot['pilot_name'] == ''){
			continue;
		}
		$temp_rounds=array();
		while(isset($lines[$l][$x])){
			switch($event_type_code){
				case 'f3b':
					# F3b 3 rounds in one
					
					break;
				case 'f3f':
					# F3F Flights
					if($f3f_group == 1){
						$temp_rounds[$r]['group']=$lines[$l][$x];
						$x++;
					}else{
						$temp_rounds[$r]['group']='';
					}
					$temp_rounds[$r]['flights']['sub'][1]=$lines[$l][$x];
					$x++;
					$temp_rounds[$r]['penalty']=$lines[$l][$x];
					$x++;
					break;
				case 'f3j':
					# F3J special fields
					$temp_rounds[$r]['group']=$lines[$l][$x];
					$x++;
					$temp_rounds[$r]['min']=$lines[$l][$x];
					$x++;
					$temp_rounds[$r]['sec']=$lines[$l][$x];
					$x++;
					$temp_rounds[$r]['land']=$lines[$l][$x];
					$x++;
					if($lines[$l][$x] != '' && $lines[$l][$x] != 0){
						$temp_rounds[$r]['over']=1;
					}else{
						$temp_rounds[$r]['over']=0;
					}
					$x++;
					$temp_rounds[$r]['penalty']=$lines[$l][$x];
					$x++;
					break;
				case 'f3k':
					# F3K subflights for this round
					$temp_rounds[$r]['group']=$lines[$l][$x];
					$x++;
					# Read in all the subflights
					for($y=1;$y<=$rounds[$r]['flight_type_sub_flights'];$y++){
						if(preg_match("/\:/",$lines[$l][$x])){
							# It has a colon in it already so its in colon notation
							$temp_rounds[$r]['flights']['sub'][$y]=$lines[$l][$x];
						}else{
							# It is in full seconds, so convert it to colon notation
							$temp_rounds[$r]['flights']['sub'][$y]=convert_seconds_to_colon($lines[$l][$x]);
						}
						$x++;
					}
					$temp_rounds[$r]['penalty']=$lines[$l][$x];
					$x++;
					break;
				case 'td':
					# TD flights
					$temp_rounds[$r]['group']=$lines[$l][$x];
					$x++;
					$temp_rounds[$r]['min']=$lines[$l][$x];
					$x++;
					$temp_rounds[$r]['sec']=$lines[$l][$x];
					$x++;
					$temp_rounds[$r]['land']=$lines[$l][$x];
					$x++;
					$temp_rounds[$r]['penalty']=$lines[$l][$x];
					$x++;
					break;
			}
			$r++;
		}
		$temp_pilot['rounds']=$temp_rounds;
		$pilots[]=$temp_pilot;
	}
	
	# Now lets step through the pilots and if they don't have an id, do a search for possible pilot names
	foreach($pilots as $key=>$p){
		$potentials=array();
		$found_pilots=array();
		if($p['pilot_id']=='' || $p['pilot_id']=='0' || intval($p['pilot_id'])<=0){
			# Lets get the list of possible pilot names for this one
			$pilot_entered=$p['pilot_name'];
			$q = trim(urldecode(strtolower($pilot_entered)));
			$q = '%'.$q.'%';
			# lets get the first name and last name out of it
			$words=preg_split("/\s+/",$pilot_entered,2);
			$first_name=$words[0];
			$last_name=$words[1];
			# Do search
			$stmt=db_prep("
				SELECT *
				FROM pilot p
				LEFT JOIN state s ON p.state_id=s.state_id
				LEFT JOIN country c ON p.country_id=c.country_id
				WHERE LOWER(p.pilot_first_name) LIKE :term1
					OR LOWER(p.pilot_last_name) LIKE :term2
					OR LOWER(CONCAT(p.pilot_first_name,' ',p.pilot_last_name)) LIKE :term3
					OR LOWER(p.pilot_first_name) LIKE :term4
					OR LOWER(p.pilot_last_name) LIKE :term5
					OR LOWER(CONCAT(p.pilot_last_name,' ',p.pilot_first_name)) LIKE :term6
			");
			$found_pilots=db_exec($stmt,array(
				"term1"=>$first_name,
				"term2"=>$last_name,
				"term3"=>$q,
				"term4"=>$last_name,
				"term5"=>$first_name,
				"term6"=>$q
			));
			$potentials[]=array("pilot_id"=>0,"pilot_full_name"=>'Add As New Pilot');
		}else{
			$stmt=db_prep("
				SELECT *
				FROM pilot p
				LEFT JOIN state s ON p.state_id=s.state_id
				LEFT JOIN country c ON p.country_id=c.country_id
				WHERE p.pilot_id=:pilot_id
			");
			$found_pilots=db_exec($stmt,array("pilot_id"=>$p['pilot_id']));
		}
		$found=0;
		foreach($found_pilots as $key2=>$fp){
			$fp['pilot_full_name']=$fp['pilot_first_name']." ".$fp['pilot_last_name'];
			if($fp['pilot_full_name']==$p['pilot_name']){
				$found=1;
			}
			$potentials[]=$fp;
		}
		$pilots[$key]['potentials']=$potentials;
		# See if the class they are in matches any class id
		$pilots[$key]['class_id']=0;
		foreach($classes as $class_name=>$c){
			$class_desc=$c['class_description'];
			if(preg_match("/^$class_name$/i",strtolower($p['pilot_class'])) || preg_match("/^$class_desc$/",strtolower($p['pilot_class']))){
				$pilots[$key]['class_id']=$c['class_id'];
				break;
			}
		}
		$pilots[$key]['found']=$found;
	}

	$event['event_id']=$event_id;
	$event['field_separator']=$field_separator;
	$event['decimal_type']=$decimal_type;
	$event['event_name']=$event_name;
	$event['event_start_date']=$event_start_date;
	$event['event_end_date']=$event_end_date;
	$event['event_type_id']=$event_type_id;
	$event['event_type_name']=$event_type_name;
	$event['event_type_code']=$event_type_code;
	$event['location_id']=$e['location_id'];
	$event['location_name']=$e['location_name'];
	$event['event_cd']=$e['event_cd'];
	$event['f3f_group']=$f3f_group;
	# If it was an existing event, lets get the cd name for the screen
	if(isset($e)){
		$stmt=db_prep("
			SELECT *
			FROM pilot p
			WHERE p.pilot_id=:pilot_id
		");
		$result=db_exec($stmt,array("pilot_id"=>$e['event_cd']));
		if(isset($result[0])){
			$cd_name=$result[0]['pilot_first_name']." ".$result[0]['pilot_last_name'];
		}else{
			$cd_name='';
		}
	}else{
		$cd_name='';
	}
	$event['cd_name']=$cd_name;
	
	$smarty->assign("event",$event);
	$smarty->assign("pilots",$pilots);
	$smarty->assign("rounds",$rounds);
	
	$maintpl=find_template("import/import_verify.tpl");
	return $smarty->fetch($maintpl);
}
function import_import() {
	global $smarty;

	$user=get_user_info($GLOBALS['fsession']['user_id']);
	
	$event['event_id']=$_REQUEST['event_id'];
	$event['event_name']=$_REQUEST['event_name'];
	$event['event_start_date']=$_REQUEST['event_start_date'];
	$event['event_end_date']=$_REQUEST['event_end_date'];
	$event['location_id']=$_REQUEST['location_id'];
	$event['event_cd']=$_REQUEST['event_cd'];
	$event['event_type_id']=$_REQUEST['event_type_id'];
	$event['event_type_code']=$_REQUEST['event_type_code'];
	$event['f3f_group']=$_REQUEST['f3f_group'];
	
	if(isset($_REQUEST['event_start_dateMonth'])){
		$event['event_start_date']=date("Y-m-d 00:00:00",strtotime($_REQUEST['event_start_dateMonth'].'/'.$_REQUEST['event_start_dateDay'].'/'.$_REQUEST['event_start_dateYear']));
	}else{
		$event['event_start_date']=date("Y-m-d 00:00:00");
	}
	if(isset($_REQUEST['event_end_dateMonth'])){
		$event['event_end_date']=date("Y-m-d 00:00:00",strtotime($_REQUEST['event_end_dateMonth'].'/'.$_REQUEST['event_end_dateDay'].'/'.$_REQUEST['event_end_dateYear']));
	}else{
		$event['event_end_date']=date("Y-m-d 00:00:00");
	}

	$event['event_zero_round']=0;
	if(isset($_REQUEST['event_zero_round']) && ($_REQUEST['event_zero_round']=='on' || $_REQUEST['event_zero_round']==1)){
		$event['event_zero_round']=1;
	}
	$flyoff=0;
	if(isset($_REQUEST['flyoff']) && ($_REQUEST['flyoff']=='on' || $_REQUEST['flyoff']==1)){
		$flyoff=1;
	}

	# Now lets get the pilot info and put it in an array
	$pilots=array();
	foreach($_REQUEST as $key=>$value){
		if(preg_match("/^pilot_name_(\d+)/",$key,$match)){
			$number=$match[1];
			$pilots[$number]['pilot_name']=$value;
		}
		if(preg_match("/^pilot_class_id_(\d+)/",$key,$match)){
			$number=$match[1];
			$pilots[$number]['pilot_class_id']=$value;
		}
		if(preg_match("/^pilot_freq_(\d+)/",$key,$match)){
			$number=$match[1];
			$pilots[$number]['pilot_freq']=$value;
		}
		if(preg_match("/^pilot_team_(\d+)/",$key,$match)){
			$number=$match[1];
			$pilots[$number]['pilot_team']=$value;
		}
		if(preg_match("/^pilot_(\d+)_round_(\d+)_group/",$key,$match)){
			$number=$match[1];
			$round=$match[2];
			$pilots[$number]['rounds'][$round]['group']=$value;
		}
		if(preg_match("/^pilot_(\d+)_round_(\d+)_pen/",$key,$match)){
			$number=$match[1];
			$round=$match[2];
			$pilots[$number]['rounds'][$round]['pen']=$value;
		}
		if(preg_match("/^pilot_(\d+)_round_(\d+)_min/",$key,$match)){
			$number=$match[1];
			$round=$match[2];
			$pilots[$number]['rounds'][$round]['min']=$value;
		}
		if(preg_match("/^pilot_(\d+)_round_(\d+)_sec/",$key,$match)){
			$number=$match[1];
			$round=$match[2];
			$pilots[$number]['rounds'][$round]['sec']=$value;
		}
		if(preg_match("/^pilot_(\d+)_round_(\d+)_sub_(\d+)/",$key,$match)){
			$number=$match[1];
			$round=$match[2];
			$sub=$match[3];
			$pilots[$number]['rounds'][$round]['sub'][$sub]=$value;
		}
		if(preg_match("/^pilot_(\d+)_round_(\d+)_land/",$key,$match)){
			$number=$match[1];
			$round=$match[2];
			$pilots[$number]['rounds'][$round]['land']=$value;
		}
		if(preg_match("/^pilot_(\d+)_round_(\d+)_over/",$key,$match)){
			$number=$match[1];
			$round=$match[2];
			$pilots[$number]['rounds'][$round]['over']=$value;
		}
		if(preg_match("/^pilot_id_(\d+)/",$key,$match)){
			$number=$match[1];
			$pilots[$number]['pilot_id']=$value;
		}
		if(preg_match("/^event_round_(\d+)_target$/",$key,$match)){
			$round=$match[1];
			$event['rounds'][$round]['target']=$value;
		}
		if(preg_match("/^event_round_(\d+)$/",$key,$match)){
			$round=$match[1];
			$event['rounds'][$round]['flight_type_id']=$value;
		}
	}

	# OK, now do each of the steps to create or update the event
	# First check to see if the event exists, and get its info
	if($event['event_id']!=0){
		# Search for the event, and update it if it exists
		$stmt=db_prep("
			SELECT *
			FROM event
			WHERE event_id=:event_id
		");
		$result=db_exec($stmt,array(
			"event_id"=>$event['event_id']
		));
	}else{
		$stmt=db_prep("
			SELECT *
			FROM event
			WHERE event_name=:event_name
				AND event_start_date=:event_start_date
				AND event_end_date=:event_end_date
		");
		$result=db_exec($stmt,array(
			"event_name"=>$event['event_name'],
			"event_start_date"=>$event['event_start_date'],
			"event_end_date"=>$event['event_end_date']			
		));
	}
	if(!isset($result[0])){
		# Event does not exist
		$event['event_id']=0;
	}else{
		# Update the event with the given info
		$event['event_id']=$result[0]['event_id'];
		$stmt=db_prep("
			UPDATE event
			SET event_name=:event_name,
				location_id=:location_id,
				event_cd=:event_cd,
				event_start_date=:event_start_date,
				event_end_date=:event_end_date,
				event_type_id=:event_type_id,
				event_view_status=1,
				event_status=1
			WHERE event_id=:event_id
		");
		$result=db_exec($stmt,array(
			"event_name"=>$event['event_name'],
			"location_id"=>$event['location_id'],
			"event_cd"=>$event['event_cd'],
			"event_start_date"=>$event['event_start_date'],
			"event_end_date"=>$event['event_end_date'],
			"event_type_id"=>$event['event_type_id'],
			"event_id"=>$event['event_id']
		));
		user_message("Update Event information.");
	}
	if($event['event_id']==0){
		if($flyoff==1){
			user_message("Cannot add flyoff rounds to a non-existent event. Make sure the name and dates of the event are identical.",1);
			return import_view();
		}
		# Create the new event with the given parameters
		$stmt=db_prep("
			INSERT INTO event
			SET pilot_id=:pilot_id,
				event_name=:event_name,
				location_id=:location_id,
				event_cd=:event_cd,
				event_start_date=:event_start_date,
				event_end_date=:event_end_date,
				event_type_id=:event_type_id,
				event_view_status=1,
				event_status=1
		");
		$result=db_exec($stmt,array(
			"pilot_id"=>$user['pilot_id'],
			"event_name"=>$event['event_name'],
			"location_id"=>$event['location_id'],
			"event_cd"=>$event['event_cd'],
			"event_start_date"=>$event['event_start_date'],
			"event_end_date"=>$event['event_end_date'],
			"event_type_id"=>$event['event_type_id']
		));
		user_message("Created New Event.");
		$event['event_id']=$GLOBALS['last_insert_id'];
	}

	# If its a flyoff round, then lets get the existing number of rounds
	if($flyoff==1){
		$e=new Event($event['event_id']);
		$e->get_rounds();
		$existing_rounds=count($e->rounds);
		# Lets figure out the next round flyoff number
		$flyoff_number=0;
		foreach($e->rounds as $rn=>$r){
			if($r['event_round_flyoff']>$flyoff_number){
				$flyoff_number=$r['event_round_flyoff'];
			}
		}
		$flyoff_number++;
	}else{
		$flyoff_number=0;
	}

	# Set the flight types if the event type is not f3k and they weren't set
	if($event['event_type_code']!='f3k'){
		$flight_type=array();
		$stmt=db_prep("
			SELECT *
			FROM flight_type
			WHERE flight_type_code LIKE :flight_type_code
		");
		$result=db_exec($stmt,array("flight_type_code"=>$event['event_type_code'].'%'));
		$flight_type=$result[0];
		
		foreach($pilots as $number=>$p){
			foreach($p['rounds'] as $round=>$r){
				if($flyoff==1){
					$round_number=$round+$existing_rounds;
				}else{
					$round_number=$round;
				}
				if($event['event_zero_round']==1){
					$round_number=$round_number-1;
				}
				if(!isset($event['rounds'][$round_number]['flight_type_id'])){
					$event['rounds'][$round_number]['flight_type_id']=$flight_type['flight_type_id'];
				}
			}
			break;
		}
	}
	# Modify event.rounds if its a flyoff
	if($flyoff==1){
		$newrounds=array();
		foreach($event['rounds'] as $round_number=>$r){
			$round_number+=$existing_rounds;
			$newrounds[$round_number]=$r;
		}
		$event['rounds']=$newrounds;
	}
	# Get list of pilots if there are any existing
	
	# Determine event classes to check in the options and set up the classes for the event
	$classes=array();
	foreach($pilots as $number=>$p){
		$class_id=$p['pilot_class_id'];
		$classes[$class_id]=1;
	}
	foreach($classes as $class_id=>$c){
		# Lets search if there is a class set up for this event
		$stmt=db_prep("
			SELECT *
			FROM event_class 
			WHERE event_id=:event_id
				AND class_id=:class_id
		");
		$result=db_exec($stmt,array("event_id"=>$event['event_id'],"class_id"=>$class_id));
		if(!isset($result[0])){
			# Create a record for event class
			$stmt=db_prep("
				INSERT INTO event_class
				SET event_id=:event_id,
					class_id=:class_id,
					event_class_status=1
			");
			$result=db_exec($stmt,array("event_id"=>$event['event_id'],"class_id"=>$class_id));
		}else{
			# Lets update the record if we need to
			if($result[0]['event_class_status']==0){
				# Turn it back on
				$stmt=db_prep("
					UPDATE event_class
					SET event_class_status=1
					WHERE event_class_id=:event_class_id
				");
				$result=db_exec($stmt,array("event_class_id"=>$result[0]['event_class_id']));
			}
		}
	}
	
	# Update list of pilots from array and copy in event_pilot_id to the array
	if($flyoff==0){
		# Clear existing pilots
		$stmt=db_prep("
			UPDATE event_pilot
			SET event_pilot_status=0
			WHERE event_id=:event_id
		");
		$result=db_exec($stmt,array("event_id"=>$event['event_id']));
	}
	# Create any event_pilots that don't already exist
	$entry_order=1;
	foreach($pilots as $number=>$p){
		$pilot_id=$p['pilot_id'];
		# If the pilot doesn't exist, then lets create one
		if($pilot_id==0){
			# Break name into first name and last name
			$words=preg_split("/\s+/",$p['pilot_name'],2);
			$first_name=ucwords($words[0]);
			$last_name=ucwords($words[1]);
			$stmt=db_prep("
				INSERT INTO pilot
				SET user_id=0,
					pilot_first_name=:pilot_first_name,
					pilot_last_name=:pilot_last_name
			");
			$result=db_exec($stmt,array(
				"pilot_first_name"=>$first_name,
				"pilot_last_name"=>$last_name
			));
			$pilot_id=$GLOBALS['last_insert_id'];
			user_message("Created new pilot $first_name $last_name.");
		}
		# Lets see if there is a current event_pilot with this pilot id
		$stmt=db_prep("
			SELECT *
			FROM event_pilot 
			WHERE event_id=:event_id
				AND pilot_id=:pilot_id
		");
		$result=db_exec($stmt,array("event_id"=>$event['event_id'],"pilot_id"=>$pilot_id));
		if(!isset($result[0])){
			# A pilot record does not exist, so lets create a new one
			$stmt=db_prep("
				INSERT INTO event_pilot
				SET event_id=:event_id,
					pilot_id=:pilot_id,
					event_pilot_entry_order=:event_pilot_entry_order,
					event_pilot_bib=:event_pilot_bib,
					class_id=:class_id,
					event_pilot_team=:event_pilot_team,
					event_pilot_freq=:event_pilot_freq,
					event_pilot_status=1
			");
			$result=db_exec($stmt,array(
				"event_id"=>$event['event_id'],
				"pilot_id"=>$pilot_id,
				"event_pilot_entry_order"=>$entry_order,
				"event_pilot_bib"=>$entry_order,
				"class_id"=>$p['pilot_class_id'],
				"event_pilot_team"=>$p['pilot_team'],
				"event_pilot_freq"=>$p['pilot_freq']
			));
			$event_pilot_id=$GLOBALS['last_insert_id'];
		}else{
			# A current event pilot exists, so lets update it
			$event_pilot_id=$result[0]['event_pilot_id'];
			$stmt=db_prep("
				UPDATE event_pilot
				SET class_id=:class_id,
					event_pilot_team=:event_pilot_team,
					event_pilot_freq=:event_pilot_freq,
					event_pilot_status=1
				WHERE event_pilot_id=:event_pilot_id
			");
			$result=db_exec($stmt,array(
				"class_id"=>$p['pilot_class_id'],
				"event_pilot_team"=>$p['pilot_team'],
				"event_pilot_freq"=>$p['pilot_freq'],
				"event_pilot_id"=>$event_pilot_id
			));
		}		
		# Now lets set the event_pilot_id in the array for the rest of the setups
		$pilots[$number]['event_pilot_id']=$event_pilot_id;
		$entry_order++;
	}	
	
	# Set event tasks if there are any
	if($event['event_type_code']=='f3k'){
		# Lets get the rounds array and make sure the tasks are set to the same
		if($flyoff==0){
			# Lets first clear any existing ones
			$stmt=db_prep("
				UPDATE event_task
				SET event_task_status=0 
				WHERE event_id=:event_id
			");
			$result=db_exec($stmt,array("event_id"=>$event['event_id']));
		}
		# Now lets turn back on or create the new ones
		foreach($event['rounds'] as $round=>$r){
			if($flyoff==1){
				# Add the existing rounds
				$rn=$round+$existing_rounds;
				# Mark as flyoff
				$rn_type='flyoff';
			}else{
				# Set round number
				$rn=$round;
				$rn_type='prelim';
			}
			# Search for existing one
			$stmt=db_prep("
				SELECT *
				FROM event_task 
				WHERE event_id=:event_id
					AND event_task_round=:event_task_round
			");
			$result=db_exec($stmt,array("event_id"=>$event['event_id'],"event_task_round"=>$rn));
			if(isset($result[0])){
				# This one exists, update it
				$stmt=db_prep("
					UPDATE event_task
					SET event_task_round_type=:event_task_round_type,
						flight_type_id=:flight_type_id,
						event_task_status=1 
					WHERE event_task_id=:event_task_id
				");
				$result=db_exec($stmt,array(
					"event_task_round_type"=>$rn_type,
					"flight_type_id"=>$r['flight_type_id'],
					"event_task_id"=>$result[0]['event_task_id']
				));
			}else{
				# New one so create it
				$stmt=db_prep("
					INSERT INTO event_task
					SET event_id=:event_id,
						event_task_round=:event_task_round,
						event_task_round_type=:event_task_round_type,
						flight_type_id=:flight_type_id,
						event_task_status=1 
				");
				$result=db_exec($stmt,array(
					"event_id"=>$event['event_id'],
					"event_task_round"=>$rn,
					"event_task_round_type"=>$rn_type,
					"flight_type_id"=>$r['flight_type_id']
				));
			}
		}
	}
	
	# Clear all round entries by turning them off
	# Turn off event rounds and flights for all pilots unless its a flyoff
	if($flyoff==0){
		# Search for all the rounds and flights
		$stmt=db_prep("
			SELECT er.event_round_id,eprf.event_pilot_round_flight_id
			FROM event_pilot_round_flight eprf
			LEFT JOIN event_pilot_round epr ON eprf.event_pilot_round_id=epr.event_pilot_round_id
			LEFT JOIN event_round er ON epr.event_round_id=er.event_round_id
			WHERE er.event_id=:event_id
		");
		$result=db_exec($stmt,array("event_id"=>$event['event_id']));
		# Now lets step through these and set the flights and rounds to off
		foreach($result as $r){
			$event_pilot_round_flight_id=$r['event_pilot_round_flight_id'];
			$event_round_id=$r['event_round_id'];
			$stmt=db_prep("
				UPDATE event_pilot_round_flight
				SET event_pilot_round_flight_status=0 
				WHERE event_pilot_round_flight_id=:event_pilot_round_flight_id
			");
			$result=db_exec($stmt,array("event_pilot_round_flight_id"=>$event_pilot_round_flight_id));
			$stmt=db_prep("
				UPDATE event_round
				SET event_round_status=0 
				WHERE event_round_id=:event_round_id
			");
			$result=db_exec($stmt,array("event_round_id"=>$event_round_id));
		}
	}
	
	# Step through each pilot and create the round entries (turning on if existing)
	# Lets first make an easier array so we can go through round by round instead of pilot by pilot
	$import_rounds=array();
	foreach($pilots as $number=>$p){
		$event_pilot_id=$p['event_pilot_id'];
		foreach($p['rounds'] as $round_number=>$r){
			if($event['event_zero_round']==1){
				$round_number--;
			}
			if($flyoff==1){
				# Add the existing rounds
				$round_number=$round_number+$existing_rounds;
			}
			$import_rounds[$round_number][$event_pilot_id]=$r;
		}
	}

	# Now lets step through the rounds and set the flights
	foreach($import_rounds as $round_number=>$ep){
		# Make sure the round is set up
		if($round_number==0){
			$event_round_score_status=0;
		}else{
			$event_round_score_status=1;
		}
		$event_round_time_choice = 0;
		if($event['rounds'][$round_number]['target']){
			$event_round_time_choice = $event['rounds'][$round_number]['target'];
		}
		$stmt=db_prep("
			SELECT *
			FROM event_round
			WHERE event_id=:event_id
				AND event_round_number=:event_round_number
		");
		$result=db_exec($stmt,array(
			"event_id"=>$event['event_id'],
			"event_round_number"=>$round_number
		));
		if(isset($result[0])){
			$event_round_id=$result[0]['event_round_id'];
			# This round exists, so update it
			$stmt=db_prep("
				UPDATE event_round
				SET flight_type_id=:flight_type_id,
					event_round_time_choice=:event_round_time_choice,
					event_round_score_status=:event_round_score_status,
					event_round_flyoff=:flyoff_number,
					event_round_status=1 
				WHERE event_round_id=:event_round_id
			");
			$result=db_exec($stmt,array(
				"flight_type_id"=>$event['rounds'][$round_number]['flight_type_id'],
				"event_round_time_choice"=>$event_round_time_choice,
				"event_round_score_status"=>$event_round_score_status,
				"flyoff_number"=>$flyoff_number,
				"event_round_id"=>$event_round_id
			));
		}else{
			# This round does not exist, so create it
			$stmt=db_prep("
				INSERT INTO event_round
				SET event_id=:event_id,
					event_round_number=:event_round_number,
					flight_type_id=:flight_type_id,
					event_round_time_choice=:event_round_time_choice,
					event_round_score_status=:event_round_score_status,
					event_round_flyoff=:flyoff_number,
					event_round_status=1 
			");
			$result=db_exec($stmt,array(
				"event_id"=>$event['event_id'],
				"event_round_number"=>$round_number,
				"flight_type_id"=>$event['rounds'][$round_number]['flight_type_id'],
				"event_round_time_choice"=>$event_round_time_choice,
				"event_round_score_status"=>$event_round_score_status,
				"flyoff_number"=>$flyoff_number
			));
			$event_round_id=$GLOBALS['last_insert_id'];
		}
		# Set the event_round_flight record
		$stmt=db_prep("
			SELECT *
			FROM event_round_flight
			WHERE event_round_id=:event_round_id
		");
		$result=db_exec($stmt,array(
			"event_round_id"=>$event_round_id
		));
		if(isset($result[0])){
			# Already exists, so update it
			$stmt=db_prep("
				UPDATE event_round_flight
				SET flight_type_id=:flight_type_id,
					event_round_flight_score=1
				WHERE event_round_flight_id=:event_round_flight_id
			");
			$result=db_exec($stmt,array(
				"flight_type_id"=>$event['rounds'][$round_number]['flight_type_id'],
				"event_round_flight_id"=>$result[0]['event_round_flight_id']
			));
		}else{
			# Create it
			$stmt=db_prep("
				INSERT INTO event_round_flight
				SET event_round_id=:event_round_id,
					flight_type_id=:flight_type_id,
					event_round_flight_score=1
			");
			$result=db_exec($stmt,array(
				"event_round_id"=>$event_round_id,
				"flight_type_id"=>$event['rounds'][$round_number]['flight_type_id']
			));
		}
		
		# OK, now lets create or update the event_pilot_round
		foreach($ep as $event_pilot_id=>$r){
			$stmt=db_prep("
				SELECT *
				FROM event_pilot_round
				WHERE event_pilot_id=:event_pilot_id
					AND event_round_id=:event_round_id
			");
			$result=db_exec($stmt,array(
				"event_pilot_id"=>$event_pilot_id,
				"event_round_id"=>$event_round_id
			));
			if(isset($result[0])){
				# It already exists, so leave it
				$event_pilot_round_id=$result[0]['event_pilot_round_id'];
			}else{
				# It doesn't exist, so lets create it
				$stmt=db_prep("
					INSERT INTO event_pilot_round
					SET event_pilot_id=:event_pilot_id,
						event_round_id=:event_round_id
				");
				$result=db_exec($stmt,array(
					"event_pilot_id"=>$event_pilot_id,
					"event_round_id"=>$event_round_id
				));
				$event_pilot_round_id=$GLOBALS['last_insert_id'];
			}
			# OK, now we have the event_pilot_round_id, so lets add the flights
			
			# Lets total the sub flights if there are any
############## Not finished. Needs to be modified if we are going to do any other imports
			$subtotal=0;
			switch($event['event_type_code']){
				case 'f3k':
					foreach($r['sub'] as $sub_num=>$sub_time){
						$subtotal+=convert_colon_to_seconds($sub_time);
					}
					$min=floor($subtotal/60);
					$sec=sprintf("%02d",fmod($subtotal,60));
					break;
				case 'f3f':
					$min=0;
					foreach($r['sub'] as $sub_num=>$sub_time){
						$subtotal+=convert_colon_to_seconds($sub_time);
					}
					$sec=$subtotal;
					break;
				case 'f3j':
				case 'td':
					$min = $r['min'];
					$sec=sprintf("%02.f",$r['sec']);
					break;
				default:
					foreach($r['sub'] as $sub_num=>$sub_time){
						$subtotal+=convert_colon_to_seconds($sub_time);
					}
					$min=floor($subtotal/60);
					$sec=sprintf("%02d",fmod($subtotal,60));
					break;
			}
			
			$stmt=db_prep("
				SELECT *
				FROM event_pilot_round_flight
				WHERE event_pilot_round_id=:event_pilot_round_id
					AND flight_type_id=:flight_type_id
			");
			$result=db_exec($stmt,array(
				"event_pilot_round_id"=>$event_pilot_round_id,
				"flight_type_id"=>$event['rounds'][$round_number]['flight_type_id']
			));
			if(isset($result[0])){
				$event_pilot_round_flight_id=$result[0]['event_pilot_round_flight_id'];
				# It already exists, so update it
				$stmt=db_prep("
					UPDATE event_pilot_round_flight
					SET event_pilot_round_flight_group=:group,
						event_pilot_round_flight_minutes=:min,
						event_pilot_round_flight_seconds=:sec,
						event_pilot_round_flight_landing=:landing,
						event_pilot_round_flight_over=:over,
						event_pilot_round_flight_penalty=:penalty,
						event_pilot_round_flight_status=1
					WHERE event_pilot_round_flight_id=:event_pilot_round_flight_id
				");
				$result=db_exec($stmt,array(
					"group"=>$r['group'],
					"min"=>$min,
					"sec"=>$sec,
					"landing"=>$r['land'],
					"over"=>$r['over'],
					"penalty"=>$r['penalty'],
					"event_pilot_round_flight_id"=>$event_pilot_round_flight_id
				));
			}else{
				# Need to create it
				$stmt=db_prep("
					INSERT INTO event_pilot_round_flight
					SET event_pilot_round_id=:event_pilot_round_id,
						flight_type_id=:flight_type_id,
						event_pilot_round_flight_group=:group,
						event_pilot_round_flight_minutes=:min,
						event_pilot_round_flight_seconds=:sec,
						event_pilot_round_flight_landing=:landing,
						event_pilot_round_flight_over=:over,
						event_pilot_round_flight_penalty=:penalty,
						event_pilot_round_flight_status=1
				");
				$result=db_exec($stmt,array(
					"event_pilot_round_id"=>$event_pilot_round_id,
					"flight_type_id"=>$event['rounds'][$round_number]['flight_type_id'],
					"group"=>$r['group'],
					"min"=>$min,
					"sec"=>$sec,
					"landing"=>$r['land'],
					"over"=>$r['over'],
					"penalty"=>$r['pen']
				));
				$event_pilot_round_flight_id=$GLOBALS['last_insert_id'];
			}
			
			# Now add the sub flights
			if(isset($r['sub'])){
				foreach($r['sub'] as $sub_num=>$sub_time){
					# See if there already is one
					$stmt=db_prep("
						SELECT *
						FROM event_pilot_round_flight_sub
						WHERE event_pilot_round_flight_id=:event_pilot_round_flight_id
							AND event_pilot_round_flight_sub_num=:sub_num
					");
					$result=db_exec($stmt,array(
						"event_pilot_round_flight_id"=>$event_pilot_round_flight_id,
						"sub_num"=>$sub_num
					));
					if(isset($result[0])){
						# Update it
						$stmt=db_prep("
							UPDATE event_pilot_round_flight_sub
							SET event_pilot_round_flight_sub_val=:sub_time
							WHERE event_pilot_round_flight_sub_id=:event_pilot_round_flight_sub_id
						");
						$result=db_exec($stmt,array(
							"sub_time"=>$sub_time,
							"event_pilot_round_flight_sub_id"=>$result[0]['event_pilot_round_flight_sub_id']
						));
					}else{
						# Create it
						$stmt=db_prep("
							INSERT INTO event_pilot_round_flight_sub
							SET event_pilot_round_flight_id=:event_pilot_round_flight_id,
								event_pilot_round_flight_sub_num=:sub_num,
								event_pilot_round_flight_sub_val=:sub_time
						");
						$result=db_exec($stmt,array(
							"event_pilot_round_flight_id"=>$event_pilot_round_flight_id,
							"sub_num"=>$sub_num,
							"sub_time"=>$sub_time
						));
					}
				}
			}
		}
	}
	
	# Step through each round and total the round now that all of the round data is entered
	$e1=new Event($event['event_id']);
	$e1->get_rounds();
	# Now lets recalculate each round and save the event total info
	foreach($e1->rounds as $event_round_number=>$r){
		$e1->calculate_round($event_round_number);
	}
	# Refresh the round info
	$e1->get_rounds();
	# Run the total entire event
	$e1->event_save_totals();

	user_message("Successfully imported event!");
	$_REQUEST['action']='event';
	$_REQUEST['function']='event_view';
	$_REQUEST['event_id']=$event['event_id'];
	include_once("event.php");
	return event_view();
}


?>
