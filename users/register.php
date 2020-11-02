<?php 
	include("config.php");
	$error = array();
	$r=false;
	if(isset($_POST['submit'])) {
		$username = isset($_POST['username']) ? $_POST['username']:'';
		$password = isset($_POST['password']) ? $_POST['password']:'';
		$repassword = isset($_POST['repassword']) ? $_POST['repassword']:'';
		$email = isset($_POST['email']) ? $_POST['email']:'';
		$role = "user";

		if (!preg_match ("/^[a-zA-z]*$/", $username) ) { 
			$error[] = array('msg'=>"username is not valid.");  
		} 
		
		$pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
		if (!preg_match ($pattern, $email) ) {  
			$error[] = array('msg'=>"Email is not valid.");  
		}  
	 
		
		if ($password != $repassword) {
			$error[] = array('input' =>'password' ,'msg'=> 'Password does not match');
		}

		if(sizeof($error) == 0) {
			$pass = md5($password);
			$sqlselect = "SELECT * FROM users ";
			$result = $conn->query($sqlselect);
			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()) {
					if(($row['username'] == $_POST['username']) || $row['email'] == $_POST['email']) {
							$r=true;
					}
				}
			}
			if($r == false){
				$sql = "INSERT INTO users(`username`, `password`, `email` , `role`) VALUES ('".$username."', '".$pass."', '".$email."' ,'".$role."')";
				if ($conn->query($sql) === true) {
					echo "<div id='success'><script type='text/javascript'>alert('Register successfully')</script></div>";
				} else {
					$error[] = array('input' => 'form' , 'msg' => $conn->error);
				}
			}else {
				$error[] = array('input' => 'form' , 'msg' => 'Duplicate username or email does not exist');
			}

			$conn->close();
		}
	}
?>
<html>
<head>
	<title>
		Register
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
	<h2 id="heading">Register</h2>
		<div id="signup-form">
			<form action="" method="POST">
				<p><label for="username">Username: <input type="text" name="username" required></label></p></br>
				<p><label for="password">Password: <input type="password" name="password" required></label></p></br>
				<p><label for="repassword">Re-Password: <input type="password" name="repassword" required></label></p></br>
				<p><label for="email">Email: <input type="email" name="email" required></label></p></br>
				<p>
					<input type="submit" name="submit" value="Submit">
				</p>
			</form>
			<span class="btn">Already have an account?<a  href="login.php">Login here</a></span>
		</div>
	</div>
  
</body>
</html>