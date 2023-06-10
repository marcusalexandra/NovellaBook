<?php
  include '../conn.php';
  error_reporting(0);
  session_start();
  $user_id = "";
  $user_id = $_SESSION['user_id'];
  $book_id = $_SESSION['one_book'];
    $sql = "SELECT * FROM books WHERE book_id = '$book_id'";
    $result = mysqli_query($connect, $sql);
    $books_array = array();
    while ($row = $result->fetch_assoc()){
      $books_array['title'] = $row['title'];
      $books_array['publishing_year']=$row['publishing_year'];
      $books_array['copies'] = $row['copies'];
      $books_array['price']=$row['price'];
      $books_array['language']=$row['language'];
      $author_id = $row['author_id'];
      $sql = "SELECT *  FROM authors WHERE author_id = '$author_id'";
      $result_author = mysqli_query($connect, $sql);
      while($row_author = $result_author -> fetch_assoc()) {
        $books_array['author_firstname'] = $row_author["firstname"];
        $books_array['author_lastname'] = $row_author["lastname"];
        $books_array['author_email'] = $row_author["email"];
        $books_array['author_phone'] = $row_author["phone"];
      }
      $category_id = $row['category_id'];
      $sql = "SELECT *  FROM category WHERE category_id = '$category_id'";
      $result_category = mysqli_query($connect, $sql);
      while($row_category = $result_category -> fetch_assoc()) {
        $books_array['category_name'] = $row_category["name"];
      }
      $publisher_id = $row['publisher_id'];
      $sql = "SELECT *  FROM publisher WHERE publisher_id = '$publisher_id'";
      $result_publisher = mysqli_query($connect, $sql);
      while($row_publisher = $result_publisher -> fetch_assoc()) {
        $books_array['publisher_name'] = $row_publisher["name"];
        $books_array['publisher_email'] = $row_publisher["email"];
        $books_array['publisher_phone'] = $row_publisher["phone"];
      }
      $books_array['description']=$row['description'];
    }
    $copies_initial = $books_array['copies'];
    if(isset($_POST['reserve'])){
      $reserv_date = date("Y-m-d");
      $return_date = date('Y-m-d', strtotime($reserv_date. ' + 30 days'));
      $sql = "INSERT INTO reservations (reservation_date, return_date, user_id, book_id)
              VALUES ('$reserv_date', '$return_date', '$user_id', '$book_id')";
      $reserv_date = "";
      $return_date = "";
      mysqli_query($connect,$sql);
      $copies = $books_array['copies']-1;
      header("Refresh:0");
      $sql = "UPDATE books SET copies = '$copies' WHERE book_id = '$book_id'";
      mysqli_query($connect,$sql);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
</head>
<body>
<header>
	<nav>
		<ul class="navbar__links">
			<li><a href="../index.php">Acasă</a></li>
      <?php
       if($user_id == null){
          echo '<li><a href="login.php">Rezervări</a></li>
                <li><a href="login.php">Profil</a></li>
                <li><a href="login.php">Conectare</a></li>';
        }
        else {
          if($user_id == 1) {
            echo '<li><a href="books.php">Cărți</a></li>
                  <li><a href="book.php">Adaugă carte</a></li>
                  <li><a href="authors_publications.php">Autori și publicații</a></li>
                  <li><a href="users.php">Utilizatori</a></li>';

          }
          echo '<li><a href="reservations.php">Rezervări</a></li>
                <li><a href="profile.php">Profil</a></li>
                <li><a href="logout.php">Deconectare</a></li>';
        }
        ?>
			<li><a href="#footer">Contact</a></li>
		</ul>
	</nav>
        <?php
        $title = $books_array['title'];
        echo "<div style= 'background-color:blue;'><p>$title</p></div>";
        ?>
        <?php
        if($copies_initial >= 1){
          echo "<form action='' method ='POST' >
          <button name='reserve' class='search-bar__button' type='submit'>Rezerva</button>
          </form>";
        }
        else{
          echo "Nu mai sunt carti disponibile";
        }

        ?>

</header>
</body>
</html>
