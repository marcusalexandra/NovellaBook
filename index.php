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
                <li><a href="links/profile.php">Profil</a></li>
                <li><a href="links/logout.php">Deconectare</a></li>';
              }
              ?>
              <li><a href="#footer">Contact</a></li>
            </ul>
        </div>
      </div>
    </nav>
  </header>
  <?php
if ($user_id == null) {
  echo '<div class="main">
          <h1>Descoperă lumi noi între paginile noastre</h1>
          <form action="" method="POST" class="search-bar">
          <input class="search-bar__bar" type="text" name="search" id="search" />
          <button name="search_button" class="search-bar__button" type="submit"><i class="fa fa-search search-icon"></i></button>
          </form>
          <div class="input-group">
            <label for="publisher">Selectează prețul maxim:</label>
            <input type="number" placeholder="Preț" name="price" value="">
          </div>
          <div class="input-group">
            <label for="publisher">Selectează vârsta maximă:</label>
            <input type="number" placeholder="Vârstă" name="age" value="">
          </div>';
          echo "<div class='input-group'>
                <label for='category'>Selectează o categorie existentă:</label>
                <select name='category' >
                <option name = 'NULL' value = ''></option>";
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
            if ($books_array != null) {
              $count = count($books_array);
              for ($j = 0; $j < $count; $j++) {
                  $title = $books_array[$j]['title'];
                  $book_id = $books_array[$j]['book_id'];
          
                  // Opening the form and container div
                  echo "<form action='' method='POST'>";
                  echo "<div class=container style='background-color:grey;'>";
          
                  // Output the book title within a <p> tag
                  echo "<p>$title</p>";
          
                  // Use a hidden input to store the book_id value
                  echo "<input type='hidden' name='one_book' value='$book_id' />";
          
                  // Closing the container div
                  echo "</div>";
          
                  // Submit button (a button within a form should be of type 'submit')
                  echo "<button name='see_more' class='search-bar__button' type='submit'>See More</button>";
          
                  // Close the form
                  echo "</form>";
          
                  // Adding line breaks
                  echo "<br><br>";
              }
          }
          echo '<img class=corner-image src="Images/home_ill.svg">';
          echo "</div>";
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
  .main {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    padding-top: 15px;
    height: 95px;
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

.search-icon {
  font-size: 20px;
  margin-right: 10px;
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

.search-bar__button {
  background-color: #D0D0D0;
  border: none;
  border-radius: 5px;
  color: #fff;
  cursor: pointer;
  padding: 6px 12px;
  font-size: 16px;
}

.search-bar__button i {
  font-weight: lighter;
  font-size: 20px;
  position: relative;
  float: left;
}
.corner-image {
    position: absolute;
    max-width: 700px;
    min-width: 300px;
    width: 25vw;
    bottom: 0;
    left: 0;
}
</style>
</body>
<footer id="footer">
  <p>ana</p>
</footer>
      
</html>
