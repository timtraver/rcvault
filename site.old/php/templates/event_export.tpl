<div class="page type-page status-publish hentry clearfix post nodate">
	<div class="entry clearfix">                
		<h1 class="post-title entry-title">F3X Event Export</h1>
		<div class="entry-content clearfix">

			<h1 class="post-title entry-title">{$event->info.event_type_name} Export Parameters</h1>
			<br>
			<form name="main" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="action" value="event">
			<input type="hidden" name="function" value="event_export_export">
			<input type="hidden" name="event_id" value="{$event->info.event_id}">
			<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
			<tr>
				<th width="10%">Export Format</th>
				<td>
					<select name="export_format">
					<option value="csv_file"{if $export_format=="csv_file" || $export_format==""} SELECTED{/if}>CSV Saved File</option>
					<option value="csv_text"{if $export_format=="csv_text"} SELECTED{/if}>CSV Text</option>
				</td>
			</tr>
			<tr>
				<th>Export Field Separators</th>
				<td>
					<input type="radio" name="field_separator" value=","{if $field_separator=="," || $field_separator==""} CHECKED{/if}> Comma or 
					<input type="radio" name="field_separator" value=";"{if $field_separator==";"} CHECKED{/if}> Semicolon 
				</td>
			</tr>
			{if $export_content}
			<tr>
				<th>Export Text</th>
				<td>
					<textarea name="export_text" rows="40" cols="150">{$export_content}</textarea>
				</td>
			</tr>
			{/if}
			<tr>
				<td colspan="2">
					<input type="button" value=" Back To Event Edit " class="block-button" onClick="goback.submit();">
					<input type="button" value=" Export Event " class="block-button" onClick="document.main.submit();">
				</td>
			</tr>
			</table>
			</form>
		
		
			<form name="goback" method="POST">
			<input type="hidden" name="action" value="event">
			<input type="hidden" name="function" value="event_edit">
			<input type="hidden" name="event_id" value="{$event->info.event_id}">
			</form>
			
			
			
		</div>
	</div>
</div>

