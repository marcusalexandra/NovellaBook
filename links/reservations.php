<?php
  include '../conn.php';
  error_reporting(0);
  session_start();
  $user_id = "";
  $user_id = $_SESSION['user_id'];
  if(isset($_POST['return'])){
    $bookReturn_id = $_POST['book_id'];
    $reservation_id = $_POST['reservation_id'];
    $sql = "SELECT * FROM books WHERE book_id = '$bookReturn_id'";
    $result = mysqli_query($connect, $sql);
    $books_array = array();
    $sql = "DELETE FROM reservations WHERE reservation_id = '$reservation_id'";
    mysqli_query($connect,$sql);

    header("Refresh:0");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> <!-- Add this line for the sidebar icons -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <title>Rezervări</title>
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
        <?php
        if($user_id != 1){
          $sql = "SELECT * FROM reservations WHERE user_id = '$user_id'";
          $results = mysqli_query($connect, $sql);
          while ($row = $results->fetch_assoc()) {
              $reservation_id = $row['reservation_id'];
              $reservation_date = $row['reservation_date'];
              $return_date = $row['return_date'];
              $book_id = $row['book_id'];
              $sql = "SELECT * FROM books WHERE book_id = '$book_id'";
              $results_title = mysqli_query($connect, $sql);
              while ($row_title = $results_title->fetch_assoc()) {
                  $book_title = $row_title['title'];
                  $book_picture = $row_title['book_picture'];
              echo '<div class="container">
              <div class="row">
                <div class="col-md-12">
                  <div class="card-module">
                    <div class="card-content">
                    <form action ="" method = "POST">';
              if($return_date <= date("Y-m-d")){
                echo "<p style='color:red;'>Această carte trebuie returnată!</p>";
              }
              echo "<img src='$book_picture' alt='$book_title' style='max-width: 50%; height: 50%;'>";
              echo "<p style='font-size:22px; margin-top:15px;'>$book_title</p>
              <p style='border-top:1px solid #808080; width:70%; padding:5px; margin-left:100px; '></p>
                  <p style='text-align:left; margin-left:200px;'><i class='fa fa-calendar' aria-hidden='true' style='margin-right:10px;'></i>Această carte a fost rezervată de la data de $reservation_date</p>
                  <p style='text-align:left; margin-left:200px;'><i class='fa fa-calendar' aria-hidden='true' style='margin-right:10px;'></i>Cartea trebuie returnată în data de $return_date</p>
                  <input type = 'hidden' name = 'reservation_id' value = '$reservation_id'>
                  <input type = 'hidden' name = 'book_id' value = '$book_id'>
                  <button name='return' class='search-bar__button' type='submit' style='color:#333;'>Returnare
              </form></div></div></div></div></div>";
            }
          }
        }elseif($user_id == 1){
          $sql = "SELECT r.*, u.firstname AS user_firstname, u.lastname AS user_lastname FROM reservations r JOIN users u ON r.user_id = u.user_id";
          $results = mysqli_query($connect, $sql);
          while ($row = $results->fetch_assoc()){
            $firstname = $row['user_firstname'];
            $lastname = $row['user_lastname'];
            $reservation_id = $row['reservation_id'];
            $reservation_date = $row['reservation_date'];
            $return_date = $row['return_date'];
            $book_id = $row['book_id'];
            $sql = "SELECT * FROM books WHERE book_id = '$book_id'";
            $results_title = mysqli_query($connect, $sql);
            while ($row_title = $results_title->fetch_assoc()){
              $book_title = $row_title['title'];
              $book_picture = $row_title['book_picture'];
              echo '<div class="container">
              <div class="row">
                <div class="col-md-12">
                  <div class="card-module">
                    <div class="card-content">
                    <form action ="" method = "POST">';
              if($return_date <= date("Y-m-d")){
                echo "Această carte trebuie returnată!";
              }
              echo "<img src='$book_picture' alt='$book_title' style='max-width: 50%; height: 50%;'>";
                echo "<p style='font-size:22px; margin-top:15px;'>$book_title</p>
                <p style='border-top:1px solid #808080; width:70%; padding:5px; margin-left:100px; '></p>
                  <p style='text-align:left; margin-left:230px;><i class='fa fa-user' aria-hidden='true' style='margin-right:10px;'></i>Utilizator: $lastname $firstname</p>
                  <p style='text-align:left; margin-left:230px;'><i class='fa fa-calendar' aria-hidden='true' style='margin-right:10px;'></i>Cartea este împrumutată de la data de $reservation_date</p>
                  <p style='text-align:left; margin-left:230px;'><i class='fa fa-calendar' aria-hidden='true' style='margin-right:10px;'></i>Cartea trebuie returnată la data de $return_date</p>
                  <input type = 'hidden' name = 'reservation_id' value = '$reservation_id'>
                  <input type = 'hidden' name = 'book_id' value = '$book_id'>
              </form></div></div></div></div></div>";
            }
          }
        }
        ?>

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
    width: 100%;
    top: 0;
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
  .card-module {
    margin: 0 auto; /* Center horizontally */
    background-color: #fff;
    border-radius: 3px;
    padding: 25px;
    margin-bottom: 100px;
    margin-top: 50px;
    width: 50%;
    height: 600px;
    box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
    -moz-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
    -webkit-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
    display: flex; /* Apply flexbox */
    flex-direction: column; /* Align children vertically */
    justify-content: center; /* Center children vertically */
}
.card-content{
  margin-bottom: 15px;
  word-wrap: break-word;
  text-align: center;
  width:700px;
}
.card-module {
  /* Restul stilurilor existente */
  display: flex;
  align-items: center;
  justify-content: center;
}
.search-bar__button {
    background-color: #D0D0D0;
    border: none;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    padding: 6px 12px;
    font-size: 16px;
    margin-right: 10px; /* Adjust this margin to control spacing between icon and input */
}
  #footer {
    background-color: #B8B8B8;
    color: #fff;
    text-align: center;
    padding: 10px;
    position: relative;
    bottom: 0;
    width: 100%;
}
</style>
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
</html>
