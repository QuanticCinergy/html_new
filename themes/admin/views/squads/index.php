<h1>Team Management</h1>
<div id="subnav"> 
	<ul> 
		<li class="active"><a href="/admin/squads/index/">Squads</a></li> 
		<li><a href="/admin/squad_categories/index/">Squad Categories</a></li> 
		<li><a href="/admin/matches/index/">Matches</a></li> 
	</ul> 
</div>
			<div id="mainbody" class="with-subnav"> 
				<ul class="action-buttons"> 
					<li><a href="/admin/squads/add/" class="generic_button large">Add Squad</a></li> 
				</ul><br>
				<?php if(count($squads) > 0) : ?>
				<div class="component-block"> 
				
					<table cellpadding="0" cellspacing="0" class="sortable"> 
						<tr class="lead">
							<th>Name</th>
							<th>Description</th>
							<th class="controls"></th> 
						</tr>
						<?php foreach($squads as $squad) : ?> 
						<tr id="squad-<?=$squad->id;?>" class="sort">
							<td><?php echo link_to($squad->name, '/admin/squads/edit/id/'.$squad->id); ?></td>
							<td><?php echo $squad->description; ?></td>
							<td class="controls-lists"> 
								<ul class="buttons">
									<li><a href="/admin/squads/remove/id/<?php echo $squad->id; ?>" class="delete">Delete</a></li> 
									<li><a href="/admin/squads/edit/id/<?php echo $squad->id; ?>" class="edit">Edit</a></li> 
								</ul> 
							</td> 
						</tr> 
						<?php endforeach; ?>
						</table> 
				</div>
				<?php else: ?>
				<p class="none">No squads found.</p>
				<?php endif; ?>
			</div> 

<script type="text/javascript" charset="utf-8">

	var orderTimer = null;

	function saveAlert() {
	    $("#saved").clone().removeAttr('id').attr('class', 'saved').css('display', 'block').prependTo('body');
		setTimeout(function(){
			$(".saved").fadeOut(300, function(){
				$(this).remove();
			});
		}, 3000);
	}

	$(function(){

		$(".sortable tbody tr.lead").css('cursor', 'default');

		$(".sortable tbody tr.sort").mouseover(function(){
			$(this).addClass('sort-active');
		}).mouseout(function(){
			$(this).removeClass('sort-active');
		});

		var userAgent = navigator.userAgent.toLowerCase();

		if(userAgent.match(/firefox/)) {
			$(".sortable tbody").bind("sortstart", function(event, ui){
				ui.helper.css('margin-top', $(window).scrollTop());
			}).bind('sortbeforestop', function(event, ui){
				ui.helper.css('margin-top', 0);
			});
		}

		$(".sortable tbody").sortable({
			helper: function(event, ui) {
				ui.children().each(function(){
					$(this).width($(this).width());
				});

				return ui;
			},
			update: function() {
				var order      = $(".sortable tbody").sortable('serialize', {key: 'item'});

				// Save the the new order
				clearTimeout(orderTimer);

				orderTimer = setTimeout(function(){
		            save                = {};
					save.order          = order;
		            save.csrf_test_name = '<?php echo $this->security->csrf_hash; ?>';

		            $.post("<?=site_url('admin/squads/index/order');?>", save, function(data){

						if(data.success) {
							saveAlert();
						} else {
							alert(data.error);
						}
		        	});
		        }, 1000);
			},
			items: 'tr.sort',
			axis: 'y'
		}).disableSelection();
	});
</script>