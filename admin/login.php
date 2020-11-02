<?php
	include("config.php");
	$error=array();
	if(isset($_POST['submit'])) {
		$username = isset($_POST['username']) ? $_POST['username']:'';
        $password = isset($_POST['password']) ? $_POST['password']:'';
        $pass = md5($password);
        
        if (preg_match ("/^[a-zA-z]*$/", $username) ) { 
			$username = $_POST['username'];
			$email ='';
		} 
		else { 
			$username = '';
			$email = $_POST['username'];
			$pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
			if (!preg_match ($pattern, $email) ) {  
                $error[] = array('msg'=>"username or Email is not valid.");  
			}  
		}  

		if(sizeof($error) == 0) {
			$sql = "SELECT * FROM users WHERE (`username`='$username' OR `email` = '$email') AND `password`='$pass'";
			$result = $conn->query($sql);

			if($result->num_rows > 0) {
				while($row = $result->fetch_assoc()){
					$_SESSION['admin'] =array('username'=>$row['username'],'role'=>"admin" ,'email' => $email, 'id'=> $row['id']);
					header('location:dashboard.php');
				}
			}
			else
			{
				$error[]=array('input'=>'form','msg'=>'Invalid login details');
			}
			$conn->close(); 
		}
	}
?>
<html>
<head>
	<title>
		Login
	</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php if (sizeof($error)>0) : ?>
		<?php foreach($error as $err) : ?>
			<div  id = 'error'><?php echo '<script type="text/javascript">alert("'.$err['msg'].'")</script>' ; ?></div>
		<?php endforeach; ?>
	<?php endif; ?>

	<div id="wrapper">
		<div id="login-form">
			<h2>Login</h2></br>
			<form action="" method="post">
				<p>
					<label for="username">Username or Email: <input type="text" name="username" required></label>
				</p></br>
				<p>
					<label for="password">Password: <input type="password" name="password" required></label>
				</p></br>
				<p>
					<input type="submit" name="submit" value="submit">
				</p></br>
			</form>
			<span class="btn">Don't have an account?<a  href="signup.php">Sign up</a></span>
		</div>
	</div>
</body>
</html>