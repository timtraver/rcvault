<div class="page type-page status-publish hentry clearfix post nodate">
	<div class="entry clearfix">                
		<h1 class="post-title entry-title">My Pilot Profile</h1>
		<div class="entry-content clearfix">

<form name="main" method="POST">
<input type="hidden" name="action" value="{$action|escape}">
<input type="hidden" name="function" value="my_user_save">

{if $is_pilotlist}
	<input type="hidden" name="connect" value="1">
	<p>It appears this is the first time you are logging in to edit your Pilot Profile, and we may already have a pilot in the database with your name that has attended an entered event.</p>
	<p>Are any of these pilots you?</p>

	<table width="100%" cellpadding="2" cellspacing="2" class="tableborder">
	<tr class="table-row-heading-left">
		<th colspan="4" style="text-align: left;">Possible Pilots</td>
	</tr>
	<tr>
		<th nowrap>&nbsp;</th>
		<th nowrap style="text-align: left;">Pilot Last Name</th>
		<th nowrap style="text-align: left;">Pilot First Name</th>
	<th nowrap style="text-align: left;">Last Event</th>
	<tr>
	{foreach $pilotlist as $p}
	<tr>
		<th nowrap>
			<input type="radio" name="pilot_id" value="{$p.pilot_id}">
		</th>
		<td>{$p.pilot_last_name}</td>
		<td>{$p.pilot_first_name}</td>
		<td>{$p.eventstring}</td>
	</tr>
	{/foreach}
	<tr>
		<th nowrap>
			<input type="radio" name="pilot_id" value="0" CHECKED>
		</th>
		<td colspan="3">I'm sorry, but none of these pilots are me. Please start with my default information.</td>
	</tr>
	<tr>
		<th colspan="4" style="text-align: center;">
		<input type="submit" value="Connect the Selected Pilot with My Account" class="block-button">
		</th>
	</tr>
	</table>
{else}
<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
<tr>
	<th>Pilot First Name</th>
	<td><input type="text" size="30" name="pilot_first_name" value="{$pilot.pilot_first_name|escape}"></td>
</tr>
<tr>
	<th>Pilot Last Name</th>
	<td><input type="text" size="30" name="pilot_last_name" value="{$pilot.pilot_last_name|escape}"></td>
</tr>
<tr>
	<th>Pilot Email</th>
	<td><input type="text" size="30" name="pilot_email" value="{$pilot.pilot_email|escape}"></td>
</tr>
<tr>
	<th>Pilot City</th>
	<td><input type="text" size="30" name="pilot_city" value="{$pilot.pilot_city|escape}"></td>
</tr>
<tr>
	<th>Pilot State</th>
	<td>
		<select name="state_id">
		{foreach $states as $state}
			<option value="{$state.state_id}" {if $state.state_id==$pilot.state_id}SELECTED{/if}>{$state.state_name}</option>
		{/foreach}
		</select>
	</td>
</tr>
<tr>
	<th>Pilot Country</th>
	<td>
		<select name="country_id">
		{foreach $countries as $country}
			<option value="{$country.country_id}" {if $country.country_id==$pilot.country_id}SELECTED{/if}>{$country.country_name}</option>
		{/foreach}
		</select>
	</td>
</tr>
<tr>
	<th>Pilot AMA Number</th>
	<td><input type="text" size="10" name="pilot_ama" value="{$pilot.pilot_ama|escape}"></td>
</tr>
<tr>
	<th>Pilot FIA Number</th>
	<td><input type="text" size="10" name="pilot_fia" value="{$pilot.pilot_fia|escape}"></td>
</tr>
</table>
<center>
<br>
<input type="submit" value=" Save My User Values " class="block-button">
</center>
{if $pilot.pilot_id!=0}
<h1 class="post-title entry-title">My Aircraft</h1>
	<table width="100%" cellpadding="2" cellspacing="1">
	<tr>
		<th style="text-align: left;">Plane</th>
		<th style="text-align: left;">Plane Type</th>
		<th style="text-align: left;">Plane Manufacturer</th>
		<th style="text-align: left;">Color Scheme</th>
		<th style="text-align: left;">&nbsp;</th>
	</tr>
	{if $pilot_planes}
		{foreach $pilot_planes as $pp}
			<tr bgcolor="{cycle values="white,lightgray"}">
			<td><a href="?action=my&function=my_plane_edit&pilot_plane_id={$pp.pilot_plane_id}" title="Edit My Aircraft">{$pp.plane_name}</a></td>
			<td>{$pp.plane_type_short_name}</td>
			<td>{$pp.plane_manufacturer}</td>
			<td>{$pp.pilot_plane_color}</td>
			<td> <a href="?action=my&function=my_plane_del&pilot_plane_id={$pp.pilot_plane_id}" title="Remove Plane" onClick="confirm('Are you sure you wish to remove this plane?')"><img src="images/del.gif"></a></td>
		</tr>
		{/foreach}
	{else}
		<tr>
			<td colspan="5">You currently have no planes in your quiver.</td>
		</tr>
	{/if}
	</table>
	<center>
	<br>
	<input type="button" value="Add A New Plane to my Quiver" onClick="add_plane.submit()" class="block-button">
	</center>
</form>
<h1 class="post-title entry-title">My RC Flying Locations</h1>
<table width="100%" cellpadding="2" cellspacing="1">
<tr>
	<th style="text-align: left;">Location Name</th>
	<th style="text-align: left;">Location City</th>
	<th style="text-align: left;">State/Country</th>
	<th style="text-align: left;">&nbsp;</th>
</tr>
{if $pilot_locations}
	{foreach $pilot_locations as $pl}
	<tr bgcolor="{cycle values="white,lightgray"}">
		<td><a href="?action=location&function=location_view&location_id={$pl.location_id}" title="View This Location">{$pl.location_name}</a></td>
		<td>{$pl.location_city}</td>
		<td>{$pl.state_name} {$pl.country_code}</td>
		<td> <a href="?action=my&function=my_location_del&pilot_location_id={$pl.pilot_location_id}" title="Remove Location" onClick="confirm('Are you sure you wish to remove this location?')"><img src="images/del.gif"></a></td>
	</tr>
	{/foreach}
{else}
	<tr>
		<td colspan="4">You currently have no selected locations.</td>
	</tr>
{/if}
</table>
<center>
<br>
<input type="button" value="Add A New Location Where I fly" onClick="add_location.submit()" class="block-button">
</center>
</form>

<form name="add_plane" method="POST">
<input type="hidden" name="action" value="my">
<input type="hidden" name="function" value="my_plane_edit">
<input type="hidden" name="pilot_plane_id" value="0">
</form>
<form name="add_location" method="POST">
<input type="hidden" name="action" value="my">
<input type="hidden" name="function" value="my_location_edit">
<input type="hidden" name="pilot_location_id" value="0">
</form>
{/if}
{/if}
</div>
</div>
</div>
