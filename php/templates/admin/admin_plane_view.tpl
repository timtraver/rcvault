{extends file='layout/layout_main.tpl'}

{block name="content"}

<div class="panel">
	<div class="panel-heading">
		<h2 class="heading">F3X Vault Admin area !</h2>
	</div>
	<div class="panel-body">

		<h2 class="post-title entry-title">Plane View</h2>

		<form name="main" method="POST">
		<input type="hidden" name="action" value="admin">
		<input type="hidden" name="function" value="admin_plane_save">
		<input type="hidden" name="plane_id" value="{$plane.plane_id|escape}">
		<table width="100%" cellpadding="2" cellspacing="1" class="table table-condensed">
		<tr>
			<th>Plane Name</th>
			<td><input type="text" size="40" name="plane_name" value="{$plane.plane_name|escape}"></td>
			<th>Plane Disciplines</th>
		</tr>
		<tr>
			<th>Plane Wingspan</th>
			<td>
				<input type="text" size="10" name="plane_wingspan" value="{$plane.plane_wingspan|string_format:'%.1f'}" onChange="calc_wingspan();">
				<select name="plane_wingspan_units" onChange="calc_wingspan();">
				<option value="in" {if $plane.plane_wingspan_units=="in"}SELECTED{/if}>Inches</option>
				<option value="cm" {if $plane.plane_wingspan_units=="cm"}SELECTED{/if}>Centimeters</option>
				</select>
				<span id="wingspan"></span>
			</td>
			<td rowspan="6">
			{foreach $disciplines as $d}
			<input type="checkbox" name="disc_{$d.discipline_id|escape}"{if $d.discipline_selected}CHECKED{/if}> {$d.discipline_description|escape}<br>
			{/foreach}
			</td>
		</tr>
		<tr>
			<th>Plane Length</th>
			<td>
				<input type="text" size="10" name="plane_length" value="{$plane.plane_length|string_format:'%.1f'}" onChange="calc_length();">
				<select name="plane_length_units" onChange="calc_length();">
				<option value="in" {if $plane.plane_length_units=="in"}SELECTED{/if}>Inches</option>
				<option value="cm" {if $plane.plane_length_units=="cm"}SELECTED{/if}>Centimeters</option>
				</select>
				<span id="length"></span>		
			</td>
		</tr>
		<tr>
			<th>Plane Root Chord Length</th>
			<td>
				<input type="text" size="10" name="plane_root_chord_length" value="{$plane.plane_root_chord_length|string_format:'%.1f'}" onChange="calc_wingspan();">
				<span id="chord_units"></span>
			</td>
		</tr>
		<tr>
			<th>Plane Aspect Ratio</th>
			<td bgcolor="lightgrey">
				<span id="aspect"></span>		
			</td>
		</tr>
		<tr>
			<th>Plane AUW Range (Empty)</th>
			<td>
				<input type="text" size="10" name="plane_auw_from" value="{$plane.plane_auw_from|string_format:'%.1f'}" onChange="calc_auw();">
				To 
				<input type="text" size="10" name="plane_auw_to" value="{$plane.plane_auw_to|string_format:'%.1f'}" onChange="calc_auw();">
				<select name="plane_auw_units" onChange="calc_auw();">
				<option value="oz" {if $plane.plane_auw_from_units=="oz"}SELECTED{/if}>Ounces</option>
				<option value="gr" {if $plane.plane_auw_from_units=="gr"}SELECTED{/if}>Grams</option>
				</select>
				<span id="auwrange"></span>		
			</td>
		</tr>
		<tr>
			<th>Plane Wing Area</th>
			<td>
				<input type="text" size="10" name="plane_wing_area" value="{$plane.plane_wing_area|string_format:'%.2f'}" onChange="calc_area();">
				<select name="plane_wing_area_units" onChange="calc_area();">
				<option value="in2" {if $plane.plane_wing_area_units=="in2"}SELECTED{/if}>Inches squared</option>
				<option value="dm2" {if $plane.plane_wing_area_units=="dm2"}SELECTED{/if}>Decimeters squared</option>
				</select>
				<span id="wingarea"></span>		
			</td>
		</tr>
		<tr>
			<th>Plane Tail Area</th>
			<td>
				<input type="text" size="10" name="plane_tail_area" value="{$plane.plane_tail_area|string_format:'%.2f'}" onChange="calc_area();">
				<span id="tailarea"></span>		
			</td>
		</tr>
		<tr>
			<th>Plane Total Area</th>
			<td bgcolor="lightgrey">
				<span id="totalarea"></span>		
			</td>
		</tr>
		<tr>
			<th>Plane Manufacturer</th>
			<td><input type="text" size="40" name="plane_manufacturer" value="{$plane.plane_manufacturer|escape}"></td>
		</tr>
		<tr>
			<th>Manufactured In</th>
			<td>
				<select name="country_id">
				<option value="0">Select A Country</option>
				{foreach $countries as $country}
					<option value="{$country.country_id|escape}" {if $country.country_id==$plane.country_id}SELECTED{/if}>{$country.country_name|escape}</option>
				{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<th>Manufacturer Year</th>
			<td colspan="2"><input type="text" size="10" name="plane_year" value="{$plane.plane_year|escape}"></td>
		</tr>
		<tr>
			<th>Manufacturer Web Site</th>
			<td colspan="2"><input type="text" size="60" name="plane_website" value="{$plane.plane_website|escape}"></td>
		</tr>
		<tr>
			<th valign="top">Plane Attributes</th>
			<td colspan="2">
				<table width="100%" cellspacing="0" cellspadding="1" style="border-style: none;">
				{assign var='cat' value=''}
				{foreach $plane_attributes as $pa}
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
							<input type="checkbox" name="plane_att_{$pa.plane_att_id|escape}" {if $pa.plane_att_value_status==1 && $pa.plane_att_value_value ==1}CHECKED{/if}> {$pa.plane_att_name|escape}
						</td>
					{else}
						<td style="border-style: none;" nowrap>
							{$pa.plane_att_name|escape} <input type="text" name="plane_att_{$pa.plane_att_id|escape}" size="{$pa.plane_att_size|escape}" value="{if $pa.plane_att_value_status==1}{$pa.plane_att_value_value|escape}{/if}"> 
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
		
		
		<tr>
			<th colspan="3" style="text-align: center;">
				<input type="submit" value="Save Plane Values{if $from} and Return{/if}" class="btn btn-primary btn-rounded">
				<input type="button" value="Back To Plane List" onClick="backtolist.submit();" class="btn btn-primary btn-rounded">
			</th>
		</tr>
		</table>
		</form>

	</div>
</div>

<form name="backtolist" method="GET">
<input type="hidden" name="action" value="admin">
<input type="hidden" name="function" value="admin_plane_list">
</form>
{/block}