<?php  

function twitter_feed($username, $fallback ,$active=true ){ 

$feed = "http://search.twitter.com/search.atom?q=from:" . $username . "&rpp=1";  

function parse_feed($feed) {  
$stepOne = explode("<content type=\"html\">", $feed);
	if(isset($stepOne[1])){
		$stepTwo = explode("</content>", $stepOne[1]);  
		$tweet = $stepTwo[0];  
		$tweet = html_entity_decode($stepTwo[0]);  
 
	return $tweet; 
	}
}  

if($active){
$twitterFeed = @file_get_contents($feed); 
$data[1] = parse_feed($twitterFeed); 
}else{
$twitterFeed = '';
$data[1] ='';
}

$data[0] ='<a href="http://twitter.com/'.$username.'" title="" id="tweet_follow">Follow me in twitter</a>';
if ($data[1] =='') $data[1] = $fallback;
return $data;
}