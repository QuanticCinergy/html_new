<h1>Products</h1>

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

<? if($success): ?>
<div class="success">Product successfully updated</div>
<? endif; ?>

<div id="mainbody" class="with-subnav">
<h2  class="form-head">Edit Product</h2>
<?php echo partial('validation'); ?>
<?php echo form_open_multipart('admin/shop_items/update'); ?>
<?php echo form_hidden('id', param('id')); ?>

<div class="form-row title">
<label>Product Name</label>
<?php echo form_input('name', $item->name); ?>
</div>

<div class="form-row">
	<label>Status</label>
	<?php echo form_dropdown('status', array(
		'enabled' => 'Enabled',
		'disabled' => 'Disabled'
	), ($item->status === 'enabled') ? 'enabled' : 'disabled'); ?>
</div>


<div class="form-row">
	<div class="form-half">
	<label>Brand</label>
	<?php echo form_dropdown('brand_id', $brands, $item->brand_id); ?>
	</div>

	<div class="form-half">
	<label>Category</label>
	<?php echo form_dropdown('category_id', $categories, $item->category_id); ?>
	</div>
</div>


<div class="form-row tabbed-row">
<label>Product Financing</label>

<ul class="tabs">
	<li><a href="#">Price</a></li>
	<li id="offers"><a href="#">Offers</a></li>
</ul>

<div class="panes">

	<div class="the-pane">
		<div class="additional single_price_box inner-form-row" <?php if(count($variations) > 0) echo 'style="display:none"'; ?>> 
			<label>Price</label>
			<?php echo form_input('price', $item->price); ?>
			<span class="add"><a href="#">add</a></span>
		</div>
		
		<div id="additional_prices">
			
			<?php if(count($variations) > 0): ?> 
			<div class="additional reset-price"><a id="reset_prices" href="#">Reset to single price</a></div>
			
			
			<?php for($i = 0; $i < count($variations); $i++) { ?> 
			<div class="additional"> 
               <ul class="in-threes">
                    <li><label>Name</label> 
                    <input type="text" name="variation[<?php echo $variations[$i]->id; ?>][name]" value="<?php echo $variations[$i]->name; ?>" /> 
					</li>

					<li>
	                <label>Price (&euro;)</label> 
		            <input type="text" class="price-field" name="variation[<?php echo $variations[$i]->id; ?>][price]" value="<?php echo number_format($variations[$i]->price, 2); ?>" /> 
	                </li>        
		        	<li>
		        	<?php $class = ($i == count($variations)-1) ? 'add' : 'delete'; ?> 
		        	<span class="<?php echo $class; ?>"><a href="#">add</a></span> 
	            	</li>
			       </ul>
				</div>
			
			<?php } ?>
			
			<?php endif; ?> 
			
		</div>
	</div>
	
	<div class="the-pane">
		<div id="additional_offers" class="form-row">
			
			<?php if($offer_error): ?>
			<div class="error">That offer code has already been used</div>
			<?php endif; ?>
		    
		    <?php
		    $count_offers = 0;
		    $offers_length = count($offers);
		    foreach($offers as $offer){
		        $button_class = "delete";
		        if($offers_length-1 == $count_offers) $button_class = "add add_offer";
		    ?>
		    <div class="additional">
				<div class="inner-form-row">
		            <input type="hidden" class="curr_offer" value="<?=$count_offers?>" />
		            <input type="hidden" class="offer_id" name="offer[<?=$count_offers?>][id]" value="<?=$offer->id?>" />
					<ul class="in-threes">	
						<li><label>Offer type</label>
				            <select name="offer[<?=$count_offers?>][type]">
				                <option value="percent" <?php if($offer->type=='percent') echo 'selected=""';?>>% off price</option>
				                <option value="fixed" <?php if($offer->type=='fixed') echo 'selected=""';?>>fixed amount off price</option>
				                <option value="custom" <?php if($offer->type=='custom') echo 'selected=""';?>>Custom field</option>
				            </select>
			            </li>
			            
			            <li><label style="width:60%;">Offer label</label><input type="text" name="offer[<?=$count_offers?>][custom]" value="<?=$offer->custom_type?>" /></li>
			            
			            <li><label>Amount</label><input type="text" name="offer[<?=$count_offers?>][amount]" value="<?=$offer->amount?>" /></li>
		            
		       		</ul>
				</div>
		        <div class="inner-form-row">
		            <ul class="in-one">
		            	<li>
		            		<label>Description</label>
		            		<!--<textarea name="offer[<?=$count_offers?>][desc]"><?=$offer->desc?></textarea>-->
		            		
		            		<?php echo form_textarea('offer['.$count_offers.'][desc]', $offer->desc, 'class="short"'); ?>
		            		
		            	</li>
		            </ul>
		        </div>
		        <div class="inner-form-row">
		            <?php
		            $count_codes = 0;
		            $codes_length = count($offer->codes);
		            foreach($offer->codes as $code){
		                $code_class = "delete";
		                if($codes_length-1 == $count_codes) $code_class = "add add_offer_code";
		            ?>
		            <ul class="in-threes">
		
			          	<li>
			          	    <input type="hidden" class="curr_offer_code" value="<?=$count_codes?>" />
			                <input type="hidden" class="offer_code_id" name="offer[<?=$count_offers?>][code][<?=$count_codes?>][id]" value="<?=$code->id?>" />
			                <label style="width:60%">Unique code</label>
			                <input type="text" name="offer[<?=$count_offers?>][code][<?=$count_codes?>][code]" value="<?=$code->code?>" />
			          	</li>
			          	<li>
			          		<label>Start Date</label>
			                <input type="text" name="offer[<?=$count_offers?>][code][<?=$count_codes?>][start]" class="date" value="<?=$code->start?>" />
			          	</li>
			          	<li>
			          		<label>End Date</label>
			                <input type="text" name="offer[<?=$count_offers?>][code][<?=$count_codes?>][end]" class="date" value="<?=$code->end?>" />
						</li>
						<li><span class="<?=$code_class?>"><a href="#">add</a> Add new code</span></li>
		            </ul>
		            <?php
		            $count_codes++; 
		            }
		            if($codes_length==0){ ?>
		            <ul class="in-threes">
		            	<li>
			            	<input type="hidden" class="curr_offer_code" value="0" />
		    	            <input type="text" name="offer[<?=$count_offers?>][code][0][code]" value="" />
		                </li>
		 				<li>             
		        	        <input type="text" name="offer[<?=$count_offers?>][code][0][start]" class="date" value="" />
			            </li>
		    			<li>
			                <input type="text" name="offer[<?=$count_offers?>][code][0][end]" class="date" value="" />

		                </li>
		                <li><span class="add add_offer_code"><a href="#">add</a> Add new offer</span></li>
		            </ul>
		            <?php 
		            }
		            ?>
		            
		        </div>
		        <!--<span class="<?=$button_class?>"><a href="#">add</a> Add new offer</span>-->
				</div>
			    <?php
			    $count_offers++;
			    }
			    if($offers_length==0){ ?>
			    <div class="additional">
					<div class="inner-form-row">
			            <ul class="in-threes">
				            <li>
					            <input type="hidden" class="curr_offer" value="0" />
								<label>Offer type</label>
					            <select name="offer[0][type]">
					                <option value="percent">% off price</option>
					                <option value="fixed">fixed amount off price</option>
					                <option value="custom">Custom field</option>
					            </select>
				            </li>
			            	<li>
			            		<span class="custom_type_box">	
				                	<label>Offer Label</label><input type="text" name="offer[0][custom]" />
			                	</span>
			                </li>
							<li>		            
					            <label>Amount</label><input type="text" name="offer[0][amount]" />
				            </li>
						</ul>            
					</div>
			        <div class="inner-form-row">
			        	<ul class="in-one">
			            	<li>
			            		<label>Description</label>
					            <textarea name="offer[0][desc]"></textarea>
					        </li>
			            </ul>
			        </div>
			        <div class="inner-form-row">
			           <ul class="in-threes">
			                <li><input type="hidden" class="curr_offer_code" value="0" />
			                <label>Unique code</label>
			                <input type="text" name="offer[0][code][0][code]" value="" />
			                </li>
			                <li>
			                <label>Start Date</label>
			                <input type="text" name="offer[0][code][0][start]" class="date" value="" />
			                </li>
			                <li>
			                <label>End Date</label>
			                <input type="text" name="offer[0][code][0][end]" class="date" value="" />
			                </li>
			                <li>
			                	<span class="add add_offer_code"><a href="#">add</a></span>
			                </li>
			            </ul>
			        </div>
			        <span class="add add_offer"><a href="#">add</a></span>
				</div>
			    <?php
			    }
			    ?>
			</div>
		</div>
	</div> <!-- End PANES -->
	<script>

	// perform JavaScript after the document is scriptable.
	$(function() {
		// setup ul.tabs to work as tabs for each div directly under div.panes
		$("ul.tabs").tabs("div.panes > .the-pane", {
			effect: 'fade',
		
		});
	});
	</script>
</div>


<div class="form-row">
<label>Release Date</label>
<input type="text" name="release_date" class="date" value="<?php if(!empty($item->release_date)) : ?><?php echo date('d-m-Y h:m', $item->release_date); ?><?php endif; ?>">
</div>


<div class="form-row">
<label>Description</label>
<?php echo form_textarea('description', $item->description, 'class="full"'); ?>
</div>

<div class="form-row">
<label>Specification</label>
<?php echo form_textarea('specification', $item->specification, 'class="full"'); ?>
</div>

<div class="form-row">
<label>Photo</label>
<?php echo img($item->photo_thumb_url); ?>
<?php echo form_upload('photo'); ?>
</div>

<div class="form-row">
<label>Stock levels</label>
<?php echo form_hidden('stock_old', $item->stock); ?>
<?php echo form_input('stock', $item->stock); ?>

<?php if($times_sold > 0): ?>
	<br />
	<i>Totally sold <strong><?php echo $times_sold; ?></strong> items in the past.</i>
<?php endif; ?>
</div>
<div class="form-row">
<label>Digital good</label>
<?php echo form_dropdown('digital', array
(
	0	=> 'No',
	1	=> 'Yes'
), $item->digital); ?>
</div>

<div class="form-row">
<label>Language attribute</label>
<?php echo form_dropdown('language', array
(
	0	=> 'No',
	1	=> 'Yes'
), $item->language); ?>
</div>


<?php foreach($meta as $key=>$value) : ?>
<div class="form-row">
<label><?php echo humanize($key); ?></label>
<?php echo form_input('meta['.$key.']', $value); ?>
</div>
<?php endforeach; ?>


<div class="form-row">
<?php echo form_submit('submit', 'Update'); ?>
</div>

</form>

</div>

<script type="text/javascript">
	var first = true;
	var variations = <?php echo count($variations) ? 'true' : 'false'; ?>;
	var price = 0.00;
	var count = 0;
	$(function(){
		$(".additional.single_price_box .add, #additional_prices .add").live('click', function(){
			$(".additional.single_price_box").hide();
			var html  = '';
			var price = 0.00;
			
			if(first && !variations) {
				
				
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
		
		/*$(".additional .delete").live('click', function(){
			$(this).parent().parent().remove();
			return false;
		});*/
        $(".additional .delete").live('click', function(){
	
			offer_id = $(".offer_id").val();
			
			if(offer_id > 0) {
				$("#additional_offers").append('<input name="offer_del[]" value="'+offer_id+'" type="hidden" />');
			}
			
			offer_code_id = $(this).parent().parent().find('.offer_code_id').val();
			
			if(offer_code_id > 0)
			{
				$("#additional_offers").append('<input name="offer_code_del[]" value="'+offer_code_id+'" type="hidden" />');
			}
			
            if($(this).parents("#additional_offers").length>0){
                $(this).parent().parent().remove();
            }else{
                $(this).parent().parent().parent().remove();
            }
			
			return false;
		});
		
		$("#reset_prices").live('click', function(){
			variations = false;
			$(".additional").show();
			$("#additional_prices").html('');
			$(this).parent().parent().find("span").attr('class', 'add');
			first = true;
			return false;
		});
        
        
        
        
        
        
        
        var count_offers =1;
        $(".add_offer").live('click', function(){
            
            curr_offer = parseInt($(this).parent().children().children(".curr_offer").val());
            curr_offer++;
            
            var html_offer  = '';
			
            html_offer    += '<div class="additional">';
    		html_offer    += '	<div class="inner-form-row">';
            html_offer    += '      <input type="hidden" class="curr_offer" value="'+curr_offer+'" />';
    		html_offer    += '		<ul class="in-threes"><li><label>Offer type</label>';
            html_offer    += '        <select name="offer['+ curr_offer +'][type]">';
            html_offer    += '            <option value="percent">% off price</option>';
            html_offer    += '            <option value="fixed">fixed amount off price</option>';
            html_offer    += '            <option value="custom">Custom field</option>';
            html_offer    += '        </select></li>';
            html_offer    += '        <li><span class="custom_type_box">';
            html_offer    += '            <label>Custom type</label><input type="text" name="offer['+ curr_offer +'][custom]" />';
            html_offer    += '        </span></li>';
            html_offer    += '        <li><label>Amount</label><input type="text" name="offer['+ curr_offer +'][amount]" /></li>';
    		html_offer    += '	</ul></div>';
            html_offer    += '  <div class="inner-form-row">';
            html_offer    += '        <label>Description</label>';
            html_offer    += '        <textarea name="offer['+ curr_offer +'][desc]"></textarea>';
            html_offer    += '    </div>';
            html_offer    += '    <div class="inner-form-row">';
            html_offer    += '        <ul class="in-threes">';
            html_offer    += '            <li><input type="hidden" class="curr_offer_code" value="0" />';
            html_offer    += '            <input type="text" name="offer['+ curr_offer +'][code][0][code]" value="" /></li>';
            html_offer    += '            <li><input type="text" name="offer['+ curr_offer +'][code][0][start]" class="date" value="" /></li>';
            html_offer    += '            <li><input type="text" name="offer['+ curr_offer +'][code][0][end]" class="date" value="" /></li>';
            html_offer    += '            <li><span class="add add_offer_code"><a href="#">add</a> Add new code</span></li>';
            html_offer    += '        </ul>';
            html_offer    += '    </div>';
            html_offer    += '    <span class="add add_offer generic_button float-right"><a href="#">add</a> Add new offer</span>';
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

			curr_offer = $(".curr_offer").val();
			
            curr_offer_code = parseInt($(this).parent().parent().find(".curr_offer_code").val());
            curr_offer_code++;
            

            html_code    += '    <ul class="in-threes">';
            html_code    += '        <li><input type="hidden" class="curr_offer_code" value="'+curr_offer_code+'" />';
            html_code    += '        <input type="text" name="offer['+curr_offer+'][code]['+curr_offer_code+'][code]" value="" /></li>';
            html_code    += '        <li><input type="text" name="offer['+curr_offer+'][code]['+curr_offer_code+'][start]" class="date" value="" /></li>';
            html_code    += '        <li><input type="text" name="offer['+curr_offer+'][code]['+curr_offer_code+'][end]" class="date" value="" /></li>';
            html_code    += '        <li><span class="add add_offer_code" style="margin: 0 0 0 9px; width: 200px; padding: 5px 0 0 0;"><a href="#">add</a> Add new code</span></li>';
            html_code    += '    </ul>';

            
            $(this).attr('class', 'delete');
			$(this).parent().parent().parent().append(html_code);
            return false;
        });
        
        if(window.location.hash == '#offers') {
			// Click offers tab
			$("#offers a").trigger('click');
		}
	});
</script>