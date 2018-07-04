{extends file='layout/layout_main.tpl'}

{block name="content"}

<div class="panel">
	<div class="panel-heading">
		<h2 class="heading">Welcome {$user.user_first_name}!</h2>
	</div>
	<div class="panel-body">

		<p>
			<center>
				<h2>Quick Links</h2>
				<div style="width: 300px;">
				<a href="?action=pilot&function=pilot_view&pilot_id={$user.pilot_id}" class="btn btn-block btn-primary btn-rounded" style="font-size: 20px;"><i class="fa fa-user" style="float:left;padding-top: 3px;"></i>View My Pilot Profile</a><br>
				
				<a href="?action=event" class="btn btn-block btn-primary btn-rounded" style="font-size: 20px;"><i class="fa fa-trophy" style="float:left;padding-top: 3px;"></i>Browse Events</a><br>
				
				{if $current}
					<a href="?action=event&function=event_view&event_id={$current.event_id}" class="btn btn-block btn-warning btn-rounded" style="font-size: 20px;"><i class="fa fa-thumbs-o-up" style="float:left;padding-top: 3px;"></i>I Am At This Event Now!</a><br>
					{*
					<a href="?action=event&function=event_enter_score&event_id={$current.event_id}" class="btn btn-block btn-warning btn-rounded"><i class="fa fa-list" style="float:left;padding-top: 3px;"></i>Enter Scores</a><br>
					*}
				{/if}
				{if $future|count !=0}
					<div class="btn-group" style="display:block;">
						<button class="btn btn-block btn-success btn-rounded dropdown-toggle" style="font-size: 20px;" data-toggle="dropdown" aria-expanded="false">
							<i class="fa fa-hand-o-right" style="float:left;padding-top: 3px;"></i>
							My Future Events
							<i class="dropdown-caret fa fa-chevron-down"style="padding-top: 3px;padding-left: 15px;"></i>
						</button>
						<ul class="dropdown-menu" style="width:100%;position: relative;font-size:16px;">
							{foreach $future as $f}
								<li><a href="?action=event&function=event_view&event_id={$f.event_id}">{$f.event_start_date|date_format:"%y-%m-%d"} - {$f.event_name|truncate:"28"}</a></li>
							{/foreach}
						</ul>
					</div>
					<br>
					<br>
					<br>
				{/if}
				{if $past|count !=0}
					<div class="btn-group" style="display:block;">
						<button class="btn btn-block btn-success btn-rounded dropdown-toggle" style="font-size: 20px;" data-toggle="dropdown" aria-expanded="false">
							<i class="fa fa-hand-o-left" style="float:left;padding-top: 3px;"></i>
							My Past Events
							<i class="dropdown-caret fa fa-chevron-down"style="padding-top: 3px;padding-left: 15px;"></i>
						</button>
						<ul class="dropdown-menu" style="width:100%;position: relative;font-size:16px;">
							{foreach $past as $p}
								<li><a href="?action=event&function=event_view&event_id={$p.event_id}">{$p.event_start_date|date_format:"%y-%m-%d"} - {$p.event_name|truncate:"28"}</a></li>
							{/foreach}
						</ul>
					</div>
					<br>
					<br>
					<br>
				{/if}
				
				<a href="?action=plane" class="btn btn-block btn-primary btn-rounded" style="font-size: 20px;"><i class="fa fa-plane" style="float:left;padding-top: 3px;"></i>Browse Planes</a><br>
				<a href="?action=location" class="btn btn-block btn-primary btn-rounded" style="font-size: 20px;"><i class="fa fa-globe" style="float:left;padding-top: 3px;"></i>Browse Locations</a><br>
				<a href="?action=main&function=view_home&slideshow=1&user_only=1" class="btn btn-block btn-mint btn-rounded" style="font-size: 20px;"><i class="fa fa-area-chart" style="float:left;padding-top: 3px;"></i>View My Slide Show</a><br>
			
				</div>
				<br>
				<br>
				<br>
			</center>
		</p>
						
	</div>
</div>

{/block}