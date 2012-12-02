 <?php
		$startale_articles = array();
		
			$this->db->select('ac.url_name AS category_url_name, a.*, asec.url_name AS section_url_name, u.username');
			$this->db->from('article_categories_map acm');
			$this->db->join('article_categories ac', 'acm.category_id = ac.id');
			$this->db->join('articles a', 'acm.article_id = a.id');
			$this->db->join('article_sections asec', 'asec.id = a.section_id');
			$this->db->join('users u', 'a.user_id = u.id');
			$this->db->where('acm.category_id', '32');
			$this->db->order_by('a.created_at', 'desc');
			$this->db->limit(4);
			
			foreach($this->db->get()->result() as $row)
			{
				// We need this crappyness to keep view working without any changes
				
				// section->url_name
				$row->section = new stdClass;
				$row->section->url_name = $row->section_url_name;
				
				// category->url_name
				$row->category = new stdClass;
				$row->category->url_name = $row->category_url_name;
				
				// user->username
				$row->user = new stdClass;
				$row->user->username = $row->username;
				
				
				$startale_articles[] = $row;
			} 
?>
<aside id="sidebar" class="margin-top">	
	<section id="related" class="list-box grad-bg">
		<h2>StarTale Articles</h2>

			<?php foreach($startale_articles as $item): ?>
				<article>
					<img class="thumb" src="<?php echo $item->image_article_thumb_url ?>" title="<?php echo $item->title ?>" />
					<h3><a href="<?= article_url($item->section->url_name, $item->category->url_name, $item->id, $item->url_title) ?>"><?= $item->title ?></a></h3>
					<p class="meta name"><?php echo $item->username ?></p>
	    			<p class="meta"> <?= date("jS F Y", $item->created_at); ?></p>
				</article>
			<?php endforeach; ?>					

	</section>
	</aside>