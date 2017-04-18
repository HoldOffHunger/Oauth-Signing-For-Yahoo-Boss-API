<?php
	
		// Class: Yahoo
		// Function: Sign an Oauth Request Designed for Yahoo BOSS API
		
		// Yahoo BOSS: https://developer.yahoo.com/boss/
		// OAUTH Signing Implemented: https://oauth1.wp-api.org/docs/basics/Signing.html
		
			// NOTE: YAHOO BOSS is deprecated!  You will not be able to query yahoo's services.
			// This is presented as a demo of how to SIGN an Oauth Request.
			
			// This is offered under the BSD 2-clause license.
	
	class Yahoo
	{
		public function __construct($args)
		{
				# Actual lengths here are comparable
			$this->client_id = 'INSERT-CLIENT-ID-HERE....................................................................';
			$this->client_secret = 'INSERT-CLIENT-SECRET-HERE.........';
		}
		
		public function getImageSearchUrl($args)
		{
			$oauth_version = '1.0';
			$oauth_timestamp = time();
			$oauth_nonce = hash('sha256', $oauth_timestamp);
			$oauth_consumer_key = $this->client_id;
			$oauth_signature_method = 'HMAC-SHA1';
			$oauth_method = 'GET';
			
			$search_term = $args['searchterm'];
			
			$parameter_string = '';
			$parameter_string .= 'oauth_consumer_key=' . urlencode($oauth_consumer_key);
			$parameter_string .= '&oauth_nonce=' . urlencode($oauth_nonce);
			$parameter_string .= '&oauth_signature_method=' . urlencode($oauth_signature_method);
			$parameter_string .= '&oauth_timestamp=' . urlencode($oauth_timestamp);
			$parameter_string .= '&oauth_version=' . urlencode($oauth_version);
			$parameter_string .= '&q=' . urlencode($search_term);
			
			$yahoo_image_search_url = 'https://yboss.yahooapis.com/ysearch/images';		# ending '/' unnecessary
			
			$payload = $oauth_method . '&' . urlencode($yahoo_image_search_url) . '&' . urlencode($parameter_string);
			$signature_key = $this->client_secret . '&';		# client secret + '&' + value of 'token' parameter
			$oauth_signature = base64_encode(hash_hmac('sha1', $payload, $signature_key, TRUE));
			
			$full_url = $yahoo_image_search_url . '?' . $parameter_string;
			$queryable_full_url = $full_url . '&oauth_signature=' . urlencode($oauth_signature);	
			
			return $queryable_full_url;
		}
	}
	
	$yahoo = new Yahoo();
	$url = $yahoo->getImageSearchURL({'searchterm'=>'nature'});
	
		# GET URL for Retrieving JSON
	print('URL? ' . $url . '<BR><BR>');
	
		# The Retrieved JSON Itself
	print('Raw JSON? ' . file_get_contents($url));

?>
