<?php
############################################################################
#       country_fix.php
#
#       Tim Traver
#       3/5/13
#       This is the script to quickly change the country names to uc words
#
############################################################################

if(file_exists('C:/Program Files (x86)/Apache Software Foundation/Apache2.2/local')){
	require_once("C:\Program Files (x86)\Apache Software Foundation\Apache2.2\php\conf.php");
}else{
	require_once("/shared/links/r/c/v/a/rcvault.com/site/php/conf.php");
}

include_library('functions.inc');

$countries=get_countries();
	
foreach($countries as $c){
	$country_id=$c['country_id'];
	$country_name=ucwords(strtolower($c['country_name']));
	$stmt=db_prep("
		UPDATE country
		SET country_name=:country_name
		WHERE country_id=:country_id
	");
	$result=db_exec($stmt,array("country_name"=>$country_name,"country_id"=>$country_id));
	print "country_name=$country_name\n";
}

?>

