<div id="content" class="has-side">

<section id="stream" class="streams">
			<h2 id="page-title"><?= $stream->section->name ?> Streams</h2>			
			
			<div id="the-post">
				<h1 id="the-title"><?= $stream->title ?> <span class="category"><?= $stream->category->name ?></span></h1>
				
				<?php widget('sharing'); ?>
				
				
				
				<!--<img width="510" alt="<?php echo $stream->title; ?>" src="<?php echo $stream->image_url; ?>" class="rf-article-img">-->	
				
				<div class="stream">
					<?php
					$api_str = file_get_contents("http://api.justin.tv/api/channel/show/{$stream->title}.json");
					$results = json_decode($api_str,true);
					?>	
					<?php echo $results["embed_code"]; ?>
				</div>
				
				<div class="chat">
				<?php
					$chatData = file_get_contents('http://api.justin.tv/api/channel/chat_embed/' .$stream->title. '?height=450&width=640');
					echo $chatData;
				?>
				</div>
				
				
				
				
			</div>
			
		</section>
<!--
<?= partial('comments', array(
	'model' => $stream,
)) ?>-->

</div>
<?php sidebar('main'); ?>
