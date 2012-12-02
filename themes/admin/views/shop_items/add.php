<h1>Shop</h1>

<div id="subnav"> 
	<ul> 
		<li class="active"><a href="/admin/shop_items/index/">Products</a></li> 
		<li><a href="/admin/shop_categories/index/">Categories</a></li>
        <li><a href="/admin/shop_brands/index/">Brands</a></li> 
		<li><a href="/admin/shop_countries/index/">Countries</a></li>	
		<li><a href="/admin/orders/index">Orders</a></li>
		<li><a href="/admin/orders/offers/">Offers</a></li>
		<li><a href="/admin/orders/reports/">Reports</a></li>
	</ul> 
</div>

<div id="mainbody" class="with-subnav">
	<h2 class="form-head">Add New Product</h2>
	<?php echo partial('validation'); ?>
	<?php echo form_open_multipart('admin/shop_items/create'); ?>
	<div class="form-row title">
		<label>Product Name</label>
		<?php echo form_input('name'); ?>
	</div>
	
	<div class="form-row">

		<label>Status</label>
		<?php echo form_dropdown('status', array(
			'enabled' => 'Enabled',
			'disabled' => 'Disabled'
		), 'disabled'); ?>
	
	</div>
	
	<div class="form-row">
		
		<div class="form-half">
			<label>Brand</label>
			<?php echo form_dropdown('brand_id', $brands); ?>
		</div>
		<div class="form-half">
			<label>Category</label>
			<?php echo form_dropdown('category_id', $categories); ?>
		</div>
		
	</div>
	

<div class="form-row tabbed-row">
	<label>Product Financing</label>
	
	<ul class="tabs">
		<li><a href="#">Price</a></li>
		<li><a href="#">Offers</a></li>
	</ul>

	<div class="panes">

		<div class="the-pane">
		
			<div class="additional single_price_box inner-form-row">
				<label>Price</label>
				<?php echo form_input('price', '0.00'); ?>
				<span class="add add_price"><a href="#">add</a>Add multiple prices</span>
			</div>
			<div id="additional_prices"></div>
	    
	    </div>
    
	    
    <div class="the-pane">
    
	    <div id="additional_offers" class="form-row">
			<div class="additional">
				<div class="inner-form-row">
	                <input type="hidden" class="curr_offer" value="0" />
					<ul class="in-threes">
						<li><label>Offer type</label>
		                <select name="offer[0][type]">
		                    <option value="percent">% off price</option>
		                    <option value="fixed">fixed amount off price</option>
		                    <option value="custom">Custom field</option>
		                </select>
		                </li>
		                <li>
		                    <label>Offer Label</label><input type="text" name="offer[0][custom]" />
		                </li>
		                <li><label>Amount</label><input type="text" name="offer[0][amount]" /></li>
	                </ul>
	                
				</div>
	        	<div class="inner-form-row">
	            <ul class="in-one">
	                <li><label>Description</label>
	                <?php echo form_textarea('offer[0][desc]', '', 'class="short"'); ?></li>
	                </ul>
	        	</div>
	        	<div class="inner-form-row">
	               <ul class="in-threes">
	                    <li><input type="hidden" class="curr_offer_code" value="0" />
	                    <label>Unique code</label>
	                    <input type="text" name="offer[0][code][0][code]" value="" />
						</li>
	                    <li><label>Start Date</label>
	                    <input type="text" name="offer[0][code][0][start]" class="date" value="" /></li>
						<li><label>End Date</label>
	                    <input type="text" name="offer[0][code][0][end]" class="date" value="" />
	                    </li>
	                   <li> <span class="add add_offer_code"><a href="#">add</a>Add new code</span></li>
	                </ul>
	            </div>
	            <span class="add add_offer"><a href="#">add</a></span>
			</div>
	    </div>
	</div> <!-- END THE-PANE -->
	</div>
	   
	<script>
	// perform JavaScript after the document is scriptable.
	$(function() {
		// setup ul.tabs to work as tabs for each div directly under div.panes
		$("ul.tabs").tabs("div.panes > .the-pane", {
			effect: 'fade',		
		});
	});
	</script>
    
    </div> <!-- END FORM ROW -->
    
	<div class="form-row">
		<label>Release Date</label>
		<input type="text" name="release_date" class="date">
	</div>
	
	<div class="form-row">
		<label>Description</label>
		<?php echo form_textarea('description', '', 'class="full"'); ?>
	</div>
	<div class="form-row">
		<label>Specification</label>
		<?php echo form_textarea('specification', '', 'class="full"'); ?>
	</div>
	
	<div class="form-row">
		<label>Photo</label>
		<?php echo form_upload('photo'); ?>
	</div>
	
	<div class="form-row">
		<label>Stock levels</label>
		<?php echo form_input('stock', '0'); ?>
	</div>
	
	<div class="form-row">
		<label>Digital good</label>
		<?php echo form_dropdown('digital', array
		(
			0	=> 'No',
			1	=> 'Yes'
		)); ?>
	</div>
	<div class="form-row">
		<label>Language attribute</label>
		<?php echo form_dropdown('language', array
		(
			0	=> 'No',
			1	=> 'Yes'
		)); ?>
	</div>
	
	<?php foreach($meta as $key=>$value) : ?>
	<div class="form-row">
	<label><?php echo humanize($key); ?></label>
	<?php echo form_input('meta['.$key.']'); ?>
	</div>
	<?php endforeach; ?>
	
	<div class="form-row">
		<?php echo form_submit('submit', 'Create'); ?>
	</div>
	</form>
</div>
<script type="text/javascript">
	var first = true;
	var additional_first = true;
	var price = 0.00;
	var count = 0;
	$(function(){
		$(".additional .add_price, #additional_prices .add").live('click', function(){
			//$(".additional").hide();
            $(".additional.single_price_box").hide();
			var html  = '';
			var price = 0.00;
			
			if(first) {
				html += '<div class="additional reset-price">';
				html += '<a id="reset_prices" href="#">Switch to single price</a>';
				html += '</div>'
				
				$("#additional_prices").prepend(html);
				
				html = '';
				
				price = parseFloat($(".additional input[name=\"price\"]").val());
				price = price.toFixed(2);
			}
					
			html    += '<div class="additional"><ul class="in-threes">';
			html    += '<li><label>Label</label><input type="text" name="variation['+ count +'][name]" /></li>';
			html    += '<li><label>Price (&euro;)</label><input type="text" class="price-field" name="variation['+ count +'][price]" value="'+ price +'" /></li>';
			html    += '<li><span class="add"><a href="#">add</a> Add new row</span></li></ul></div>';
			
					
			$(this).attr('class', 'delete');
			$("#additional_prices").append(html);
			count++;
			
			if(first) {
				price = 0.00;
				first = false;
			}
			
			return false;
		});
		
		$(".additional .delete").live('click', function(){
            if($(this).parents("#additional_offers").length>0){
                $(this).parent().remove();
            }else{
                $(this).parent().parent().remove();
            }
			
			return false;
		});
		
		$("#reset_prices").live('click', function(){
			$(".additional").show();
			$("#additional_prices").html('');
            
			$(".additional.single_price_box span").attr('class', 'add add_price');
			first = true;
			return false;
		});
        
        var count_offers =1;
        $(".add_offer").live('click', function(){
            
            curr_offer = parseInt($(this).parent().children().children(".curr_offer").val());
            curr_offer++;
            
            var html_offer  = '';
			var price = 0.00;
			
            html_offer    += '<div class="additional">';
    		html_offer    += '	<div class="form-half full-field">';
            html_offer    += '        <input type="hidden" class="curr_offer" value="'+curr_offer+'" />';
    		html_offer    += '		<label>Offer type</label>';
            html_offer    += '        <select name="offer['+ curr_offer +'][type]">';
            html_offer    += '            <option value="percent">% off price</option>';
            html_offer    += '            <option value="fixed">fixed amount off price</option>';
            html_offer    += '            <option value="custom">Custom field</option>';
            html_offer    += '        </select>';
            html_offer    += '        <span class="custom_type_box">';
            html_offer    += '            <label>Custom type</label><input type="text" name="offer['+ curr_offer +'][custom]" />';
            html_offer    += '        </span>';
            html_offer    += '        <label>Amount</label><input type="text" name="offer['+ curr_offer +'][amount]" />';
    		html_offer    += '	</div>';
            html_offer    += '    <div class="form-half clear-left">';
            html_offer    += '        <label>Description</label>';
            html_offer    += '        <textarea name="offer['+ curr_offer +'][desc]"></textarea>';
            html_offer    += '    </div>';
            html_offer    += '    <div class="offer_codes clear-left">';
            html_offer    += '        <div class="offer_code_box clear-left">';
            html_offer    += '            <input type="hidden" class="curr_offer_code" value="0" />';
            html_offer    += '            <label>Unique code</label>';
            html_offer    += '            <input type="text" name="offer['+ curr_offer +'][code][0][code]" value="" />';
            html_offer    += '            <label>Start Date</label>';
            html_offer    += '            <input type="text" name="offer['+ curr_offer +'][code][0][start]" class="date" value="" />';
            html_offer    += '            <label>End Date</label>';
            html_offer    += '            <input type="text" name="offer['+ curr_offer +'][code][0][end]" class="date" value="" />';
            html_offer    += '            <span class="add add_offer_code"><a href="#">add</a></span>';
            html_offer    += '        </div>';
            html_offer    += '    </div>';
            html_offer    += '    <span class="add add_offer"><a href="#">add</a></span>';
    		html_offer    += '</div>';
            
            
            
			$(this).attr('class', 'delete');
			$("#additional_offers").append(html_offer);
			
			if(first) {
				price = 0.00;
				first = false;
			}
			
			return false;
        });
        
        $(".add_offer_code").live('click', function(){
            var html_code  = '';
            
            curr_offer = $(this).parent().parent().parent().find(".curr_offer").val();
            
            curr_offer_code = parseInt($(this).parent().children(".curr_offer_code").val());
            curr_offer_code++;
            
            html_code    += '    <ul class="in-threes">';
            html_code    += '        <li><input type="hidden" class="curr_offer_code" value="'+curr_offer_code+'" />';
            html_code    += '        <input type="text" name="offer['+curr_offer+'][code]['+curr_offer_code+'][code]" value="" /></li>';
            html_code    += '        <li><input type="text" name="offer['+curr_offer+'][code]['+curr_offer_code+'][start]" class="date hasDatepicker" value="" /></li>';
            html_code    += '        <li><input type="text" name="offer['+curr_offer+'][code]['+curr_offer_code+'][end]" class="date hasDatepicker" value="" /></li>';
            html_code    += '        <li><span class="add add_offer_code"><a href="#">add</a> Add new code</span></li>';
            html_code    += '    </ul>';

            
            $(this).attr('class', 'delete');
			$(this).parent().parent().append(html_code);
            return false;
        });
        
        
	});
</script>