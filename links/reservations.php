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
  <title>Rezervări</title>
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
</header>
</body>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reservations</title>
</head>
<body>

</body>
</html>
