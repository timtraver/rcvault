<div class="page type-page status-publish hentry clearfix post nodate">
	<div class="entry clearfix">                
		<h1 class="post-title entry-title">F3X Location Database</h1>
		<div class="entry-content clearfix">
		
<script type="text/javascript">
	function showrows(){ldelim}
		if(document.main.location_media_type.value=="picture"){ldelim}
			document.getElementById("picture").style.display="";
			document.getElementById("media").style.display="none";
		{rdelim}else{ldelim}
			document.getElementById("picture").style.display="none";
			document.getElementById("media").style.display="";
		{rdelim}
	{rdelim}
</script>

<form name="main" method="POST" enctype="multipart/form-data">
<input type="hidden" name="action" value="location">
<input type="hidden" name="function" value="location_media_add">
<input type="hidden" name="location_id" value="{$location_id}">
<input type="hidden" name="MAX_FILE_SIZE" value="2000000">

<h1 class="post-title entry-title">Location Media Add</h1>

<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
<tr>
	<th>Location</th>
	<td>
		{$location.location_name}
	</td>
</tr>
<tr>
	<th>Media Type</th>
	<td>
	<select name="location_media_type" onChange="showrows();">
		<option value="picture" SELECTED>Picture or File</option>
		<option value="video">YouTube or Vimeo Video URL</option>
	</select>
	</td>
</tr>
<tbody id="picture" style="display: none;">
<tr>
	<th>Upload Picture</th>
	<td><input type="file" size="50" name="uploaded_file" value=""></td>
</tr>
</tbody>
<tbody id="media" style="display: none;">
<tr>
	<th>URL</th>
	<td><input type="text" size="50" name="location_media_url" value=""></td>
</tr>
</tbody>
<tr>
	<th>Media Caption</th>
	<td><input type="text" size="50" name="location_media_caption" value=""></td>
</tr>
</table>
<center>
<br>
<input type="submit" value=" Add This Media " class="block-button">
<input type="button" value=" Back To Location Profile " class="block-button" onclick="goback.submit();">
</center>
</form>

<script type="text/javascript">
	document.getElementById("picture").style.display="";
	document.getElementById("media").style.display="none";
</script>

<form name="goback" method="GET">
<input type="hidden" name="action" value="location">
<input type="hidden" name="function" value="location_view">
<input type="hidden" name="location_id" value="{$location_id}">
</form>

</div>
</div>
</div>
