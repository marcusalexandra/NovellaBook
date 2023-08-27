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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Conectare</title>
</head>
<body style="background-color: #e4e5e6;">
<div class="auth-page">
    <div class="auth-box form-box">
      <div class="auth-box-body">
        <div class="auth-box-header">
          <h1 class="user-login">Conectare</h1>
        </div>
        <form action="" method="POST" class="login-email">
          <div class="input-group email-group">
            <i class="fa fa-envelope-o" aria-hidden="true"></i>
            <label for="email" class="sr-only">Adresă email</label>
            <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo $email ?>" required>
          </div>
          <div class="input-group email-group">
            <i class="fa fa-lock" aria-hidden="true"></i>
            <label for="password" class="sr-only">Parolă</label>
            <input type="password" class="form-control" placeholder="Parolă" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required title="Password must be 8 characters including 1 uppercase letter, 1 lowercase letter and numeric characters" name="pass" value="<?php echo $pass ?>" required>
          </div>
          <div class="error-message" id="error-message"></div>
          <div class="input-group">
            <button name="submit" class="btn">Conectare</button>
          </div>
          <div class="login-register-container">
            <p class="login-register-text">Încă nu ai un cont ? <a href="register.php">Crează un cont</a></p>
          </div>
        </form>
      </div>
    </div>
  <style>
    .auth-page{
      margin:0 auto;
      max-width:420px;
      width:auto;
      padding-top:150px;
    }
    .auth-box.form-box{
    padding-top: 10px;
    padding-bottom: 10px;
    margin: 0 auto;
    max-width: 700px;
    background-color: rgba(255,255,255,1);}
    .auth-box-body{
    width:400px;
    background-color: rgba(255,255,255,1);
    padding: 35px 50px 35px 50px;
    border-radius: 3px;
    position:relative;}
    .auth-page .auth-box-body .user-login{
    margin-top: 25px;}
    .user-login{
    color: #e4e5e6;
    margin-bottom: 50px;
    font-size: 40px;}
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
/* Adaugă stiluri pentru buton */
.btn {
    background-color: #9ca1af;
    color: #fff;
    border: none;
    border-radius: 1;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    text-align: center;
    width: 320px;
}

/* Stiluri pentru butonul la hover */
.btn:hover {
    background-color: #9ca1af;
}

/* Stiluri pentru textul butonului la hover */
.btn:hover span {
    text-decoration: underline;
}

/* Stiluri pentru textul butonului */
.btn span {
    display: inline-block;
    margin-left: 10px;
}

/* Stiluri pentru linkul din "Încă nu ai un cont?" */
.login-register-text a {
    text-decoration: none;
}

/* Stiluri pentru linkul din "Încă nu ai un cont?" la hover */
.login-register-text a:hover {
    text-decoration: underline;
}
.login-register-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
}
</style>

</body>
</html>
