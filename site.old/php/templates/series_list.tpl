<div class="page type-page status-publish hentry clearfix post nodate">
	<div class="entry clearfix">                
		<h1 class="post-title entry-title">Browse F3X Event Series</h1>
		<div class="entry-content clearfix">

<form name="searchform" method="POST">
<input type="hidden" name="action" value="series">
<input type="hidden" name="function" value="series_list">

<table width="80%">
<tr>
	<th>Filter By Country</th>
	<td>
	<select name="country_id" onChange="document.searchform.state_id.value=0;searchform.submit();">
	<option value="0">Choose Country to Narrow Search</option>
	{foreach $countries as $country}
		<option value="{$country.country_id}" {if $country_id==$country.country_id}SELECTED{/if}>{$country.country_name|escape}</option>
	{/foreach}
	</select>
	</td>
	<th>Filter By State</th>
	<td>
	<select name="state_id" onChange="searchform.submit();">
	<option value="0">Choose State to Narrow Search</option>
	{foreach $states as $state}
		<option value="{$state.state_id}" {if $state_id==$state.state_id}SELECTED{/if}>{$state.state_name|escape}</option>
	{/foreach}
	</select>
	</td>
</tr>
<tr>
	<th nowrap>	
		And Search on Field : 
	</th>
	<td valign="center" colspan="3">
		<select name="search_field">
		<option value="series_name" {if $search_field=="series_name"}SELECTED{/if}>Series Name</option>
		<option value="series_area" {if $search_field=="series_area"}SELECTED{/if}>Series Area</option>
		</select>
		<select name="search_operator">
		<option value="contains" {if $search_operator=="contains"}SELECTED{/if}>Contains</option>
		<option value="exactly" {if $search_operator=="exactly"}SELECTED{/if}>Is Exactly</option>
		</select>
		<input type="text" name="search" size="30" value="{$search|escape}">
		<input type="submit" value=" Search " class="block-button">
		<input type="submit" value=" Reset " class="block-button" onClick="document.searchform.country_id.value=0;document.searchform.state_id.value=0;document.searchform.search_field.value='series_name';document.searchform.search_operator.value='contains';document.searchform.search.value='';searchform.submit();">
		</form>
	</td>
</tr>
</table>
</form>
<br>
<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
<tr class="table-row-heading-left">
	<th colspan="6" style="text-align: left;">Event Series (records {$startrecord|escape} - {$endrecord|escape} of {$totalrecords|escape})  Sorted by most recent events in series</th>
</tr>
<tr style="background-color: lightgray;">
        <td align="left" colspan="3">
                {if $startrecord>1}[<a href="?action=series&function=series_list&page={$prevpage|escape}"> &lt;&lt; Prev Page</a>]{/if}
                {if $endrecord<$totalrecords}[<a href="?action=series&function=series_list&page={$nextpage|escape}">Next Page &gt;&gt</a>]{/if}
        </td>
        <td align="right" colspan="3">PerPage
                [<a href="?action=series&function=series_list&&perpage=25">25</a>]
                [<a href="?action=series&function=series_list&&perpage=50">50</a>]
                [<a href="?action=series&function=series_list&&perpage=100">100</a>]
                [<a href="?action=series&function=series_list&page=1">First Page</a>]
                [<a href="?action=series&function=series_list&page={$totalpages|escape}">Last Page</a>]
        </td>
</tr>
<tr>
	<th style="text-align: left;">Series Name</th>
	<th style="text-align: left;">Series Area</th>
	<th style="text-align: left;">State</th>
	<th style="text-align: left;">Country</th>
	<th style="text-align: left;">Total Events</th>
</tr>
{foreach $series as $s}
<tr bgcolor="{cycle values="#FFFFFF,#E8E8E8"}">
	<td>
		<a href="?action=series&function=series_view&series_id={$s.series_id|escape}">{$s.series_name|escape}</a>
	</td>
	<td>{$s.series_area|escape}</td>
	<td>
		{if $s.state_name && $s.country_code=="US"}<img src="/images/flags/states/16/{$s.state_name|replace:' ':'-'}-Flag-16.png" style="vertical-align: middle;">{/if} 
		{$s.state_name|escape}
	</td>
	<td>
		{if $s.country_code}<img src="/images/flags/countries-iso/shiny/16/{$s.country_code|escape}.png" style="vertical-align: middle;">{/if}
		{$s.country_name|escape}
	</td>
	<td>{$s.series_total_events|escape}</td>
</tr>
{/foreach}
<tr style="background-color: lightgray;">
        <td align="left" colspan="3">
                {if $startrecord>1}[<a href="?action=series&function=series_list&page={$prevpage|escape}"> &lt;&lt; Prev Page</a>]{/if}
                {if $endrecord<$totalrecords}[<a href="?action=series&function=series_list&page={$nextpage|escape}">Next Page &gt;&gt</a>]{/if}
        </td>
        <td align="right" colspan="3">PerPage
                [<a href="?action=series&function=series_list&perpage=25">25</a>]
                [<a href="?action=series&function=series_list&perpage=50">50</a>]
                [<a href="?action=series&function=series_list&perpage=100">100</a>]
                [<a href="?action=series&function=series_list&page=1">First Page</a>]
                [<a href="?action=series&function=series_list&page={$totalpages|escape}">Last Page</a>]
        </td>
</tr>
<tr>
	<td colspan="6" align="center">
		<input type="button" value=" Create New Event Series " onclick="newseries.submit();" class="block-button">
	</td>
</tr>
</table>

<form name="newseries" method="POST">
<input type="hidden" name="action" value="series">
<input type="hidden" name="function" value="series_edit">
<input type="hidden" name="series_id" value="0">
</form>


</div>
</div>
</div>

