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
<body style="background-color: #e4e5e6;">
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

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card-module">
        <div class="card-content">
          <form action="" method="POST" class="login-email">
            <div class="input-group email-group">
              <input type="text" class="form-control" placeholder="Adresă" name="address" value="<?php echo $address ?>" required>
            </div>
            <div class="input-group email-group">
              <button name="asubmit" class="btn">Schimbă adresa</button>
            </div>
          </form>
          
          <form action="" method="POST" class="login-email">
            <div class="input-group email-group">
              <input type="text" class="form-control" placeholder="Număr telefon" name="number" pattern="[0-9]{10}" value="<?php echo $number ?>" required>
            </div>
            <div class="input-group email-group">
              <button name="psubmit" class="btn">Schimbă număr telefon</button>
            </div>
          </form>
          
          <form action="" method="POST" class="login-email">
            <div class="input-group email-group">
              <input type="password" class="form-control" placeholder="Parola" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"   required title="Password must be 8 characters including 1 uppercase letter, 1 lowercase letter and numeric characters" name="pass" value="<?php echo $pass ?>" required>
            </div>
            <div class="input-group email-group">
              <input type="password" class="form-control" placeholder="Confirmă Parola" name="cpassword" value="<?php echo $cpassword ?>" required>
            </div>
            <div class="input-group">
              <button name="password_submit" class="btn">Schimbă parola</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
  .card-module{
  margin-bottom:30px;
  position: relative;
  background-color: #fff;
  border-radius: 3px;
  padding: 25px;
  margin-bottom: 15px;
  width: 50%;
  height: 500px;
  box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
  -moz-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
  -webkit-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
}
.card-content{
  margin-bottom: 15px;
  word-wrap: break-word;
  text-align: center;
  width:100px;
}
.card-module {
  /* Restul stilurilor existente */
  display: flex;
  align-items: center;
  justify-content: center;
}

.sr-only{
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip:rect(0,0,0,0);
    border: 0;
    }
    .form-control{
    display: inline-block;
    width: 84%;
    padding: 10px 10px 5px 0;
    color: #9ca1af;
    border-style: none;
    border-bottom: 1px solid #eaeaec;
    border-radius: 0;
    box-shadow: none;
    }
    .input-group{
    margin-bottom: 20px;
    cursor: pointer;
    min-height: 35px;
    }
    .email-group {
    display: flex;
    align-items: center;}
    .email-group i {
    margin-right: 10px;
    margin-top: 3px;
  }
  /* Anulează stilurile implicite pentru elementele active/focus */
  .input-group input:focus {
    outline: none; /* Elimină conturul albastru la focus */
    border-color: #eaeaec; /* Setează culoarea chenarului la focus */
    box-shadow: none; /* Elimină umbra la focus */
}

/* Adaugă stil personalizat pentru casuța email */
.email-group input {
    border-radius: 0; /* Elimină colțurile rotunjite ale casuței */
}

/* Adaugă stil personalizat pentru casuța parolă */
.input-group input[type="password"] {
    border-top: none; /* Elimină partea superioară a chenarului */
    border-left: none; /* Elimină latura stângă a chenarului */
    border-right: none; /* Elimină latura dreaptă a chenarului */
    border-bottom-color: #eaeaec; /* Setează culoarea chenarului pentru partea de jos la focus */
    border-radius: 0; /* Elimină colțurile rotunjite ale casuței */
}
.btn {
    background-color: #9ca1af;
    color: #fff;
    border: none;
    border-radius: 1;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    text-align: center;
    width: 300px;
    margin-top:10px;
}
</style>
</body>
</html>
