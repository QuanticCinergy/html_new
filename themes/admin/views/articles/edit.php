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
			'article_id'	: '<?php echo $article->id; ?>'
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
			$.post('/admin/galleries/upload', { filename: response, user_id: '<?php echo current_user()->id; ?>', article_id: '<?php echo $article->id; ?>', csrf_test_name: '<?php echo $this->security->csrf_hash; ?>' });
		
		},
		'onAllComplete'	: function() {
		
			// Refresh the window
			window.location.reload();
			return false;
		
		}
	});
	
	$('input[name="title"]').keyup(function(){
		if($(this).val() != last_title) {
			last_title = $(this).val();
			readySave();
		}
	});
	$('select[name="section_id"]').change(readySave);
	$('input[name="category[]"]').change(readySave);
	$('input[name="created_at"]').change(readySave);
	$('select[name="status"]').change(readySave);
});

var game_ids = [];

<?php
if(isset($games_json))
{
	$games_ids = json_decode($games_json, TRUE);
	
	for($i = 0; $i < count($games_ids); $i++)
	{
		echo 'game_ids['.$i.'] = '.$games_ids[$i]['id'].';';
	}
}
?>

var last_title = '<?=$article->title;?>';
var st;

function addGame(id) {
	game_ids.push(parseInt(id));
	readySave();
}

function removeGame(id) {
	var idx = game_ids.indexOf(parseInt(id));
	
	if(idx != -1) {
		game_ids.splice(idx, 1);
	}
	readySave();
}

function readySave() {
	clearTimeout(st);
	st = setTimeout("doSave()", 2000);
}

function doSave() {
	
	save = {};
	
	save.id      = $('input[name="id"]').val();
	save.title   = $('input[name="title"]').val();
	save.section = $('select[name="section_id"]').val();
	save.short   = tinyMCE.get('short_content').getContent();
	save.full    = tinyMCE.get('full_content').getContent();
	save.date    = $('input[name="created_at"]').val();
	save.status  = $('select[name="status"]').val();
	save.games   = game_ids.toString();
	
	var categories = '';
	$('input[name="category[]"]').each(function(){
		if($(this).is(':checked')) {
			categories += $(this).val() + ',';
		}
	});
	save.categories = categories;
	
	$.get(window.location.href + '/save', save, function(data){
		$('#preview_link').attr('href', data).html(save.title);
		$("#saved").clone().removeAttr('id').attr('class', 'saved').css('display', 'block').prependTo('body');
		setTimeout(function(){
			$(".saved").fadeOut(300, function(){
				$(this).remove();
			});
		}, 3000);
	});
	
}
</script>

<div id="saved">Article Saved</div>

<h1>Articles</h1>

<div id="subnav"> 
				<ul> 
						<li class="active"><a href="/admin/articles/index/">Articles</a></li> 
						<li><a href="/admin/article_sections/index/">Sections</a></li> 
						<li><a href="/admin/article_categories/index/">Categories</a></li>
				</ul> 
			</div> 
	
<?php if($success): ?>		
<div class="success"><?=$success;?></div>
<?php endif; ?>

<div id="mainbody" class="with-subnav">
	

	<?php echo partial('validation'); ?>
	<?php echo form_open_multipart('admin/articles/update'); ?>
	<?php echo form_hidden('id', param('id')); ?>
			<script>
			$(function() {

    var $sidebar   = $("#form-final"),
        $window    = $(window),
        offset     = $sidebar.offset(),
        topPadding = 130;

    $window.scroll(function() {
        if ($window.scrollTop() > offset.top) {
            $sidebar.stop().animate({
                marginTop: $window.scrollTop() - offset.top + topPadding
            });
        } else {
            $sidebar.stop().animate({
                marginTop: 0
            });
        }
    });

});
		</script>
		<div id="form-final">
	
			<div class="final-row">
				<a id="preview_link" class="generic_button floatleft" href="/articles/<?= $article->section->url_name; ?>/<?= $article->category->url_name; ?>/<?= $article->id; ?>/<?= $article->url_title; ?>" target="_blank">Preview Article</a>
			</div>
			<div class="final-row">
				<label>Article Image</label>
				<?php echo img($article->image_article_url); ?>
				<?php echo form_upload('image_article'); ?>
			</div>	
			<div class="final-row">
				<label>Date (click to change) </label>
				<input type="text" value="<?= date('d-m-Y G:i', $article->original_created_at) ?>" name="created_at" class="date" />
			</div>
			<div class="final-row">
				<label>Publish Status</label>
				<?php echo form_dropdown('status', array(
					'draft' => 'Draft',
					'published' => 'Published'
				), $article->status); ?>
			</div>
			
			<div class="final-row">
				<?php echo form_submit('submit', 'Save'); ?>
				<a href="/admin/articles/index/" class="cancel">Cancel</a>
				
			</div>
		</div>
		
	
		
		<div id="form-content">	
			<h2 class="form-head">Edit Article</h2>
			
			<div class="form-row title">
				<label>Title</label>
				<?php echo form_input('title', $article->title); ?>
			</div>
			<div class="form-row">
				<label>Section</label>
				<?php echo form_dropdown('section_id', $sections, $article->section_id); ?>
			</div>
			<div class="form-row">
				<label>Category</label>
				<?php //echo form_dropdown('category_id', $categories, $article->category_id); ?>
				<div class="articles_categories_container">
					<ul>
					<?php foreach($categories as $cat) { ?>
						<li><?php $checked = (in_array($cat->id, $selected_categories)) ? 'checked="checked"' : ''; ?> 
						<input type="checkbox" <?=$checked;?> name="category[]" value="<?=$cat->id;?>" /> <?=$cat->name;?></li>
					<?php } ?>
					</ul>
				</div>
			</div>
			<div class="form-row">
				<label>Attach Games</label>
				<script>window.onload = function(){pop('<?php echo $games_json; ?>');}</script>
				<input type="text" name="games" class="games-tokeninput">
				<br /><br />
			</div>
			
			<div class="form-row">
				<label>Intro</label>
				<?=form_textarea(array(
					'name'  => 'short_content',
					'id'    => 'short_content',
					'class' => 'short'
				), $article->short_content);?>
			</div>
			<div class="form-row">
				<label>Full content</label>
				<?=form_textarea(array(
					'name'  => 'content',
					'id'    => 'full_content',
					'class' => 'full'
				), $article->content);?>
			</div>
			
						
			<div class="form-row">
				<label>Article Gallery</label>
				<!--<input type="file" multiple accept="image/*" name="photos[]" />-->
				<input type="file" id="upload_image" name="image" />
				<div id="fileQueue"></div>
			</div>
			<div class="form-row">
				<label>Current Article Gallery Images</label>
				<ul id="preview-images">
				<?php foreach($article->photos as $photo) : ?>
					<li>
						<?php echo img($photo->photo_thumb_url); ?>
						<div class="preview-actions"><a href="/admin/photos/set_as_cover/id/<?php echo $photo->id; ?>/article_id/<?php echo $article->id; ?>" id="make_cover">Make Cover</a><a href="/admin/photos/remove/id/<?php echo $photo->id; ?>/" id="remove">Remove</a></div>
					</li>
				<?php endforeach; ?>
				</ul>
			</div>

			
		</div>
	</form>
</div>

