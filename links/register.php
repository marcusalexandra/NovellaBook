<?php
include '../conn.php';
error_reporting(0);
session_start();


if(isset($_POST['submit'])) {

  $fname = $_POST["fname"];
  $lname = $_POST["lname"];
  $address = $_POST["address"];
  $number = $_POST["number"];
  $email = $_POST["email"];
  $pass = md5($_POST["pass"]);
  $cpassword = md5($_POST["cpassword"]);
  if($pass == $cpassword) {
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($connect, $sql);
    if(!$result -> num_rows > 0) {
      $sql = "SELECT * FROM users WHERE phone = '$number'";
      $result = mysqli_query($connect, $sql);
      if(!$result -> num_rows > 0) {
        $sql = "INSERT INTO users (email, user_password, firstname, lastname, phone, address)
            VALUES ('$email', '$pass', '$fname', '$lname', '$number', '$address')";
        $result = mysqli_query($connect, $sql);
        $fname = "";
        $lname = "";
        $address = "";
        $number = "";
        $email = "";
        $pass = "";
        $cpassword = "";
      }
      else{
        echo "Woops! The phone number already exists.";
      }
    }
    else {
      echo "Woops! The email already exists.";
    }
  }
  else {
    echo "Woops! The passswords don't match.";
  }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="../style.css"> -->
  <title>Sign Up</title>
</head>
<body>
  <!-- Sign Up form  -->
  <div class="container">
		<form action="" method="POST" class="login-email">
          <p class="login-text" style="font-size: 2rem; font-weight: 800;">Register</p>
			<div class="input-group">
				<input type="text" placeholder="First Name" name="fname" value="<?php echo $fname ?>" required>
			</div>
			<div class="input-group">
				<input type="text" placeholder="Last Name" name="lname" value="<?php echo $lname ?>" required>
			</div>
      <div class="input-group">
				<input type="text" placeholder="Address" name="address" value="<?php echo $address ?>" required>
			</div>
			<div class="input-group">
				<input type="text" placeholder="Number" name="number" pattern="[0-9]{10}" value="<?php echo $number ?>" required>
			</div>
			<div class="input-group">
				<input type="email" placeholder="Email" name="email" value="<?php echo $email ?>" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"   required title="Password must be 8 characters including 1 uppercase letter, 1 lowercase letter and numeric characters" name="pass" value="<?php echo $pass ?>" required>
            </div>
            <div class="input-group">
				<input type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo $cpassword ?>" required>
			</div>
			<br>
			<div class="input-group">
				<button name="submit" class="btn">Sign Up</button>
			</div>
			<p class="login-register-text">Have an account? <a href="login.php">Log In Here</a>.</p>
		</form>
	</div>
</body>
</html>
