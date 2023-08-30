<?php
  include 'conn.php';
  error_reporting(0);
  session_start();
  $user_id = "";
  $user_id = $_SESSION['user_id'];
  if(isset($_POST['search_button'])) {
    $search = $_POST['search'];
    $price = $_POST['price'];
    $age = $_POST['age'];
    $category = $_POST['category'];
    $sql = "SELECT category_id FROM category WHERE name = '$category'";
    $result = mysqli_query($connect, $sql);
    while ($row = $result->fetch_assoc()){
      $category_id = $row['category_id'];
    }
    $sql = "SELECT * FROM books WHERE title RLIKE('$search')";
    if (!empty($category)) {
        $sql .= " AND category_id = '$category_id'";
    }

    if (!empty($price)) {
      $sql .= " AND price <= $price";
    }

    if (!empty($age)) {
        $sql .= " AND age <= $age";
    }
    $result = mysqli_query($connect, $sql);
    $i = 0;
    $books_array = array();
    while ($row = $result->fetch_assoc()){
      $books_array[$i]['book_id'] = $row['book_id'];
      $books_array[$i]['title'] = $row['title'];
      $books_array[$i]['publishing_year']=$row['publishing_year'];
      $books_array[$i]['price']=$row['price'];
      $books_array[$i]['language']=$row['language'];
      $author_id = $row['author_id'];
      $sql = "SELECT *  FROM authors WHERE author_id = '$author_id'";
      $result_author = mysqli_query($connect, $sql);
      while($row_author = $result_author -> fetch_assoc()) {
        $books_array[$i]['author_firstname'] = $row_author["firstname"];
        $books_array[$i]['author_lastname'] = $row_author["lastname"];
        $books_array[$i]['author_email'] = $row_author["email"];
        $books_array[$i]['author_phone'] = $row_author["phone"];
      }
      $category_id = $row['category_id'];
      $sql = "SELECT *  FROM category WHERE category_id = '$category_id'";
      $result_category = mysqli_query($connect, $sql);
      while($row_category = $result_category -> fetch_assoc()) {
        $books_array[$i]['category_name'] = $row_category["name"];
      }
      $publisher_id = $row['publisher_id'];
      $sql = "SELECT *  FROM publisher WHERE publisher_id = '$publisher_id'";
      $result_publisher = mysqli_query($connect, $sql);
      while($row_publisher = $result_publisher -> fetch_assoc()) {
        $books_array[$i]['publisher_name'] = $row_publisher["publiser_name"];
        $books_array[$i]['publisher_email'] = $row_publisher["publiser_email"];
        $books_array[$i]['publisher_phone'] = $row_publisher["publiser_phone"];
      }
      $books_array[$i]['description']=$row['description'];
      $i++;
    }
  }
  if(isset($_POST['see_more'])) {
    $one_book = $_POST['one_book'];
    $_SESSION['one_book'] = $one_book;
    header("Location: links/one_book.php");
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
  <link href='https://fonts.googleapis.com/css?family=Qwitcher Grypen' rel='stylesheet'>
</head>
  <title>Acasă</title>
</head>
<body style="background-color: #e4e5e6;">
<?php
    if($user_id != 1){
      echo'<header>
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
                <li><a href="links/all_books.php">Cărți</a></li>';
                if($user_id == null){
                  echo '<li><a href="links/login.php">Conectare</a></li>';
                  }
                  else {
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
                <a href="index.php">
                  <img class="logo" src="Images/logo.png" alt="logo" style="width:120px; height:70px;">
                </a>
              </div>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
              <ul class="nav navbar-nav">
                <li><a href="index.php">Acasă</a></li>';
                  echo '<li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-users" aria-hidden="true"></i> Gestiuni <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                  <li><a href="links/books.php">Cărți</a></li>
                  <li><a href="links/authors.php">Autori</a></li>
                  <li><a href="links/categories.php">Categorii</a></li>
                  <li><a href="links/publishers.php">Edituri</a></li>
                  <li><a href="links/users.php">Utilizatori</a></li>
                  <li><a href="links/reservations.php">Rezervări</a></li>
                  </ul>
                    </li>';
                echo '<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user-circle-o" aria-hidden="true"></i> Profil <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                    <li><a href="links/profile.php">Vezi profil</a></li>
                    <li><a href="links/logout.php">Deconectare</a></li>
                    </ul>
                    </li>';
                echo '<li><a href="#footer">Contact</a></li>
                </ul>
            </div>
          </div>
        </nav>
      </header>';
    }
  ?>
  <?php
if ($user_id != 1) {
  echo '<div class="main-container">
          <h1>Descoperă lumi noi între paginile noastre</h1>
          <form action="" method="POST" class="search-bar">
          <button name="search_button" class="search-bar__button" type="submit">
          <i class="fa fa-search search-icon" style="border-right: 1px solid #888888; position:relative; padding-right:15px;"></i>
          </button>
          <input class="search-bar__bar" type="text" name="search" id="search"/>
          </form>
          <div class="row input-group-row">
  <div class="column input-column">
    <label for="price">Selectează prețul maxim:</label>
    <input type="number" class="form-control" name="price" value="">
  </div>
  <div class="column input-column">
    <label for="age">Selectează vârsta maximă:</label>
    <input type="number" class="form-control" name="age" value="">
  </div>
  <div class="column input-column">
    <label for="category">Selectează o categorie existentă:</label>
    <select name="category">
      <option value=""></option>
          ';
        $sql = mysqli_query($connect, "SELECT category_id FROM category");
            $i = 0;
            $cat_id = array();
            while ($row = $sql->fetch_assoc()){
              $cat_id[$i] = $row['category_id'];
              $i++;
            }
            $count = count($cat_id);
            for($i = 0; $i < $count; $i++){
              $sql = mysqli_query($connect, "SELECT name FROM category WHERE category_id = '$cat_id[$i]'");
              while ($row = $sql->fetch_assoc()){
                $name = $row['name'];
                echo '<option name = "'.$name.'" value="'.$name.' ">' . $name.'</option>';
              }
            }
            echo "</select>";
            echo "</div>";
            echo "</div>";
            if ($books_array != null) {
              $count = count($books_array);
              for ($j = 0; $j < $count; $j++) {
                  $title = $books_array[$j]['title'];
                  $book_id = $books_array[$j]['book_id'];
          
                  // Opening the form and container div
                  echo "<form action='' method='POST'>";
                  echo "<div class=container style='background-color:grey;'>";
          
                  // Output the book title within a <p> tag
          
                  // Use a hidden input to store the book_id value
                  echo "<input type='hidden' name='one_book' value='$book_id' />";
          
                  // Closing the container div
                  echo "</div>";
          
                  // Submit button (a button within a form should be of type 'submit')
                  echo "<button name='see_more' class='search-bar__button' type='submit'>Cartea ta te așteaptă aici</button>";
          
                  // Close the form
                  echo "</form>";
          
                  // Adding line breaks
                  echo "<br><br>";
              }
          }
          echo '<img class="corner-image" src="Images/fundal.png">';
          echo "</div>";
}elseif($user_id == 1){
  $sql_authors = "SELECT COUNT(*) as author_count FROM authors";
  $sql_users = "SELECT COUNT(*) as users_count FROM users";
  $sql_publishers = "SELECT COUNT(*) as publisher_count FROM publisher";
  $sql_books = "SELECT COUNT(*) as book_count FROM books";
  

  $result_authors = mysqli_query($connect, $sql_authors);
  $result_users = mysqli_query($connect, $sql_users);
  $result_publishers = mysqli_query($connect, $sql_publishers);
  $result_books = mysqli_query($connect, $sql_books);
  

  $row_authors = $result_authors->fetch_assoc();
  $row_users = $result_users->fetch_assoc();
  $row_publishers = $result_publishers->fetch_assoc();
  $row_books = $result_books->fetch_assoc();

  $authors_number = $row_authors['author_count'];
  $users_number = $row_users['users_count'];
  $publisher_number = $row_publishers['publisher_count'];
  $book_number = $row_books['book_count'];
echo '<div class="container">';
echo '  <div class="row justify-content-center">';
echo '    <div class="col-md-12 text-center" style="margin-top:50px; margin-bottom:50px;">';
echo '      <h2>Statistici ale bazei de date</h2>';
echo '    </div>';
echo '  </div>';
echo '  <div class="row text-center" style="padding-left:65px;">';

// Iterați prin fiecare categorie și afișați coloanele cu butoane de detalii
$categories = array(
    array("Numărul total de autori", $authors_number, "links/authors.php"),
    array("Numărul total de utilizatori", $users_number, "links/users.php"),
    array("Numărul total de edituri", $publisher_number, "links/publishers.php"),
    array("Numărul total de cărți", $book_number, "links/books.php")
);

foreach ($categories as $category) {
    echo '<div class="col-sm-4" style=" width: 23%; padding: 10px; height: 250px; background-color:#fff; margin: 5px 5px 5px 5px; padding:25px 25px 25px 25px; box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16); -moz-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16); -webkit-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);border-radius: 5px;">';
    echo '  <p style="font-size:17px;"><i class="fa fa-address-book" aria-hidden="true" style="margin-right:12px;"></i>' . $category[0] . '<br><br><p class="category-number">' . $category[1] . '</p>';
    echo '  <a href="' . $category[2] . '" class="btn btn-transparent">Detalii</a>'; // Adăugați butonul de detalii cu link-ul corespunzător
    echo '</div>';
}

echo '  </div>';
echo '</div>';

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
.category-number {
    font-size: 30px; /* Ajustează mărimea fontului după preferințele tale */
    color: #333; /* Schimbă culoarea textului la gri */
}
.btn-transparent {
    color: #333;
    background-color: transparent;
    border: 2px solid #D0D0D0;
    border-radius: 5px;
    transition: background-color 0.3s, color 0.3s;
    margin-top:60px;
    width:100%;
}

.btn-transparent:hover {
    background-color: #D0D0D0;
    color: #333;
    text-decoration: none;
}
.input-group-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 1000px;
  margin-top: 20px;
}

.input-column {
  flex: 1;
  background-color: #e4e5e6;
  padding: 10px;
  border-radius: 5px;
  margin-right: 10px;
}

.input-column:last-child {
  margin-right: 0; /* Elimină marginul dreapta pentru ultimul element */
}

.input-column label {
  display: block;
  font-size: 14px;
  color: #606060;
  margin-bottom: 5px;
}

.input-column select,
.input-column input {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  color: #D0D0D0;
}
/* Eliminarea culorii albastre la focus pe câmpurile de selectie și input */
.input-column select:focus,
.input-column input:focus {
  outline: none; /* Elimină conturul la focus */
  box-shadow: none; /* Elimină umbra la focus */
}
/* Eliminarea conturului albastru la focus pe câmpurile de selectie și input */
.input-column select:focus,
.input-column input:focus {
  outline: none;
  box-shadow: none;
  border-color: #ccc; /* Setează culoarea dorită pentru bordură */
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
  .main-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
}

/* Adăugarea regulii pentru poziționarea footer-ului */
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
h1 {
    font-size: 70px;
    font-weight: 200;
    font-family: 'Qwitcher Grypen', cursive;
}
/* Stilizare pentru câmpul de căutare */
.search-bar {
    display: flex;
    align-items: center;
    background-color: #D0D0D0;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 5px;
    margin-right: 10px;
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
.corner-image {
      position: absolute;
      width: 700px;
      min-width: 200px;
      left: -5px;
    }
.main-container .corner-image {
    margin-top: 155px; /* Eliminăm margin-top */
    bottom: auto; /* Eliminăm poziționarea "bottom" */
    top: 100%; /* Plasăm imaginea deasupra footer-ului */
    transform: translateY(-100%); /* Plasăm imaginea în zona de vizibilitate */
  } 
.input-group-row {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  margin-bottom: 10px; /* Spațiu între grupurile de input-uri */
  margin-top:50px;
  width: 1100px;
  text-align: center;
}

.input-group {
  flex: 1;
  margin-right: 10px;
   /* Spațiu între input-uri */
}

.input-group label,
.input-group input,
.input-group select {
  display: block;
  margin-bottom: 5px;
}
input:focus {
    outline: none;
} 
.input-group{
    margin-bottom: 20px;
    cursor: pointer;
    min-height: 35px;
    }
    .email-group {
    display: flex;
    align-items: center;}
    .input-group.email-group {
  margin-bottom: 20px;
}

.input-group.email-group label {
  display: block;
  margin-bottom: 5px;
  font-size:14px;
  color: #404040; 
  margin-right:10px;
}

.input-group.email-group select {
  width: 500%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  color: #666; /* Lighter font color */
}
@media only screen and (max-width: 767px) {
    /* Adjust font size for smaller screens */
    h1 {
      font-size: 40px;
    }

    /* Center-align search bar elements */
    .search-bar {
      justify-content: center;
      margin-top: 10px;
      margin-bottom: 20px;
    }

    /* Adjust input column widths for better layout */
    .input-group-row {
      flex-direction: column;
      width: auto;
      margin-top: 10px;
    }

    .input-column {
      width: 100%;
      margin-right: 0;
      margin-bottom: 10px;
    }

    /* Reduce padding for navbar items */
    .navbar-nav>li>a {
      padding: 15px 20px;
      font-size: 14px;
      margin-top: 0;
    }

    /* Adjust corner image size */
    .corner-image {
      width: 200px;
      min-width: auto;
      max-width: 100%;
      margin-top: 10px;
    }
  }

  /* Add more media query adjustments for other breakpoints */
  @media only screen and (max-width: 479px) {
    /* Example adjustments for even smaller screens */
    h1 {
      font-size: 30px;
    }

    /* ... */
  }
</style>
</body>
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