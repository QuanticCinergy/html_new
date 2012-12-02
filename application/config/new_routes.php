<?php

$route = array(
	'home' => array('/', 'home/index'),
	
	// Friends
	'friends' => array('profile/friends/:username', 'friends/index/username/$1', 'profile/friends'),
	'notifications' => array('profile/notifications', 'friends/pending'),
	'accept_friend' => array('friends/accept/:id', 'friends/accept/id/$1'),
	'deny_friend' => array('friends/deny/:id', 'friends/deny/id/$1'),
	'delete_friend' => array('friends/delete/:id', 'friends/delete/id/$1'),
	'add_friend' => array('friends/add/:id', 'friends/add/id/$1'),
	
	// Profiles
	'profile' => array('profile/:username', 'users/show/username/$1', 'profile'),
	'edit_profile' => array('profile/edit', 'users/edit'),
	'update_profile' => array('profile/update', 'users/update'),
	
	// Posts - Blog Management
    'manage_posts' => array('profile/posts', 'posts/manage/page/$1'),
    'add_post' => array('profile/posts/add', 'posts/add'),
    'create_post' => array('profile/posts/create', 'posts/create'),
    'edit_post' => array('profile/posts/:id/edit', 'posts/edit/id/$1'),
    'userpost_update' => array('userpost/:id/update', 'posts/update/id/$1'),
    'remove_post' => array('profile/posts/:id/remove', 'posts/remove/id/$1'),
	
	// Hubs
	'hubs' => array('hubs/:title', 'hubs/show/title/$1'),
	
	// Games 
	'recent_games'       => array('games/recent', 'games/recent'),
	'recent_games_page'  => array('games/recent/page/:page', 'games/recent/page/$1'),
	'coming_games'       => array('games/coming_soon', 'games/coming_soon'),
	'coming_games_page'  => array('games/coming_soon/page/:page', 'games/coming_soon/page/$1'),
	'genre'              => array('games/genre/:genre', 'games/genre/$1'),
	'genres'             => array('games/genre', 'games/genre'),
	
	'games_auto' => array('games/autocomplete', 'games/autocomplete'),
	'games_auto_query' => array('games/autocomplete/:query', 'games/autocomplete/$1'),
	'games' => array('games/:genre/page/:page', 'games/index/genre/$1/page/$2'),
	'game' => array('games/:genre/:title', 'games/show/genre/$1/title/$2'),
	'game_videos' => array('games/:title/videos', 'games/videos/title/$1/videos'),
	
	// PMs
	'messages' => array('profile/messages', 'private_messages/index'),
	'message' => array('profile/messages/show/:id', 'private_messages/show/id/$1'),
	'incoming_messages' => array('profile/messages/incoming', 'private_messages/incoming'),
	'outgoing_messages' => array('profile/messages/outgoing', 'private_messages/outgoing'),
	'new_message' => array('profile/messages/new/:additional', 'private_messages/compose/$1', 'profile/messages/newe'),
	'create_message' => array('profile/messages/create', 'private_messages/create'),
	
	// Articles
	'articles' => array('articles/:section/:category/page/:page', 'articles/index/section/$1/category/$2/page/$3'),
	'articles_in_section' => array('articles/:section/page/:page', 'articles/index/section/$1/page/$2'),
	'article' => array('articles/:section/:category/:id/:title/page/:page', 'articles/show/section/$1/category/$2/id/$3/title/$4/page/$5'),
	'articles_feed' => array('articles/feed/:section', 'articles/feed/section/$1'),
	
	// User Posts
	'posts' => array('posts/:category/page/:page', 'posts/index/category/$1/page/$2'),
	'post' => array('posts/:category/:id/:title/page/:page', 'posts/show/category/$1/id/$2/title/$3/page/$4'),
	
	// Comments
	'create_comment' => array('comments/create', 'comments/create'),
	'edit_comment' => array('comments/:comment_id/edit', 'comments/edit/comment_id/$1'),
	'update_comment' => array('comments/:comment_id/update', 'comments/update/comment_id/$1'),
	
	// Streams
	'streams' => array('streams/:section/:category/page/:page', 'streams/index/section/$1/category/$2/page/$3'),
	'streams_in_section' => array('streams/:section/page/:page', 'streams/index/section/$1/page/$2'),
	'stream' => array('streams/:section/:category/:id/:title/page/:page', 'streams/show/section/$1/category/$2/id/$3/title/$4/page/$5'),
	'streams_feed' => array('streams/feed/:section', 'streams/feed/section/$1'),
	
	// Shop
	'shop' => array('shop/:category/page/:page', 'shop/index/category/$1/page/$2'),
	'checkout' => array('shop/checkout', 'shop/checkout'),
	'shop_pay' => array('shop/init_pay', 'shop/init_pay'),
	//'cart_add' => array('shop/cart_add/:item_id/:quantity', 'shop/cart_add/item_id/$1/quantity/$2'),
	'cart_add' => array('shop/cart_add/:item_id/:quantity/:offer_code', 'shop/cart_add/item_id/$1/quantity/$2/offer_code/:$3'),        
	'cart_remove' => array('shop/cart_remove/:item_id', 'shop/cart_remove/item_id/$1'),
	'cart_process' => array('shop/cart_process', 'shop/cart_process'),
	'offer_check' => array('shop/:brand/:category/:id/:name/offer_check/:code', 'shop/offer_check/$5'),
	'shop_item' => array('shop/:brand/:category/:id/:name', 'shop/show/brand/$1/category/$2/id/$3/name/$4'),
	'shop_notify' => array('shop/notify/:item_id', 'shop/notify/item_id/$1'),
	
	// Orders
	'my_orders'	=> array('my_orders', 'orders/my_orders'),
	'cancel_order' => array('my_orders/cancel/:order_id', 'orders/cancel_order/order_id/$1'),
	
	// Videos
	'videos' => array('videos/:category/page/:page', 'videos/index/category/$1/page/$2'),
	'video' => array('videos/:category/:id/:title', 'videos/show/id/$2/title/$3'),
	
	// Galleries
	'galleries' => array('galleries/page/:page', 'galleries/index/page/$1'),
	'gallery' => array('galleries/:id/:title', 'galleries/show/id/$1/title/$2'),
	
	// Forums
	'forums' => array('forums', 'forums/index'),
	'forum_threads' => array('forums/:name/page/:page', 'forums/show_threads/name/$1/page/$2'),
	'new_forum_thread' => array('forums/:name/new', 'forums/new_thread/name/$1'),
	'create_forum_thread' => array('forums/:name/create', 'forums/create_thread/name/$1'),
	'forum_thread' => array('forums/:name/:id/:title/page/:page', 'forums/show_thread/name/$1/title/$3/id/$2/page/$4'),
	'edit_forum_thread' => array('forums/:name/:id/:title/edit', 'forums/edit_thread/name/$1/title/$3/id/$2'),
	'update_forum_thread' => array('forums/:name/:id/:title/update', 'forums/update_thread/name/$1/title/$3/id/$2'),
	'new_forum_post' => array('forums/:name/:id/:title/new', 'forums/new_post/name/$1/title/$3/id/$2'),
	'create_forum_post' => array('forums/:name/:id/:title/create', 'forums/create_post/name/$1/title/$3/id/$2'),
	'edit_forum_post' => array('forums/:name/:id/:title/:post_id/edit', 'forums/edit_post/name/$1/title/$2/id/$3/post_id/$4'),
	'update_forum_post' => array('forums/:name/:id/:title/:post_id/update', 'forums/update_post/name/$1/title/$2/id/$3/post_id/$4'),
		
	// Files
	'files' => array('files/:category/page/:page', 'files/index/category/$1/page/$2'),
	'download_file' => array('files/download/:id', 'files/download/id/$1'),
	'file' => array('files/:category/:id', 'files/show/id/$2'),
	
	// Matches
	'matches' => array('matches/page/:page', 'matches/index/page/$1'),
	'match' => array('matches/:id', 'matches/show/id/$1'),
	
	// Payments
	'payments_ipn' => array('payments/ipn/:method', 'orders/ipn/method/$1'),
	'success_payment' => array('payments/success', 'orders/success'),
	'cancel_payment' => array('payments/cancel', 'orders/cancel'),
	
	// Team
	'team' => array('team', 'team/show'),
	
	// Admin
	'admin' => array('admin', 'admin/home/index'),
	'admin_any' => array('admin/:any', 'admin/$1'),
	
	// Auth
	'auth' => array('auth', 'auth/index'),
	'auth_login' => array('auth/sign_in', 'auth/sign_in'),
	'auth_signup' => array('auth/sign_up', 'auth/sign_up'),
	'auth_logout' => array('logout', 'auth/logout'),
	'auth_forgotten' => array('forgotten', 'auth/forgot_password'),
	'register' => array('register', 'auth/sign_up'),
	'login' => array('login', 'auth/sign_in'),
	'activation' => array('activation', 'auth/activation'),
	'auth_any' => array('auth/:any', 'auth/$1'),
	'dynamic' => array('dynamic/:resource/:id', 'dynamic/go/resource/$1/id/$2'),
	
	// Pages
	'page' => array(':page', 'pages/show/title/$1'),
	'sub_page' => array(':page/:sub_page', 'pages/show/title/$2'),
	
	// 'admin_login' => array('admin/login' => 'admin/auth/login_in'),  
	'admin_login' => array('admin/login', 'admin/auth/sign_in') 
    
);


