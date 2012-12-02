<div id="content" class="has-side streams">
	
	<h1 id="page-title"><?= humanize(param('section')) ?> Streams</h1>

	<?php
	  $fetch = array();
	  $streams = fetch('streams', 'limit=100&order_by_desc=id&section_id=1');

	  if( !empty( $streams ) )
	  {
		  foreach ($streams as $stream)
		  {
		    $index = strtolower('live_user_' . $stream->title);
		    $fetch[$index] = $stream;
		    $stream_titles[] = $stream->title;
		  }

		  $url = "http://api.justin.tv/api/stream/list.json?channel=" . implode(",", $stream_titles);

		  $mycurl = curl_init();
		  curl_setopt ($mycurl, CURLOPT_HEADER, 0);
		  curl_setopt ($mycurl, CURLOPT_RETURNTRANSFER, 1);
		  curl_setopt ($mycurl, CURLOPT_URL, $url);
		  $responses =  json_decode(curl_exec($mycurl));
	  }
	?>

	<?php if( !empty( $responses ) ): ?>
		<?php foreach($responses as $response): ?>
	    	<?php $fetch[$response->name]->response = $response; ?>
		<?php endforeach; ?>

		<div class="teamstreams">
			<h2>Quantic Streams</h2>
			<ul id="team-streams">
			    <?php foreach($fetch as $key => $stream) : ?>
			      <?php if ( ! empty($stream->response)): ?>
				<li>
					<a href="<?= stream_url($stream->section->url_name, $stream->category->url_name, $stream->id, $stream->url_title) ?>"><img src="<?= $stream->response->channel->image_url_small; ?>" class="rf-thumb"></a>		
					<h3><a href="<?= stream_url($stream->section->url_name, $stream->category->url_name, $stream->id, $stream->url_title) ?>"><?= $stream->title ?></a></h3>
					<span class="viewers">Viewers: <?php echo $stream->response->stream_count ?></span>
					<span class="category"><?php echo $stream->category->name; ?></span>
					<p><?php echo $stream->response->channel->status; ?></p>
				</li>
			<?php endif; ?>
			<?php endforeach; ?>
			</ul>
		</div>
	<?php else: ?>
		<p>No streams.</p>
	<?php endif; ?>

	<?php
	  $responses = array();
	  $stream_titles = array();
	  $fetch = array();
	  $streams = fetch('streams', 'limit=100&order_by_desc=id&section_id=2');

	  if( !empty( $streams ) )
	  {
		  foreach ($streams as $stream)
		  {
		    $index = strtolower('live_user_' . $stream->title);
		    $fetch[$index] = $stream;
		    $stream_titles[] = $stream->title;
		  }

		  $url = "http://api.justin.tv/api/stream/list.json?channel=" . implode(",", $stream_titles);

		  $mycurl = curl_init();
		  curl_setopt ($mycurl, CURLOPT_HEADER, 0);
		  curl_setopt ($mycurl, CURLOPT_RETURNTRANSFER, 1);
		  curl_setopt ($mycurl, CURLOPT_URL, $url);
		  $responses =  json_decode(curl_exec($mycurl));
	  }
	?>

	<div class="featured">
			<h2>Featured Streams</h2>
			<?php if( !empty( $responses ) ): ?>
				<?php foreach($responses as $response): ?>
			    	<?php $fetch[$response->name]->response = $response; ?>
				<?php endforeach; ?>

			<ul id="featured-streams">
			    <?php foreach($fetch as $key => $stream) : ?>
			      <?php if ( ! empty($stream->response)): ?>
					<li>
						<a href="<?= stream_url($stream->section->url_name, $stream->category->url_name, $stream->id, $stream->url_title) ?>"><img src="<?= $stream->response->channel->image_url_small; ?>" class="rf-thumb"></a>		
						<h3><a href="<?= stream_url($stream->section->url_name, $stream->category->url_name, $stream->id, $stream->url_title) ?>"><?= $stream->title ?></a></h3>
						<span class="viewers">Viewers: <?php echo $stream->response->stream_count ?></span>
						<span class="category"><?php echo $stream->category->name; ?></span>
						<p><?php echo $stream->response->channel->status; ?></p>
					</li>
				<?php endif; ?>
			
				<?php endforeach; ?>
			</ul>
	<?php else: ?>		
	<p>No featured streams.</p>
	<?php endif; ?>		
</div>	
		<?php
	  $responses = array();
	  $stream_titles = array();
	  $fetch = array();
	  $streams = fetch('streams', 'limit=100&order_by_desc=id&section_id=3');

	  if( !empty( $streams ) )
	  {
		  foreach ($streams as $stream)
		  {
		    $index = strtolower('live_user_' . $stream->title);
		    $fetch[$index] = $stream;
		    $stream_titles[] = $stream->title;
		  }

		  $url = "http://api.justin.tv/api/stream/list.json?channel=" . implode(",", $stream_titles);

		  $mycurl = curl_init();
		  curl_setopt ($mycurl, CURLOPT_HEADER, 0);
		  curl_setopt ($mycurl, CURLOPT_RETURNTRANSFER, 1);
		  curl_setopt ($mycurl, CURLOPT_URL, $url);
		  $responses =  json_decode(curl_exec($mycurl));
	  }
	?>

	<div class="userstreams">
		<h2>User Streams</h2>

		<?php if( !empty( $responses ) ): ?>
			<?php foreach($responses as $response): ?>
		    	<?php $fetch[$response->name]->response = $response; ?>
			<?php endforeach; ?>
		<ul id="user-streams">
		<?php foreach($fetch as $key => $stream) : ?>
	      <?php if ( ! empty($stream->response)): ?>
			<li>
				<a href="<?= stream_url($stream->section->url_name, $stream->category->url_name, $stream->id, $stream->url_title) ?>"><img src="<?= $stream->response->channel->image_url_small; ?>" class="rf-thumb"></a>		
				<h3><a href="<?= stream_url($stream->section->url_name, $stream->category->url_name, $stream->id, $stream->url_title) ?>"><?= $stream->title ?></a></h3>
				<span class="viewers">Viewers: <?php echo $stream->response->stream_count ?></span>
				<span class="category"><?php echo $stream->category->name; ?></span>
				<p><?php echo $stream->response->channel->status; ?></p>
			</li>
		<?php endif; ?>
		<?php endforeach; ?>
		</ul>
	
	
	<?php else: ?>
		<p>No User Streams</p>
	<?php endif; ?>
	</div>
	
	

</div>

<?php sidebar('main'); ?>
