<?php
 include '../conn.php';
  error_reporting(0);
  session_start();
  $user_id = "";
  $user_id = $_SESSION['user_id'];

  $totalBooks = mysqli_num_rows(mysqli_query($connect, 'SELECT * FROM books'));

  $booksPerPage = 5;

  $totalPages = ceil($totalBooks / $booksPerPage);

  if (isset($_GET['page'])) {
      $currentPage = $_GET['page'];
  } else {
      $currentPage = 1;
  }

  $offset = ($currentPage - 1) * $booksPerPage;

  if (isset($_POST['search_button'])) {
    $searchTerm = mysqli_real_escape_string($connect, $_POST['search']);
    $category = $_POST['category']; // Capture category filter
    $price = $_POST['price'];       // Capture price filter
    $age = $_POST['age'];
    $sql = "SELECT a.book_id, a.title, a.publishing_year, a.price, a.pages, a.author_id, a.category_id, a.age, a.book_picture, au.firstname AS firstname, au.lastname AS lastname, c.name AS name
        FROM books a
        JOIN authors au ON a.author_id = au.author_id
        JOIN category c ON a.category_id = c.category_id
        WHERE a.title LIKE '%$searchTerm%'";
   if (!empty($category)) {
    $sql .= " AND a.category_id = '$category'";
}

if (!empty($price)) {
    $sql .= " AND a.price <= $price";
}

if (!empty($age)) {
    $sql .= " AND a.age <= $age";
}
} else {
    $sql = "SELECT a.book_id, a.title, a.publishing_year, a.price, a.pages, a.author_id, a.category_id, a.age, a.book_picture, au.firstname AS firstname, au.lastname AS lastname, c.name AS name
        FROM books a JOIN authors au ON a.author_id = au.author_id JOIN category c ON a.category_id = c.category_id
        LIMIT $offset, $booksPerPage";
    if (!empty($category)) {
        $sql .= " WHERE a.category_id = '$category'";
    }

    if (!empty($price)) {
        if (strpos($sql, 'WHERE') === false) {
            $sql .= " WHERE";
        } else {
            $sql .= " AND";
        }
        $sql .= " a.price <= $price";
    }

    if (!empty($age)) {
        if (strpos($sql, 'WHERE') === false) {
            $sql .= " WHERE";
        } else {
            $sql .= " AND";
        }
        $sql .= " a.age <= $age";
    }
}
  $result = mysqli_query($connect, $sql);
  $i = 0;
  $books_array = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $books_array[$i]['title'] = $row['title'];
    $books_array[$i]['publishing_year']=$row['publishing_year'];
    $books_array[$i]['price']=$row['price'];
    $books_array[$i]['pages']=$row['pages'];
    $books_array[$i]['age'] = $row['age'];
    $books_array[$i]['author_firstname']=$row['firstname'];
    $books_array[$i]['author_lastname']=$row['lastname'];
    $books_array[$i]['name']=$row['name'];
    $books_array[$i]['book_picture'] = $row['book_picture'];
    $books_array[$i]['book_id'] = $row['book_id'];
    $i++;
  }
  if(isset($_POST['see_more'])) {
    $one_book = $_POST['one_book'];
    header("Location: one_book.php?book_id=$one_book");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> <!-- Add this line for the sidebar icons -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link href='https://fonts.googleapis.com/css?family=Qwitcher Grypen' rel='stylesheet'>
  <title>Cărți</title>
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
    }
  ?>
</body>
<div class="container" style="padding-top: 50px; padding-bottom: 100px;">
  <form action="" method="POST" class="search-bar form-1-style">
    <button name="search_button" class="search-bar__button" type="submit">
      <i class="fa fa-search search-icon" style="border-right: 1px solid #888888; position:relative; padding-right:15px;"></i>
    </button>
    <input class="search-bar__bar" type="text" name="search" id="search"/>
  </form>
  <form action="" method="POST" class="search-bar list" style="margin-left: 180px; width: 900px;  justify-content: center; text-align: center; margin-bottom: 50px; background-color: transparent; border: none;">
    <div class="row" style="margin-top: 25px;">
        <div class="col-sm-4 input-column">
            <label for="price">Selectează prețul maxim:</label>
            <input type="number" class="form-control" name="price" value="">
        </div>
        <div class="col-sm-4 input-column">
            <label for="age">Selectează vârsta maximă:</label>
            <input type="number" class="form-control" name="age" value="">
        </div>
        <div class="col-sm-4 input-column">
            <label for="category">Selectează o categorie:</label>
            <select class="form-control" name="category">
                <option value=""></option>
                <?php
                $sql = mysqli_query($connect, "SELECT category_id FROM category");
                $cat_id = array();
                while ($row = $sql->fetch_assoc()) {
                    $cat_id[] = $row['category_id'];
                }
                foreach ($cat_id as $id) {
                    $sql = mysqli_query($connect, "SELECT name FROM category WHERE category_id = '$id'");
                    while ($row = $sql->fetch_assoc()) {
                        $name = $row['name'];
                        echo '<option value="'.$name.'">' . $name.'</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-sm-4 input-column" style="margin-top: 25px;">
            <button name="search_button" class="search-bar__button btn btn-primary" type="submit" style="background-color:#D0D0D0; color:#333; margin-left:300px;">Aplică filtrele</button>
        </div>
    </div>
</form>




  <div class="row">
        <?php
        for ($i = 0; $i < count($books_array); $i++) {
            echo '<div class="col-xs-12 col-sm-6 col-md-4">';
            echo '<div class="card">';
            echo '<img src="' . $books_array[$i]['book_picture'] . '" class="card-img-top" alt="' . $books_array[$i]['title'] . '">';
            echo '<div class="card-body text-center">';
            echo '<h5 class="card-title">' . $books_array[$i]['title'] . '</h5>';
            echo '<p class="card-text"> ' . $books_array[$i]['author_firstname'] . ' ' . $books_array[$i]['author_lastname'] . '</p>';
            echo "<form action='' method='POST'>";
                  echo "<div class=container style='background-color:grey;'>";
                  echo '<input type="hidden" name="one_book" value="' . $books_array[$i]['book_id'] . '" />';
                  echo "</div>";
                  echo "<button name='see_more' class='search-bar__button' type='submit'style='color:#333; width:300px; margin-top:30px;'>Detalii</button>";
                  echo "</form>";
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
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
  .search-bar {
    display: flex;
    align-items: center;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 5px;
    margin-top: 20px;
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

.search-icon {
    font-size: 20px;
    color: #333; /* Culoarea pentru iconiță */
}

.search-bar__bar {
    border: none;
    padding: 5px;
    width: 300px;
    font-size: 16px;
    color: #333; /* Culoarea pentru text */
    background-color: #D0D0D0;
    width: 500px;
}

.search-bar__button i {
  font-size: 20px;
  color: #888888;
  font-weight: lighter;
}
.search-bar.form-1-style {
  width: 600px; margin-bottom: 50px; margin-left: 350px; background-color: #D0D0D0;
}
.serch-bar.list{
  margin-left: 180px; width: 900px;  justify-content: center; text-align: center; margin-bottom: 50px; background-color: transparent; border: none;
}

  .hidden {
    display: none;
}
.card {
    border: none;
    margin-bottom:30px;
  position: relative;
  background-color: #fff;
  border-radius: 3px;
  padding: 25px;
  margin-bottom: 15px;
  width: 100%;
  height:500px;
  box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
  -moz-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
  -webkit-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
}
.card-body.text-center {
    text-align: center;
}
.card-module img {
    max-width: 100%; /* Asigură că imaginea nu depășește lățimea containerului */
    height: auto; /* Păstrează proporțiile originale ale imaginii */
}
.card-img-top {
    max-width: 60%; /* Asigură că imaginea nu depășește lățimea containerului */
    height: 60%;
    object-fit: cover;
    display: block; /* Add this line to center-align the image */
    margin: 0 auto; /* Add this line to center-align the image */
}

.card-title {
    font-size: 24px;
    margin-top: 15px;

}

.card-text {
    font-size: 14px;
    color: #555;
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
input:focus {
    outline: none;
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
/* Stiluri pentru media query de 480px */
@media all and  (max-width: 480px) {
  .search-bar.form-1-style {
  width: 400px; margin-bottom: 50px; margin-left: 25px; background-color: #D0D0D0;
}
.serch-bar.list{
  margin-left: 25px; width: 400px;  justify-content: center; text-align: center; margin-bottom: 50px; background-color: transparent; border: none;
}
  .navbar-nav {
    display: flex;
    flex-direction: column;
  }
  
  .navbar-nav > li {
    position: relative;
  }

  .navbar-nav .dropdown-menu {
    display: none;
    position: absolute;
    left: 100%;
    top: 0;
    background-color: #fff;
    z-index: 1;
  }

  .navbar-nav .dropdown:hover .dropdown-menu {
    display: block;
  }

  .navbar-nav .dropdown > a::after {
    content: "\f107";
    font-family: FontAwesome;
    float: right;
  }

  .navbar-nav .profile-dropdown > a::after {
    content: "\f105";
    font-family: FontAwesome;
    float: right;
  }

  .navbar-nav .profile-dropdown:hover .dropdown-menu {
    display: flex;
    flex-direction: column;
  }

  .container {
    max-width: 100%;
    padding-right: 15px;
    padding-left: 15px;
  }

  .search-bar {
    width: 50px;
    margin-left: 0;
  }

  .search-bar__bar {
    width: 100px;;
  }

  .search-bar__button {
    margin-right: 0;
  }
}
</style>
<footer id="footer">
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
<style>
  .corner-image {
    position: absolute;
    max-width: 700px;
    min-width: 300px;
    width: 25vw;
    top: 0; /* Plasăm imaginea în partea de sus a footer-ului */
    right: 0; /* Poziționăm imaginea în colțul din dreapta sus */
  }

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
