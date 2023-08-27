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
                <li><a href="links/profile.php">Profil</a></li>
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
        <?php
          $sql = "SELECT * FROM reservations WHERE user_id = '$user_id' AND return_date >= CURDATE()";
          $results = mysqli_query($connect, $sql);
          while ($row = $results->fetch_assoc()){
            $reservation_id = $row['reservation_id'];
            $book_id = $row['book_id'];
            $sql = "SELECT * FROM books WHERE book_id = '$book_id'";
            $results_title = mysqli_query($connect, $sql);
            while ($row_title = $results_title->fetch_assoc()){
              $book_title = $row_title['title'];
              echo "<div style='background-color:red'><form action ='' method = 'POST'>
                  <p>$book_title</p>
                  <input type = 'hidden' name = 'reservation_id' value = '$reservation_id'>
                  <input type = 'hidden' name = 'book_id' value = '$book_id'>
                  <button name='return' class='search-bar__button' type='submit'>
              </form></div>";
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
</style>
</body>
</html>
