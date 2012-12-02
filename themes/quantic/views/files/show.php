<h1><?php echo $file->name; ?></h1>
<p><?php echo $file->description; ?></p>
Category: <?php echo $file->category->name; ?><br>

<b>Properties:</b><br>
<ul>
	<li>Filename: <?php echo $file->file_filename; ?></li>
	<li>Size: <?php echo $file->file_size; ?> Kb</li>
	<li>MIME: <?php echo $file->file_mime; ?></li>
</ul>

<?php echo link_to('Download', '/files/download/'.$file->id); ?>
