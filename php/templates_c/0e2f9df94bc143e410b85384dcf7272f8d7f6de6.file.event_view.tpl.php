<?php /* Smarty version Smarty-3.1.11, created on 2013-05-08 01:09:45
         compiled from "C:\Program Files (x86)\Apache Software Foundation\Apache2.2\php\templates\event_view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:32280511ca384f1fcf3-21943121%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0e2f9df94bc143e410b85384dcf7272f8d7f6de6' => 
    array (
      0 => 'C:\\Program Files (x86)\\Apache Software Foundation\\Apache2.2\\php\\templates\\event_view.tpl',
      1 => 1368000221,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '32280511ca384f1fcf3-21943121',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_511ca3850d27c4_25618471',
  'variables' => 
  array (
    'permission' => 0,
    'event' => 0,
    'num' => 0,
    'p' => 0,
    'r' => 0,
    'flight_type_id' => 0,
    'e' => 0,
    'f' => 0,
    'dropval' => 0,
    'dropped' => 0,
    'drop' => 0,
    'event_round_number' => 0,
    'event_pilot_id' => 0,
    'fast' => 0,
    'fast_id' => 0,
    'flyoff_number' => 0,
    't' => 0,
    'user' => 0,
    'duration_rank' => 0,
    'speed_rank' => 0,
    'c' => 0,
    'rank' => 0,
    'distance_rank' => 0,
    'lap_totals' => 0,
    'speed_averages' => 0,
    'top_landing' => 0,
    'distance_laps' => 0,
    'speed_times' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_511ca3850d27c4_25618471')) {function content_511ca3850d27c4_25618471($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'C:\\Program Files (x86)\\Apache Software Foundation\\Apache2.2\\php\\libraries\\smarty\\libs\\plugins\\modifier.date_format.php';
if (!is_callable('smarty_function_cycle')) include 'C:\\Program Files (x86)\\Apache Software Foundation\\Apache2.2\\php\\libraries\\smarty\\libs\\plugins\\function.cycle.php';
?><script src="/includes/jquery-ui/ui/jquery.ui.core.js"></script>
<script src="/includes/jquery-ui/ui/jquery.ui.widget.js"></script>
<script src="/includes/jquery-ui/ui/jquery.ui.position.js"></script>
<script src="/includes/jquery-ui/ui/jquery.ui.menu.js"></script>
<script src="/includes/jquery-ui/ui/jquery.ui.autocomplete.js"></script>
<script>

$(function() {
	$("#pilot_name").autocomplete({
		source: "/lookup.php?function=lookup_pilot",
		minLength: 2, 
		highlightItem: true, 
        matchContains: true,
        autoFocus: true,
        scroll: true,
        scrollHeight: 300,
   		search: function( event, ui ) {
   			var loading=document.getElementById('loading');
			loading.style.display = "inline";
		},
   		select: function( event, ui ) {
			document.event_pilot_add.pilot_id.value = ui.item.id;
			var name=document.getElementById('pilot_name');
			document.event_pilot_add.pilot_name.value=name.value;
			event_pilot_add.submit();
		},
   		change: function( event, ui ) {
   			var id=document.getElementById('pilot_name');
   			if(id.value==''){
				document.event_pilot_add.pilot_id.value = 0;
			}
		},
   		response: function( event, ui ) {
   			var loading=document.getElementById('loading');
			loading.style.display = "none";
   			var mes=document.getElementById('search_message');
			if(ui.content && ui.content.length){
				mes.innerHTML = ' Found ' + ui.content.length + ' results. Use Arrow keys to select';
			}else{
				mes.innerHTML = ' No Results Found. Use Add button to add new pilot.';
			}
		}
	});
	$("#pilot_name").keyup(function(event) { 
		if (event.keyCode == 13) { 
			//For enter.
			var name=document.getElementById('pilot_name');
			document.event_pilot_add.pilot_name.value=name.value;
			event_pilot_add.submit();
        }
    });
});
function toggle(element,tog) {
	 if (document.getElementById(element).style.display == 'none') {
	 	document.getElementById(element).style.display = 'block';
	 	tog.innerHTML = '(<u>Hide Pilot List</u>)';
	 } else {
		 document.getElementById(element).style.display = 'none';
		 tog.innerHTML = '(<u>Show Pilot List</u>)';
	 }
}

function check_permission() {
	<?php if ($_smarty_tpl->tpl_vars['permission']->value!=1){?>
		alert('Sorry, but you do not have permission to edit this event. Contact the event owner if you need access to edit this event.');
		return 0;
	<?php }else{ ?>
		return 1;
	<?php }?>
}
</script>

<div class="page type-page status-publish hentry clearfix post nodate">
	<div class="entry clearfix">                
		<h1 class="post-title entry-title"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->info['event_name'], ENT_QUOTES, 'UTF-8', true);?>
 <input type="button" value=" Edit Event Parameters " onClick="if(check_permission()){document.event_edit.submit();}" class="block-button">
		</h1>
		<div class="entry-content clearfix">
		<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
		<tr>
			<th width="20%" align="right">Event Dates</th>
			<td>
			<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['event']->value->info['event_start_date'],"%Y-%m-%d");?>
 to <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['event']->value->info['event_end_date'],"%Y-%m-%d");?>

			</td>
			<th align="right">Location</th>
			<td>
			<a href="?action=location&function=location_view&location_id=<?php echo $_smarty_tpl->tpl_vars['event']->value->info['location_id'];?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->info['location_name'], ENT_QUOTES, 'UTF-8', true);?>
 - <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->info['location_city'], ENT_QUOTES, 'UTF-8', true);?>
,<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->info['state_code'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->info['country_code'], ENT_QUOTES, 'UTF-8', true);?>
</a>
			</td>
		</tr>
		<tr>
			<th align="right">Event Type</th>
			<td>
			<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->info['event_type_name'], ENT_QUOTES, 'UTF-8', true);?>

			</td>
			<th align="right">Event Contest Director</th>
			<td>
			<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->info['pilot_first_name'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->info['pilot_last_name'], ENT_QUOTES, 'UTF-8', true);?>
 - <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->info['pilot_city'], ENT_QUOTES, 'UTF-8', true);?>

			</td>
		</tr>
		<?php if ($_smarty_tpl->tpl_vars['event']->value->info['series_name']||$_smarty_tpl->tpl_vars['event']->value->info['club_name']){?>
		<tr>
			<th align="right">Part Of Series</th>
			<td>
			<a href="?action=series&function=series_view&series_id=<?php echo $_smarty_tpl->tpl_vars['event']->value->info['series_id'];?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->info['series_name'], ENT_QUOTES, 'UTF-8', true);?>
</a>
			</td>
			<th align="right">Club</th>
			<td>
			<a href="?action=club&function=club_view&club_id=<?php echo $_smarty_tpl->tpl_vars['event']->value->info['club_id'];?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->info['club_name'], ENT_QUOTES, 'UTF-8', true);?>
</a>
			</td>
		</tr>
		<?php }?>
		</table>
		
	</div>
		<br>
		<h1 class="post-title entry-title">Event Pilots <?php if ($_smarty_tpl->tpl_vars['event']->value->pilots){?>(<?php echo count($_smarty_tpl->tpl_vars['event']->value->pilots);?>
)<?php }?> <span id="viewtoggle" onClick="toggle('pilots',this);">(<u>Hide Pilot List</u>)</span></h1>
		<span id="pilots">
		<input type="button" class="button" value=" Add New Pilot " style="float:right;" onclick="if(check_permission()){var name=document.getElementById('pilot_name');document.event_pilot_add.pilot_name.value=name.value;event_pilot_add.submit();}">
		<input type="text" id="pilot_name" name="pilot_name" size="40">
		    <img id="loading" src="/images/loading.gif" style="vertical-align: middle;display: none;">
		    <span id="search_message" style="font-style: italic;color: grey;"> Start typing to search pilot to Add</span>
		<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
		<tr>
			<th width="2%" align="left"></th>
			<th width="10%" align="center">AMA#</th>
			<th align="left">Pilot Name</th>
			<th align="left">Pilot Class</th>
			<th align="left">Pilot Plane</th>
			<th align="left">Pilot Freq</th>
			<th align="left">Event Team</th>
			<th align="left" width="4%"></th>
		</tr>
		<?php $_smarty_tpl->tpl_vars['num'] = new Smarty_variable(1, null, 0);?>
		<?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['event']->value->pilots; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
?>
		<tr>
			<td><?php echo $_smarty_tpl->tpl_vars['num']->value;?>
</td>
			<td align="center"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['p']->value['pilot_ama'], ENT_QUOTES, 'UTF-8', true);?>
</td>
			<td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['p']->value['pilot_first_name'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['p']->value['pilot_last_name'], ENT_QUOTES, 'UTF-8', true);?>
</td>
			<td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['p']->value['class_description'], ENT_QUOTES, 'UTF-8', true);?>
</td>
			<td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['p']->value['plane_name'], ENT_QUOTES, 'UTF-8', true);?>
</td>
			<td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['p']->value['event_pilot_freq'], ENT_QUOTES, 'UTF-8', true);?>
</td>
			<td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['p']->value['event_pilot_team'], ENT_QUOTES, 'UTF-8', true);?>
</td>
			<td nowrap>
				<a href="/?action=event&function=event_pilot_edit&event_id=<?php echo $_smarty_tpl->tpl_vars['event']->value->info['event_id'];?>
&event_pilot_id=<?php echo $_smarty_tpl->tpl_vars['p']->value['event_pilot_id'];?>
" title="Edit Event Pilot"><img width="16" src="/images/icon_edit_small.gif"></a>
				<a href="/?action=event&function=event_pilot_remove&event_id=<?php echo $_smarty_tpl->tpl_vars['event']->value->info['event_id'];?>
&event_pilot_id=<?php echo $_smarty_tpl->tpl_vars['p']->value['event_pilot_id'];?>
" title="Remove Event Pilot" onClick="return confirm('Are you sure you want to remove <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['p']->value['pilot_first_name'], ENT_QUOTES, 'UTF-8', true);?>
 from the event?');"><img width="14px" src="/images/del.gif"></a>
			</td>
		</tr>
		<?php $_smarty_tpl->tpl_vars['num'] = new Smarty_variable($_smarty_tpl->tpl_vars['num']->value+1, null, 0);?>
		<?php } ?>
		</table>
		</span>




		<br>
		<h1 class="post-title entry-title">Event <?php if (count($_smarty_tpl->tpl_vars['event']->value->flyoff_totals)>0){?>Preliminary <?php }?>Rounds <?php if ($_smarty_tpl->tpl_vars['event']->value->rounds){?>(<?php echo $_smarty_tpl->tpl_vars['event']->value->totals['total_rounds'];?>
) <?php }?> Overall Classification
			<input type="button" value=" Add Flyoff Round " onClick="if(check_permission()){document.event_add_round.flyoff_round.value=1; document.event_add_round.submit();}" class="block-button">
			<?php if ($_smarty_tpl->tpl_vars['event']->value->info['event_type_zero_round']==1){?><input type="button" value=" Add Zero Round " onClick="if(check_permission()){document.event_add_round.zero_round.value=1; document.event_add_round.submit();}" class="block-button"><?php }?>
			<input type="button" value=" Add Round " onClick="if(check_permission()){document.event_add_round.submit();}" class="block-button">
		</h1>
		<table width="100%" cellpadding="2" cellspacing="2">
		<tr>
			<td width="2%" align="left"></td>
			<th width="10%" align="right" nowrap></th>
			<th colspan="<?php if ($_smarty_tpl->tpl_vars['event']->value->totals['total_rounds']>9){?>10<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['event']->value->totals['total_rounds']+1;?>
<?php }?>" align="center" nowrap>
				Completed Rounds (<?php if ($_smarty_tpl->tpl_vars['event']->value->totals['round_drops']==0){?>No<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['event']->value->totals['round_drops'];?>
<?php }?> Drop<?php if ($_smarty_tpl->tpl_vars['event']->value->totals['round_drops']!=1){?>s<?php }?> In Effect)
			</th>
			<th width="5%" nowrap>SubTotal</th>
			<th width="5%" nowrap>Pen</th>
			<th width="5%" nowrap>Total Score</th>
			<th width="5%" nowrap>Percent</th>
		</tr>
		<tr>
			<th width="2%" align="left"></th>
			<th width="10%" align="right" nowrap>Pilot Name</th>
			<?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['event']->value->rounds; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['r']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
 $_smarty_tpl->tpl_vars['r']->iteration++;
?>
				<?php if ($_smarty_tpl->tpl_vars['r']->value['event_round_flyoff']!=0){?>
					<?php continue 1?>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['r']->iteration<=9){?>
				<th class="info" width="5%" align="center" nowrap>
					<div style="position:relative;">
					<span>
						<?php $_smarty_tpl->tpl_vars['flight_type_id'] = new Smarty_variable($_smarty_tpl->tpl_vars['r']->value['flight_type_id'], null, 0);?>
						<?php if ($_smarty_tpl->tpl_vars['r']->value['event_round_score_status']==0||($_smarty_tpl->tpl_vars['event']->value->info['event_type_code']!='f3b'&&$_smarty_tpl->tpl_vars['r']->value['flights'][$_smarty_tpl->tpl_vars['flight_type_id']->value]['event_round_flight_score']==0&&$_smarty_tpl->tpl_vars['flight_type_id']->value!=0)){?>
							<font color="red"><b>Round Not Currently Scored</b></font><br>
						<?php }?>
						<?php if (strstr($_smarty_tpl->tpl_vars['event']->value->flight_types[$_smarty_tpl->tpl_vars['flight_type_id']->value]['flight_type_code'],"f3k")){?>
							View Details of Round<br><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->flight_types[$_smarty_tpl->tpl_vars['flight_type_id']->value]['flight_type_name'], ENT_QUOTES, 'UTF-8', true);?>

						<?php }else{ ?>
							View Details of Round <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value['event_round_number'], ENT_QUOTES, 'UTF-8', true);?>

						<?php }?>
					</span>
					<a href="/?action=event&function=event_round_edit&event_id=<?php echo $_smarty_tpl->tpl_vars['event']->value->info['event_id'];?>
&event_round_id=<?php echo $_smarty_tpl->tpl_vars['r']->value['event_round_id'];?>
" title="Edit Round"><?php if ($_smarty_tpl->tpl_vars['r']->value['event_round_score_status']==0||($_smarty_tpl->tpl_vars['event']->value->info['event_type_code']!='f3b'&&$_smarty_tpl->tpl_vars['r']->value['flights'][$_smarty_tpl->tpl_vars['flight_type_id']->value]['event_round_flight_score']==0&&$_smarty_tpl->tpl_vars['flight_type_id']->value!=0)){?><del><font color="red"><?php }?>Round <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value['event_round_number'], ENT_QUOTES, 'UTF-8', true);?>
<?php if ($_smarty_tpl->tpl_vars['r']->value['event_round_score_status']==0||($_smarty_tpl->tpl_vars['event']->value->info['event_type_code']!='f3b'&&$_smarty_tpl->tpl_vars['r']->value['flights'][$_smarty_tpl->tpl_vars['flight_type_id']->value]['event_round_flight_score']==0&&$_smarty_tpl->tpl_vars['flight_type_id']->value!=0)){?></del></font><?php }?></a>
					</div>
				</th>
				<?php }?>
			<?php } ?>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
		<?php  $_smarty_tpl->tpl_vars['e'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['e']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['event']->value->totals['pilots']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['e']->key => $_smarty_tpl->tpl_vars['e']->value){
$_smarty_tpl->tpl_vars['e']->_loop = true;
?>
		<?php $_smarty_tpl->tpl_vars['event_pilot_id'] = new Smarty_variable($_smarty_tpl->tpl_vars['e']->value['event_pilot_id'], null, 0);?>
		<tr style="background-color: <?php echo smarty_function_cycle(array('values'=>"#9DCFF0,white"),$_smarty_tpl);?>
;">
			<td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['e']->value['overall_rank'], ENT_QUOTES, 'UTF-8', true);?>
</td>
			<td align="right" nowrap><a href="?action=event&function=event_pilot_rounds&event_pilot_id=<?php echo $_smarty_tpl->tpl_vars['e']->value['event_pilot_id'];?>
&event_id=<?php echo $_smarty_tpl->tpl_vars['event']->value->info['event_id'];?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['e']->value['pilot_first_name'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['e']->value['pilot_last_name'], ENT_QUOTES, 'UTF-8', true);?>
</a></td>
			<?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['e']->value['rounds']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['r']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
 $_smarty_tpl->tpl_vars['r']->iteration++;
?>
				<?php if ($_smarty_tpl->tpl_vars['r']->iteration<=9){?>
				<td class="info" align="right"<?php if ($_smarty_tpl->tpl_vars['r']->value['event_pilot_round_rank']==1||($_smarty_tpl->tpl_vars['event']->value->info['event_type_code']!='f3b'&&$_smarty_tpl->tpl_vars['r']->value['event_pilot_round_total_score']==1000)){?> style="border-width: 2px;border-color: green;color:green;font-weight:bold;"<?php }?>>
					<div style="position:relative;">
					<?php $_smarty_tpl->tpl_vars['dropval'] = new Smarty_variable(0, null, 0);?>
					<?php $_smarty_tpl->tpl_vars['dropped'] = new Smarty_variable(0, null, 0);?>
					<?php  $_smarty_tpl->tpl_vars['f'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['f']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['r']->value['flights']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['f']->key => $_smarty_tpl->tpl_vars['f']->value){
$_smarty_tpl->tpl_vars['f']->_loop = true;
?>
						<?php if ($_smarty_tpl->tpl_vars['f']->value['event_pilot_round_flight_dropped']){?>
							<?php $_smarty_tpl->tpl_vars['dropval'] = new Smarty_variable($_smarty_tpl->tpl_vars['dropval']->value+$_smarty_tpl->tpl_vars['f']->value['event_pilot_round_total_score'], null, 0);?>
							<?php $_smarty_tpl->tpl_vars['dropped'] = new Smarty_variable(1, null, 0);?>
						<?php }?>
					<?php } ?>
					<?php $_smarty_tpl->tpl_vars['drop'] = new Smarty_variable(0, null, 0);?>
					<?php if ($_smarty_tpl->tpl_vars['dropped']->value==1&&$_smarty_tpl->tpl_vars['dropval']->value==$_smarty_tpl->tpl_vars['r']->value['event_pilot_round_total_score']){?><?php $_smarty_tpl->tpl_vars['drop'] = new Smarty_variable(1, null, 0);?><?php }?>
					<?php if ($_smarty_tpl->tpl_vars['drop']->value==1){?><del><font color="red"><?php }?>
						<?php echo sprintf("%06.3f",$_smarty_tpl->tpl_vars['r']->value['event_pilot_round_total_score']);?>

					<?php if ($_smarty_tpl->tpl_vars['drop']->value==1){?></font></del><?php }?>
					
						<span>
							<?php $_smarty_tpl->tpl_vars['event_round_number'] = new Smarty_variable($_smarty_tpl->tpl_vars['r']->key, null, 0);?>
							<?php  $_smarty_tpl->tpl_vars['f'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['f']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['event']->value->rounds[$_smarty_tpl->tpl_vars['event_round_number']->value]['flights']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['f']->key => $_smarty_tpl->tpl_vars['f']->value){
$_smarty_tpl->tpl_vars['f']->_loop = true;
?>
								<?php if (strstr($_smarty_tpl->tpl_vars['f']->value['flight_type_code'],'duration')||strstr($_smarty_tpl->tpl_vars['f']->value['flight_type_code'],'f3k')){?>
									<?php if ($_smarty_tpl->tpl_vars['f']->value['flight_type_code']=='f3b_duration'){?>A - <?php }?>
									<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['f']->value['pilots'][$_smarty_tpl->tpl_vars['event_pilot_id']->value]['event_pilot_round_flight_minutes'], ENT_QUOTES, 'UTF-8', true);?>
:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['f']->value['pilots'][$_smarty_tpl->tpl_vars['event_pilot_id']->value]['event_pilot_round_flight_seconds'], ENT_QUOTES, 'UTF-8', true);?>
<?php if ($_smarty_tpl->tpl_vars['f']->value['flight_type_landing']){?> - <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['f']->value['pilots'][$_smarty_tpl->tpl_vars['event_pilot_id']->value]['event_pilot_round_flight_landing'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?><br>
								<?php }?>
								<?php if (strstr($_smarty_tpl->tpl_vars['f']->value['flight_type_code'],'distance')){?>
									<?php if ($_smarty_tpl->tpl_vars['f']->value['flight_type_code']=='f3b_distance'){?>B - <?php }?>
									<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['f']->value['pilots'][$_smarty_tpl->tpl_vars['event_pilot_id']->value]['event_pilot_round_flight_laps'], ENT_QUOTES, 'UTF-8', true);?>
 Laps<br>
								<?php }?>
								<?php if (strstr($_smarty_tpl->tpl_vars['f']->value['flight_type_code'],'speed')){?>
									<?php if ($_smarty_tpl->tpl_vars['f']->value['flight_type_code']=='f3b_speed'){?>C - <?php }?>
									<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['f']->value['pilots'][$_smarty_tpl->tpl_vars['event_pilot_id']->value]['event_pilot_round_flight_seconds'], ENT_QUOTES, 'UTF-8', true);?>
s
								<?php }?>
							<?php } ?>
						</span>
					</div>
				</td>
				<?php }?>
			<?php } ?>
			<td></td>
			<td width="5%" nowrap align="right"><?php echo sprintf("%06.3f",$_smarty_tpl->tpl_vars['e']->value['subtotal']);?>
</td>
			<td width="5%" align="center" nowrap><?php if ($_smarty_tpl->tpl_vars['e']->value['penalties']!=0){?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['e']->value['penalties'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?></td>
			<td width="5%" nowrap align="right"><?php echo sprintf("%06.3f",$_smarty_tpl->tpl_vars['e']->value['total']);?>
</td>
			<td width="5%" nowrap align="right"><?php echo sprintf("%03.2f",$_smarty_tpl->tpl_vars['e']->value['event_pilot_total_percentage']);?>
%</td>
		</tr>
		<?php } ?>
		<?php if ($_smarty_tpl->tpl_vars['event']->value->info['event_type_code']=='f3f'){?>
		<tr>
			<th colspan="2" align="right">Round Fast Time</th>
			<?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['event']->value->rounds; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['r']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
 $_smarty_tpl->tpl_vars['r']->iteration++;
?>
				<?php if ($_smarty_tpl->tpl_vars['r']->iteration<=9){?>
					<?php $_smarty_tpl->tpl_vars['fast'] = new Smarty_variable(1000, null, 0);?>
					<?php $_smarty_tpl->tpl_vars['fast_id'] = new Smarty_variable(0, null, 0);?>
					<?php  $_smarty_tpl->tpl_vars['f'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['f']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['r']->value['flights']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['f']->key => $_smarty_tpl->tpl_vars['f']->value){
$_smarty_tpl->tpl_vars['f']->_loop = true;
?>
						<?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['f']->value['pilots']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
?>
						<?php if ($_smarty_tpl->tpl_vars['p']->value['event_pilot_round_flight_seconds']<$_smarty_tpl->tpl_vars['fast']->value&&$_smarty_tpl->tpl_vars['p']->value['event_pilot_round_flight_seconds']!=0){?>
							<?php $_smarty_tpl->tpl_vars['fast'] = new Smarty_variable($_smarty_tpl->tpl_vars['p']->value['event_pilot_round_flight_seconds'], null, 0);?>
							<?php $_smarty_tpl->tpl_vars['fast_id'] = new Smarty_variable($_smarty_tpl->tpl_vars['p']->value['event_pilot_id'], null, 0);?>
						<?php }?>
						<?php } ?>
					<?php } ?>
					<?php if ($_smarty_tpl->tpl_vars['fast']->value==1000){?><?php $_smarty_tpl->tpl_vars['fast'] = new Smarty_variable(0, null, 0);?><?php }?>
					<th class="info" align="center">
						<div style="position:relative;">
						<a href="" onClick="return false;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['fast']->value, ENT_QUOTES, 'UTF-8', true);?>
s</a>
						<span>
							Fast Time : <?php echo $_smarty_tpl->tpl_vars['fast']->value;?>
s<br>
							<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->pilots[$_smarty_tpl->tpl_vars['fast_id']->value]['pilot_first_name'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->pilots[$_smarty_tpl->tpl_vars['fast_id']->value]['pilot_last_name'], ENT_QUOTES, 'UTF-8', true);?>

						</span>
						</div>
					</th>
				<?php }?>
			<?php } ?>
		</tr>
		<?php }?>
		</table>

		<?php if ($_smarty_tpl->tpl_vars['event']->value->totals['total_rounds']>9){?>
		<br>
		<h1 class="post-title entry-title">Event <?php if (count($_smarty_tpl->tpl_vars['event']->value->flyoff_totals)>0){?>Preliminary <?php }?>Rounds <?php if ($_smarty_tpl->tpl_vars['event']->value->rounds){?>(<?php echo $_smarty_tpl->tpl_vars['event']->value->totals['total_rounds'];?>
) <?php }?> Overall Classification
			<input type="button" value=" Add Flyoff Round " onClick="document.event_add_round.flyoff_round.value=1; document.event_add_round.submit();" class="block-button">
			<?php if ($_smarty_tpl->tpl_vars['event']->value->info['event_type_zero_round']==1){?><input type="button" value=" Add Zero Round " onClick="document.event_add_round.zero_round.value=1; document.event_add_round.submit();" class="block-button"><?php }?>
			<input type="button" value=" Add Round " onClick="document.event_add_round.submit();" class="block-button">
		</h1>
		<table width="100%" cellpadding="2" cellspacing="2">
		<tr>
			<td width="2%" align="left"></td>
			<th width="10%" align="right" nowrap></th>
			<th colspan="<?php echo $_smarty_tpl->tpl_vars['event']->value->totals['total_rounds']-8;?>
" align="center" nowrap>
				Completed Rounds (<?php if ($_smarty_tpl->tpl_vars['event']->value->totals['round_drops']==0){?>No<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['event']->value->totals['round_drops'];?>
<?php }?> Drop<?php if ($_smarty_tpl->tpl_vars['event']->value->totals['round_drops']!=1){?>s<?php }?> In Effect)
			</th>
			<th width="5%" nowrap>SubTotal</th>
			<th width="5%" nowrap>Pen</th>
			<th width="5%" nowrap>Total Score</th>
			<th width="5%" nowrap>Percent</th>
		</tr>
		<tr>
			<th width="2%" align="left"></th>
			<th width="10%" align="right" nowrap>Pilot Name</th>
			<?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['event']->value->rounds; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['r']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
 $_smarty_tpl->tpl_vars['r']->iteration++;
?>
				<?php if ($_smarty_tpl->tpl_vars['r']->value['event_round_flyoff']!=0){?>
					<?php continue 1?>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['r']->iteration>9){?>
				<th class="info" width="5%" align="center" nowrap>
					<div style="position:relative;">
					<span>
						<?php $_smarty_tpl->tpl_vars['flight_type_id'] = new Smarty_variable($_smarty_tpl->tpl_vars['r']->value['flight_type_id'], null, 0);?>
						<?php if ($_smarty_tpl->tpl_vars['r']->value['event_round_score_status']==0||($_smarty_tpl->tpl_vars['event']->value->info['event_type_code']!='f3b'&&$_smarty_tpl->tpl_vars['r']->value['flights'][$_smarty_tpl->tpl_vars['flight_type_id']->value]['event_round_flight_score']==0&&$_smarty_tpl->tpl_vars['flight_type_id']->value!=0)){?>
							<font color="red"><b>Round Not Currently Scored</b></font><br>
						<?php }?>
						<?php if (strstr($_smarty_tpl->tpl_vars['event']->value->flight_types[$_smarty_tpl->tpl_vars['flight_type_id']->value]['flight_type_code'],"f3k")){?>
							View Details of Round<br><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->flight_types[$_smarty_tpl->tpl_vars['flight_type_id']->value]['flight_type_name'], ENT_QUOTES, 'UTF-8', true);?>

						<?php }else{ ?>
							View Details of Round <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value['event_round_number'], ENT_QUOTES, 'UTF-8', true);?>

						<?php }?>
					</span>
					<a href="/?action=event&function=event_round_edit&event_id=<?php echo $_smarty_tpl->tpl_vars['event']->value->info['event_id'];?>
&event_round_id=<?php echo $_smarty_tpl->tpl_vars['r']->value['event_round_id'];?>
" title="Edit Round"><?php if ($_smarty_tpl->tpl_vars['r']->value['event_round_score_status']==0||($_smarty_tpl->tpl_vars['event']->value->info['event_type_code']!='f3b'&&$_smarty_tpl->tpl_vars['r']->value['flights'][$_smarty_tpl->tpl_vars['flight_type_id']->value]['event_round_flight_score']==0&&$_smarty_tpl->tpl_vars['flight_type_id']->value!=0)){?><del><font color="red"><?php }?>Round <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value['event_round_number'], ENT_QUOTES, 'UTF-8', true);?>
<?php if ($_smarty_tpl->tpl_vars['r']->value['event_round_score_status']==0||($_smarty_tpl->tpl_vars['event']->value->info['event_type_code']!='f3b'&&$_smarty_tpl->tpl_vars['r']->value['flights'][$_smarty_tpl->tpl_vars['flight_type_id']->value]['event_round_flight_score']==0&&$_smarty_tpl->tpl_vars['flight_type_id']->value!=0)){?></del></font><?php }?></a>
					</div>
				</th>
				<?php }?>
			<?php } ?>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
		<?php  $_smarty_tpl->tpl_vars['e'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['e']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['event']->value->totals['pilots']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['e']->key => $_smarty_tpl->tpl_vars['e']->value){
$_smarty_tpl->tpl_vars['e']->_loop = true;
?>
		<?php $_smarty_tpl->tpl_vars['event_pilot_id'] = new Smarty_variable($_smarty_tpl->tpl_vars['e']->value['event_pilot_id'], null, 0);?>
		<tr style="background-color: <?php echo smarty_function_cycle(array('values'=>"#9DCFF0,white"),$_smarty_tpl);?>
;">
			<td><?php echo $_smarty_tpl->tpl_vars['e']->value['overall_rank'];?>
</td>
			<td align="right" nowrap><a href="?action=event&function=event_pilot_rounds&event_pilot_id=<?php echo $_smarty_tpl->tpl_vars['e']->value['event_pilot_id'];?>
&event_id=<?php echo $_smarty_tpl->tpl_vars['event']->value->info['event_id'];?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['e']->value['pilot_first_name'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['e']->value['pilot_last_name'], ENT_QUOTES, 'UTF-8', true);?>
</a></td>
			<?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['e']->value['rounds']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['r']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
 $_smarty_tpl->tpl_vars['r']->iteration++;
?>
				<?php if ($_smarty_tpl->tpl_vars['r']->iteration>9){?>
				<td class="info" align="right"<?php if ($_smarty_tpl->tpl_vars['r']->value['event_pilot_round_rank']==1||($_smarty_tpl->tpl_vars['event']->value->info['event_type_code']!='f3b'&&$_smarty_tpl->tpl_vars['r']->value['event_pilot_round_total_score']==1000)){?> style="border-width: 2px;border-color: green;color:green;font-weight:bold;"<?php }?>>
					<div style="position:relative;">
					<?php $_smarty_tpl->tpl_vars['dropval'] = new Smarty_variable(0, null, 0);?>
					<?php $_smarty_tpl->tpl_vars['dropped'] = new Smarty_variable(0, null, 0);?>
					<?php  $_smarty_tpl->tpl_vars['f'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['f']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['r']->value['flights']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['f']->key => $_smarty_tpl->tpl_vars['f']->value){
$_smarty_tpl->tpl_vars['f']->_loop = true;
?>
						<?php if ($_smarty_tpl->tpl_vars['f']->value['event_pilot_round_flight_dropped']){?>
							<?php $_smarty_tpl->tpl_vars['dropval'] = new Smarty_variable($_smarty_tpl->tpl_vars['dropval']->value+$_smarty_tpl->tpl_vars['f']->value['event_pilot_round_total_score'], null, 0);?>
							<?php $_smarty_tpl->tpl_vars['dropped'] = new Smarty_variable(1, null, 0);?>
						<?php }?>
					<?php } ?>
					<?php $_smarty_tpl->tpl_vars['drop'] = new Smarty_variable(0, null, 0);?>
					<?php if ($_smarty_tpl->tpl_vars['dropped']->value==1&&$_smarty_tpl->tpl_vars['dropval']->value==$_smarty_tpl->tpl_vars['r']->value['event_pilot_round_total_score']){?><?php $_smarty_tpl->tpl_vars['drop'] = new Smarty_variable(1, null, 0);?><?php }?>
					<?php if ($_smarty_tpl->tpl_vars['drop']->value==1){?><del><font color="red"><?php }?>
						<?php echo sprintf("%06.3f",$_smarty_tpl->tpl_vars['r']->value['event_pilot_round_total_score']);?>

					<?php if ($_smarty_tpl->tpl_vars['drop']->value==1){?></font></del><?php }?>
					
						<span>
							<?php $_smarty_tpl->tpl_vars['event_round_number'] = new Smarty_variable($_smarty_tpl->tpl_vars['r']->key, null, 0);?>
							<?php  $_smarty_tpl->tpl_vars['f'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['f']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['event']->value->rounds[$_smarty_tpl->tpl_vars['event_round_number']->value]['flights']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['f']->key => $_smarty_tpl->tpl_vars['f']->value){
$_smarty_tpl->tpl_vars['f']->_loop = true;
?>
								<?php if (strstr($_smarty_tpl->tpl_vars['f']->value['flight_type_code'],'duration')||strstr($_smarty_tpl->tpl_vars['f']->value['flight_type_code'],'f3k')){?>
									<?php if ($_smarty_tpl->tpl_vars['f']->value['flight_type_code']=='f3b_duration'){?>A - <?php }?>
									<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['f']->value['pilots'][$_smarty_tpl->tpl_vars['event_pilot_id']->value]['event_pilot_round_flight_minutes'], ENT_QUOTES, 'UTF-8', true);?>
:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['f']->value['pilots'][$_smarty_tpl->tpl_vars['event_pilot_id']->value]['event_pilot_round_flight_seconds'], ENT_QUOTES, 'UTF-8', true);?>
<?php if ($_smarty_tpl->tpl_vars['f']->value['flight_type_landing']){?> - <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['f']->value['pilots'][$_smarty_tpl->tpl_vars['event_pilot_id']->value]['event_pilot_round_flight_landing'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?><br>
								<?php }?>
								<?php if (strstr($_smarty_tpl->tpl_vars['f']->value['flight_type_code'],'distance')){?>
									<?php if ($_smarty_tpl->tpl_vars['f']->value['flight_type_code']=='f3b_distance'){?>B - <?php }?>
									<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['f']->value['pilots'][$_smarty_tpl->tpl_vars['event_pilot_id']->value]['event_pilot_round_flight_laps'], ENT_QUOTES, 'UTF-8', true);?>
 Laps<br>
								<?php }?>
								<?php if (strstr($_smarty_tpl->tpl_vars['f']->value['flight_type_code'],'speed')){?>
									<?php if ($_smarty_tpl->tpl_vars['f']->value['flight_type_code']=='f3b_speed'){?>C - <?php }?>
									<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['f']->value['pilots'][$_smarty_tpl->tpl_vars['event_pilot_id']->value]['event_pilot_round_flight_seconds'], ENT_QUOTES, 'UTF-8', true);?>
s
								<?php }?>
							<?php } ?>
						</span>
					</div>
				</td>
				<?php }?>
			<?php } ?>
			<td></td>
			<td width="5%" nowrap align="right"><?php echo sprintf("%06.3f",$_smarty_tpl->tpl_vars['e']->value['subtotal']);?>
</td>
			<td width="5%" align="center" nowrap><?php if ($_smarty_tpl->tpl_vars['e']->value['penalties']!=0){?><?php echo $_smarty_tpl->tpl_vars['e']->value['penalties'];?>
<?php }?></td>
			<td width="5%" nowrap align="right"><?php echo sprintf("%06.3f",$_smarty_tpl->tpl_vars['e']->value['total']);?>
</td>
			<td width="5%" nowrap align="right"><?php echo sprintf("%03.2f",$_smarty_tpl->tpl_vars['e']->value['event_pilot_total_percentage']);?>
%</td>
		</tr>
		<?php } ?>
		<?php if ($_smarty_tpl->tpl_vars['event']->value->info['event_type_code']=='f3f'){?>
		<tr>
			<th colspan="2" align="right">Round Fast Time</th>
			<?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['event']->value->rounds; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['r']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
 $_smarty_tpl->tpl_vars['r']->iteration++;
?>
				<?php if ($_smarty_tpl->tpl_vars['r']->iteration>9){?>
					<?php $_smarty_tpl->tpl_vars['fast'] = new Smarty_variable(1000, null, 0);?>
					<?php $_smarty_tpl->tpl_vars['fast_id'] = new Smarty_variable(0, null, 0);?>
					<?php  $_smarty_tpl->tpl_vars['f'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['f']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['r']->value['flights']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['f']->key => $_smarty_tpl->tpl_vars['f']->value){
$_smarty_tpl->tpl_vars['f']->_loop = true;
?>
						<?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['f']->value['pilots']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
?>
						<?php if ($_smarty_tpl->tpl_vars['p']->value['event_pilot_round_flight_seconds']<$_smarty_tpl->tpl_vars['fast']->value&&$_smarty_tpl->tpl_vars['p']->value['event_pilot_round_flight_seconds']!=0){?>
							<?php $_smarty_tpl->tpl_vars['fast'] = new Smarty_variable($_smarty_tpl->tpl_vars['p']->value['event_pilot_round_flight_seconds'], null, 0);?>
							<?php $_smarty_tpl->tpl_vars['fast_id'] = new Smarty_variable($_smarty_tpl->tpl_vars['p']->value['event_pilot_id'], null, 0);?>
						<?php }?>
						<?php } ?>
					<?php } ?>
					<?php if ($_smarty_tpl->tpl_vars['fast']->value==1000){?><?php $_smarty_tpl->tpl_vars['fast'] = new Smarty_variable(0, null, 0);?><?php }?>
					<th class="info" align="center">
						<div style="position:relative;">
						<a href="" onClick="return false;"><?php echo $_smarty_tpl->tpl_vars['fast']->value;?>
s</a>
						<span>
							Fast Time : <?php echo $_smarty_tpl->tpl_vars['fast']->value;?>
s<br>
							<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->pilots[$_smarty_tpl->tpl_vars['fast_id']->value]['pilot_first_name'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->pilots[$_smarty_tpl->tpl_vars['fast_id']->value]['pilot_last_name'], ENT_QUOTES, 'UTF-8', true);?>

						</span>
						</div>
					</th>
				<?php }?>
			<?php } ?>
		</tr>
		<?php }?>
		</table>
		<?php }?>




		<!--# Now lets do the flyoff rounds -->
		<?php  $_smarty_tpl->tpl_vars['t'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['t']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['event']->value->flyoff_totals; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['t']->key => $_smarty_tpl->tpl_vars['t']->value){
$_smarty_tpl->tpl_vars['t']->_loop = true;
?>
			<br>
			<?php $_smarty_tpl->tpl_vars['flyoff_number'] = new Smarty_variable($_smarty_tpl->tpl_vars['t']->key, null, 0);?>
		<h1 class="post-title entry-title">Event Flyoff #<?php echo $_smarty_tpl->tpl_vars['flyoff_number']->value;?>
 Rounds (<?php echo $_smarty_tpl->tpl_vars['t']->value['total_rounds'];?>
) Overall Classification
		</h1>
		<table width="100%" cellpadding="2" cellspacing="2">
		<tr>
			<td width="2%" align="left"></td>
			<th width="10%" align="right" nowrap></th>
			<th colspan="<?php echo $_smarty_tpl->tpl_vars['t']->value['total_rounds']+1;?>
" align="center" nowrap>
				Completed Rounds (<?php if ($_smarty_tpl->tpl_vars['t']->value['round_drops']==0){?>No<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['t']->value['round_drops'];?>
<?php }?> Drop<?php if ($_smarty_tpl->tpl_vars['t']->value['round_drops']!=1){?>s<?php }?> In Effect)
			</th>
			<th width="5%" nowrap>SubTotal</th>
			<th width="5%" nowrap>Pen</th>
			<th width="5%" nowrap>Total Score</th>
			<th width="5%" nowrap>Percent</th>
		</tr>
		<tr>
			<th width="2%" align="left"></th>
			<th width="10%" align="right" nowrap>Pilot Name</th>
			<?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['event']->value->rounds; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['r']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
 $_smarty_tpl->tpl_vars['r']->iteration++;
?>
				<?php if ($_smarty_tpl->tpl_vars['r']->value['event_round_flyoff']!=$_smarty_tpl->tpl_vars['flyoff_number']->value){?>
					<?php continue 1?>
				<?php }?>
				<th class="info" width="5%" align="center" nowrap>
					<div style="position:relative;">
					<span>
						<?php $_smarty_tpl->tpl_vars['flight_type_id'] = new Smarty_variable($_smarty_tpl->tpl_vars['r']->value['flight_type_id'], null, 0);?>
						<?php if (strstr($_smarty_tpl->tpl_vars['event']->value->flight_types[$_smarty_tpl->tpl_vars['flight_type_id']->value]['flight_type_code'],"f3k")){?>
							View Details of Round<br><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->flight_types[$_smarty_tpl->tpl_vars['flight_type_id']->value]['flight_type_name'], ENT_QUOTES, 'UTF-8', true);?>

						<?php }else{ ?>
							View Details of Round <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value['event_round_number'], ENT_QUOTES, 'UTF-8', true);?>

						<?php }?>
					</span>
					<a href="/?action=event&function=event_round_edit&event_id=<?php echo $_smarty_tpl->tpl_vars['event']->value->info['event_id'];?>
&event_round_id=<?php echo $_smarty_tpl->tpl_vars['r']->value['event_round_id'];?>
" title="Edit Round"><?php if ($_smarty_tpl->tpl_vars['r']->value['event_round_score_status']==0){?><del><font color="red"><?php }?>Round <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value['event_round_number'], ENT_QUOTES, 'UTF-8', true);?>
<?php if ($_smarty_tpl->tpl_vars['r']->value['event_round_score_status']==0){?></del></font><?php }?></a>
					</div>
				</th>
			<?php } ?>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
		<?php  $_smarty_tpl->tpl_vars['e'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['e']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['t']->value['pilots']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['e']->key => $_smarty_tpl->tpl_vars['e']->value){
$_smarty_tpl->tpl_vars['e']->_loop = true;
?>
		<?php $_smarty_tpl->tpl_vars['event_pilot_id'] = new Smarty_variable($_smarty_tpl->tpl_vars['e']->value['event_pilot_id'], null, 0);?>
		<tr style="background-color: <?php echo smarty_function_cycle(array('values'=>"#9DCFF0,white"),$_smarty_tpl);?>
;">
			<td><?php echo $_smarty_tpl->tpl_vars['e']->value['overall_rank'];?>
</td>
			<td align="right" nowrap><a href="?action=event&function=event_pilot_rounds&event_pilot_id=<?php echo $_smarty_tpl->tpl_vars['e']->value['event_pilot_id'];?>
&event_id=<?php echo $_smarty_tpl->tpl_vars['event']->value->info['event_id'];?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['e']->value['pilot_first_name'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['e']->value['pilot_last_name'], ENT_QUOTES, 'UTF-8', true);?>
</a></td>
			<?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['e']->value['rounds']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['r']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
 $_smarty_tpl->tpl_vars['r']->iteration++;
?>
				<?php if ($_smarty_tpl->tpl_vars['r']->iteration<=9){?>
				<td class="info" align="right"<?php if ($_smarty_tpl->tpl_vars['r']->value['event_pilot_round_rank']==1||($_smarty_tpl->tpl_vars['event']->value->info['event_type_code']!='f3b'&&$_smarty_tpl->tpl_vars['r']->value['event_pilot_round_total_score']==1000)){?> style="border-width: 2px;border-color: green;color:green;font-weight:bold;"<?php }?>>
					<div style="position:relative;">
					<?php $_smarty_tpl->tpl_vars['dropval'] = new Smarty_variable(0, null, 0);?>
					<?php $_smarty_tpl->tpl_vars['dropped'] = new Smarty_variable(0, null, 0);?>
					<?php  $_smarty_tpl->tpl_vars['f'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['f']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['r']->value['flights']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['f']->key => $_smarty_tpl->tpl_vars['f']->value){
$_smarty_tpl->tpl_vars['f']->_loop = true;
?>
						<?php if ($_smarty_tpl->tpl_vars['f']->value['event_pilot_round_flight_dropped']){?>
							<?php $_smarty_tpl->tpl_vars['dropval'] = new Smarty_variable($_smarty_tpl->tpl_vars['dropval']->value+$_smarty_tpl->tpl_vars['f']->value['event_pilot_round_total_score'], null, 0);?>
							<?php $_smarty_tpl->tpl_vars['dropped'] = new Smarty_variable(1, null, 0);?>
						<?php }?>
					<?php } ?>
					<?php $_smarty_tpl->tpl_vars['drop'] = new Smarty_variable(0, null, 0);?>
					<?php if ($_smarty_tpl->tpl_vars['dropped']->value==1&&$_smarty_tpl->tpl_vars['dropval']->value==$_smarty_tpl->tpl_vars['r']->value['event_pilot_round_total_score']){?><?php $_smarty_tpl->tpl_vars['drop'] = new Smarty_variable(1, null, 0);?><?php }?>
					<?php if ($_smarty_tpl->tpl_vars['drop']->value==1){?><del><font color="red"><?php }?>
						<?php echo sprintf("%06.3f",$_smarty_tpl->tpl_vars['r']->value['event_pilot_round_total_score']);?>

					<?php if ($_smarty_tpl->tpl_vars['drop']->value==1){?></font></del><?php }?>
					
						<span>
							<?php $_smarty_tpl->tpl_vars['event_round_number'] = new Smarty_variable($_smarty_tpl->tpl_vars['r']->key, null, 0);?>
							<?php  $_smarty_tpl->tpl_vars['f'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['f']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['event']->value->rounds[$_smarty_tpl->tpl_vars['event_round_number']->value]['flights']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['f']->key => $_smarty_tpl->tpl_vars['f']->value){
$_smarty_tpl->tpl_vars['f']->_loop = true;
?>
								<?php if (strstr($_smarty_tpl->tpl_vars['f']->value['flight_type_code'],'duration')||strstr($_smarty_tpl->tpl_vars['f']->value['flight_type_code'],'f3k')){?>
									<?php if ($_smarty_tpl->tpl_vars['f']->value['flight_type_code']=='f3b_duration'){?>A - <?php }?>
									<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['f']->value['pilots'][$_smarty_tpl->tpl_vars['event_pilot_id']->value]['event_pilot_round_flight_minutes'], ENT_QUOTES, 'UTF-8', true);?>
:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['f']->value['pilots'][$_smarty_tpl->tpl_vars['event_pilot_id']->value]['event_pilot_round_flight_seconds'], ENT_QUOTES, 'UTF-8', true);?>
<?php if ($_smarty_tpl->tpl_vars['f']->value['flight_type_landing']){?> - <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['f']->value['pilots'][$_smarty_tpl->tpl_vars['event_pilot_id']->value]['event_pilot_round_flight_landing'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?><br>
								<?php }?>
								<?php if (strstr($_smarty_tpl->tpl_vars['f']->value['flight_type_code'],'distance')){?>
									<?php if ($_smarty_tpl->tpl_vars['f']->value['flight_type_code']=='f3b_distance'){?>B - <?php }?>
									<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['f']->value['pilots'][$_smarty_tpl->tpl_vars['event_pilot_id']->value]['event_pilot_round_flight_laps'], ENT_QUOTES, 'UTF-8', true);?>
 Laps<br>
								<?php }?>
								<?php if (strstr($_smarty_tpl->tpl_vars['f']->value['flight_type_code'],'speed')){?>
									<?php if ($_smarty_tpl->tpl_vars['f']->value['flight_type_code']=='f3b_speed'){?>C - <?php }?>
									<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['f']->value['pilots'][$_smarty_tpl->tpl_vars['event_pilot_id']->value]['event_pilot_round_flight_seconds'], ENT_QUOTES, 'UTF-8', true);?>
s
								<?php }?>
							<?php } ?>
						</span>
					</div>
				</td>
				<?php }?>
			<?php } ?>
			<td></td>
			<td width="5%" nowrap align="right"><?php echo sprintf("%06.3f",$_smarty_tpl->tpl_vars['e']->value['subtotal']);?>
</td>
			<td width="5%" align="center" nowrap><?php if ($_smarty_tpl->tpl_vars['e']->value['penalties']!=0){?><?php echo $_smarty_tpl->tpl_vars['e']->value['penalties'];?>
<?php }?></td>
			<td width="5%" nowrap align="right"><?php echo sprintf("%06.3f",$_smarty_tpl->tpl_vars['e']->value['total']);?>
</td>
			<td width="5%" nowrap align="right"><?php echo sprintf("%03.2f",$_smarty_tpl->tpl_vars['e']->value['event_pilot_total_percentage']);?>
%</td>
		</tr>
		<?php } ?>
		<?php if ($_smarty_tpl->tpl_vars['event']->value->info['event_type_code']=='f3f'){?>
		<tr>
			<th colspan="2" align="right">Round Fast Time</th>
			<?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['event']->value->rounds; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['r']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
 $_smarty_tpl->tpl_vars['r']->iteration++;
?>
				<?php if ($_smarty_tpl->tpl_vars['r']->iteration<=9){?>
					<?php $_smarty_tpl->tpl_vars['fast'] = new Smarty_variable(1000, null, 0);?>
					<?php $_smarty_tpl->tpl_vars['fast_id'] = new Smarty_variable(0, null, 0);?>
					<?php  $_smarty_tpl->tpl_vars['f'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['f']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['r']->value['flights']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['f']->key => $_smarty_tpl->tpl_vars['f']->value){
$_smarty_tpl->tpl_vars['f']->_loop = true;
?>
						<?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['f']->value['pilots']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
?>
						<?php if ($_smarty_tpl->tpl_vars['p']->value['event_pilot_round_flight_seconds']<$_smarty_tpl->tpl_vars['fast']->value&&$_smarty_tpl->tpl_vars['p']->value['event_pilot_round_flight_seconds']!=0){?>
							<?php $_smarty_tpl->tpl_vars['fast'] = new Smarty_variable($_smarty_tpl->tpl_vars['p']->value['event_pilot_round_flight_seconds'], null, 0);?>
							<?php $_smarty_tpl->tpl_vars['fast_id'] = new Smarty_variable($_smarty_tpl->tpl_vars['p']->value['event_pilot_id'], null, 0);?>
						<?php }?>
						<?php } ?>
					<?php } ?>
					<?php if ($_smarty_tpl->tpl_vars['fast']->value==1000){?><?php $_smarty_tpl->tpl_vars['fast'] = new Smarty_variable(0, null, 0);?><?php }?>
					<th class="info" align="center">
						<div style="position:relative;">
						<a href="" onClick="return false;"><?php echo $_smarty_tpl->tpl_vars['fast']->value;?>
s</a>
						<span>
							Fast Time : <?php echo $_smarty_tpl->tpl_vars['fast']->value;?>
s<br>
							<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->pilots[$_smarty_tpl->tpl_vars['fast_id']->value]['pilot_first_name'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->pilots[$_smarty_tpl->tpl_vars['fast_id']->value]['pilot_last_name'], ENT_QUOTES, 'UTF-8', true);?>

						</span>
						</div>
					</th>
				<?php }?>
			<?php } ?>
		</tr>
		<?php }?>
		</table>
		
		
		<?php } ?>
		<!--# End of flyoff rounds -->



<br>
<input type="button" value=" Back To Event List " onClick="goback.submit();" class="block-button">
<input type="button" value=" Print Overall Classification " onClick="print_overall.submit();" class="block-button">
<?php if ($_smarty_tpl->tpl_vars['user']->value['user_id']!=0&&$_smarty_tpl->tpl_vars['user']->value['user_id']==$_smarty_tpl->tpl_vars['event']->value->info['user_id']){?>
<input type="button" value=" Delete Event " onClick="confirm('Are you sure you wish to delete this event?') && event_delete.submit();" class="block-button" style="float:none;margin-right:auto;">
<?php }?>
	</div>
</div>

<?php if (count($_smarty_tpl->tpl_vars['event']->value->classes)>1||$_smarty_tpl->tpl_vars['event']->value->totals['teams']||$_smarty_tpl->tpl_vars['duration_rank']->value||$_smarty_tpl->tpl_vars['speed_rank']->value){?>
<h1 class="post-title">Contest Ranking Reports
<input type="button" value=" Print Event Rankings " onClick="print_rank.submit();" class="block-button">
</h1>
<div class="page type-page status-publish hentry clearfix post nodate" style="display:inline-block;">
	<?php if (count($_smarty_tpl->tpl_vars['event']->value->classes)>1){?>
	<div class="entry clearfix" style="display:inline-block;vertical-align:top;">                
		<h1 class="post-title">Class Rankings</h1>
		<table cellpadding="2" cellspacing="1" class="tableborder">
			<?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['event']->value->classes; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
			<?php $_smarty_tpl->tpl_vars['rank'] = new Smarty_variable(1, null, 0);?>
					<tr>
						<th colspan="3" nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value['class_description'], ENT_QUOTES, 'UTF-8', true);?>
 Rankings</th>
					</tr>
					<tr>
						<th></th>
						<th>Pilot</th>
						<th>Total</th>
					</tr>
					<?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['event']->value->totals['pilots']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
?>
					<?php $_smarty_tpl->tpl_vars['event_pilot_id'] = new Smarty_variable($_smarty_tpl->tpl_vars['p']->value['event_pilot_id'], null, 0);?>
					<?php if ($_smarty_tpl->tpl_vars['event']->value->pilots[$_smarty_tpl->tpl_vars['event_pilot_id']->value]['class_id']==$_smarty_tpl->tpl_vars['c']->value['class_id']){?>
					<tr style="background-color: <?php echo smarty_function_cycle(array('values'=>"#9DCFF0,white"),$_smarty_tpl);?>
;">
						<td><?php echo $_smarty_tpl->tpl_vars['rank']->value;?>
</td>
						<td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['p']->value['pilot_first_name'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['p']->value['pilot_last_name'], ENT_QUOTES, 'UTF-8', true);?>
</td>
						<td><?php echo sprintf("%06.3f",$_smarty_tpl->tpl_vars['p']->value['total']);?>
</td>
					</tr>
					<?php $_smarty_tpl->tpl_vars['rank'] = new Smarty_variable($_smarty_tpl->tpl_vars['rank']->value+1, null, 0);?>
					<?php }?>
					<?php } ?>
			<?php } ?>
		</tr>
		</table>
	</div>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['event']->value->totals['teams']){?>
	<div class="entry clearfix" style="display:inline-block;vertical-align:top;">                
		<h1 class="post-title">Team Rankings</h1>
		<table cellpadding="2" cellspacing="1" class="tableborder">
		<tr>
			<th></th>
			<th>Team</th>
			<th>Total</th>
		</tr>
		<?php  $_smarty_tpl->tpl_vars['t'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['t']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['event']->value->totals['teams']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['t']->key => $_smarty_tpl->tpl_vars['t']->value){
$_smarty_tpl->tpl_vars['t']->_loop = true;
?>
		<tr style="background-color:#9DCFF0;">
			<td><?php echo $_smarty_tpl->tpl_vars['t']->value['rank'];?>
</td>
			<td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['t']->value['team_name'], ENT_QUOTES, 'UTF-8', true);?>
</td>
			<td><?php echo sprintf("%06.3f",$_smarty_tpl->tpl_vars['t']->value['total']);?>
</td>
		</tr>
			<?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['event']->value->totals['pilots']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
?>
			<?php $_smarty_tpl->tpl_vars['event_pilot_id'] = new Smarty_variable($_smarty_tpl->tpl_vars['p']->value['event_pilot_id'], null, 0);?>
			<?php if ($_smarty_tpl->tpl_vars['event']->value->pilots[$_smarty_tpl->tpl_vars['event_pilot_id']->value]['event_pilot_team']==$_smarty_tpl->tpl_vars['t']->value['team_name']){?>
			<tr>
				<td></td>
				<td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['p']->value['pilot_first_name'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['p']->value['pilot_last_name'], ENT_QUOTES, 'UTF-8', true);?>
</td>
				<td align="right"><?php echo sprintf("%06.3f",$_smarty_tpl->tpl_vars['p']->value['total']);?>
</td>
			</tr>
			<?php }?>
			<?php } ?>
		<?php } ?>
		</table>
	</div>
	<?php }?>
	
	<?php if ($_smarty_tpl->tpl_vars['duration_rank']->value){?>
	<div class="entry clearfix" style="display:inline-block;vertical-align:top;padding-bottom:10px;">                
		<h1 class="post-title">Duration Ranking</h1>
		<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
		<tr>
			<th></th>
			<th>Pilot</th>
			<th>Score</th>
		</tr>
		<?php $_smarty_tpl->tpl_vars['rank'] = new Smarty_variable(1, null, 0);?>
		<?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['duration_rank']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
?>
			<?php $_smarty_tpl->tpl_vars['event_pilot_id'] = new Smarty_variable($_smarty_tpl->tpl_vars['p']->value['event_pilot_id'], null, 0);?>
			<tr style="background-color: <?php echo smarty_function_cycle(array('values'=>"#9DCFF0,white"),$_smarty_tpl);?>
;">
				<td><?php echo $_smarty_tpl->tpl_vars['rank']->value;?>
</td>
				<td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->pilots[$_smarty_tpl->tpl_vars['event_pilot_id']->value]['pilot_first_name'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->pilots[$_smarty_tpl->tpl_vars['event_pilot_id']->value]['pilot_last_name'], ENT_QUOTES, 'UTF-8', true);?>
</td>
				<td align="center"><?php echo sprintf("%06.3f",$_smarty_tpl->tpl_vars['p']->value['event_pilot_round_flight_score']);?>
</td>
			</tr>
			<?php $_smarty_tpl->tpl_vars['rank'] = new Smarty_variable($_smarty_tpl->tpl_vars['rank']->value+1, null, 0);?>
		<?php } ?>
		</table>
	</div>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['distance_rank']->value){?>
	<div class="entry clearfix" style="display:inline-block;vertical-align:top;padding-bottom:10px;">                
		<h1 class="post-title">Distance Ranking</h1>
		<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
		<tr>
			<th></th>
			<th>Pilot</th>
			<th>Score</th>
		</tr>
		<?php $_smarty_tpl->tpl_vars['rank'] = new Smarty_variable(1, null, 0);?>
		<?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['distance_rank']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
?>
			<?php $_smarty_tpl->tpl_vars['event_pilot_id'] = new Smarty_variable($_smarty_tpl->tpl_vars['p']->value['event_pilot_id'], null, 0);?>
			<tr style="background-color: <?php echo smarty_function_cycle(array('values'=>"#9DCFF0,white"),$_smarty_tpl);?>
;">
				<td><?php echo $_smarty_tpl->tpl_vars['rank']->value;?>
</td>
				<td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->pilots[$_smarty_tpl->tpl_vars['event_pilot_id']->value]['pilot_first_name'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->pilots[$_smarty_tpl->tpl_vars['event_pilot_id']->value]['pilot_last_name'], ENT_QUOTES, 'UTF-8', true);?>
</td>
				<td align="center"><?php echo sprintf("%06.3f",$_smarty_tpl->tpl_vars['p']->value['event_pilot_round_flight_score']);?>
</td>
			</tr>
			<?php $_smarty_tpl->tpl_vars['rank'] = new Smarty_variable($_smarty_tpl->tpl_vars['rank']->value+1, null, 0);?>
		<?php } ?>
		</table>
	</div>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['speed_rank']->value){?>
	<div class="entry clearfix" style="display:inline-block;vertical-align:top;padding-bottom:10px;">                
		<h1 class="post-title">Speed Ranking</h1>
		<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
		<tr>
			<th></th>
			<th>Pilot</th>
			<th>Score</th>
		</tr>
		<?php $_smarty_tpl->tpl_vars['rank'] = new Smarty_variable(1, null, 0);?>
		<?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['speed_rank']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
?>
			<?php $_smarty_tpl->tpl_vars['event_pilot_id'] = new Smarty_variable($_smarty_tpl->tpl_vars['p']->value['event_pilot_id'], null, 0);?>
			<tr style="background-color: <?php echo smarty_function_cycle(array('values'=>"#9DCFF0,white"),$_smarty_tpl);?>
;">
				<td><?php echo $_smarty_tpl->tpl_vars['rank']->value;?>
</td>
				<td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->pilots[$_smarty_tpl->tpl_vars['event_pilot_id']->value]['pilot_first_name'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->pilots[$_smarty_tpl->tpl_vars['event_pilot_id']->value]['pilot_last_name'], ENT_QUOTES, 'UTF-8', true);?>
</td>
				<td align="center"><?php echo sprintf("%06.3f",$_smarty_tpl->tpl_vars['p']->value['event_pilot_round_flight_score']);?>
</td>
			</tr>
			<?php $_smarty_tpl->tpl_vars['rank'] = new Smarty_variable($_smarty_tpl->tpl_vars['rank']->value+1, null, 0);?>
		<?php } ?>
		</table>
	</div>
	<?php }?>
	
</div>
<?php }?>

<!-- Lets figure out if there are reports for speed or laps -->
<?php if ($_smarty_tpl->tpl_vars['lap_totals']->value||$_smarty_tpl->tpl_vars['speed_averages']->value||$_smarty_tpl->tpl_vars['top_landing']->value){?>
<h1 class="post-title">Statistics Reports
<input type="button" value=" Print Event Statistics " onClick="print_stats.submit();" class="block-button">
</h1>
<div class="page type-page status-publish hentry clearfix post nodate" style="display:inline-block;">
	<?php if ($_smarty_tpl->tpl_vars['lap_totals']->value){?>
	<div class="entry clearfix" style="display:inline-block;vertical-align:top;padding-bottom:10px;">                
		<h1 class="post-title">Total Distance Laps</h1>
		<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
		<tr>
			<th>Rank</th>
			<th>Pilot</th>
			<th>Laps</th>
		</tr>
		<?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lap_totals']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
?>
			<tr style="background-color: <?php echo smarty_function_cycle(array('values'=>"#9DCFF0,white"),$_smarty_tpl);?>
;">
				<td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['p']->value['event_pilot_lap_rank'], ENT_QUOTES, 'UTF-8', true);?>
</td>
				<td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['p']->value['pilot_first_name'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['p']->value['pilot_last_name'], ENT_QUOTES, 'UTF-8', true);?>
</td>
				<td align="center"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['p']->value['event_pilot_total_laps'], ENT_QUOTES, 'UTF-8', true);?>
</td>
			</tr>
		<?php } ?>
		</table>
	</div>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['distance_laps']->value){?>
	<div class="entry clearfix" style="display:inline-block;vertical-align:top;padding-bottom:10px;">                
		<h1 class="post-title">Top 20 Distance Runs</h1>
		<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
		<tr>
			<th>Rank</th>
			<th>Pilot</th>
			<th>Laps</th>
		</tr>
		<?php $_smarty_tpl->tpl_vars['rank'] = new Smarty_variable(1, null, 0);?>
		<?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['distance_laps']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
?>
			<?php $_smarty_tpl->tpl_vars['event_pilot_id'] = new Smarty_variable($_smarty_tpl->tpl_vars['p']->value['event_pilot_id'], null, 0);?>
			<tr style="background-color: <?php echo smarty_function_cycle(array('values'=>"#9DCFF0,white"),$_smarty_tpl);?>
;">
				<td><?php echo $_smarty_tpl->tpl_vars['rank']->value;?>
</td>
				<td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->pilots[$_smarty_tpl->tpl_vars['event_pilot_id']->value]['pilot_first_name'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->pilots[$_smarty_tpl->tpl_vars['event_pilot_id']->value]['pilot_last_name'], ENT_QUOTES, 'UTF-8', true);?>
</td>
				<td align="center"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['p']->value['event_pilot_round_flight_laps'], ENT_QUOTES, 'UTF-8', true);?>
</td>
			</tr>
			<?php if ($_smarty_tpl->tpl_vars['rank']->value==20){?><?php break 1?><?php }?>
			<?php $_smarty_tpl->tpl_vars['rank'] = new Smarty_variable($_smarty_tpl->tpl_vars['rank']->value+1, null, 0);?>
		<?php } ?>
		</table>
	</div>
	<?php }?>
	
	<?php if ($_smarty_tpl->tpl_vars['speed_averages']->value){?>
	<div class="entry clearfix" style="display:inline-block;vertical-align:top;padding-bottom:10px;">                
		<h1 class="post-title">Average Speeds</h1>
		<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
		<tr>
			<th>Rank</th>
			<th>Pilot</th>
			<th>Avg</th>
		</tr>
		<?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['speed_averages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
?>
			<?php if ($_smarty_tpl->tpl_vars['p']->value['event_pilot_average_speed_rank']!=0){?>
			<tr style="background-color: <?php echo smarty_function_cycle(array('values'=>"#9DCFF0,white"),$_smarty_tpl);?>
;">
				<td><?php echo $_smarty_tpl->tpl_vars['p']->value['event_pilot_average_speed_rank'];?>
</td>
				<td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['p']->value['pilot_first_name'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['p']->value['pilot_last_name'], ENT_QUOTES, 'UTF-8', true);?>
</td>
				<td><?php echo sprintf("%06.3f",$_smarty_tpl->tpl_vars['p']->value['event_pilot_average_speed']);?>
</td>
			</tr>
			<?php }?>
		<?php } ?>
		</table>
	</div>
	
		<div class="entry clearfix" style="display:inline-block;vertical-align:top;padding-bottom:10px;">                
		<h1 class="post-title">Top 20 Speed Runs</h1>
		<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
		<tr>
			<th>Rank</th>
			<th>Pilot</th>
			<th>Speed</th>
			<th>Round</th>
		</tr>
		<?php $_smarty_tpl->tpl_vars['rank'] = new Smarty_variable(1, null, 0);?>
		<?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['speed_times']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
?>
			<?php $_smarty_tpl->tpl_vars['event_pilot_id'] = new Smarty_variable($_smarty_tpl->tpl_vars['p']->value['event_pilot_id'], null, 0);?>
			<tr style="background-color: <?php echo smarty_function_cycle(array('values'=>"#9DCFF0,white"),$_smarty_tpl);?>
;">
				<td><?php echo $_smarty_tpl->tpl_vars['rank']->value;?>
</td>
				<td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->pilots[$_smarty_tpl->tpl_vars['event_pilot_id']->value]['pilot_first_name'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->pilots[$_smarty_tpl->tpl_vars['event_pilot_id']->value]['pilot_last_name'], ENT_QUOTES, 'UTF-8', true);?>
</td>
				<td><?php echo sprintf("%06.3f",$_smarty_tpl->tpl_vars['p']->value['event_pilot_round_flight_seconds']);?>
</td>
				<td align="center"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['p']->value['event_round_number'], ENT_QUOTES, 'UTF-8', true);?>
</td>
			</tr>
			<?php if ($_smarty_tpl->tpl_vars['rank']->value==20){?><?php break 1?><?php }?>
			<?php $_smarty_tpl->tpl_vars['rank'] = new Smarty_variable($_smarty_tpl->tpl_vars['rank']->value+1, null, 0);?>
		<?php } ?>
		</table>
	</div>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['top_landing']->value){?>
	<div class="entry clearfix" style="display:inline-block;vertical-align:top;padding-bottom:10px;">                
		<h1 class="post-title">Landing Averages</h1>
		<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
		<tr>
			<th>Rank</th>
			<th>Pilot</th>
			<th>Avg</th>
		</tr>
		<?php $_smarty_tpl->tpl_vars['rank'] = new Smarty_variable(1, null, 0);?>
		<?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['top_landing']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
?>
			<?php $_smarty_tpl->tpl_vars['event_pilot_id'] = new Smarty_variable($_smarty_tpl->tpl_vars['p']->value['event_pilot_id'], null, 0);?>
			<tr style="background-color: <?php echo smarty_function_cycle(array('values'=>"#9DCFF0,white"),$_smarty_tpl);?>
;">
				<td><?php echo $_smarty_tpl->tpl_vars['rank']->value;?>
</td>
				<td nowrap><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->pilots[$_smarty_tpl->tpl_vars['event_pilot_id']->value]['pilot_first_name'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['event']->value->pilots[$_smarty_tpl->tpl_vars['event_pilot_id']->value]['pilot_last_name'], ENT_QUOTES, 'UTF-8', true);?>
</td>
				<td><?php echo sprintf("%02.2f",$_smarty_tpl->tpl_vars['p']->value['average_landing']);?>
</td>
			</tr>
			<?php if ($_smarty_tpl->tpl_vars['rank']->value==20){?><?php break 1?><?php }?>
			<?php $_smarty_tpl->tpl_vars['rank'] = new Smarty_variable($_smarty_tpl->tpl_vars['rank']->value+1, null, 0);?>
		<?php } ?>
		</table>
	</div>
	<?php }?>
	
</div>
<?php }?>
<script>
	document.getElementById('pilot_name').focus();
</script>

<form name="goback" method="GET">
<input type="hidden" name="action" value="event">
<input type="hidden" name="function" value="event_list">
</form>
<form name="event_edit" method="POST">
<input type="hidden" name="action" value="event">
<input type="hidden" name="function" value="event_edit">
<input type="hidden" name="event_id" value="<?php echo $_smarty_tpl->tpl_vars['event']->value->info['event_id'];?>
">
</form>
<form name="event_delete" method="POST">
<input type="hidden" name="action" value="event">
<input type="hidden" name="function" value="event_delete">
<input type="hidden" name="event_id" value="<?php echo $_smarty_tpl->tpl_vars['event']->value->info['event_id'];?>
">
</form>
<form name="event_pilot_add" method="POST">
<input type="hidden" name="action" value="event">
<input type="hidden" name="function" value="event_pilot_edit">
<input type="hidden" name="event_id" value="<?php echo $_smarty_tpl->tpl_vars['event']->value->info['event_id'];?>
">
<input type="hidden" name="event_pilot_id" value="0">
<input type="hidden" name="pilot_id" value="">
<input type="hidden" name="pilot_name" value="">
</form>
<form name="event_add_round" method="POST">
<input type="hidden" name="action" value="event">
<input type="hidden" name="function" value="event_round_edit">
<input type="hidden" name="event_id" value="<?php echo $_smarty_tpl->tpl_vars['event']->value->info['event_id'];?>
">
<input type="hidden" name="event_round_id" value="0">
<input type="hidden" name="zero_round" value="0">
<input type="hidden" name="flyoff_round" value="0">
</form>
<form name="print_overall" method="GET" action="?" target="_blank">
<input type="hidden" name="action" value="event">
<input type="hidden" name="function" value="event_print_overall">
<input type="hidden" name="event_id" value="<?php echo $_smarty_tpl->tpl_vars['event']->value->info['event_id'];?>
">
<input type="hidden" name="use_print_header" value="1">
</form>
<form name="print_stats" method="GET" action="?" target="_blank">
<input type="hidden" name="action" value="event">
<input type="hidden" name="function" value="event_print_stats">
<input type="hidden" name="event_id" value="<?php echo $_smarty_tpl->tpl_vars['event']->value->info['event_id'];?>
">
<input type="hidden" name="use_print_header" value="1">
</form>
<form name="print_rank" method="GET" action="?" target="_blank">
<input type="hidden" name="action" value="event">
<input type="hidden" name="function" value="event_print_rank">
<input type="hidden" name="event_id" value="<?php echo $_smarty_tpl->tpl_vars['event']->value->info['event_id'];?>
">
<input type="hidden" name="use_print_header" value="1">
</form>
<?php if ($_smarty_tpl->tpl_vars['event']->value->rounds){?>
<script>
	 document.getElementById('pilots').style.display = 'none';
	 document.getElementById('viewtoggle').innerHTML = '(<u>Show Pilot List</u>)';
</script>
<?php }?><?php }} ?>