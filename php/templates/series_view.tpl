<script src="/includes/jquery-ui/ui/jquery.ui.core.js"></script>
<script src="/includes/jquery-ui/ui/jquery.ui.widget.js"></script>
<script src="/includes/jquery-ui/ui/jquery.ui.position.js"></script>
<script src="/includes/jquery-ui/ui/jquery.ui.menu.js"></script>
<script src="/includes/jquery-ui/ui/jquery.ui.autocomplete.js"></script>
<script>
{literal}
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
   			var loading=document.getElementById('loading_pilot');
			loading.style.display = "inline";
		},
   		select: function( event, ui ) {
   			var id=document.getElementById('pilot_name');
			document.add_pilot.pilot_id.value = ui.item.id;
			document.add_pilot.pilot_name.value = id.value;
		},
   		change: function( event, ui ) {
   			var id=document.getElementById('pilot_name');
   			if(id.value==''){
				document.add_pilot.pilot_id.value = 0;
			}
		},
   		response: function( event, ui ) {
   			var loading=document.getElementById('loading_pilot');
			loading.style.display = "none";
   			var mes=document.getElementById('pilot_message');
			if(ui.content && ui.content.length){
				mes.innerHTML = ' Found ' + ui.content.length + ' results. Use Arrow keys to select';
			}else{
				mes.innerHTML = ' No Results Found. Use Add button to add new pilot.';
			}
		}
	});
});
</script>
{/literal}

<div class="page type-page status-publish hentry clearfix post nodate">
	<div class="entry clearfix">                
		<h1 class="post-title entry-title">Series Settings - {$series->info.series_name} <input type="button" value=" Edit Series Parameters " onClick="document.edit_series.submit();" class="block-button">
		</h1>
		<div class="entry-content clearfix">
		<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
		<tr>
			<th width="20%" align="right">Series Name</th>
			<td>
			{$series->info.series_name}
			</td>
		</tr>
		<tr>
			<th align="right">Location</th>
			<td>
			{$series->info.series_area},{$series->info.state_code} {$series->info.country_code}
			</td>
		</tr>
		<tr>
			<th align="right">Series Web URL</th>
			<td><a href="{$series->info.series_url}" target="_new">{$series->info.series_url}</a></td>
		</tr>
		</table>
		
	</div>
		<br>
		<h1 class="post-title entry-title">Series Events</h1>
		<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
		<tr>
			<th align="left">Event Name</th>
			<th align="left">Location</th>
			<th align="left">State</th>
			<th align="left">Country</th>
			<th align="left">Pilots</th>
		</tr>
		{foreach $series->events as $e}
		<tr>
			<td>
				<a href="?action=event&function=event_view&event_id={$e.event_id}">{$e.event_name}</a>
			</td>
			<td>{$e.location_name}</td>
			<td>{$e.state_name}</td>
			<td>{$e.country_name}</td>
			<td nowrap>{$e.total_pilots}</td>
		</tr>
		{/foreach}
		</table>



		<br>
		{$event_num=1}
		<h1 class="post-title entry-title">Series Overall Classification</h1>
		<table width="100%" cellpadding="2" cellspacing="2">
		<tr>
			<td width="2%" align="left"></td>
			<th width="10%" align="right" nowrap></th>
			<th colspan="{if $series->totals.total_events > 10}11{else}{$series->totals.total_events + 1}{/if}" align="center" nowrap>
				Completed Events ({if $series->totals.round_drops==0}No{else}{$series->totals.round_drops}{/if} Drop{if $series->totals.round_drops!=1}s{/if} In Effect)
			</th>
			<th width="5%" nowrap>Total Score</th>
			<th width="5%" nowrap>Percentage</th>
		</tr>
		<tr>
			<th width="2%" align="left"></th>
			<th width="10%" align="right" nowrap>Pilot Name</th>
			{foreach $series->events as $e}
				<th class="info" width="5%" align="center" nowrap>
					<div style="position:relative;">
					<span>
						{$e.event_name}
					</span>
					<a href="/?action=event&function=event_view&event_id={$e.event_id}">Event {$event_num}</a>
					</div>
				</th>
				{$event_num=$event_num+1}
			{/foreach}
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
		{foreach $series->totals.pilots as $p}
		{$pilot_id=$p@key}
		<tr style="background-color: {cycle values="#9DCFF0,white"};">
			<td>{$p.overall_rank}</td>
			<td align="right" nowrap><a href="?action=event&function=event_pilot_rounds&event_pilot_id={$e.event_pilot_id}&event_id={$event->info.event_id}">{$p.pilot_first_name} {$p.pilot_last_name}</a></td>
			{foreach $series->events as $e}
				{$event_id=$e.event_id}
				<td class="info" align="right"{if $e.pilots.$pilot_id.event_pilot_position==1} style="border-width: 2px;border-color: green;color:green;font-weight:bold;"{/if}>
					<div style="position:relative;">
						{$drop=$p.events.$event_id.dropped}
						{if $drop==1}<del><font color="red">{/if}
						{if $p.events.$event_id.event_score!=0}
						{$p.events.$event_id.event_score|string_format:"%06.3f"}
						{else}
						0
						{/if}
						{if $drop==1}</font></del>{/if}
					</div>
				</td>
			{/foreach}
			<td></td>
			<td width="5%" nowrap align="right">{$p.total_score|string_format:"%06.3f"}</td>
			<td width="5%" nowrap align="right">{$p.pilot_total_percentage|string_format:"%03.2f"}%</td>
		</tr>
		{/foreach}
		</table>




<br>


<input type="button" value=" Back To Series List " onClick="goback.submit();" class="block-button">

</div>
</div>

<form name="goback" method="GET">
<input type="hidden" name="action" value="series">
<input type="hidden" name="function" value="series_list">
</form>
<form name="edit_series" method="POST">
<input type="hidden" name="action" value="series">
<input type="hidden" name="function" value="series_edit">
<input type="hidden" name="series_id" value="{$series->info.series_id}">
</form>
<form name="add_pilot" method="POST">
<input type="hidden" name="action" value="series">
<input type="hidden" name="function" value="series_add_pilot">
<input type="hidden" name="series_id" value="{$series->info.series_id}">
<input type="hidden" name="pilot_id" value="">
<input type="hidden" name="pilot_name" value="">
</form>
<form name="add_location" method="POST">
<input type="hidden" name="action" value="series">
<input type="hidden" name="function" value="series_location_add">
<input type="hidden" name="series_id" value="{$series->info.series_id}">
<input type="hidden" name="location_id" value="">
</form>
<form name="create_new_location" method="POST">
<input type="hidden" name="action" value="location">
<input type="hidden" name="function" value="location_edit">
<input type="hidden" name="location_id" value="0">
</form>

