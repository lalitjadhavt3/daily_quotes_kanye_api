<?php
	session_start();
	// function to get quotes from the remote API
	function getQuotesFromApi() {
	  $response = file_get_contents('https://api.kanye.rest/');
	  $data = json_decode($response, true);
	  return $data['quote'];
	}
	$data = array(); // for inserting array of quotes to local json api
	$cache = array(); // file pointer 
	// get quotes from cache or remote API
	if(isset($_POST) && isset($_POST['refresh']))
	{
		
		//remove the local file so that after refresh new random quotes will added
		if(file_exists('quotes_cache.json')){
			unlink('quotes_cache.json');
			getNewQuotes();
			header("Location: ".$_SERVER['PHP_SELF']);
		}

	}
	if(@file_get_contents('quotes_cache.json')){
	    $cache = json_decode(file_get_contents('quotes_cache.json'), true);
	} 
	else
	{
		getNewQuotes();
	}
	// function to get new quotes and store in local json api
	function getNewQuotes(){
	  for ($i=0; $i < 5; $i++) { 
	  	$quotes = getQuotesFromApi();
	  	//add quotes and its expiration time such as each quote will have expiry time of 1 minute from the time its added
	  	$data[] = array("quote" => $quotes, "expiration" => time() + 60);
	  }
	  file_put_contents('quotes_cache.json', json_encode($data));
	  $_POST = array();
	 }

if (isset($_SESSION['logged_in'])) {
  echo'<!DOCTYPE html>
		<html lang="en">
		<head>
		  <title>Daily Quotes</title>
		  <meta charset="utf-8">
		  <meta http-equiv="refresh" content="60">
		  <meta name="viewport" content="width=device-width, initial-scale=1">
		  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
		  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>
		  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
		  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
		</head>
		<body>

		<div class="container" style="margin: auto;margin-top: 5%">
		  <h3 class="text-center">Daily Quotes</h3>
		  <ul class="list-group">';
		  	
		  	 foreach ($cache as $key => $value) {
		  			
		  			if (time() > $value['expiration']) {
		  				//if the current time exceeds with any of quote's expiration time then new quotes will get generated
		  				getNewQuotes();
		  				break;
		  			}
		  			else
		  			{
		  				echo '<li class="list-group-item">'.$value['quote'].'</li>';
		  			}
		  		}
		  	
		 echo' </ul>
		  		<form method="post" >
	          		<input type="submit" name="refresh"
	                  class="btn btn-success" value="Refresh" />
		      		</form><br/>
		  		<a type="button" class="btn btn-danger" href="logout.php">Logout</a>
		</div>

		</body>
		</html>';
}
else{
	header('location:login.php');
}
