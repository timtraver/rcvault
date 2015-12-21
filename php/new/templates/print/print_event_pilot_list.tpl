{extends file='layout/layout_print.tpl'}

{block name="content"}

{include file='print/print_event_header_info.tpl'}

<table width="100%" cellpadding="2" cellspacing="1" class="table table-condensed table-striped table-event">
<tr>
	<th width="2%" align="left">#</th>
	<th align="left" colspan="2">Pilot Name</th>
	<th width="10%" align="left">AMA/FAI#</th>
	<th align="left">Pilot Class</th>
	<th align="left">Pilot Plane</th>
	<th align="left">Pilot Freq</th>
	<th align="left">Event Team</th>
	{if $event->info.event_reg_flag==1}
		<th align="left" align="right">Reg Status</th>
	{/if}
</tr>
{if $event->pilots|count >0}
	{assign var=num value=1}
	{foreach $event->pilots as $p}
	<tr>
		<td>{$num}</td>
		<td width="1%" nowrap>
			{if $p.country_code}<img src="/images/flags/countries-iso/shiny/16/{$p.country_code|escape}.png" class="inline_flag" title="{$p.country_code}">{else}<img src="/images/1x1.png" width="16" style="display:inline;">{/if}
			{if $p.state_name && $p.country_code=="US"}<img src="/images/flags/states/16/{$p.state_name|replace:' ':'-'}-Flag-16.png" class="inline_flag" title="{$p.state_name}">{else}<img src="/images/1x1.png" width="16" style="display:inline;">{/if}
		</td>
		<td{if $p.event_pilot_draw_status==0} bgcolor="lightgrey"{/if}>
			{if $p.event_pilot_bib!='' && $p.event_pilot_bib!=0}
				<div class="pilot_bib_number">{$p.event_pilot_bib}</div>
			{/if}
			&nbsp;{$p.pilot_first_name|escape} {$p.pilot_last_name|escape}
		</td>
		<td align="left">
			{if $p.pilot_fai}
				{$p.pilot_fai|escape}
			{else}
				{$p.pilot_ama|escape}
			{/if}
		</td>
		<td>{$p.class_description|escape}</td>
		<td>{$p.plane_name|escape}</td>
		<td>{$p.event_pilot_freq|escape}</td>
		<td>{$p.event_pilot_team|escape}</td>
		{if $event->info.event_reg_flag==1}
			<td align="right">
				{if $p.event_pilot_paid_flag==1}
				<font color="green">PAID</font>
				{else}
				<font color="red">DUE</font>
				{/if}
			</td>
		{/if}
	</tr>
	{assign var=num value=$num+1}
	{/foreach}
{else}
	<tr>
		<td colspan="8">Currently no pilots registered for this event.</td>
	</tr>
{/if}
</table>
{/block}