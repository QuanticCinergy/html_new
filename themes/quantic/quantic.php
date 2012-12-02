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

  <title><?php echo $title; ?></title>
  
	<script type="text/javascript" src="http://use.typekit.com/qkn7rbg.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
	
  	<meta name="description" content="Quantic Gaming">
  	<meta name="author" content="Tiny Rocketship, Bath, UK">

  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

  <!-- CSS: implied media=all -->
  <!-- CSS concatenated and minified via ant build script-->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700' rel='stylesheet' type='text/css'>
  <?php echo css('style'); ?>
  <?php if(isset($js)) : foreach($js as $name) : echo js($name); endforeach; endif; ?>
  <?php if(isset($css)) : foreach($css as $name) : echo css($name); endforeach; endif; ?>
  <!-- end CSS-->

  <link rel="icon" type="image/png" href="/themes/quantic/assets/img/ico/favicon.png" />	
	
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script src="http://cdn.jquerytools.org/1.2.5/all/jquery.tools.min.js"></script>
  <script src="/themes/quantic/assets/js/jquery.jcarousel.min.js" type="text/javascript"></script>
  <script src="/themes/quantic/assets/js/jquery.cycle.all.js" type="text/javascript"></script>
  <script src="/themes/quantic/assets/plugins/jquery-validation-1.8.1/jquery.validate.min.js" type="text/javascript"></script>
		

  <!-- All JavaScript at the bottom, except for Modernizr / Respond.
       Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
       For optimal performance, use a custom Modernizr build: www.modernizr.com/download/ -->
  <script src="/themes/quantic/assets/js/modernizr.js" type="text/javascript"></script>
  
  <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-24448390-5']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

	</script>
  
</head>

<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
  <div id="container">
    <header id="fixed-head">
		<section>
			<div class="inner">
				<div id="logo"><a href="/" alt="Quantic Gaming"><img src="/themes/quantic/assets/img/logos/logo.png" /></a></div>
			</div>
		</section>
		<?php widget('userbox');?>
		 <section id="primary-nav">
			<nav>
				<ul>
					<li class="lead <?php if($this->uri->segment(1) == ''): echo 'active'; endif; ?>"><a href="/" title="Go to the Quantic Homepage">Home</a></li>
					<li class="lead <?php if($this->uri->segment(2) == 'news'): echo 'active'; endif; ?>"><a href="/articles/news">News</a></li>
					<li class="lead <?php if($this->uri->segment(1) == 'team'): echo 'active'; endif; ?>"><a href="/team">Team</a></li>	
					<li class="lead <?php if($this->uri->segment(1) == 'teams'): echo 'active'; endif; ?>"><a href="/teams">Teams (old)</a></li>							
					<li class="lead <?php if($this->uri->segment(1) == 'videos'): echo 'active'; endif; ?>"><a href="/videos" title="Go to videos Quantic Gaming">Videos</a></li>
					<li class="lead <?php if($this->uri->segment(1) == 'galleries'): echo 'active'; endif; ?>"><a href="/galleries" title="Go to gallery Quantic Gaming">Galleries</a></li>
					<li class="lead <?php if($this->uri->segment(1) == 'forums'): echo 'active'; endif; ?>"><a href="/forums" title="Go to forums Quantic Gaming">Forums</a></li>
					<li class="lead <?php if($this->uri->segment(1) == 'streams'): echo 'active'; endif; ?>"><a href="/streams" title="Go to streams Quantic Gaming">Streams</a></li>
					<li class="lead <?php if($this->uri->segment(1) == 'shop'): echo 'active'; endif; ?>"><a href="/shop" title="Go to store Quantic Gaming">Shop</a></li>
					<li class="lead <?php if($this->uri->segment(1) == 'about'): echo 'active'; endif; ?>"><a href="/about" title="About Us">About</a></li>
					<li class="lead <?php if($this->uri->segment(1) == 'contact'): echo 'active'; endif; ?>"><a href="/contact" title="Go to contact Quantic Gaming">Contact</a></li>
					<li class="lead"><a href="/jobs" title="Jobs">Jobs</a></li>
					<li class="lead"><a href="http://quantic.spreadshirt.com" title="Go to the Quantic Gaming Shop">Shop (old)</a></li>
				</ul>
			</nav>
			</section>
	</section>
    </header>
    
   
    
    <div id="main" role="main"> 
		<!--<?php widget('userbox'); ?>-->
		
    	{yield}
    	
    	<footer class="grad-bg">
	    	
			<nav>
				<ul id="footer-nav">
					<li><a href="/terms" title="Go to Terms and Conditions">Terms and Conditions</a></li>
					<li><a href="/privacy" title="Go to Privacy Policy">Privacy Policy</a></li>
					<li><a href="/contact" title="Go to Contact us">Contact us</a></li>
				</ul>
			</nav>
			<p class="copyright">&copy; 2009-2012. All rights reserved.</p>
    	</footer>
    </div>
    
    
    
   
  </div> <!--! end of #container -->
  <div id="credit">
  	<p class="our-cms">Site by <a href="http://gavinweeks.com">Gavin Weeks</a> using <a href="http://rocketeercms.com">Rocketeer CMS</a></p>
  </div>


  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>
  
  <script src="/themes/quantic/assets/plugins/jquery-validation-1.8.1/jquery.validate.min.js" type="text/javascript"></script>
	
	<!-- Start of Woopra Code -->
<script type="text/javascript">
function woopraReady(tracker) {
    tracker.setDomain('quanticgaming.com');
    tracker.setIdleTimeout(300000);
    tracker.track();
    return false;
}
(function() {
    var wsc = document.createElement('script');
    wsc.src = document.location.protocol+'//static.woopra.com/js/woopra.js';
    wsc.type = 'text/javascript';
    wsc.async = true;
    var ssc = document.getElementsByTagName('script')[0];
    ssc.parentNode.insertBefore(wsc, ssc);
})();
</script>
<!-- End of Woopra Code -->



  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  
</body>
</html>
