<?php
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
<header>
    <nav class="navbar navbar-default navbar-shadow">
      <div class="container">
        <div class="navbar-header">
          <div class="logo-container">
            <a href="index.php">
              <img class="logo" src="Images/logo.png" alt="logo" style="width:120px; height:70px;">
            </a>
          </div>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Acasă</a></li>
            <?php
            if($user_id == null){
              echo '<li><a href="links/login.php">Conectare</a></li>';
              }
              else {
                if($user_id == 1) {
                  echo '<li><a href="links/books.php">Cărți</a></li>
                  <li><a href="links/book.php">Adaugă carte</a></li>
                  <li><a href="links/authors_publications.php">Autori și publicații</a></li>
                  <li><a href="links/users.php">Utilizatori</a></li>';
                }
                echo '<li><a href="links/reservations.php">Rezervări</a></li>
                <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user-circle-o" aria-hidden="true"></i> Profil <span class="caret"></span></a>
                <ul class="dropdown-menu">
                <li><a href="links/profile.php">Vezi profil</a></li>
                <li><a href="links/logout.php">Deconectare</a></li>
                </ul>
                </li>';
              }
              ?>
              <li><a href="#footer">Contact</a></li>
            </ul>
        </div>
      </div>
    </nav>
  </header>
<div class="profile-card">
    <div class="profile-details">
      <div class="profile-icon">
      <i class="fa fa-user-circle-o" aria-hidden="true"></i>
      </div>
      <div class="user-details">
    <div class="profile-icon">
        <i class="fa fa-user-circle-o" aria-hidden="true"></i>
    </div>
    <div class="row">
        <label for="last_name">Nume</label>
        <p><?php echo $user['lastname']; ?></p>
        <label for="first_name">Prenume</label>
        <p><?php echo $user['firstname']; ?></p>
    </div>
    <div class="row">
        <label for="phone">Număr de telefon</label>
        <p><?php echo $user['phone']; ?></p>
        <label for="email">Email</label>
        <p><?php echo $user['email']; ?></p>
    </div>
    <div class="row">
        <label for="address">Adresă</label>
        <p><?php echo $user['address']; ?></p>
    </div>
    <button class="settings-button" id="settingsButton">Setări</button>
</div>

    </div>
    <div class="settings-form" id="settingsForm">
      <form action="" method="POST" class="login-email">
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
      </form>
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
  align-items: center;
  height: 100vh;
}

.profile-details {
  display: flex;
  align-items: center;
  background-color: #fff;
  border-radius: 3px;
  box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
  padding: 20px;
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

.settings-form {
  display: none;
  margin-top: 20px;
}

.show {
  display: block;
}

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
      margin-top: 15px;
    }

    .settings-form {
      display: none;
    margin-top: 20px;
    clear: both; 
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

</style>
<script>
const settingsButton = document.getElementById('settingsButton');
const settingsForm = document.getElementById('settingsForm');

settingsButton.addEventListener('click', () => {
    settingsForm.classList.toggle('show');
    if (settingsForm.classList.contains('show')) {
        settingsButton.textContent = 'Ascunde Setările';
    } else {
        settingsButton.textContent = 'Setări';
    }
});

</script>
</body>
</html>
