<?php
  include '../conn.php';
  error_reporting(0);
  session_start();
  $user_id = "";
  $user_id = $_SESSION['user_id'];
  $sql = "SELECT firstname, lastname, email, phone, address FROM users WHERE user_id = '$user_id'";
  $result = mysqli_query($connect, $sql);
  $user = array();
  while ($row = $result->fetch_assoc()){
              $user['firstname']= $row['firstname'];
              $user['lastname']= $row['lastname'];
              $user['email']= $row['email'];
              $user['phone']= $row['phone'];
              $user['address']= $row['address'];
            }
  if(isset($_POST['asubmit'])) {
    $address = $_POST['address'];
    $sql = "UPDATE users SET address = '$address' WHERE user_id = '$user_id'";
    $result = mysqli_query($connect, $sql);
    header("Refresh:0");
  }
  if(isset($_POST['psubmit'])) {
    $number = $_POST['number'];
    $sql = "UPDATE users SET phone = '$number' WHERE user_id = '$user_id'";
    $result = mysqli_query($connect, $sql);
    header("Refresh:0");
  }
  if(isset($_POST['password_submit'])) {
    $pass = md5($_POST["pass"]);
    $cpassword = md5($_POST["cpassword"]);
    if($pass == $cpassword) {
      $sql = "UPDATE users SET user_password = '$pass' WHERE user_id = '$user_id'";
      $result = mysqli_query($connect, $sql);
      header("Refresh:0");
    }
    else{
      echo 'Eroare!';
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil</title>
</head>
<body>
  <header>
	<nav>
		<ul class="navbar__links">
			<li><a href="../index.php">Acasă</a></li>
      <?php
       if($user_id == null){
          echo '<li><a href="login.php">Rezervări</a></li>
                <li><a href="login.php">Profil</a></li>
                <li><a href="login.php">Conectare</a></li>';
        }
        else {
          if($user_id == 1) {
            echo '<li><a href="books.php">Cărți</a></li>
                  <li><a href="book.php">Adaugă carte</a></li>
                  <li><a href="authors_publications.php">Autori și publicații</a></li>
                  <li><a href="users.php">Utilizatori</a></li>';

          }
          echo '<li><a href="reservations.php">Rezervări</a></li>
                <li><a href="profile.php">Profil</a></li>
                <li><a href="logout.php">Deconectare</a></li>';
        }
        ?>
			<li><a href="#footer">Contact</a></li>
		</ul>
	</nav>

</header>
<p><?php echo $user['firstname'];  ?></p>
<p><?php echo $user['lastname'];  ?></p>
<p><?php echo $user['phone'];  ?></p>
<p><?php echo $user['email'];  ?></p>
<p><?php echo $user['address'];  ?></p>

<form action="" method="POST" class="login-email">
  <div class="input-group">
		<input type="text" placeholder="Address" name="address" value="<?php echo $address ?>" required>
	</div>
  <div class="input-group">
    <button name="asubmit" class="btn">Schimba adresa</button>
  </div>
</form>
<form action="" method="POST" class="login-email">
  <div class="input-group">
				<input type="text" placeholder="Number" name="number" pattern="[0-9]{10}" value="<?php echo $number ?>" required>
			</div>
  <div class="input-group">
    <button name="psubmit" class="btn">Schimba numar</button>
  </div>
</form>
<form action="" method="POST" class="login-email">
  <div class="input-group">
				<input type="password" placeholder="Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"   required title="Password must be 8 characters including 1 uppercase letter, 1 lowercase letter and numeric characters" name="pass" value="<?php echo $pass ?>" required>
            </div>
            <div class="input-group">
				<input type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo $cpassword ?>" required>
			</div>
  <div class="input-group">
    <button name="password_submit" class="btn">Schimba parola</button>
  </div>
</form>
</body>
</html>
