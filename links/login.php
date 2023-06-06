<?php
include '../conn.php';
error_reporting(0);
session_start();


if(isset($_POST['submit'])) {

  $email = $_POST['email'];
  $pass = md5($_POST['pass']);
  $sql = "SELECT * FROM users WHERE email = '$email' AND user_password = '$pass'";
  $result = mysqli_query($connect,$sql);

  if($result -> num_rows > 0) {
    $sql = "SELECT user_id FROM users WHERE email = '$email' ";
    $result = mysqli_query($connect, $sql);
    while($row = $result -> fetch_assoc()) {
      $user_id = $row["user_id"];
    }
    $_SESSION['user_id'] = $user_id;
    header("Location: ../index.php");
  }
  else {
    echo "User or password is wrong!";
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
  <title>Log In</title>
</head>
<body>
  <br>
  <br>
  <div class="container">
    <form action="" method="POST" class="login-email">
      <div class="input-group">
        <input type="email" placeholder="Email" name="email" value="<?php echo $email ?>" required>
      </div>
      <div class="input-group">
        <input type="password" placeholder="Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"   required title="Password must be 8 characters including 1 uppercase letter, 1 lowercase letter and numeric characters" name="pass" value="<?php echo $pass ?>" required>
      </div>
      <div class="input-group">
        <button name="submit" class="btn">Sign Up</button>
      </div>
      <p class="login-register-text" style = "text-align:center;">Don't have an account? <a href="register.php">Sign Up Here</a>.</p>
    </form>
  </div>
</body>
</html>
