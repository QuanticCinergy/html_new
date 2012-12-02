<section id="content">

	<?php $this->current_section = FALSE; ?>

<h1 id="page-title"><?= $page->title ?></h1>

<section id="page-intro">
	<?= $page->intro ?>
</section>

<section id="page-content">
	<?= $page->content ?>
	
	
	<?php if($errors): ?>
	    <h2>Uh oh! There seems to have been a few errors:</h2>
	    <ul class="errors">
	    <?php foreach($errors as $error): ?>
	        <li><?=$error;?></li>
	    <?php endforeach; ?>
	    </ul>
	<?php endif; ?>
	
	<?= form_open('contact-us'); ?>
	    

	    <div class="form-row">
	    <label for="name">Name: <span>*</span></label>
	    <?= form_input(array(
	       'name'  => 'name',
	       'id'    => 'name',
	       'value' => (isset($name)) ? $name : ''
	    )); ?>
	    </div>

	    

	    <div class="form-row">  

	    <label for="email">Email: <span>*</span></label>
	    <?= form_input(array(
	       'name'  => 'email',
	       'id'    => 'email',
	       'value' => (isset($email)) ? $email : ''
	    )); ?>

</div>   

	    <div class="form-row">
	    <label for="company">Subject:</label>
	    <?= form_input(array(
	       'name'  => 'company',
	       'id'    => 'company',
	       'value' => (isset($company)) ? $company : ''
	    )); ?>
		</div>
	    

	    <div class="form-row">
	    <label for="message">Message: <span>*</span></label>
    	    <div class="textarea">
		    <?= form_textarea(array(
		       'name'  => 'message',
		       'id'    => 'message',
		       'value' => (isset($message)) ? $message : ''
		    )); ?>
		    </div>
	    </div>
        
        <div class="form-row">
        <input type="hidden" name="submitted" value="submitted" />
        <input class="button float-right" type="submit" value="Submit &raquo;" />
        </div>
	    
	</form>
	
</section>

<?php sidebar('main'); ?>


</section>