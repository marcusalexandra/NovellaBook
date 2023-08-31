<?php
  include '../conn.php';
  error_reporting(0);
  session_start();
  $user_id = "";
  $user_id = $_SESSION['user_id'];

  if(isset($_POST['asubmit'])) {
    $anumber = "";
    $aemail = "";
    $afname = $_POST["afname"];
    $alname = $_POST["alname"];
    if($_POST['anumber'] != null) {
        $anumber = $_POST["anumber"];
    }
    if($_POST['aemail'] != null) {
        $aemail = $_POST["aemail"];
    }
    $sql = "INSERT INTO authors (email, firstname, lastname, phone)
            VALUES ('$aemail', '$afname', '$alname', '$anumber')";
        $result = mysqli_query($connect, $sql);
        $afname = "";
        $alname = "";
        $anumber = "";
        $aemail = "";
        
  }

  if(isset($_POST['csubmit'])) {
    $cname = $_POST["cname"];
    $sql = "INSERT INTO category (name)
            VALUES ('$cname')";
        $result = mysqli_query($connect, $sql);
        $cname = "";
        
  }

  if(isset($_POST['psubmit'])) {
      $pnumber = "";
      $pemail = "";
      $pname = $_POST["pname"];
      if($_POST['pnumber'] != null) {
        $pnumber = $_POST["pnumber"];
    }
    if($_POST['pemail'] != null) {
        $pemail = $_POST["pemail"];
    }
      $sql = "INSERT INTO publisher (publisher_email, publisher_name, publisher_phone)
              VALUES ('$pemail', '$pname', '$pnumber')";
          $result = mysqli_query($connect, $sql);
          $pname = "";
          $pnumber = "";
          $pemail = "";
          
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
  <title>Autori și publicații</title>
</head>
<body style="background-color: #e4e5e6;">
<header>
</header>
<div class="container" style="margin-top:100px;">
  <div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4 text-center">
      <div class="card-module">
        <div class="card-content">
        <form action="" method="POST" class="login-email">
          <p class="login-text" style="font-size: 30px;">Adaugă autori</p>
          <div class="input-group email-group">
            <i class="fa fa-user" aria-hidden="true"></i>
            <label for="email" class="sr-only">Nume</label>
            <input type="text" class="form-control" placeholder="Nume" name="afname" value="<?php echo $afname ?>" required>
          </div>
          <div class="input-group email-group">
            <i class="fa fa-user" aria-hidden="true"></i>
            <label for="email" class="sr-only">Prenume</label>
            <input type="text" class="form-control" placeholder="Prenume" name="alname" value="<?php echo $alname ?>" required>
          </div>
          <div class="input-group email-group">
            <i class="fa fa-phone" aria-hidden="true"></i>
            <label for="email" class="sr-only">Număr de telefon</label>
            <input type="text" class="form-control" placeholder="Număr de telefon" name="anumber" pattern="[0-9]{10}" value="<?php echo $anumber ?>">
          </div>
          <div class="input-group email-group">
            <i class="fa fa-envelope" aria-hidden="true"></i>
            <label for="email" class="sr-only">Adresă email</label>
            <input type="email" class="form-control" placeholder="Email" name="aemail" value="<?php echo $aemail ?>">
          </div>
          <br>
          <div class="input-group">
            <button name="asubmit" class="btn">Adaugă</button>
          </div>
        </form>
      </div>
    </div>
  </div>
    <div class="col-xs-12 col-sm-6 col-md-4 text-center">
      <div class="card-module">
      <div class="card-content">
        <form action="" method="POST" class="login-email">
          <p class="login-text" style="font-size: 30px;">Adaugă o categorie</p>
          <div class="input-group email-group">
            <i class="fa fa-book" aria-hidden="true"></i>
            <label for="email" class="sr-only">Titlu categorie</label>
            <input type="text" class="form-control" placeholder="Titlu" name="cname" value="<?php echo $cname ?>" required>
          </div>
          <br>
          <div class="input-group">
            <button name="csubmit" class="btn" style="top:165px; position:relative;">Adaugă</button>
          </div>
        </form>
      </div>
    </div>
  </div>
    <div class="col-xs-12 col-sm-6 col-md-4 text-center">
      <div class="card-module">
      <div class="card-content">
        <form action="" method="POST" class="login-email">
          <p class="login-text" style="font-size: 30px;">Adaugă o publicație</p>
          <div class="input-group email-group">
            <i class="fa fa-book" aria-hidden="true"></i>
            <label for="email" class="sr-only">Titlu publicație</label>
            <input type="text" class="form-control" placeholder="Titlu" name="pname" value="<?php echo $pname ?>" required>
          </div>
          <div class="input-group email-group">
            <i class="fa fa-phone" aria-hidden="true"></i>
            <label for="email" class="sr-only">Număr telefon</label>
            <input type="text" class="form-control" placeholder="Număr de telefon" name="pnumber" pattern="[0-9]{10}" value="<?php echo $pnumber ?>">
          </div>
          <div class="input-group email-group">
            <i class="fa fa-envelope" aria-hidden="true"></i>
            <label for="email" class="sr-only">Adresă email</label>
            <input type="email" class="form-control" placeholder="Email" name="pemail" value="<?php echo $pemail ?>">
          </div>
          <br>
          <div class="input-group">
            <button name="psubmit" class="btn" style="top:55px; position:relative;">Adaugă</button>
          </div>
        </form>
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
  width: 100%;
  height:450px;
  box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
  -moz-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
  -webkit-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
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
.btn-primary {
    background-color: #337ab7;
    border-color: #337ab7;
}

.btn-primary:hover {
    background-color: #286090;
    border-color: #204d74;
}

.btn-block {
    display: block;
    width: 100%;
}
.card-content{
  min-height:110px;
  margin-top: 30px;
  margin-bottom: 15px;
  word-wrap: break-word;
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

</style>
</body>
</html>
