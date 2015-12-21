{extends file='layout/layout_main.tpl'}

{block name="content"}
<br>
<div class="panel">
	<div class="panel-heading">
		<h2 class="heading">Club Pilot Quick Add - {$club.club_name|escape}</h2>
	</div>
	<div class="panel-body">

		<form name="main" method="POST">
		<input type="hidden" name="action" value="club">
		<input type="hidden" name="function" value="club_save_pilot_quick_add">
		<input type="hidden" name="club_id" value="{$club.club_id}">
		<table width="100%" cellpadding="2" cellspacing="2" class="table table-condensed table-event">
		<tr>
			<th colspan="3">Pilot Information</th>
		</tr>
		<tr>
			<th nowrap>Pilot First Name</th>
			<td colspan="2">
				<input type="text" name="pilot_first_name" size="40" value="{$pilot_first_name|escape}">
			</td>
		</tr>
		<tr>
			<th nowrap>Pilot Last Name</th>
			<td colspan="2">
				<input type="text" name="pilot_last_name" size="40" value="{$pilot_last_name|escape}">
			</td>
		</tr>
		<tr>
			<th nowrap>Pilot City</th>
			<td colspan="2">
				<input type="text" name="pilot_city" size="40" value="">
			</td>
		</tr>
		<tr>
			<th nowrap>Pilot State</th>
			<td colspan="2">
				<select name="state_id">
				{foreach $states as $state}
					<option value="{$state.state_id}">{$state.state_name}</option>
				{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<th nowrap>Pilot Country</th>
			<td colspan="2">
				<select name="country_id">
				{foreach $countries as $country}
					<option value="{$country.country_id}">{$country.country_name}</option>
				{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<th nowrap>Pilot AMA #</th>
			<td colspan="2">
				<input type="text" name="pilot_ama" size="15" value="">
			</td>
		</tr>
		<tr>
			<th nowrap>Pilot FAI #</th>
			<td colspan="2">
				<input type="text" name="pilot_fai" size="15" value="">
			</td>
		</tr>
		<tr>
			<th nowrap>Email Address</th>
			<td colspan="2">
				<input type="text" name="pilot_email" size="40" value="">
			</td>
		</tr>
		</table>
		<center>
			<input type="button" value=" Cancel " class="btn btn-primary btn-rounded" onClick="goback.submit();">
			<input type="submit" value=" Add New Pilot To This Club " class="btn btn-primary btn-rounded">
		</center>
		<br>
		</form>
		
		<form name="goback" method="POST">
		<input type="hidden" name="action" value="club">
		<input type="hidden" name="function" value="club_view">
		<input type="hidden" name="club_id" value="{$club.club_id}">
		</form>

	</div>
</div>
{/block}