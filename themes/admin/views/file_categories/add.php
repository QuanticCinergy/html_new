<h1>File Categories</h1>

<div id="subnav"> 
				<ul> 
					<li><a href="/admin/files/index/">Files</a></li>
					<li class="active"><a href="/admin/file_categories/index/">Categories</a></li> 
				</ul> 
			</div> 
			
	<div id="mainbody" class="with-subnav"> 
		<h2>Add New Category</h2>
		<?php echo partial('validation'); ?>
		<?php echo form_open('admin/file_categories/create'); ?>
			<div class="form-row">
				<label>Name</label>
				<?php echo form_input('name'); ?>
			</div>
			<div class="form-row">	
				<?php echo form_submit('submit', 'Create'); ?>
				<a href="/admin/file_categories/index/" class="cancel">Cancel</a>
			</div>
		</form>
	</div>
