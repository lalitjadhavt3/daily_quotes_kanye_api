<?php
	@session_start();
	if (isset($_POST['password'])) {
		if($_POST['password']==='secret'){
			$_SESSION['logged_in']=true;
			header('location:index.php');
		}
		else{echo '<script type="text/javascript">
    		alert("wrong password");
    		window.location.href="logout.php";
    	</script>';
		}
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Daily Quotes</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container" >
  <form method="post" >
		Password: <input type="password" name="password" placeholder="password is secret">
		<input type="submit" name="submit">
  </form>
  		
</div>

</body>
</html>