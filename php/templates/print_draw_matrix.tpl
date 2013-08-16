		<h2>{$event->info.event_name}</h2>           
		<table width="600" cellpadding="2" cellspacing="1" class="printborder">
		<tr>
			<th width="15%" align="right">Event Dates</th>
			<td>
			{$event->info.event_start_date|date_format:"%Y-%m-%d"} to {$event->info.event_end_date|date_format:"%Y-%m-%d"}
			</td>
			<th align="right">Location</th>
			<td>
			{$event->info.location_name|escape} - {$event->info.location_city|escape},{$event->info.state_code|escape} {$event->info.country_code|escape}
			</td>
		</tr>
		</table>
		<h2 class="post-title entry-title" style="margin:0px;">Draw Matrix - {$event->flight_types.$flight_type_id.flight_type_name}</h2>
		<table cellspacing="2">
		<tr>
			{foreach $event->rounds as $r}
			{if $r.event_round_number<$print_round_from || $r.event_round_number>$print_round_to || $r.flights.$flight_type_id.event_round_flight_score==0}
				{continue}
			{/if}
			{$bgcolor=''}
			<td>
				<table cellpadding="1" cellspacing="1" style="border: 1px solid black;font-size:{if $print_format=="pdf"}8{else}12{/if};">
				<tr bgcolor="lightgray">
					<td {if $print_format=="html"}colspan="2"{/if}>Round {$r.event_round_number}</td>
				</tr>
				<tr bgcolor="lightgray">
					{if $event->flight_types.$flight_type_id.flight_type_group}
						<td width="30">Group</td>
					{else}
						<td>Order</td>
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
							{$bottom=1}
						{/if}
					{/if}
					<tr>
						{if $event->flight_types.$flight_type_id.flight_type_group}
							<td align="center" bgcolor="{$bgcolor}" {if $bottom}style="border-top: 2px solid black;"{/if}>{$p.event_pilot_round_flight_group}</td>
						{else}
							<td align="center" bgcolor="{$bgcolor}" {if $bottom}style="border-top: 2px solid black;"{/if}>{$p.event_pilot_round_flight_order}</td>
						{/if}
						<td align="left" nowrap bgcolor="{$bgcolor}" {if $bottom}style="border-top: 2px solid black;"{/if}>{$event->pilots.$event_pilot_id.pilot_first_name} {$event->pilots.$event_pilot_id.pilot_last_name}</td>
					{if $event->flight_types.$flight_type_id.flight_type_code=='f3b_duration' 
						|| $event->flight_types.$flight_type_id.flight_type_code=='td_duration'
						|| $event->flight_types.$flight_type_id.flight_type_code=='f3b_distance'
						|| $event->flight_types.$flight_type_id.flight_type_code=='f3j_duration'}
						<td align="center" bgcolor="{$bgcolor}" {if $bottom}style="border-top: 2px solid black;"{/if}>{$p.event_pilot_round_flight_lane}</td>
					{/if}
					</tr>
					{$oldgroup=$p.event_pilot_round_flight_group}
					{$bottom=0}
				{/foreach}
				</table>
			</td>
			{$total_rounds_shown=$total_rounds_shown+1}
			{if $r@iteration is div by 5}
				</tr>
				<tr>
			{/if}
			{/foreach}
			</tr>
			</table>