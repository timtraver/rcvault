<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=0.75, minimum-scale=0.25">
	<title>F3X Vault</title>
	
	<!--STYLESHEET-->
	<!--=================================================-->

	<!--Open Sans Font [ OPTIONAL ] -->
 	<!-- <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;subset=latin" rel="stylesheet">
	 -->

	<!--Bootstrap Stylesheet [ REQUIRED ]-->
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<!--Nifty Stylesheet [ REQUIRED ]-->
	<link href="css/nifty.css" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="/includes/jquery-ui/css/rcvault/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="/includes/jquery-ui/css/rcvault/jquery.ui.theme.css">
	
	<!--Font Awesome [ OPTIONAL ]-->
	<link href="css/font-awesome.min.css" rel="stylesheet">

	<!--Bootstrap Select [ OPTIONAL ]-->
	<link href="plugins/bootstrap-select/bootstrap-select.css" rel="stylesheet">

	<link href="css/f3x.min.css" rel="stylesheet">
	<!--SCRIPT-->
	<!--=================================================-->
	
	<!--Page Load Progress Bar [ OPTIONAL ]-->
	<link href="css/pace.min.css" rel="stylesheet">
	<script src="js/pace.min.js"></script>

    {if $debug}
        <link href="/css/debug-toolbar.css" rel="stylesheet" type="text/css">
    {/if}

	{block name="header"}{/block}
</head>
<body>
	<div id="container" class="effect mainnav-lg navbar-fixed">
		
		<!--NAVBAR-->
		<!--===================================================-->
		<header id="navbar">
			<div id="navbar-container" class="boxed">

				<!--Brand logo & name-->
				<!--================================-->
				<div class="navbar-header">
					<a href="#" class="navbar-brand">
						<img id="main_logo" src="img/logo.png" alt="F3xVault Logo" class="brand-icon mainnav-toggle">
						<div class="brand-title">
							<span class="brand-text mainnav-toggle">F3XVault
							

							</span>
						</div>
					</a>
				</div>
				<!--================================-->
				<!--End brand logo & name-->
				<!--Navbar Dropdown-->
				<!--================================-->
				<div class="navbar-content clearfix" style="position: relative;">
					<h3 style="float: left;margin-left: 10px;">{$event->info.event_name}</h3>
					<input type="button" style = "float: right;margin-right: 15px;margin-top: 10px;" value=" Back To Event " onClick="window.location.href='/?action=event&function=event_view&event_id={$event->info.event_id}';" class="btn btn-primary btn-rounded">
				</div>
				<!--================================-->
				<!--End Navbar Dropdown-->

			</div>
		</header>
		<!--===================================================-->
		<!--END NAVBAR-->
				
		<div class="boxed">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">
				<div id="page-content">
					{block name="content"}{/block}
				</div>
			</div>
			<!--===================================================-->
			<!--END CONTENT CONTAINER-->
			
			<!--MAIN NAVIGATION-->
			<!--===================================================-->
			<nav id="mainnav-container">
				<div id="mainnav">
					<!--Menu-->
					<!--================================-->
					<div id="mainnav-menu-wrap">
						<div class="nano">
							<div class="nano-content">
								<ul id="mainnav-menu" class="list-group">
						
									<!--Home-->
									<li{if $current_menu == 'home'} class="active-link"{/if}>
										<a href="/">
											<i class="fa fa-home"></i>
											<span class="menu-title">
												<strong>{if $user.user_name !=''}My {/if}Home</strong>
											</span>
										</a>
									</li>
									<!--Menu list item-->
									<li{if $current_menu == 'locations'} class="active-link"{/if}>
										<a href="#">
											<i class="fa fa-globe"></i>
											<span class="menu-title">
												<strong>Flying Locations</strong>
												<span class="pull-right badge badge-blue">{$stats.locations}</span>
											</span>
											<i class="arrow"></i>
										</a>
										<ul class="collapse{if $current_menu == 'locations'} in{/if}">
											<li{if $current_menu == 'locations' && $function == 'view_locations'} class="active-link"{/if}><a href="/?action=main&function=view_locations"><strong>Location Home</strong></a></li>
											<li{if $current_menu == 'locations' && $function == ""} class="active-link"{/if}><a href="/?action=location&country_id=0&state_id=0&search="><strong>Location Browse</strong></a></li>
											<li{if $current_menu == 'locations' && $function == 'location_map'} class="active-link"{/if}><a href="/?action=location&function=location_map&country_id=0&state_id=0&search="><strong>Location Map</strong></a></li>
										</ul>
									</li>
						
									<!--Menu list item-->
									<li{if $current_menu == 'planes'} class="active-link"{/if}>
										<a href="#">
											<i class="fa fa-plane"></i>
											<span class="menu-title">
												<strong>Plane Database</strong>
												<span class="pull-right badge badge-blue">{$stats.planes}</span>
											</span>
											<i class="arrow"></i>
										</a>
										<ul class="collapse{if $current_menu == 'planes'} in{/if}">
											<li{if $current_menu == 'planes' && $function == 'view_planes'} class="active-link"{/if}><a href="/?action=main&function=view_planes"><strong>Plane Home</strong></a></li>
											<li{if $current_menu == 'planes' && $function != 'view_planes'} class="active-link"{/if}><a href="/?action=plane&search="><strong>Plane Browse</strong></a></li>
										</ul>
									</li>
						
									<!--Menu list item-->
									<li{if $current_menu == 'events'} class="active-link"{/if}>
										<a href="#">
											<i class="fa fa-trophy"></i>
											<span class="menu-title">
												<strong>Competitions</strong>
												<span class="pull-right badge badge-blue">{$stats.events}</span>
											</span>
											<i class="arrow"></i>
										</a>
										<ul class="collapse{if $current_menu == 'events' || $current_menu == 'records'} in{/if}">
											<li{if $current_menu == 'events' && $function == 'view_events'} class="active-link"{/if}><a href="/?action=main&function=view_events"><strong>Competition Home</strong></a></li>
											<li{if $current_menu == 'events' && ($function == 'event_list' || $function == '')} class="active-link"{/if}><a href="/?action=event&country_id=0&state_id=0&search="><strong>Event Browse</strong></a></li>
											<li><a href="/?action=event&function=event_edit&event_id=0"><strong>Create New Event</strong></a></li>
											<li{if $current_menu == 'events' && preg_match("/^series\_/",$function)} class="active-link"{/if}><a href="/?action=series&country_id=0&state_id=0&search="><strong>Series Browse</strong></a></li>
											<li{if $current_menu == 'records'} class="active-link"{/if}><a href="/?action=records&country_id=0&page=1&perpage=20"><strong>F3F and F3B Records</strong></a></li>
											<li><a href="/?action=import"><strong>Import Event</strong></a></li>
										</ul>
									</li>
						
									<!--Menu list item-->
									<li{if $current_menu == 'pilots' || $current_menu == 'my' || $current_menu == 'messages'} class="active-link"{/if}>
										<a href="#">
											<i class="fa fa-user"></i>
											<span class="menu-title">
												<strong>Pilot Profiles</strong>
												<span class="pull-right badge badge-blue">{$stats.pilots}</span>
											</span>
											<i class="arrow"></i>
										</a>
										<ul class="collapse{if $current_menu == 'pilots' || $current_menu == 'my' || $current_menu == 'messages'} in{/if}">
											<li{if $current_menu == 'pilots' && $function == 'view_pilots'} class="active-link"{/if}><a href="/?action=main&function=view_pilots"><strong>Pilots Home</strong></a></li>
											<li{if $current_menu == 'my'} class="active-link"{/if}><a href="/?action=pilot&function=pilot_view&pilot_id={$user.pilot_id}"><strong>My Pilot Profile</strong></a></li>
											<li{if $current_menu == 'pilots' && $function == ''} class="active-link"{/if}><a href="/?action=pilot&country_id=0&state_id=0&search="><strong>Browse Pilot Profiles</strong></a></li>
											<li{if $current_menu == 'messages'} class="active-link"{/if}><a href="/?action=message"><strong>Message Center</strong></a></li>
										</ul>
									</li>
						
									<!--Menu list item-->
									<li{if $current_menu == 'clubs'} class="active-link"{/if}>
										<a href="#">
											<i class="fa fa-users"></i>
											<span class="menu-title">
												<strong>Clubs</strong>
												<span class="pull-right badge badge-blue">{$stats.clubs}</span>
											</span>
											<i class="arrow"></i>
										</a>
										<ul class="collapse{if $current_menu == 'clubs'} in{/if}">
											<li{if $current_menu == 'clubs' && $function == 'view_clubs'} class="active-link"{/if}><a href="/?action=main&function=view_clubs"><strong>Clubs Home</strong></a></li>
											<li{if $current_menu == 'clubs' && $function == ''} class="active-link"{/if}><a href="/?action=club&country_id=0&state_id=0&search="><strong>Club Browse</strong></a></li>
										</ul>
									</li>
						
									<!--Menu list item-->
									<li>
										<a href="/?action=main&function=main_feedback">
											<i class="fa fa-list"></i>
											<span class="menu-title">
												<strong>Todo</strong>
											</span>
										</a>
									</li>
									
									<!--API Docs-->
									<li>
										<a href="/?action=api_docs">
											<i class="fa fa-book"></i>
											<span class="menu-title">
												<strong>API Docs</strong>
											</span>
										</a>
									</li>

									<!--Menu list item-->
									<li>
										<a href="/?action=main&function=logout">
											<i class="fa fa-sign-out"></i>
											<span class="menu-title">
												<strong>Logout</strong>
											</span>
										</a>
									</li>

									<br>
									<br>
									<br>
									<br>
									<br>
									<br>
									<li>
										<a href="/?action=register">
											<i class="fa fa-hand-o-right"></i>
											<span class="menu-title">
												<strong>Register</strong>
											</span>
										</a>
									</li>
									<li>
										<a href="/?action=main&function=main_feedback">
											<i class="fa fa-thumbs-o-up"></i>
											<span class="menu-title">
												<strong>Feedback</strong>
											</span>
										</a>
									</li>
									<li>
										<a href="/?action=main&function=main_privacy">
											<i class="fa fa-key"></i>
											<span class="menu-title">
												<strong>Privacy Policy</strong>
											</span>
										</a>
									</li>
									<li>
										<a href="#" onClick="document.donate.submit();">
											<i class="fa fa-money"></i>
											<span class="menu-title">
												<strong>Donate</strong>
											</span>
										</a>
									</li>
									<li>
										<a href="#">
											<i class="fa fa-copyright"></i>
											<span class="menu-title">
												<strong>Tim Traver 2015-17</strong>
											</span>
										</a>
									</li>
									<li>
										<a href="?action=main&function=view_home&slideshow=1">
											<i class="fa fa-picture-o"></i>
											<span class="menu-title">
												<strong>Slide Show</strong>
											</span>
										</a>
									</li>
									{if $user.user_admin == 1}
									<li>
										<a href="?action=admin">
											<i class="fa fa-cogs"></i>
											<span class="menu-title">
												<strong>Admin</strong>
											</span>
										</a>
									</li>
									{/if}
							</div>
						</div>
					</div>
					<!--================================-->
					<!--End menu-->

				</div>
			</nav>
			<!--===================================================-->
			<!--END MAIN NAVIGATION-->
			

		<!-- SCROLL TOP BUTTON -->
		<!--===================================================-->
		<button id="scroll-top" class="btn"><i class="fa fa-chevron-up"></i></button>
		<!--===================================================-->
		<div id="floating-top-right" class="floating-container"></div>
		
	</div>
	<!--===================================================-->
	<!-- END OF CONTAINER -->
	
	<!--JAVASCRIPT-->
	<!--=================================================-->
	<!--jQuery [ REQUIRED ]-->
	<script src="js/jquery-2.1.1.min.js"></script>

	<!--BootstrapJS [ RECOMMENDED ]-->
	<script src="js/bootstrap.min.js"></script>

	<!--Bootstrap Select [ OPTIONAL ]-->
	<script src="plugins/bootstrap-select/bootstrap-select.min.js"></script>
	
	<!--Nifty Admin [ RECOMMENDED ]-->
	<script src="js/nifty.min.js"></script>

	<!--Fast Click [ OPTIONAL ]-->
	<script src="js/fastclick.min.js"></script>

	{block name="footer"}{/block}
	{block name="footer2"}{/block}

	<script>
		$( "#main_logo" ).hide();
		setInterval(function(){ldelim}
		$( "#main_logo" ).fadeIn(2000).fadeOut(500);
		{rdelim},0);
	</script>
	<script type="text/javascript">
		$(document).ready(function() {ldelim}
			var sw = nifty.container.width();
			if (sw <= 740) {ldelim}
				nifty.container.addClass('mainnav-sm').removeClass('mainnav-lg');
			{rdelim}
		{rdelim})
	</script>

	<script type="text/javascript">
		$(document).ready(function() {ldelim}
			{foreach $messages as $m}
				$.niftyNoty({ldelim}
					type: '{if $m.message_color == 'green'}success{else}danger{/if}',
					icon: 'fa {if $m.message_color == 'green'}fa-thumbs-o-up{else}fa-thumbs-o-down{/if}',
					container : 'floating',
					title : '{$m.message}',
					timer : 10000
				{rdelim});
			{/foreach}
		{rdelim});
	</script>
	{if $first_view}
		<script type="text/javascript">
			$(document).ready(function() {ldelim}
				$.niftyNoty({ldelim}
					type: 'warning',
					icon: 'fa fa-arrow-left',
					container : 'floating',
					title : 'Click on the Blinking <img src="img/logo.png" width="35"> Plane Icon for Menu',
					timer : 10000
				{rdelim});
			{rdelim});
		</script>
	{/if}

	<!--

	REQUIRED
	You must include this in your project.

	RECOMMENDED
	This category must be included but you may modify which plugins or components which should be included in your project.

	OPTIONAL
	Optional plugins. You may choose whether to include it in your project or not.


	Detailed information and more samples can be found in the document.

	-->
	<form name="donate" method="GET" action="https://www.paypal.com/cgi-bin/webscr" target="_blank">
	<input name="cmd" type="hidden" value="_xclick">
	<input name="business" type="hidden" value="timtraver@gmail.com">
	<input name="currency_code" type="hidden" value="USD">
	<input name="item_name" type="hidden" value="F3XVault Donation">
	<input name="amount" type="hidden" value="">
	</form>
	<form name="logmein" method="POST">
	<input name="action" type="hidden" value="main">
	<input name="function" type="hidden" value="login">
	</form>
	<form id="goback" name="goback" method="GET">
	<input type="hidden" name="action" value="event">
	<input type="hidden" name="function" value="event_view">
	<input type="hidden" name="event_id" value="{$event->info.event_id}">
	</form>


	<!-- google analytics code -->
	{literal}
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-38521011-2', 'auto');
		ga('send', 'pageview');
	</script>
	{/literal}
	{if $debug}
		{debug}
	{/if}
</body>
</html>
