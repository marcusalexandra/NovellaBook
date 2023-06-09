<?php
  include 'conn.php';
  error_reporting(0);
  session_start();
  $user_id = "";
  $user_id = $_SESSION['user_id'];
  if(isset($_POST['search_button'])) {
    $search = $_POST['search'];
    $sql = "SELECT * FROM books WHERE title RLIKE('$search')";
    $result = mysqli_query($connect, $sql);
    $i = 0;
    $books_array = array();
    while ($row = $result->fetch_assoc()){
      $books_array[$i]['book_id'] = $row['book_id'];
      $books_array[$i]['title'] = $row['title'];
      $books_array[$i]['publishing_year']=$row['publishing_year'];
      $books_array[$i]['copies'] = $row['copies'];
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
        $books_array[$i]['publisher_name'] = $row_publisher["name"];
        $books_array[$i]['publisher_email'] = $row_publisher["email"];
        $books_array[$i]['publisher_phone'] = $row_publisher["phone"];
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
  <link rel="stylesheet" href="CSS/style.css">
  <title>Home</title>
</head>
<body>
  <header id="main-menu">
	<nav class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
          <div class="logo-container">
            <a href="index.php" class="logo">
              <img id="logo" src="Images/novella_logo.png" width="200px" height="90px"  alt="Combs 'n' Fro Logo"/>
            </a>
          </div>
      </div>
    </div>
		<ul class="navbar__links">
			<li><a href="index.php">Acasă</a></li>
      <?php
      if($user_id == null){
          echo '<li><a href="links/login.php">Rezervări</a></li>
                <li><a href="links/login.php">Profil</a></li>
                <li><a href="links/login.php">Conectare</a></li>';
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
	</nav>
</header>
      <form action="" method="POST">
        <input class="search-bar__bar" type="text" placeholder="Search..." name="search" id="search" />
		  	<button name="search_button" class="search-bar__button" type="submit">
          <i class="fa fa-search"></i>
      </button>
      </form>
      <?php
      if($books_array != null){
        $count = count($books_array);
        for($j=0;$j<$count;$j++)
        {
          $title = $books_array[$j]['title'];
          $book_id = $books_array[$j]['book_id'];
          echo "<form action='' method='POST'><div class=container style='background-color:red;'><p>'$title'</p></div>";
          echo "<input type='hidden' name='one_book' value= '$book_id' />";
          echo "<button name='see_more' class='search-bar__button' type='submit'></form></div>
          <br>
          <br>";

        }

      }
      else {
      }
      ?>
</body>
</html>
