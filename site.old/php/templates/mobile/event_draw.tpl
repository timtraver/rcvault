<div class="page type-page status-publish hentry clearfix post nodate">
	<div class="entry clearfix">                
	<div class="entry clearfix">                
		<h1 class="post-title entry-title">Event Draw</h1>
		<h1 class="post-title entry-title">{$event->info.event_name|escape}</h1>
		<div class="entry-content clearfix">
		<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
		<tr>
			<th width="20%" align="right">Event Dates</th>
			<td>
			{$event->info.event_start_date|date_format:"%Y-%m-%d"} to {$event->info.event_end_date|date_format:"%Y-%m-%d"}
			</td>
			<th align="right">Location</th>
			<td>
			<a href="?action=location&function=location_view&location_id={$event->info.location_id}">{$event->info.location_name|escape} - {$event->info.location_city|escape},{$event->info.state_code|escape} {$event->info.country_code|escape}</a>
			</td>
		</tr>
		<tr>
			<th align="right">Event Type</th>
			<td>
			{$event->info.event_type_name|escape}
			</td>
			<th align="right">Event Contest Director</th>
			<td>
			{$event->info.pilot_first_name|escape} {$event->info.pilot_last_name|escape} - {$event->info.pilot_city|escape}
			</td>
		</tr>
		{if $event->series || $event->info.club_name}
		<tr>
			<th valign="top" align="right">Series</th>
			<td valign="top" align="right">
				{foreach $event->series as $s}
				<a href="?action=series&function=series_view&series_id={$s.series_id}">{$s.series_name|escape}</a>{if !$s@last}<br>{/if}
				{/foreach}
			</td>
		</tr>
		<tr>
			<th align="right">Club</th>
			<td>
			<a href="?action=club&function=club_view&club_id={$event->info.club_id}">{$event->info.club_name|escape}</a>
			</td>
		</tr>
		{/if}
		</table>
		
	</div>
	
	<br>
	<h2 style="color:red;">Under Construction...</h2>
<h1 class="post-title entry-title">Draws
		<input type="button" value=" Back To Event View " onClick="goback.submit();" class="block-button">
</h1>
	
<form name="main" method="POST">
<input type="hidden" name="action" value="event">
<input type="hidden" name="function" value="event_draw_edit">
<input type="hidden" name="event_draw_id" value="0">
<input type="hidden" name="event_id" value="{$event->info.event_id}">
<input type="hidden" name="flight_type_id" value="0">
<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
<tr>
	<th width="15%" nowrap>Flight Type</th>
	<th width="10%" nowrap>Status</th>
	<th width="15%" nowrap>Draw Type</th>
	<th width="10%" nowrap>Round From</th>
	<th width="10%" nowrap>Round To</th>
	<th nowrap>Statistics</th>
	<th width="40%" nowrap>Action</th>
</tr>
{foreach $event->flight_types as $ft}
	{$total=0}
	{foreach $event->draws as $d}
		{if $d.flight_type_id==$ft.flight_type_id}
			{$total=$total+1}
		{/if}
	{/foreach}
	{if $total==0}
		<tr>
			<th width="20%" nowrap>{$ft.flight_type_name}</th>
			<td colspan="4">No draws created</td>
		</tr>
	{else}	
		{foreach $event->draws as $d}
			{if $d.flight_type_id!=$ft.flight_type_id}
				{continue}
			{/if}
			<tr>
			<th width="20%" nowrap>{$ft.flight_type_name}</th>
			{if $d.event_draw_active}
				<td align="center" bgcolor="#9DCFF0">
					Active
				</td>
			{else}
				<td align="center">
					Not Applied
				</td>
			{/if}
			<td align="center">{if $d.event_draw_type=="random"}Random{elseif $d.event_draw_type=='random_step'}Random With Step{elseif $d.event_draw_type=='group'}Group{/if}</td>
			<td align="center">{$d.event_draw_round_from}</td>
			<td align="center">{$d.event_draw_round_to}</td>
			<td align="center">
				{if $ft.flight_type_code!="f3b_speed" && $ft.flight_type_code!="f3b_speed_only" && $ft.flight_type_code!="f3f_speed"}
					View Statistics
				{/if}
				<a href="?action=event&function=event_draw_view&event_draw_id={$d.event_draw_id}&event_id={$event->info.event_id}&flight_type_id={$d.flight_type_id}&use_print_header=1" target="_blank"><input type="button" value="View Draw" class="button"></a>
			</td>
			<td nowrap>
				<input type="button" value="Delete" class="button" onClick="if(confirm('Are you sure you wish to delete this draw?')){ldelim}location.href='?action=event&function=event_draw_delete&event_draw_id={$d.event_draw_id}&event_id={$event->info.event_id}';{rdelim}">
				<a href="?action=event&function=event_draw_edit&event_draw_id={$d.event_draw_id}&event_id={$event->info.event_id}&flight_type_id={$d.flight_type_id}"><input type="button" value="Edit" class="button"></a>
				<input type="button" value="UnApply" class="button" onClick="if(confirm('Are you sure you wish to unapply this draw?')){ldelim}location.href='?action=event&function=event_draw_unapply&event_draw_id={$d.event_draw_id}&event_id={$event->info.event_id}&flight_type_id={$d.flight_type_id}';{rdelim}">
				<input type="button" value="Apply" class="button" onClick="if(confirm('Are you sure you wish to apply this draw to the current and future rounds?')){ldelim}location.href='?action=event&function=event_draw_apply&event_draw_id={$d.event_draw_id}&event_id={$event->info.event_id}&flight_type_id={$d.flight_type_id}';{rdelim}">
			</td>
			</tr>
		{/foreach}
	{/if}
{/foreach}
<tr>
	<td colspan="7" style="padding-top:10px;">
		{foreach $event->flight_types as $ft}
		<input type="button" value=" Create {$ft.flight_type_name} Draw " onClick="document.main.flight_type_id.value={$ft.flight_type_id};submit();" class="block-button">
		{/foreach}
	</td>
</tr>
</table>
</form>

<h1 class="post-title entry-title">Printing Draws</h1>
<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
{foreach $event->flight_types as $ft}
{$flight_type_id=$ft.flight_type_id}
<form name="print_{$ft.flight_type_id}" method="POST" target="_blank">
<input type="hidden" name="action" value="event">
<input type="hidden" name="function" value="event_draw_print">
<input type="hidden" name="event_id" value="{$event->info.event_id}">
<input type="hidden" name="flight_type_id" value="{$ft.flight_type_id}">
<input type="hidden" name="print_type" value="">
<input type="hidden" name="use_print_header" value="1">
<tr>
	<th width="10%" nowrap>{$ft.flight_type_name}</th>
	<td style="padding-top:10px;">
		Rounds
		<select name="print_round_from">
		{for $i=$print_rounds.$flight_type_id.min to $print_rounds.$flight_type_id.max}
		<option value="{$i}">{$i}</option>
		{/for}
		</select>
		To
		<select name="print_round_to">
		{for $i=$print_rounds.$flight_type_id.min to $print_rounds.$flight_type_id.max}
		<option value="{$i}">{$i}</option>
		{/for}
		</select>
		<select name="print_format">
		<option value="html">HTML</option>
		<option value="pdf">PDF</option>
		</select>
		<input type="button" value=" CD Recording Sheet " onClick="document.print_{$ft.flight_type_id}.print_type.value='cd';submit();" class="block-button">
		{if !$ft.flight_type_code|strstr:"speed" && !$ft.flight_type_code|strstr:"distance"}
		<input type="button" value=" Pilot Recording Sheets " onClick="document.print_{$ft.flight_type_id}.print_type.value='pilot';submit();" class="block-button">
		{/if}
		<input type="button" value=" Draw Table " onClick="document.print_{$ft.flight_type_id}.print_type.value='table';submit();" class="block-button">
		<input type="button" value=" Full Draw Matrix " onClick="document.print_{$ft.flight_type_id}.print_type.value='matrix';submit();" class="block-button">
	</td>
</tr>
</form>
{/foreach}
</table>
</form>

<form name="goback" method="POST">
<input type="hidden" name="action" value="event">
<input type="hidden" name="function" value="event_view">
<input type="hidden" name="event_id" value="{$event->info.event_id}">
</form>

</div>
</div>
</div>

