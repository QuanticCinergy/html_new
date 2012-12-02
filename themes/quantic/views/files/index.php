<ul>
<?php foreach($files as $file) : ?>
<li><?php echo link_to($file->name, '/files/'.$file->category->url_name.'/'.$file->id); ?></li>
<?php endforeach; ?>
</ul>

<?php echo $pagination; ?>
