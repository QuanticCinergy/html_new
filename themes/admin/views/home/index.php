<h1>Dashboard</h1> 
			
			<div id="dash-full">
				
				<?php if($analytics): ?>
				<div class="traffic widget-box">
				<h3>Analytics Summary</h3> 
				
				<div id="analytics">	
						<script type="text/javascript">
							var visitsColor = '#BF202F', viewsColor = '#188B9C';
						</script>
							
						<!--[if lte IE 8]><script src="<?php echo site_url('themes/admin/assets/js/excanvas.min.js'); ?>" type="text/javascript"></script><![endif]-->
						<script src="<?php echo site_url('themes/admin/assets/js/analytics.js'); ?>" type="text/javascript"></script>
							
						<div id="loading">Compiling Analytics…</div>
				</div>
				</div>
				<?php endif; ?>
				
			</div>
			
			
			<div id="dash-static">
				<div id="newusers" class="widget-box"> 
					<h3>New Users <span class="total">Total Users: <?php echo $total_users; ?></span></h3> 
					<div class="inner"> 
						<ul class="list"> 
							<?php foreach($new_users as $user) : ?>
							<li><h4><?php echo link_to($user->username, '/admin/users/edit/id/'.$user->id); ?></h4><span class="posted"><?php echo $user->created_on; ?></span>	</li>
							<?php endforeach; ?>	
						</ul> 
					</div> 
				</div>
				
				<div id="loggedin" class="widget-box"> 
					<h3>Recently Logged In</h3> 
					<div class="inner"> 
						<ul class="list"> 
							<?php foreach($recent_users as $user) : ?>
							<li><img class="user-ico" src="<?php echo $user->avatar_thumb_url ?>" />
								<h4><?php echo link_to($user->username, '/admin/users/edit/id/'.$user->id); ?></h4><span class="posted"><?php echo date('D jS M Y - g:ia', $user->last_login); ?></span>
								<span class="meta"><?php echo $user->first_name ?> <?php echo $user->last_name ?></span>	
							</li>
							<?php endforeach; ?>	
						</ul> 
					</div> 
				</div>

			
			</div>
			
			
			<div id="dash-variable">
				<?php if($latest_orders): ?>
					<div id="latest-orders" class="widget-box">
						<h3>Latest Orders</h3>
						<div class="inner">
							<ul class="list">
								<?php foreach($latest_orders as $order): ?>
								<li>
									<?php
									if(isset($order->username) && strlen($order->username) > 0)
									{
										$name = $order->username;
									}
									elseif(isset($order->first_name))
									{
										$name = $order->first_name.' '.$order->last_name;
									}
									else
									{
										$name = $order->email;
									}
									?>
									<span class="posted"><a href="/admin/users/edit/id/<?php echo $order->user_id; ?>/"><?php echo $name; ?></a></span>
									<h4>ID #<?php echo $order->id; ?> - Total: <?php echo param('currency'); ?><?php echo $order->total_price; ?></h4>
									<span class="posted">Ordered on <?php echo date('l jS F Y', $order->created_at); ?></span>
									<ul class="buttons float-right">
										<li><a href="/admin/orders/view/id/<?php echo $order->id; ?>/" class="view">View</a></li>
									</ul>
								</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				
				<?php endif; ?>
				
				
				<div id="latest-articles" class="widget-box"> 
					<h3>Latest Articles</h3> 
					<div class="inner"> 
						<ul class="list">
							<?php foreach($latest_articles as $article): ?>
							<li> 
								<span class="posted"><?php echo link_to($article->user->full_name(), '/admin/users/edit/id/'.$article->user->id); ?> posted a <?php echo $article->section->name; ?></span> 
								<h4><?php echo $article->title; ?></h4> 
								<span class="posted"><?php echo $article->created_at; ?></span>
								<ul class="buttons float-right"> 
									<li></li>
									<li><a href="/admin/articles/edit/id/<?php echo $article->id; ?>/" class="edit">Edit</a></li>
								</ul> 
							</li>
							<?php endforeach; ?>
						</ul>
					</div> 
				</div> 
			
				
			
				<div id="latest-galleries" class="widget-box"> 
					<h3>Latest Galleries</h3> 
					<div class="inner"> 
						<ul class="list">
							<?php foreach($latest_galleries as $gallery): ?>
							<li>
								<?php
								if($gallery->cover_id) {
									$photo = new Photo($gallery->cover_id);
									echo anchor('/admin/galleries/edit/id/' . $gallery->id, img($photo->photo_thumb_url));
									unset($photo);
								}
								?>
								<h4><?php echo $gallery->title; ?></h4>
								
								<span class="posted"><?php echo $gallery->created_at; ?></span>
								<ul class="buttons float-right"> 
									<li></li>
									<li><a href="/admin/galleries/edit/id/<?php echo $gallery->id; ?>/" class="edit">Edit</a></li>
								</ul> 
								
							</li>
							<?php endforeach; ?>
						</ul>
					</div> 
				</div> 

				
			
			</div>
			
			
			
