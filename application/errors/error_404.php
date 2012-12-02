<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!-- Consider adding an manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">

  <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/b/378 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title><?php echo $heading; ?> - Tiny Rocketship</title>
  <meta name="description" content="Tiny Rocketship is a small but powerful digital creative & development studio. We deliver high quality websites and web applications. We pride ourselves on our attention to detail and ability to perform under pressure to tight deadlines.">
  <meta name="author" content="Tiny Rocketship">

  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

  <!-- CSS: implied media=all -->
  <!-- CSS concatenated and minified via ant build script-->
  <?php echo css('style'); ?>
  <?php if(isset($js)) : foreach($js as $name) : echo js($name); endforeach; endif; ?>
  <?php if(isset($css)) : foreach($css as $name) : echo css($name); endforeach; endif; ?>
  <!-- end CSS-->

  <link rel="icon" type="image/png" href="/themes/tinyrocketship/assets/img/ico/favicon.png" />	
	
	
  <!-- All JavaScript at the bottom, except for Modernizr / Respond.
       Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
       For optimal performance, use a custom Modernizr build: www.modernizr.com/download/ -->
  <script src="/themes/tinyrocketship/assets/js/modernizr.js" type="text/javascript"></script>
</head>

<body id="oops">

  <div id="container">
    <header id="fixed-head">
		<section>
			<div class="inner">
				<div id="logo"><a href="/" alt="Tiny Rocketship: Web design, development, social media and search engine optimisation"><img src="/themes/tinyrocketship/assets/img/logos/tiny.png" /></a></div>
				<p class="strapline">Small but <strong>powerful</strong> web design studio.</p>
				
				<p class="contact-info"><a href="/contact-us" title="Go to contact us">Contact us</a> or call on <strong class="phone-number">020 8133 7566</strong></p>
			</div>
		</section>
    </header>
    <div id="main" role="main">    	
    	
		<h1 id="page-title">Oops! <?php echo $heading; ?></h1>
		<?php echo $message; ?>
		
		
    </div>
    
     <section id="primary-nav">
			<nav>
				<ul>
					<li class="lead"><a href="/about" title="Go to about Tiny Rocketship">About</a>
						<ul class="dropdown">
							<li><a href="/about/staff" title="Go to the senior staff">Senior Staff</a></li>
							<li><a href="/about/vacancies" title="Go to the current vacancies">Current Vacancies</a></li>
						</ul>
					</li>
					<li class="lead"><a href="/web-design" title="Go to Web Design at Tiny Rocketship">Web Design</a>
						<ul class="dropdown">
							<li><a href="/web-design/e-commerce" title="Go to e-commerce">E-Commerce</a></li>
							<li><a href="/web-design/editorial" title="Go to editorial">Editorial Websites</a></li>
							<li><a href="/web-design/team-management" title="Go to sports & team management">Sports / Team Management</a></li>
							<li><a href="/web-design/microsites-campaigns" title="Go to micro sites and campaigns">Microsites & Campaigns</a></li>
							<li><a href="/web-design/brochure" title="Go to the brochure">Brochure Websites</a></li>
						</ul>
					</li>
					<li class="lead"><a href="/social-media" title="Go to Social Media at Tiny Rocketship">Social</a>
						<ul class="dropdown">
							<li><a href="/social-media" title="Go to Social Media Integration">Social Media Integration</a></li>
							<li><a href="/social-media/consultancy" title="Go to Social Consultancy">Social Consultancy</a></li>
							<li><a href="/social-media/blogs" title="Go to Blog Management">Blog Creation & Management</a></li>
							
						</ul>	
					</li>
					<li class="lead"><a href="/seo" title="Go to Search Engine Optimisation at Tiny Rocketship">Search</a>
						<ul class="dropdown">
							<li><a href="/seo" title="Go to Search Engine Optimisation">Search Engine Optimisation</a></li>
							<li><a href="/seo/consultancy" title="Go to Search Consultancy">Search Consultancy</a></li>
							<li><a href="/seo/copywriting" title="Go to SEO Copywriting">SEO Copywriting</a></li>
							
						</ul>
					</li>
					<li class="lead"><a href="/film-making" title="Go to Film Making at Tiny Rocketship">Film Making</a>
						<ul class="dropdown">
							<li><a href="/film-making/corporate-videos" title="Go to #">Corporate Videos</a></li>
							<li><a href="/film-making/advertising" title="Go to ">Advertising</a></li>
							<li><a href="/film-making/feature-films" title="Go to #">Feature Films</a></li>
						</ul>
					</li>
					<li class="lead no-dropdown"><a href="/our-clients" title="Go to Clients at Tiny Rocketship">Clients</a></li>
				</ul>
			</nav>
	</section>

    
    <footer>
    	<ul id="social">
    		<li><a href="http://www.twitter.com/TinyRocketship" title="Follow us on Twitter">Follow</a></li>
    		<li><a href="http://www.facebook.com/pages/Tiny-Rocketship/158226037534434" title="Like us on Facebook">Like</a></li>
    		<li><a href="http://www.linkedin.com/company/tiny-rocketship?trk=fc_badge" title="Connect with us on Linked In">Connect</a></li>
    	</ul>
		<nav>
			<ul id="footer-nav">
				<li><a href="/terms" title="Go to Terms and Conditions">Terms and Conditions</a></li>
				<li><a href="/privacy" title="Go to Privacy Policy">Privacy Policy</a></li>
				<li><a href="/acceptable-policy" title="Go to Acceptable use policy">Acceptable use policy</a></li>
				<li><a href="/accessibility" title="Go to Accessibility">Accessibility</a></li>
				<li><a href="/contact-us" title="Go to Contact us">Contact us</a></li>
			</ul>
		</nav>
		<p>&copy; 2009-2011. All rights reserved.</p>
		<p class="our-cms">This website was built and populated in less than 16 hours using our own hand made CMS <a href="http://www.rocketfuelcms.com" title="Get RocketFuel CMS">RocketFuel</a></p>
    </footer>
  </div> <!--! end of #container -->


  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>
  <script src="http://use.typekit.com/ftv6kpv.js"></script>
  <script>try{Typekit.load();}catch(e){}</script>
  
  <script src="/themes/tinyrocketship/assets/plugins/jquery-validation-1.8.1/jquery.validate.min.js" type="text/javascript"></script>
  <script src="/themes/tinyrocketship/assets/js/jquery.cycle.all.js" type="text/javascript"></script>
  <script src="/themes/tinyrocketship/assets/js/jquery.jcarousel.min.js" type="text/javascript"></script>
  <script src="/themes/tinyrocketship/assets/js/nicEdit.js" type="text/javascript"></script>

  <script type="text/javascript">
    //<![CDATA[
	  bkLib.onDomLoaded(function() { nicEditors.allTextAreas({buttonList : ['bold','italic','underline','strikeThrough','image','upload','link','unlink']} ) });		
	//]]>
  </script>


  <!-- Change UA-XXXXX-X to be your site's ID -->
  <script>
    window._gaq = [['_setAccount','UA-21749947-1'],['_trackPageview'],['_trackPageLoadTime']];
    Modernizr.load({
      load: ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js'
    });
  </script>


  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  
</body>
</html>
