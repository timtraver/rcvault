<div id="post-1" class="post-1 post type-post status-publish format-standard hentry category-uncategorized clearfix post">
	<div class="entry clearfix">
		<h2 class="post-title entry-title">RC Vault Admin area !</h2>
				<div class="entry-content clearfix">
				<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
				<tr class="table-row-heading-left">
					<td colspan="5">System Emails</td>
				</tr>
				<tr>
					<td width="10%" class="table-data-heading-left">Email Name</td>
					<td width="30%" class="table-data-heading-left">Email From</td>
					<td class="table-data-heading-left">Email Subject</td>
					<td class="table-data-heading-left">Email Send Test</td>
				</tr>
				{foreach $emails as $e}
				<tr bgcolor="{cycle values="#FFFFFF,#E8E8E8"}">
					<td>{$e.email_name}</td>
					<td>{$e.email_from_name} {$e.email_from_address}</td>
					<td><a href="?action=admin&function=admin_email_edit&email_id={$e.email_id}">{$e.email_subject}</a></td>
					<td><input type="button" value="Send Email Test" class="button" onClick="var sendto=prompt('Enter the email address to send to :','');document.sendmail_{$e.email_id}.email_to.value=sendto;if(sendto!=null) document.sendmail_{$e.email_id}.submit();"></td>
				</tr>
				{/foreach}
				<tr>
					<td colspan="5" class="table-data-heading-center">
					<input type="button" value=" Go Back " onclick="document.goback.submit();" class="button">
					<input type="button" value=" Create New Email " onclick="document.newmail.submit();" class="button">
					</td>
				</tr>
				</table>

				</div>
	</div>
</div>

 
<form name="goback" method="GET">
<input type="hidden" name="action" value="admin">
<input type="hidden" name="function" value="admin_view">
</form>
<form name="newmail" method="POST">
<input type="hidden" name="action" value="admin">
<input type="hidden" name="function" value="admin_email_edit">
<input type="hidden" name="email_id" value="0">
</form>

{foreach $emails as $e}
<form name="sendmail_{$e.email_id}" method="POST">
<input type="hidden" name="action" value="admin">
<input type="hidden" name="function" value="admin_email_send_test">
<input type="hidden" name="email_name" value="{$e.email_name}">
<input type="hidden" name="email_to" value="">
</form>
{/foreach}