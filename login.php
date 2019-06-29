<?php
	session_start();
	$msg = "";
	if(isset($_SESSION['num_login_fail']))
	{
 	 if($_SESSION['num_login_fail'] == 3)
  	{	
    if(time() - $_SESSION['last_login_time'] < 1*60 ) 
      {
         // alert to user wait for 3 minutes afer
          echo 'Bạn đã đăng nhập sai quá 3 lần. Vui lòng đăng nhập lại sau 3 phút !';
          

          return; 
      }
      else
      {
        //after 3 minutes
         $_SESSION['num_login_fail'] = 0;
      }
   }      
}

	// $sucess = doLogin(); // your check login function
	// if($success)
	// {
 //   		$_SESSION['num_login_fail'] = 0;
 //  	 //your code here
	// }
	// else
	// {
	//  $_SESSION['num_login_fail'] ++;
	//  $_SESSION['last_login_time'] = time();
	// }



	if (isset($_POST['submit'])) {
		$con = new mysqli('localhost', 'root', '', 'passwordHashing');

		$email = $con->real_escape_string($_POST['email']);
		$password = $con->real_escape_string($_POST['password']);

		$sql = $con->query("SELECT id, password FROM users WHERE email='$email'");
		if ($sql->num_rows > 0) {
		    $data = $sql->fetch_array();
		    if (password_verify($password, $data['password'])) {
		    	
		        echo "Bạn đã đăng nhập thành công!";
		        $_SESSION['num_login_fail'] = 0;
            } else{
            	
			    	 $temp = 1+$_SESSION['num_login_fail'] ++;
			    	 echo "Bạn đã đăng nhập sai ".$temp." lần";
					 $_SESSION['last_login_time'] = time();
            }
        }
         else{

            	$temp =  1+$_SESSION['num_login_fail'] ++;
            	 echo "Bạn đã đăng nhập sai ".$temp." lần";
				 $_SESSION['last_login_time'] = time();
	
}
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP Password Hashing - Log In</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>
	<div class="container" style="margin-top: 100px;">
		<div class="row justify-content-center">
			<div class="col-md-6 col-md-offset-3" align="center">
				<img src="images/logo.png"><br><br>

				<?php if ($msg != "") echo $msg . "<br><br>"; ?>

				<form method="post" action="login.php">
					<input class="form-control" name="email" type="email" placeholder="Email..."><br>
					<input class="form-control" minlength="5" name="password" type="password" placeholder="Password..."><br>
					<input class="btn btn-primary" name="submit" type="submit" value="Log In"><br>
				</form>

			</div>
		</div>
	</div>
</body>
</html>