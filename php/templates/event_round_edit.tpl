<div class="page type-page status-publish hentry clearfix post nodate">
	<div class="entry clearfix">                
		<h1 class="post-title entry-title">Event Settings - {$event->info.event_name}</h1>
		<div class="entry-content clearfix">
		<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
		<tr>
			<th width="20%" align="right">Event Dates</th>
			<td>
			{$event->info.event_start_date|date_format:"%Y-%m-%d"} to {$event->info.event_end_date|date_format:"%Y-%m-%d"}
			</td>
			<th align="right">Location</th>
			<td>
			{$event->info.location_name} - {$event->info.location_city},{$event->info.state_code} {$event->info.country_code}
			</td>
		</tr>
		<tr>
			<th align="right">Event Type</th>
			<td>
			{$event->info.event_type_name}
			</td>
			<th align="right">Event Contest Director</th>
			<td>
			{$event->info.pilot_first_name} {$event->info.pilot_last_name} - {$event->info.pilot_city}
			</td>
		</tr>
		</table>
		
	</div>
		<br>
		<form name="main" method="POST">
		<input type="hidden" name="action" value="event">
		<input type="hidden" name="function" value="event_round_save">
		<input type="hidden" name="event_id" value="{$event->info.event_id}">
		<input type="hidden" name="event_round_id" value="{$event_round_id}">
		<input type="hidden" name="event_round_number" value="{$round_number}">
		
		<h1 class="post-title entry-title">Event Round {$round_number}</h1>
		<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
		<tr>
			<th width="20%" nowrap>Event Round Type</th>
			<td>
				{if $event->info.event_type_flight_choice==1}
					<select name="flight_type_id">
					{foreach $flight_types as $ft}
					<option value="{$ft.flight_type_id}" {if $ft.flight_type_id==$event->rounds.$round_number.flight_type_id}SELECTED{/if}>{$ft.flight_type_name}</option>
					{/foreach}
					</select>
				{else}
					{foreach $flight_types as $ft}
						{$ft.flight_type_name}{if $ft.flight_type_landing} + Landing{/if}{if !$ft@last},&nbsp;{/if}
					{/foreach}
					<input type="hidden" name="flight_type_id" value="0">
				{/if}
				&nbsp;&nbsp;
				{if $event->info.event_type_time_choice==1}
					Max Flight Time : <input type="text" size="5" name="event_round_time_choice" value="{$event->rounds.$round_number.event_round_time_choice}"> Minutes
				{else}
					<input type="hidden" name="event_round_time_choice" value="0">
				{/if}
			</td>
		</tr>
		<tr>
			<th nowrap>Event Round Sort By</th>
			<td>
				<select name="flight_sort_by">
				<option value="flight_order">Flight Order</option>
				<option value="round_rank">Round Rank</option>
				</select>
			</td>
		</tr>
		</table>

		<h1 class="post-title entry-title">Round Flights</h1>
		<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
		{foreach $flight_types as $ft}
			{if $event->info.event_type_flight_choice==1 AND $ft.flight_type_id!=$event->rounds.$round_number.flight_type_id}
				{continue}
			{/if}
			{$cols=5}
			{if $ft.flight_type_group}{$cols=$cols+1}{/if}
			{if $ft.flight_type_seconds}{$cols=$cols+1}{/if}
			{if $ft.flight_type_landing}{$cols=$cols+1}{/if}
			{if $ft.flight_type_laps}{$cols=$cols+1}{/if}
			<tr>
				<th colspan="3">Round {$round_number}</th>
				<th colspan="{$cols}">{$ft.flight_type_name}</th>
			</tr>
			<tr>
				<th width="2%" align="left"></th>
				<th align="left">Pilot Name</th>
				<th align="left">Team</th>
				{if $ft.flight_type_group}
					<th align="center">Group</th>
				{/if}
				{if $ft.flight_type_minutes || $ft.flight_type_seconds}
					<th align="center">Time</th>
				{/if}
				{if $ft.flight_type_landing}
					<th align="center">Landing</th>
				{/if}
				{if $ft.flight_type_laps}
					<th align="center">Laps</th>
				{/if}
				<th align="center">Raw Score</th>
				<th align="center">Normalized Score</th>
				<th align="center">Penalty</th>
				<th align="center">Flight Rank</th>
			</tr>
			{$num=1}
			{foreach $event->rounds.$round_number.flights as $f}
			{if $f@key!=$ft.flight_type_id}
				{continue}
			{/if}
			{foreach $f.pilots as $p}
			{$event_pilot_id=$p@key}
			<tr style="background-color: lightgrey;">
				<td>{$num}</td>
				<td style="background-color: white;" nowrap>{$event->pilots.$event_pilot_id.pilot_first_name} {$event->pilots.$event_pilot_id.pilot_last_name}</td>
				<td style="background-color: white;" nowrap>{$event->pilots.$event_pilot_id.event_pilot_team}</td>
					{if $f.flight_type_group}
						<td align="center" nowrap><input autocomplete="off" type="text" size="1" style="width:10px;" name="pilot_group_{$p.event_pilot_round_flight_id}_{$event_pilot_id}_{$f.flight_type_id}" value="{$p.event_pilot_round_flight_group}"></td>					
					{/if}
					{if $f.flight_type_minutes || $f.flight_type_seconds}
						<td align="center" nowrap>
							{if $f.flight_type_minutes}<input autocomplete="off" type="text" size="2" style="width:15px;text-align: right;" name="pilot_min_{$p.event_pilot_round_flight_id}_{$event_pilot_id}_{$f.flight_type_id}" value="{$p.event_pilot_round_flight_minutes}">m{/if}
							{if $f.flight_type_seconds}
								<input autocomplete="off" type="text" size="6" style="width:40px;text-align: right;" name="pilot_sec_{$p.event_pilot_round_flight_id}_{$event_pilot_id}_{$f.flight_type_id}" value="{$p.event_pilot_round_flight_seconds|string_format:"%06.3f"}">s
							{/if}
						</td>
					{/if}
					{if $f.flight_type_landing}
						<td align="center" nowrap><input autocomplete="off" type="text" size="2" style="width:25px;text-align: right;" name="pilot_land_{$p.event_pilot_round_flight_id}_{$event_pilot_id}_{$f.flight_type_id}" value="{$p.event_pilot_round_flight_landing}"></td>
					{/if}
					{if $f.flight_type_laps}
						<td align="center" nowrap><input autocomplete="off" type="text" size="2" style="width:15px;" name="pilot_laps_{$p.event_pilot_round_flight_id}_{$event_pilot_id}_{$f.flight_type_id}" value="{$p.event_pilot_round_flight_laps}"></td>
					{/if}
					<td align="right" nowrap>
						{if $f.flight_type_code=='f3f_speed' OR $f.flight_type_code=='f3b_speed'}
						{$p.event_pilot_round_flight_raw_score}
						{else}
						{$p.event_pilot_round_flight_raw_score|string_format:"%02.0f"}
						{/if}
					</td>
					<td align="right" nowrap>
					{$p.event_pilot_round_flight_score}
					</td>
					<td align="center" nowrap>
						<input autocomplete="off" type="text" size="4" style="width:25px;text-align: right;" name="pilot_pen_{$p.event_pilot_round_flight_id}_{$event_pilot_id}_{$f.flight_type_id}" value="{if $p.event_pilot_round_flight_penalty!=0}{$p.event_pilot_round_flight_penalty}{/if}">
					</td>
					<td align="right" nowrap>
					{$p.event_pilot_round_flight_rank}
					</td>
			</tr>
			{$num=$num+1}
			{/foreach}
			{/foreach}
		{/foreach}
		</table>




		</form>
<br>
<input type="button" value=" Save and Calculate Event Round " onClick="main.submit();" class="block-button">
<input type="button" value=" Back To Event " onClick="goback.submit();" class="block-button">
</div>
</div>

<form name="goback" method="GET">
<input type="hidden" name="action" value="event">
<input type="hidden" name="function" value="event_view">
<input type="hidden" name="event_id" value="{$event->info.event_id}">
</form>