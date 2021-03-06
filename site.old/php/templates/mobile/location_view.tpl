<div class="page type-page status-publish hentry clearfix post nodate">
	<div class="entry clearfix">                
		<h1 class="post-title entry-title">F3X Location Database</h1>
		<div class="entry-content clearfix">

<h1 class="post-title entry-title">Location Details</h1>
<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
<tr>
	<th>Location Name</th>
	<td>{$location.location_name|escape}</td>
</tr>
<tr>
	<th>Location</th>
	<td>
		{$location.location_city|escape} - {$location.state_code|escape}, {$location.country_code|escape}
	</td>
</tr>
<tr>
	<th>Location Map Coordinates</th>
	<td>
		{$location.location_coordinates|escape}
		{if $location.location_coordinates!=''}
		<a class="fancybox-map" href="https://maps.google.com/maps?q={$location.location_coordinates|escape:'url'}+({$location.location_name|escape})&t=h&z=14" title="Press the Powered By Google Logo in the lower left hand corner to go to google maps.">
			<img src="/images/icons/world.png" style="display:inline;">
		</a>
		{/if}
	</td>
</tr>
<tr>
	<th valign="top">Location Flying Disciplines</th>
	<td>
		{foreach $disciplines as $d}
		{$d.discipline_description|escape}<br>
		{/foreach}
	</td>
</tr>
<tr>
	<th>Local RC Club</th>
	<td>
		{$location.location_club|escape}
	</td>
</tr>
<tr>
	<th>Local RC Club Website</th>
	<td>
		<a href="{$location.location_club_url|escape}" target="_blank">{$location.location_club_url|escape}</a>
	</td>
</tr>
<tr>
	<th valign="top">Full Location Description</th>
	<td colspan="2">
		{$location.location_description|escape}
	</td>
</tr>
<tr>
	<th valign="top">Location Directions</th>
	<td colspan="2">
		{$location.location_directions|escape}
	</td>
</tr>
<tr>
	<th valign="top">Location Attributes</th>
	<td colspan="3">
		{if $location_attributes}
		<table width="100%" cellspacing="0" cellspadding="1" style="border-style: none;">
		{assign var='cat' value=''}
		{assign var='row' value='0'}
		{foreach $location_attributes as $la name="las"}
			{if $la.location_att_cat_name != $cat}
				{if $la.location_att_cat_name != ''}
					{if $row != 0}
					</td></tr>
					{/if}
					<tr style="border-style: none;"><td colspan="4" style="border-style: none;"><hr></td></tr>							
				{/if}
				<tr style="border-style: none;"><td colspan="4" style="border-style: none;"><b>{$la.location_att_cat_name}</b> : 
				{assign var='row' value='1'}
			{/if}
			{if $la.location_att_type == 'boolean'}
				<span title="{$la.location_att_description|escape}">{$la.location_att_name|escape}</span>
			{else}
				<span title="{$la.location_att_description|escape}">{$la.location_att_name|escape}</span> <input type="text" name="location_att_{$la.location_att_id}" size="{$la.location_att_size}" value="{$la.location_att_value_value|escape}">
			{/if}
			{assign var='cat' value=$la.location_att_cat_name}
			{assign var='nextit' value=$smarty.foreach.las.index + 1}
			{if $location_attributes[$nextit].location_att_cat_name == $cat}
			&nbsp;-&nbsp; 
			{/if}
		{/foreach}
		</td></tr>
		</table>
		{else}
		This information has not been entered for this location.<br>
		Help us out and enter it!
		{/if}
	</td>
</tr>
<tr>
	<th colspan="3" style="text-align: center;">
		<input type="button" value="Back To Location List" onClick="goback.submit();" class="block-button">
	</th>
</tr>
</table>
<input type="button" value=" Edit Location Information " class="button" onClick="location_edit.submit();">
<div class="clear"></div>
<form name="goback" method="GET">
<input type="hidden" name="action" value="location">
</form>

<h1 class="post-title entry-title">Location Media</h1>
{foreach $media as $m}
	{if $m.location_media_type == 'picture'}
		<a href="{$m.location_media_url}" rel="gallery" class="fancybox-button" title="{if $m.user_id!=0}{$m.pilot_first_name|escape}, {$m.pilot_city|escape} - {/if}{$m.location_media_caption|escape}"><img src="/images/icons/picture.png" style="border-style: none;"></a>
	{else}
		<a href="{$m.location_media_url}" rel="videos" class="fancybox-media" title="{if $m.user_id!=0}{$m.pilot_first_name|escape}, {$m.pilot_city|escape} - {/if}{$m.location_media_caption|escape}"><img src="/images/icons/webcam.png" style="border-style: none;"></a>
	{/if}
{/foreach}
</div>
</div>
</div>

<div id="comments" class="clearfix no-ping">
<h4 class="comments gutter-left current">Location Comments ({$comments_num})</h4>
<ol class="clearfix" id="comments_list">
		{foreach $comments as $c}
			<li class="comment byuser bypostauthor even thread-even depth-1 clearfix" style="padding-left: 10px;">
			<div class="comment-avatar-wrap">{$c.avatar}</div>
			<h5 class="comment-author">{$c.user_first_name|escape} {$c.user_last_name|escape}</h5>
			<div class="comment-meta"><p class="commentmetadata">{$c.location_comment_date|date_format:"%B %e, %Y - %I:%M %p"}</p></div>
			<div class="comment-entry"><p>{$c.location_comment_string|escape}</p></div>
			</li>
		{/foreach}
	</ol>
<center>
	<input type="button" value="Add A Comment About This Location" onClick="addcomment.submit();" class="block-button">
</center>
</div>

<form name="addcomment" method="GET">
<input type="hidden" name="action" value="location">
<input type="hidden" name="function" value="location_comment_add">
<input type="hidden" name="location_id" value="{$location.location_id}">
</form>
<form name="location_edit" method="GET">
<input type="hidden" name="action" value="location">
<input type="hidden" name="function" value="location_edit">
<input type="hidden" name="location_id" value="{$location.location_id}">
</form>



