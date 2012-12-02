
  


<div class="widget sidewidget" id="lead-streams">       

  <h2>Currently Streaming</h2>
  
    <?php
  $fetch = array();
  $streams = fetch('streams', 'order_by_asc=section_id');

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
?>


<?php if( empty( $responses ) ): ?>
  <p>No streams available.</p>
<?php else: ?>
<ul>
<?php foreach($responses as $response): ?>
    <?php $fetch[$response->name]->response = $response; ?>
<?php endforeach; ?>

<?php foreach ($fetch as $key => $stream): ?>
  <?php if ( ! empty($stream->response)): ?>
    <li>
        <?php if($stream->section->id == '1'): ?>
          <span class="team" title="Paradigm Team Member"></span>
      <?php elseif($stream->section->id == '2'): ?>
        <span class="fav" title="Featured Stream"></span>
        <?php endif ;?>
        <h3><a href="<?= stream_url($stream->section->url_name, $stream->category->url_name, $stream->id, $stream->url_title) ?>"><?= $stream->title; ?></a></h3>
      <span class="viewers">Viewers: <?php echo $stream->response->stream_count; ?></span>
        <span class="category"><?php echo $stream->response->meta_game; ?></span>
    </li>
  <?php endif; ?>
<?php endforeach; ?>
</ul>
<?php endif; ?>
  <script>
      $("span[title]").tooltip({
        effect: 'slide',
        layout: '<span class="help-tool"><span class="arrow">]</span></span>',
         position: "center left",
         offset: [10, -4],
        });
    </script>
  
</div>

