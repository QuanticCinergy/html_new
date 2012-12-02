<div id="userbox">		
	<ul class="user-nav">
	<?php if (! user_logged_in()) : ?>
		<li><a href="/login">Login</a></li>
		<li><a href="/register">Register</a></li>
	<?php else: ?>
		<li><a href="/profile">My Profile</a></li>
		<li><a href="/profile/edit">Edit Profile</a></li>
		<li><a href="/logout">Logout</a></li>
	<?php endif; ?>				
	</ul>
</div>