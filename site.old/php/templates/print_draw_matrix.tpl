		{$highlight_color="yellow"}
		<h2>{$event->info.event_name}</h2>           
		<table width="600" cellpadding="2" cellspacing="1" class="printborder">
		<tr>
			<th width="15%" align="right">Event Dates</th>
			<td nowrap>
			{$event->info.event_start_date|date_format:"%Y-%m-%d"} to {$event->info.event_end_date|date_format:"%Y-%m-%d"}
			</td>
			<th align="right">Location</th>
			<td nowrap>
			{$event->info.location_name|escape} - {$event->info.location_city|escape},{$event->info.state_code|escape} {$event->info.country_code|escape}
			</td>
		</tr>
		</table>
		<h2 class="post-title entry-title" style="margin:0px;">Draw Matrix - {if $event->info.event_type_code!="f3k"}{$event->flight_types.$flight_type_id.flight_type_name} {/if}(Rounds {$print_round_from} - {$print_round_to})</h2>
		
			<form name="main">
			Team Highlight :
			<select name="highlight" onChange="document.hl.highlight.value=document.main.highlight.value;document.hl.submit();">
			<option value="">None</option>
			{foreach $event->teams as $t}
			<option value="{$t.event_pilot_team}"{if $highlight==$t.event_pilot_team} SELECTED{/if}>{$t.event_pilot_team}</option>
			{/foreach}
			</select>
			</form>
			
		<table cellspacing="2">
		<tr>
			{foreach $event->rounds as $r}
			{if $r.event_round_number<$print_round_from || $r.event_round_number>$print_round_to}
				{continue}
			{/if}
			{if $event->info.event_type_code=="f3k"}
				{$flight_type_id=$r.flight_type_id}
			{/if}
			{$bgcolor=''}
			{if $event->flight_types.$flight_type_id.flight_type_code=='f3b_duration' 
				|| $event->flight_types.$flight_type_id.flight_type_code=='td_duration'
				|| $event->flight_types.$flight_type_id.flight_type_code=='f3b_distance'
				|| $event->flight_types.$flight_type_id.flight_type_code=='f3j_duration'}
				{$size=3}
			{else}
				{$size=2}
			{/if}
			
			<td>
				<table cellpadding="1" cellspacing="1" style="border: 1px solid black;font-size:{if $print_format=="pdf"}8{else}12{/if};">
				<tr bgcolor="lightgray">
					<td {if $print_format=="html"}colspan="{$size}"{/if}><strong>Round {$r.event_round_number}</strong></td>
				</tr>
				{if $event->info.event_type_code=='f3k'}
					{$ftid=$r.flight_type_id}
					<tr bgcolor="white">
						<td {if $print_format=="html"}colspan="2"{/if}>{$event->flight_types.$ftid.flight_type_name_short}</td>
					</tr>
				{/if}
				<tr bgcolor="lightgray">
					{if $event->flight_types.$flight_type_id.flight_type_group}
						<td width="30">Group</td>
					{else}
						<td>&nbsp;#&nbsp;</td>
					{/if}
					<td>Pilot</td>
					{if $event->flight_types.$flight_type_id.flight_type_code=='f3b_duration' 
						|| $event->flight_types.$flight_type_id.flight_type_code=='td_duration'}
						<td>Spot</td>
					{elseif $event->flight_types.$flight_type_id.flight_type_code=='f3b_distance'
						|| $event->flight_types.$flight_type_id.flight_type_code=='f3j_duration'}
						<td>Lane</td>
					{/if}
					
				</tr>
				{$oldgroup='1000'}
				{$bottom=0}
				{foreach $r.flights.$flight_type_id.pilots as $p}
					{$event_pilot_id=$p@key}
					{if $oldgroup!=$p.event_pilot_round_flight_group}
						{if $r.flights.$flight_type_id.flight_type_code=='f3b_speed' || $r.flights.$flight_type_id.flight_type_code=='f3f_speed'}
							{$bgcolor="white"}
						{else}
							{if $bgcolor=='white'}
								{$bgcolor='lightgray'}
							{else}
								{$bgcolor='white'}
							{/if}
						{/if}
						{$bottom=1}
					{/if}
					{if $event->pilots.$event_pilot_id.event_pilot_team==$highlight}
						{$highlighted=1}
					{else}
						{$highlighted=0}
					{/if}
					<tr>
						{if $event->flight_types.$flight_type_id.flight_type_group}
							<td align="center" bgcolor="{if $highlighted}{$highlight_color}{else}{$bgcolor}{/if}" {if $bottom}style="border-top: 2px solid black;"{/if}>{$p.event_pilot_round_flight_group}</td>
						{else}
							<td align="center" bgcolor="{if $highlighted}{$highlight_color}{else}{$bgcolor}{/if}" {if $bottom}style="border-top: 2px solid black;"{/if}>{$p.event_pilot_round_flight_order}</td>
						{/if}
						<td align="left" nowrap bgcolor="{if $highlighted}{$highlight_color}{else}{$bgcolor}{/if}" {if $bottom}style="border-top: 2px solid black;"{/if}>
							{if $event->pilots.$event_pilot_id.event_pilot_bib!='' && $event->pilots.$event_pilot_id.event_pilot_bib!=0}
								<div class="pilot_bib_number_print">{$event->pilots.$event_pilot_id.event_pilot_bib}</div>
								&nbsp;
							{/if}
							{$event->pilots.$event_pilot_id.pilot_first_name} {$event->pilots.$event_pilot_id.pilot_last_name}
						</td>
					{if $event->flight_types.$flight_type_id.flight_type_code=='f3b_duration' 
						|| $event->flight_types.$flight_type_id.flight_type_code=='td_duration'
						|| $event->flight_types.$flight_type_id.flight_type_code=='f3b_distance'
						|| $event->flight_types.$flight_type_id.flight_type_code=='f3j_duration'}
						<td align="center" bgcolor="{if $highlighted}{$highlight_color}{else}{$bgcolor}{/if}" {if $bottom}style="border-top: 2px solid black;"{/if}>{$p.event_pilot_round_flight_lane}</td>
					{/if}
					</tr>
					{$oldgroup=$p.event_pilot_round_flight_group}
					{$bottom=0}
				{/foreach}
				</table>
			</td>
			{$total_rounds_shown=$total_rounds_shown+1}
			{if $r@iteration is div by 4}
				</tr>
				<tr>
			{/if}
			{/foreach}
			</tr>
			</table>
			
			<form name="hl">
			<input type="hidden" name="action" value="event">
			<input type="hidden" name="function" value="{$function}">
			<input type="hidden" name="event_id" value="{$event->info.event_id}">
			<input type="hidden" name="event_draw_id" value="{$event_draw_id}">
			<input type="hidden" name="flight_type_id" value="{$flight_type_id}">
			<input type="hidden" name="print_round_from" value="{$print_round_from}">
			<input type="hidden" name="print_round_to" value="{$print_round_to}">
			<input type="hidden" name="print_type" value="{$print_type}">
			<input type="hidden" name="print_format" value="{$print_format}">
			<input type="hidden" name="use_print_header" value="{$use_print_header}">
			<input type="hidden" name="highlight" value="">
			</form>
			
	