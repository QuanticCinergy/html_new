<link type="text/css" rel="stylesheet" href="/themes/admin/assets/plugins/uploadify-v2.1.4/uploadify.css" />
<script type="text/javascript" src="/themes/admin/assets/plugins/uploadify-v2.1.4/swfobject.js"></script>
<script type="text/javascript" src="/themes/admin/assets/plugins/uploadify-v2.1.4/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {

	// Replace file upload with uploadify uploader
	$("#upload_image").uploadify({
		'uploader'		: '/themes/admin/assets/plugins/uploadify-v2.1.4/uploadify.swf',
		'script'         : '/themes/admin/assets/plugins/uploadify-v2.1.4/uploadify.php',
		'scriptData'	: { 
			'user_id'		: '<?php echo current_user()->id; ?>',
			'gallery_id'	: '<?php echo $gallery->id; ?>'
		},
		'checkScript'	: '/themes/admin/assets/plugins/uploadify-v2.1.4/check.php',
		'folder'		: '/uploads/photos',
		'sizeLimit'		: 10737418240,
		'queueID'		: 'fileQueue',
		'auto'			: true,
		'multi'			: true,
		'cancelImg'		: '/themes/admin/assets/plugins/uploadify-v2.1.4/cancel.png',
		'onComplete'	: function(event, ID, fileObj, response, data) {
			
			// Process the photo
			$.post('/admin/galleries/upload', { filename: response, user_id: '<?php echo current_user()->id; ?>', gallery_id: '<?php echo $gallery->id; ?>', csrf_test_name: '<?php echo $this->security->csrf_hash; ?>' });
		
		},
		'onAllComplete'	: function() {
		
			// Refresh the window
			setTimeout(function(){
				window.location.reload();
			}, 300);
			return false;
		
		}
	});

});
</script>

<h1>Edit Gallery</h1>
<div id="subnav"> 
	<ul> 
		<li class="active"><a href="/admin/galleries/index/">Galleries</a></li> 
		<li><a href="/admin/videos/index/">Videos</a></li> 
		<li><a href="/admin/video_categories/index/">Video Categories</a></li> 
	</ul> 
</div> 

<div id="mainbody" class="with-subnav">

<h2 class="form-head">Edit Gallery</h2>

<?php echo partial('validation'); ?>
<?php echo form_open_multipart('admin/galleries/update'); ?>
<?php echo form_hidden('id', param('id')); ?>
<div class="form-row">
<label>Current Images</label>
<ul id="preview-images">
<?php foreach($gallery->photos as $photo) : ?>
	<li>
		<?php echo img($photo->photo_thumb_url); ?>
		<div class="preview-actions"><a href="/admin/photos/set_as_cover/id/<?php echo $photo->id; ?>/gallery_id/<?php echo $gallery->id; ?>" id="make_cover">Make Cover</a><a href="/admin/photos/remove/id/<?php echo $photo->id; ?>/" id="remove">Remove</a></div>
	</li>
<?php endforeach; ?>
</ul>
</div>

<div class="form-row">
	<label>Add More Images</label>
	<!--<input type="file" multiple accept="image/*" name="photos[]" />-->
	<input type="file" id="upload_image" name="image" />
	<div id="fileQueue"></div>
</div>

<div class="form-row">
	<label>Title</label>
	<?php echo form_input('title', $gallery->title); ?><br>
</div>

<div class="form-row">
	<label>Short Description</label>
	<?php echo form_textarea('short_description', $gallery->short_description, 'class="short"'); ?>
</div>

<div class="form-row">
	<label>Description</label>
	<?php echo form_textarea('description', $gallery->description, 'class="full"'); ?>
</div>

<div class="form-row">
<?php echo form_submit('submit', 'Update'); ?>
</div>
</form>
</div>
