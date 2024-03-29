<section id="tweet">
    		<div id="the-tweet">
	 
	    		
				
				
				<?php

					function display_latest_tweets(
						$twitter_user_id,
						$cache_file = './twitter.txt',
						$tweets_to_display = 1,
						$ignore_replies = false,
						$twitter_wrap_open = '',
						$twitter_wrap_close = '',
						$tweet_wrap_open = '<p class="grad-bg"><a class="twitter" href="http://www.twitter.com/quanticgaming">QuanticGaming:</a>',
						$meta_wrap_open = '<span class="meta"> ',
						$meta_wrap_close = '</span></p>',
						$tweet_wrap_close = '</li>',
						$date_format = 'g:i A M jS',
						$twitter_style_dates = false){
					 
						// Seconds to cache feed (1 hour).
						$cachetime = 60*60;
						// Time that the cache was last filled.
						$cache_file_created = ((@file_exists($cache_file))) ? @filemtime($cache_file) : 0;
					 
						// A flag so we know if the feed was successfully parsed.
						$tweet_found = false;
					 
						// Show file from cache if still valid.
						if (time() - $cachetime < $cache_file_created) {
					 
							$tweet_found = true;
							// Display tweets from the cache.
							@readfile($cache_file);	
					 
						} else {
					 
							// Cache file not found, or old. Fetch the RSS feed from Twitter.
							$rss = @file_get_contents('http://twitter.com/statuses/user_timeline/'.$twitter_user_id.'.rss');
					 
							if($rss) {
					 
								// Parse the RSS feed to an XML object.
								$xml = @simplexml_load_string($rss);
					 
								if($xml !== false) {
					 
									// Error check: Make sure there is at least one item.
									if (count($xml->channel->item)) {
					 
										$tweet_count = 0;
					 
										// Start output buffering.
										ob_start();
					 
										// Open the twitter wrapping element.
										$twitter_html = $twitter_wrap_open;
					 
										// Iterate over tweets.
										foreach($xml->channel->item as $tweet) {
					 
											// Twitter feeds begin with the username, "e.g. User name: Blah"
											// so we need to strip that from the front of our tweet.
											$tweet_desc = substr($tweet->description,strpos($tweet->description,":")+2);
											$tweet_desc = htmlspecialchars($tweet_desc);
											$tweet_first_char = substr($tweet_desc,0,1);
					 
											// If we are not gnoring replies, or tweet is not a reply, process it.
											if ($tweet_first_char!='@' || $ignore_replies==false){
					 
												$tweet_found = true;
												$tweet_count++;
					 
												// Add hyperlink html tags to any urls, twitter ids or hashtags in the tweet.
												$tweet_desc = preg_replace('/(https?:\/\/[^\s"<>]+)/','<a href="$1">$1</a>',$tweet_desc);
												$tweet_desc = preg_replace('/(^|[\n\s])@([^\s"\t\n\r<:]*)/is', '$1<a href="http://twitter.com/$2">@$2</a>', $tweet_desc);
												$tweet_desc = preg_replace('/(^|[\n\s])#([^\s"\t\n\r<:]*)/is', '$1<a href="http://twitter.com/search?q=%23$2">#$2</a>', $tweet_desc);
					 
					 							// Convert Tweet display time to a UNIX timestamp. Twitter timestamps are in UTC/GMT time.
												$tweet_time = strtotime($tweet->pubDate);	
					 							if ($twitter_style_dates){
													// Current UNIX timestamp.
													$current_time = time();
													$time_diff = abs($current_time - $tweet_time);
													switch ($time_diff) 
													{
														case ($time_diff < 60):
															$display_time = $time_diff.' seconds ago';                  
															break;      
														case ($time_diff >= 60 && $time_diff < 3600):
															$min = floor($time_diff/60);
															$display_time = $min.' minutes ago';                  
															break;      
														case ($time_diff >= 3600 && $time_diff < 86400):
															$hour = floor($time_diff/3600);
															$display_time = 'about '.$hour.' hour';
															if ($hour > 1){ $display_time .= 's'; }
															$display_time .= ' ago';
															break;          
														default:
															$display_time = date($date_format,$tweet_time);
															break;
													}
					 							} else {
					 								$display_time = date($date_format,$tweet_time);
					 							}
					 
												// Render the tweet.
												$twitter_html .= $tweet_wrap_open.$tweet_desc.$meta_wrap_open.'<a href="http://twitter.com/'.$twitter_user_id.'">'.$display_time.'</a>'.$meta_wrap_close.$tweet_wrap_close;
					 
											}
					 
											// If we have processed enough tweets, stop.
											if ($tweet_count >= $tweets_to_display){
												break;
											}
					 
										}
					 
										// Close the twitter wrapping element.
										$twitter_html .= $twitter_wrap_close;
										echo $twitter_html;
					 
										// Generate a new cache file.
										$file = @fopen($cache_file, 'w');
					 
										// Save the contents of output buffer to the file, and flush the buffer. 
										@fwrite($file, ob_get_contents()); 
										@fclose($file); 
										ob_end_flush();
					 
									}
								}
							}
						} 
						// In case the RSS feed did not parse or load correctly, show a link to the Twitter account.
						if (!$tweet_found){
							echo $twitter_wrap_open.$tweet_wrap_open.'Oops, our twitter feed is unavailable right now. '.$meta_wrap_open.'<a href="http://twitter.com/'.$twitter_user_id.'">Follow us on Twitter</a>'.$meta_wrap_close.$tweet_wrap_close.$twitter_wrap_close;
						}
					}
					 
					display_latest_tweets('quanticgaming');
					 
					?>

				
				
			</div>
    	</section>