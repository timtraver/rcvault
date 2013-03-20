<div id="nav">
	<div id="header-menu-wrap" class="clearfix">
		<ul id="header-menu" class="menu clearfix">
			<li class="menu-item menu-item-type-custom menu-item-object-custom {if $current_menu=='home'}current-menu-item{/if} menu-item-home"><a href="/"><strong>Home</strong></a></li>
			<li class="menu-item menu-item-type-post_type menu-item-object-page {if $current_menu=='locations'}current-menu-item{/if} menu-item-ancestor"><a href="/?action=main&function=view_locations"><strong>RC Locations</strong></a>
				<ul class="sub-menu">
					<li id="menu-item-36" class="menu-item menu-item-type-custom menu-item-object-custom"><a href="/?action=location">Location Browse</a></li>
				</ul>
			</li>
			<li class="menu-item menu-item-type-post_type menu-item-object-page {if $current_menu=='planes'}current-menu-item{/if} menu-item-ancestor"><a href="/?action=main&function=view_planes"><strong>RC Plane Database</strong></a>
				<ul class="sub-menu">
					<li class="menu-item menu-item-type-custom menu-item-object-custom"><a href="/?action=plane">Database Browse</a></li>
				</ul>
			</li>
			<li class="menu-item menu-item-type-post_type menu-item-object-page {if $current_menu=='events'}current-menu-item{/if} menu-item-ancestor"><a href="/?action=main&function=view_events"><strong>RC Events</strong></a>
				<ul class="sub-menu">
					<li class="menu-item menu-item-type-custom menu-item-object-custom"><a href="/?action=event">Event Browse</a></li>
					<li class="menu-item menu-item-type-custom menu-item-object-custom"><a href="/?action=series">Series Browse</a></li>
				</ul>
			</li>
			<li class="menu-item menu-item-type-post_type menu-item-object-page {if $current_menu=='pilots'}current-menu-item{/if} menu-item-ancestor"><a href="/?action=main&function=view_pilots"><strong>Pilot Profiles</strong></a>
				<ul class="sub-menu">
					<li class="menu-item menu-item-type-custom menu-item-object-custom"><a href="/?action=my">My Pilot Profile</a></li>
					<li class="menu-item menu-item-type-custom menu-item-object-custom"><a href="/?action=pilot">Browse Pilot Profiles</a></li>
					<li class="menu-item menu-item-type-custom menu-item-object-custom"><a href="/?action=message">Message Center</a></li>
				</ul>
			</li>
			<li class="menu-item menu-item-type-post_type menu-item-object-page {if $current_menu=='clubs'}current-menu-item{/if} menu-item-ancestor"><a href="/?action=main&function=view_clubs"><strong>RC Clubs</strong></a>
				<ul class="sub-menu">
					<li class="menu-item menu-item-type-custom menu-item-object-custom"><a href="/?action=club">RC Clubs Browse</a></li>
				</ul>
			</li>
			{if $user.user_id!=0}
			<li class="menu-item menu-item-type-custom menu-item-object-custom"><a href="/?action=main&function=logout"><strong>Log Out</strong></a></li>
			{else}
			<li class="menu-item menu-item-type-custom menu-item-object-custom {if $current_menu=='login'}current-menu-item{/if}"><a href="/?action=main&function=login"><strong>Log In</strong></a></li>
			<li class="menu-item menu-item-type-custom menu-item-object-custom {if $current_menu=='register'}current-menu-item{/if}"><a href="/?action=register"><strong>Register</strong></a></li>
			{/if}
			{if $user.user_admin==1}
			<li class="menu-item menu-item-type-custom menu-item-object-custom {if $current_menu=='admin'}current-menu-item{/if}"><a href="/?action=admin"><strong>Admin</strong></a></li>
			{/if}
		</ul>            
	</div>
	<div class="menu-bottom-shadow">&nbsp;</div>
</div>
