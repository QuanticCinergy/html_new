<?php if($this->categories): ?>

	<div class="sidewidget">
		<h2>Browse Categories</h2>

		<ul class="sb-menu">
		
			<li<?php if($this->current_category == NULL): ?> class="current"<?php endif; ?>>
				<a href="/shop" title="Shop Home" class="home">Shop Home</a>
			</li>
		
			<?php foreach($this->categories as $category): ?>
		
				<li<?php if($this->current_category == $category->url_name): ?> class="current"<?php endif; ?>>
					<a href="/shop/<?php echo $category->url_name; ?>/page/1" title="<?php echo $category->name; ?>">
						<?php echo $category->name; ?>
					</a>
				</li>
		
			<?php endforeach; ?>
		
		</ul>
	</div>

<?php endif; ?>
