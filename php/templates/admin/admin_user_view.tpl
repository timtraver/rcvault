{extends file='layout/layout_main.tpl'}

{block name="content"}

<div class="panel">
	<div class="panel-heading">
		<h2 class="heading">F3X Vault Admin area !</h2>
	</div>
	<div class="panel-body">

		<h2 class="post-title entry-title">Pilot Profile</h2>

		<form name="main" method="POST">
		<input type="hidden" name="action" value="admin">
		<input type="hidden" name="function" value="admin_user_save">
		<input type="hidden" name="pilot_id" value="{$pilot.pilot_id|escape}">
		
		<table width="100%" cellpadding="2" cellspacing="1" class="table table-condensed">
		<tr>
			<th align="right" width="20%">Pilot First Name</th>
			<td><input type="text" size="40" name="pilot_first_name" value="{$pilot.pilot_first_name|escape}"></td>
		</tr>
		<tr>
			<th align="right" width="20%">Pilot Last Name</th>
			<td><input type="text" size="40" name="pilot_last_name" value="{$pilot.pilot_last_name|escape}"></td>
		</tr>
		<tr>
			<th align="right" width="20%">Pilot City</th>
			<td><input type="text" size="40" name="pilot_city" value="{$pilot.pilot_city|escape}"></td>
		</tr>
		<tr>
			<th align="right" nowrap>Pilot State</th>
			<td>
				<select name="state_id">
				{foreach $states as $state}
					<option value="{$state.state_id|escape}" {if $state.state_id==$pilot.state_id}SELECTED{/if}>{$state.state_name|escape}</option>
				{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<th align="right" nowrap>Pilot Country</th>
			<td>
				<select name="country_id">
				{foreach $countries as $country}
					<option value="{$country.country_id|escape}" {if $country.country_id==$pilot.country_id}SELECTED{/if}>{$country.country_name|escape}</option>
				{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<th align="right" nowrap>Pilot Email</th>
			<td>
				<input type="text" name="pilot_email" size="40" value="{if $pilot.pilot_email=='' && $pilot.user_email!=''}{$pilot.user_email|escape}{else}{$pilot.pilot_email|escape}{/if}">
			</td>
		</tr>
		<tr>
			<th align="right" nowrap>Pilot AMA #</th>
			<td>
				<input type="text" name="pilot_ama" size="15" value="{$pilot.pilot_ama|escape}">
			</td>
		</tr>
		<tr>
			<th align="right" nowrap>Pilot FAI Designation</th>
			<td>
				<input type="text" name="pilot_fai_license" size="20" value="{$pilot.pilot_fai_license|escape}">
			</td>
		</tr>
		<tr>
			<th align="right" nowrap>Pilot FAI License</th>
			<td>
				<input type="text" name="pilot_fai" size="15" value="{$pilot.pilot_fai|escape}">
			</td>
		</tr>
		</table>
		<br>
		<input type="button" value=" Save Pilot Info " onclick="main.submit();" class="btn btn-primary btn-rounded">
		<input type="button" value=" Delete Pilot " onclick="deletepilot.submit();" class="btn btn-primary btn-rounded">
		
		</form>
		<form name="deletepilot" method="POST">
		<input type="hidden" name="action" value="admin">
		<input type="hidden" name="function" value="admin_user_delete">
		<input type="hidden" name="pilot_id" value="{$pilot.pilot_id|escape}">
		</form>
		
		<h2 class="post-title entry-title">Pilot Aircraft</h2>
			<table width="100%" cellpadding="2" cellspacing="1" class="table table-condensed table-striped">
			<tr>
				<th style="text-align: left;">Plane</th>
				<th style="text-align: left;">Plane Type</th>
				<th style="text-align: left;">Plane Manufacturer</th>
				<th style="text-align: left;">Color Scheme</th>
			</tr>
			{if $pilot_planes}
				{foreach $pilot_planes as $pp}
					<tr>
					<td><a href="?action=plane&function=plane_view&plane_id={$pp.plane_id|escape:"url"}" title="View Aircraft">{$pp.plane_name|escape}</a></td>
					<td>
						{foreach $pp.disciplines as $d}
							{$d.discipline_code_view|escape}{if !$d@last},{/if}
						{/foreach}
					</td>
					<td>{$pp.plane_manufacturer|escape}</td>
					<td>{$pp.pilot_plane_color|escape}</td>
				</tr>
				{/foreach}
			{else}
				<tr>
					<td colspan="5">This pilot currently has no planes in his quiver.</td>
				</tr>
			{/if}
			</table>
			<br>
		
		<h2 class="post-title entry-title">Pilot F3X Club Affiliations</h2>
		<table width="100%" cellpadding="2" cellspacing="1" class="table table-condensed table-striped">
		<tr>
			<th style="text-align: left;">Club Name</th>
			<th style="text-align: left;">Club City</th>
			<th style="text-align: left;">State/Country</th>
		</tr>
		{if $pilot_clubs}
			{foreach $pilot_clubs as $pc}
			<tr>
				<td><a href="?action=club&function=club_view&club_id={$pc.club_id|escape:"url"}" title="View This Club">{$pc.club_name|escape}</a></td>
				<td>{$pc.club_city|escape}</td>
				<td>{$pc.state_name|escape}, {$pc.country_code|escape}
					{if $pc.country_code}<img src="/images/flags/countries-iso/shiny/16/{$pc.country_code|escape}.png" style="vertical-align: middle;">{/if}
					{if $pc.state_name && $pc.country_code=="US"}<img src="/images/flags/states/16/{$pc.state_name|replace:' ':'-'}-Flag-16.png" style="vertical-align: middle;">{/if}
				</td>
			</tr>
			{/foreach}
		{else}
			<tr>
				<td colspan="4">This pilot currently has no club affiliations.</td>
			</tr>
		{/if}
		</table>
		<br>
		
		<h2 class="post-title entry-title">Pilot F3X Flying Locations</h2>
		<table width="100%" cellpadding="2" cellspacing="1" class="table table-condensed table-striped">
		<tr>
			<th style="text-align: left;">Location Name</th>
			<th style="text-align: left;">Location City</th>
			<th style="text-align: left;">State/Country</th>
			<th style="text-align: center;">Map</th>
		</tr>
		{if $pilot_locations}
			{foreach $pilot_locations as $pl}
			<tr>
				<td><a href="?action=location&function=location_view&location_id={$pl.location_id|escape:url""}" title="View This Location">{$pl.location_name|escape}</a></td>
				<td>{$pl.location_city|escape}</td>
				<td>{$pl.state_name|escape}, {$pl.country_code|escape}
					{if $pl.country_code}<img src="/images/flags/countries-iso/shiny/16/{$pl.country_code|escape}.png" style="vertical-align: middle;">{/if}
					{if $pl.state_name && $pl.country_code=="US"}<img src="/images/flags/states/16/{$pl.state_name|replace:' ':'-'}-Flag-16.png" style="vertical-align: middle;">{/if}
				</td>
				<td align="center">{if $pl.location_coordinates!=''}<a class="fancybox-map" href="http://maps.google.com/maps?q={$pl.location_coordinates|escape:'url'}+({$pl.location_name})&t=h&z=14" title="Press the Powered By Google Logo in the lower left hand corner to go to google maps."><img src="/images/icons/world.png"></a>{/if}</td>
			</tr>
			{/foreach}
		{else}
			<tr>
				<td colspan="4">This pilot currently has no selected locations.</td>
			</tr>
		{/if}
		</table>
		<br>
		
		{if $f3f_records}
		<h2 class="post-title entry-title">Pilot Top F3F Speeds</h2>
		<table width="100%" cellpadding="2" cellspacing="1" class="table table-condensed table-striped">
		<tr>
			<th style="text-align: left;">Event Date</th>
			<th style="text-align: left;">Event Name</th>
			<th style="text-align: left;">Location</th>
			<th style="text-align: left;">Speed</th>
		</tr>
		{foreach $f3f_records as $f}
			<tr>
				<td>{$f.event_start_date|date_format:"Y-m-d"}</td>
				<td><a href="?action=event&function=event_view&event_id={$f.event_id|escape:"url"}" title="View This Event">{$f.event_name|escape}</a></td>
				<td>
					{if $f.country_code}<img src="/images/flags/countries-iso/shiny/16/{$f.country_code|escape}.png" style="vertical-align: middle;" title="{$f.country_code|escape}">{/if}
					<a href="?action=location&function=location_view&location_id={$f.location_id|escape:"url"}" title="View This Location">{$f.location_name|escape}</a>,
					{$f.country_code|escape}
				</td>
				<td align="right"><b>{$f.event_pilot_round_flight_seconds|string_format:"%03.2f"}</b></td>
			</tr>
		{/foreach}
		</table>
		{/if}
		
		{if $f3b_records}
		<h2 class="post-title entry-title">Pilot Top F3B Speeds</h2>
		<table width="100%" cellpadding="2" cellspacing="1" class="table table-condensed table-striped">
		<tr>
			<th style="text-align: left;">Event Date</th>
			<th style="text-align: left;">Event Name</th>
			<th style="text-align: left;">Location</th>
			<th style="text-align: left;">Speed</th>
		</tr>
		{foreach $f3b_records as $f}
			<tr>
				<td>{$f.event_start_date|date_format:"Y-m-d"}</td>
				<td><a href="?action=event&function=event_view&event_id={$f.event_id|escape:"url"}" title="View This Event">{$f.event_name|escape}</a></td>
				<td>
					{if $f.country_code}<img src="/images/flags/countries-iso/shiny/16/{$f.country_code|escape}.png" style="vertical-align: middle;" title="{$f.country_code|escape}">{/if}
					<a href="?action=location&function=location_view&location_id={$f.location_id|escape:"url"}" title="View This Location">{$f.location_name|escape}</a>,
					{$f.country_code|escape}
				</td>
				<td align="right"><b>{$f.event_pilot_round_flight_seconds|string_format:"%03.2f"}</b></td>
			</tr>
		{/foreach}
		</table>
		{/if}
		{if $f3b_dist}
		<h2 class="post-title entry-title">Pilot Top F3B Distance Runs</h2>
		<table width="100%" cellpadding="2" cellspacing="1" class="table table-condensed table-striped">
		<tr>
			<th style="text-align: left;">Event Date</th>
			<th style="text-align: left;">Event Name</th>
			<th style="text-align: left;">Location</th>
			<th style="text-align: left;">Laps</th>
		</tr>
		{foreach $f3b_dist as $f}
			<tr>
				<td>{$f.event_start_date|date_format:"Y-m-d"}</td>
				<td><a href="?action=event&function=event_view&event_id={$f.event_id|escape:"url"}" title="View This Event">{$f.event_name|escape}</a></td>
				<td>
					{if $f.country_code}<img src="/images/flags/countries-iso/shiny/16/{$f.country_code|escape}.png" style="vertical-align: middle;" title="{$f.country_code|escape}">{/if}
					<a href="?action=location&function=location_view&location_id={$f.location_id|escape:"url"}" title="View This Location">{$f.location_name|escape}</a>,
					{$f.country_code|escape}
				</td>
				<td align="right"><b>{$f.event_pilot_round_flight_laps|escape}</b></td>
			</tr>
		{/foreach}
		</table>
		{/if}
		
		
		<h2 class="post-title entry-title">Pilot F3X Events</h2>
		<table width="100%" cellpadding="2" cellspacing="1" class="table table-condensed table-striped">
		<tr>
			<th style="text-align: left;">Event Date</th>
			<th style="text-align: left;">Event Name</th>
			<th style="text-align: left;">Event Location</th>
			<th style="text-align: left;">State/Country</th>
			<th style="text-align: left;">Position</th>
			<th style="text-align: left;">Percentage</th>
		</tr>
		{if $pilot_events}
			{foreach $pilot_events as $pe}
			<tr>
				<td>{$pe.event_start_date|date_format:"Y-m-d"}</td>
				<td><a href="?action=event&function=event_view&event_id={$pe.event_id|escape:"url"}" title="View This Event">{$pe.event_name|escape}</a></td>
				<td>
					<a href="?action=location&function=location_view&location_id={$pe.location_id:"url"}" title="View This Location">{$pe.location_name|escape}</a>
				</td>
				<td>{$pe.state_name|escape}, {$pe.country_code|escape}
					{if $pe.country_code}<img src="/images/flags/countries-iso/shiny/16/{$pe.country_code|escape}.png" style="vertical-align: middle;">{/if}
					{if $pe.state_name && $pe.country_code=="US"}<img src="/images/flags/states/16/{$pe.state_name|replace:' ':'-'}-Flag-16.png" style="vertical-align: middle;">{/if}
				</td>
				<td align="center">{$pe.event_pilot_position|escape}</td>
				<td align="right">{$pe.event_pilot_total_percentage|string_format:"%03.2f"}%</td>
			</tr>
			{/foreach}
		{else}
			<tr>
				<td colspan="4">This Pilot currently has no events.</td>
			</tr>
		{/if}
		</table>
		<center>
		<br>
		</center>
		</form>

	</div>
</div>
{/block}