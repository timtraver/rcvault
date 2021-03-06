<div class="page type-page status-publish hentry clearfix post nodate">
	<div class="entry clearfix">                
		<h1 class="post-title entry-title">Plane Comparison and Merge</h1>
		<div class="entry-content clearfix">


<form name="main" method="POST">
<input type="hidden" name="action" value="admin">
<input type="hidden" name="function" value="admin_plane_merge">


{foreach $planes as $p}
<input type="hidden" name="plane_{$p.plane_id}" value="1">
<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
<tr>
	<th>Make Primary</th>
	<td colspan="3" bgcolor="grey"><input type="radio" name="make_primary" value="{$p.plane_id}" CHECKED> Plane ID {$p.plane_id}</td>
</tr>
<tr>
	<th width="20%">Plane Name</th>
	<td>{$p.plane_name|escape}</td>
	<th>Plane Location</th>
	<td>
		{$p.country_name|escape}
		{if $p.country_code}<img src="/images/flags/countries-iso/shiny/24/{$p.country_code|escape}.png" style="vertical-align: middle;">{/if}
	</td>
</tr>
<tr>
	<th>Plane Wingspan</th>
	<td>{$p.plane_wingspan|escape} {$p.plane_wingspan_units}</td>
	<th>Plane Length</th>
	<td>{$p.plane_length|escape} {$p.plane_length_units}</td>
</tr>
<tr>
	<th>Plane Wing Area</th>
	<td>{$p.plane_wing_area|escape} {$p.plane_wing_area_units}</td>
	<th>Plane Tail Area</th>
	<td>{$p.plane_tail_area|escape} {$p.plane_wing_area_units|escape}</td>
</tr>
<tr>
	<th valign="top">Plane Attributes</th>
	<td colspan="3">
		<table width="100%" cellspacing="0" cellspadding="1" style="border-style: none;">
		{assign var='cat' value=''}
		{foreach $p.plane_attributes as $pa}
			{if $pa.plane_att_cat_name != $cat}
				{if $pa.plane_att_cat_name != ''}
				<tr style="border-style: none;"><td colspan="4" style="border-style: none;"><hr></td></tr>
				{/if}
				<tr style="border-style: none;"><td colspan="4" style="border-style: none;"><b>{$pa.plane_att_cat_name|escape}</b></td></tr>
				<tr style="border-style: none;">
				{assign var='col' value='1'}
			{/if}
			{if $pa.plane_att_type == 'boolean'}
				<td style="border-style: none;" nowrap>
					<input type="checkbox" name="plane_att_{$pa.plane_att_id}" {if $pa.plane_att_value_status==1 && $pa.plane_att_value_value ==1}CHECKED{/if}> {$pa.plane_att_name|escape}
				</td>
			{else}
				<td style="border-style: none;" nowrap>
					{$pa.plane_att_name|escape} <input type="text" name="plane_att_{$pa.plane_att_id}" size="{$pa.plane_att_size}" value="{if $pa.plane_att_value_status==1}{$pa.plane_att_value_value|escape}{/if}"> 
				</td>
			{/if}
			{if $col > 3}
			</tr><tr style="border-style: none;">
			{assign var='col' value="0"}
			{/if}
			{assign var='col' value=$col + 1}
			{assign var='cat' value=$pa.plane_att_cat_name}
		{/foreach}
		</tr>
		</table>
	</td>
</tr>
</table>
<br>
{/foreach}

		<input type="button" value=" Merge To Selected Primary Plane ID " onclick="main.submit();" class="block-button">

</form>

</div>
</div>
</div>
