<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../conn.php';
error_reporting(0);
session_start();
$user_id = $_SESSION['user_id'];

if (isset($_POST['asubmit'])) {
    $address = $_POST['address'];
    $sql = "UPDATE users SET address = '$address' WHERE user_id = '$user_id'";
    $result = mysqli_query($connect, $sql);
    header("Refresh:0");
}

if (isset($_POST['psubmit'])) {
    $number = $_POST['number'];
    $sql = "UPDATE users SET phone = '$number' WHERE user_id = '$user_id'";
    $result = mysqli_query($connect, $sql);
    header("Refresh:0");
}

if (isset($_POST['password_submit'])) {
    $pass = md5($_POST["pass"]);
    $cpassword = md5($_POST["cpassword"]);
    if ($pass == $cpassword) {
        $sql = "UPDATE users SET user_password = '$pass' WHERE user_id = '$user_id'";
        $result = mysqli_query($connect, $sql);
        header("Refresh:0");
    } else {
        echo 'Eroare!';
    }
}

$sql = "SELECT firstname, lastname, email, phone, address FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($connect, $sql);
$user = mysqli_fetch_assoc($result);

$address = $user['address'];
$number = $user['phone'];
$pass = $cpassword = ""; // Initialize these variables to avoid errors
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Profil</title>
</head>
<body style="background-color: #e4e5e6;">
<?php
    if($user_id != 1){
      echo'<header>
        <nav class="navbar navbar-default navbar-shadow">
          <div class="container">
            <div class="navbar-header">
              <div class="logo-container">
                <a href="../index.php">
                  <img class="logo" src="../Images/logo.png" alt="logo" style="width:120px; height:70px;">
                </a>
              </div>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
              <ul class="nav navbar-nav">
                <li><a href="../index.php">Acasă</a></li>
                <li><a href="all_books.php">Cărți</a></li>';
                if($user_id == null){
                  echo '<li><a href="login.php">Conectare</a></li>';
                  }
                  else {
                    echo '<li><a href="reservations.php">Rezervări</a></li>
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user-circle-o" aria-hidden="true"></i> Profil <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                    <li><a href="profile.php">Vezi profil</a></li>
                    <li><a href="logout.php">Deconectare</a></li>
                    </ul>
                    </li>';
                  }
                  echo '<li><a href="#footer">Contact</a></li>
                </ul>
            </div>
          </div>
        </nav>
      </header>';
    }elseif($user_id == 1){
      //header nou
      echo'<header>
        <nav class="navbar navbar-default navbar-shadow">
          <div class="container">
            <div class="navbar-header">
              <div class="logo-container">
                <a href="../index.php">
                  <img class="logo" src="../Images/logo.png" alt="logo" style="width:120px; height:70px;">
                </a>
              </div>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
              <ul class="nav navbar-nav">
                <li><a href="../index.php">Acasă</a></li>';
                echo '<li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-users" aria-hidden="true"></i> Gestiuni <span class="caret"></span></a>
                <ul class="dropdown-menu">
                <li><a href="books.php">Cărți</a></li>
                <li><a href="authors.php">Autori</a></li>
                <li><a href="categories.php">Categorii</a></li>
                <li><a href="publishers.php">Publicații</a></li>
                <li><a href="users.php">Utilizatori</a></li>
                <li><a href="reservations.php">Rezervări</a></li>
                </ul>
                  </li>';
                echo '<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user-circle-o" aria-hidden="true"></i> Profil <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                    <li><a href="profile.php">Vezi profil</a></li>
                    <li><a href="logout.php">Deconectare</a></li>
                    </ul>
                    </li>';
                echo '
                </ul>
            </div>
          </div>
        </nav>
      </header>';
    }
  ?>
  <div class="profile-card">
    <div class="profile-details">
      <div class="profile-icon">
        <i class="fa fa-user-circle-o" aria-hidden="true"></i>
      </div>
      <div class="user-details"style="position:relative; border-left:1px solid #A8A8A8;">
        <div class="row" style="width:150%; padding-left:15px;padding-right:190px;">
          <div class="column" style="width:45%; height: 80px;">
            <i class="fa fa-user" aria-hidden="true"></i>
            <label for="last_name">Nume</label>
            <p class="column-labels"><?php echo $user['lastname']; ?></p>
          </div>
          <div class="column" style="width:45%; height: 80px;">
            <i class="fa fa-user" aria-hidden="true"></i>
            <label for="first_name">Prenume</label>
            <p class="column-labels"><?php echo $user['firstname']; ?></p>
          </div>
        </div>
        <div class="row" style="width:150%; padding-left:15px;padding-right:190px;">
          <div class="column" style="width:45%; height: 80px;">
            <i class="fa fa-phone" aria-hidden="true"></i>
            <label for="phone">Număr de telefon</label>
            <p class="column-labels"><?php echo $user['phone']; ?></p>
          </div>
          <div class="column" style="width:45%; height: 80px;">
            <i class="fa fa-envelope" aria-hidden="true"></i>
            <label for="email">Email</label>
            <p class="column-labels"><?php echo $user['email']; ?></p>
          </div>
        </div>
        <div class="row" style="width:150%; padding-left:15px;padding-right:190px;">
          <div class="column" style="width:45%; height: 80px;">
            <i class="fa fa-home" aria-hidden="true"></i>
            <label for="address">Adresă</label>
            <p class="column-labels"><?php echo $user['address']; ?></p>
          </div>
          <div class="column" style="background-color:#fff; width:45%; height: 80px;"></div>
        </div>
        <button class="settings-button" id="settingsButton" style="margin-left:55px; position:relative;">Setări</button>
      </div>
      <div class="settings-form" id="settingsForm">
        <form action="" method="POST" class="login-email">
          <div class="container">
            <div class="col-md-12">
              <div class="card-module">
                <div class="card-content">
                  <form action="" method="POST" class="login-email">
                    <div class="input-group email-group">
                      <i class="fa fa-home" aria-hidden="true"></i>
                      <input type="text" class="form-control" placeholder="Adresă" name="address" value="<?php echo $address ?>" required>
                    </div>
                    <div class="input-group email-group">
                      <button name="asubmit" class="btn">Schimbă adresa</button>
                    </div>
                  </form>
                  <form action="" method="POST" class="login-email">
                    <div class="input-group email-group">
                      <i class="fa fa-phone" aria-hidden="true"></i>
                      <input type="text" class="form-control" placeholder="Număr telefon" name="number" pattern="[0-9]{10}" value="<?php echo $number ?>" required>
                    </div>
                    <div class="input-group email-group">
                      <button name="psubmit" class="btn">Schimbă număr telefon</button>
                    </div>
                  </form>
                  <form action="" method="POST" class="login-email">
                    <div class="input-group email-group">
                      <i class="fa fa-lock" aria-hidden="true"></i>
                      <input type="password" class="form-control" placeholder="Parola" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"   required title="Password must be 8 characters including 1 uppercase letter, 1 lowercase letter and numeric characters" name="pass" value="<?php echo $pass ?>" required>
                    </div>
                    <div class="input-group email-group">
                      <i class="fa fa-lock" aria-hidden="true"></i>
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
        </form>
      </div>
    </div>
  </div>
<style>
  * {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    text-decoration: none;
    list-style: none;
}
.user-details {
    display: flex;
    flex-direction: column;
}

.navbar-default{
    margin-bottom:0;
    border:none;
    
  }
  .navbar-shadow {
  box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* Aici puteți personaliza umbra */
}
  .navbar{
    position:relative;
    min-height:50px;
    margin-bottom:20px;
  }
  .container{
    max-width:1280px;
    width:100%;
    padding-right:15px;
    padding-left:15px;
    margin-right:auto;
    margin-left:auto;
  }
  .container>.navba-header{
    margin-right: 0;
    margin-left: 0;
  }
  .logo-container{
    padding:20px 0;
  }
  #navbar{
    min-height:85px;
  }
  .container>.navbar-collapse{
    margin-right: 0;
    margin-left: 0;
  }
  .navbar-nav{
    margin-right: -15px;
    float:right;
  }
  .nav>li{
    position: relative;
    display:block;
  }
  .nav{
    list-style:none;
  }
  .navbar-default .navbar-nav>li>a{
    padding:20px 30px;
    line-height: 55px;
    font-size: 16px;
    margin-top:10px;
  }
  .profile-card {
  display: flex;
  justify-content: center;
  height: 450px;
  position: relative;
  margin-top: 100px;
  position: relative;
}

.show{
  display: block;
}
.profile-details {
  display: flex;
  align-items: center;
  background-color: #fff;
  border-radius: 3px;
  box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
  padding: 20px;
  margin: 0 auto;
  width: 700px;
  position: relative; /* Add this line */
}
.profile-icon {
      width: 100px;
      height: 100px;
      background-color: #f3f3f3;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-right: 20px;
      border: 1px solid #ccc;
    }

    .profile-icon i {
      font-size: 60px;
      color: #9ca1af;
    }

.settings-button {
  background-color: #9ca1af;
  color: #fff;
  border: none;
  border-radius: 3px;
  padding: 10px 20px;
  font-size: 14px;
  cursor: pointer;
}


.show {
  display: block;
}

.card-content{
  margin-bottom: 15px;
  word-wrap: break-word;
  text-align: center;
  /*width:100px;*/
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
    .settings-button {
      background-color: #9ca1af;
      color: #fff;
      border: none;
      border-radius: 3px;
      padding: 10px 20px;
      font-size: 14px;
      cursor: pointer;
      margin-top: 15px;
    }
    .profile-card.show-settings {
  animation: moveProfileCard 0.3s forwards;
}

@keyframes moveProfileCard {
  from {
    transform: translateX(0);
  }
  to {
    transform: translateX(-350px); /* Adjust the value based on your design */
  }
}

.settings-form {
  display: none;
  position: absolute;
  top: -100px;
  left: calc(100% + 10px); /* Position it to the right of the profile card */
  width: 500px;
  padding: 20px;
  background-color: #fff;
  box-shadow: 0px 2px 5px rgba(6, 6, 6, 0.16);
  margin-top:100px;
}
.show-settings .settings-form {
  display: block; /* Show the form when the show-settings class is present */
  left: calc(100% + 10px); /* Position it to the right of the profile card */
}

    .show {
      display: block;
    }
    .user-details {
      display: flex;
    flex-direction: column;
    /* Alte stiluri aici */
}
.row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 5px; /* Reducerea spațiului dintre rânduri */
}

.row label,
.row p {
    margin: 0;
}
.column-labels{
  position:relative;
  top:10px;
  border-bottom: 1px solid #A8A8A8;
}
#footer {
    background-color: #B8B8B8;
    color: #fff;
    text-align: center;
    padding: 10px;
    position: relative;
    bottom: 0;
    width: 100%;
    margin-top:264px
}
/* Media Queries */



</style>
<script>
const settingsButton = document.getElementById('settingsButton');
const profileCard = document.querySelector('.profile-card');
const settingsForm = document.querySelector('.settings-form');

settingsButton.addEventListener('click', () => {
  profileCard.classList.toggle('show-settings');
  if (profileCard.classList.contains('show-settings')) {
    settingsButton.textContent = 'Ascunde Setările';
  } else {
    settingsButton.textContent = 'Setări';
  }
});
</script>
</body>
<?php 
if($user_id != 1){
    echo '<footer id="footer">
      <div class="container" style="height:350px;">
        <div class="row">
          <div class="column" style="background-color:#B8B8B8; margin-left:55px;">
            <h3 style="color:#333;">Informații suplimentare</h3>
            <ul class="informations">
              <li>
                <i class="fa fa-arrow-right" aria-hidden="true"></i>
                <a href="#">Despre noi</a>
              </li>
              <li>
                <i class="fa fa-arrow-right" aria-hidden="true"></i>
                <a href="#">Politici de confidențialitate</a>
              </li>
              <li>
                <i class="fa fa-arrow-right" aria-hidden="true"></i>
                <a href="#">Blog</a>
              </li>
            </ul>
          </div>
          <div class="column" style="background-color:#B8B8B8; width:25%;"></div>
          <div class="column" style="background-color:#B8B8B8;">
            <h3 style="color:#333;margin-right:165px;">Contact</h3>
            <ul class="informations">
              <li>
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <a>Oradea, Strada Teilor, Nr.256</a>
              </li>
              <li>
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <a>novella.book@gmail.com</a>
              </li>
              <li>
                <i class="fa fa-phone" aria-hidden="true"></i>
                <a>+01 234 567 88</a>
              </li>
            </ul>
          </div>
        </div>
        <hr class="divider">
        <div class="col-md-6 col-lg-8">
          <p class="author-rights">Drept de autor ©
            <script>document.write(new Date().getFullYear());</script>
            Toate drepturile sunt rezervate
          </p>
        </div>
        <div class="col-md-6 col-lg-4">
          <ul class="footer-social">
            <li class="social-media-icon">
              <a href="#" data-toogle="toolip" data-placement="top" title data-original-title="Twitter">
                <i class="fa fa-twitter" aria-hidden="true"></i>
              </a>
            </li>
            <li class="social-media-icon">
              <a href="#" data-toogle="toolip" data-placement="top" title data-original-title="Facebook">
                <i class="fa fa-facebook" aria-hidden="true"></i>
              </a>
            </li>
            <li class="social-media-icon">
              <a href="#" data-toogle="toolip" data-placement="top" title data-original-title="Instagram">
                <i class="fa fa-instagram" aria-hidden="true"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </footer>';
}
?>
<style>
  
  /* Create three equal columns that floats next to each other */
.column {
  float: left;
  width: 33.33%;
  padding: 10px;
  height: 200px;
  margin-top:5px; 
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

.author-rights{
  color:#333;
  margin-top:15px;
  float: left;
}
.divider{
  border:1px solid #333;
  margin-top:25px;
  margin-bottom: 25px;
}

.footer-social li {
  list-style: none;
  margin: 0 10px 0 0;
  display: inline-block;
}

.footer-social li a {
  height: 40px;
  width: 40px;
  display: block;
  background: #aaa;
  border-radius: 50%;
  position: relative;
  text-decoration: none;
}

/* Remove the '.ftco-footer-social' class from this selector */
.footer-social li a i {
  position: absolute;
  font-size: 20px;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%); /* Center the icon */
  color: #333;
}
.informations {
    list-style: none;
    padding: 0;
    margin-left: 85px;
    margin-top:25px;
}

.informations li {
    margin-bottom: 10px; /* Adaugă spațiu între elementele listei */
    display: flex; /* Folosim flexbox pentru a alinia iconița și textul */
    align-items: center; /* Aliniem elementele pe axa verticală */
}

.informations li a {
    text-decoration: none;
    color: #333; /* Schimbăm culoarea textului la o nuanță mai închisă */
    margin-left: 10px; /* Adaugă spațiu între iconiță și text */
}

.informations li i {
    color: #333; /* Schimbăm culoarea iconiței la o nuanță mai închisă */
    font-size: 18px; /* Mărimea iconiței */
    margin-right: 5px; /* Adaugă spațiu între iconiță și link */
}
.informations li:hover {
    color: #f0f0f0; /* Schimbăm culoarea de fundal la trecerea cursorului peste element */
}

.informations li:hover a {
    color: #555; /* Schimbăm culoarea textului la trecerea cursorului peste link */
    text-decoration: none; /* Eliminăm sublinierea */
}
</style>
</footer>    
</html>
