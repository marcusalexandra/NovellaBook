<?php
include '../conn.php';
  error_reporting(0);
  session_start();
  $user_id = "";
  $user_id = $_SESSION['user_id'];
  if(isset($_POST['search_button_publisher'])) {
    $search_publisher = $_POST['search_publisher'];
    $sql = "SELECT * FROM publisher WHERE publisher_name RLIKE('$search_publisher') ";
    $result = mysqli_query($connect, $sql);
    $publisher = array();
    $i = 0;
    while ($row = $result->fetch_assoc()){
              $publisher[$i]['publisher_id']= $row['publisher_id'];
              $publisher[$i]['publisher_name']= $row['publisher_name'];
              $publisher[$i]['publisher_email']= $row['publisher_email'];
              $publisher[$i]['publisher_phone']= $row['publisher_phone'];
              $i++;
            }
  }
  if(isset($_POST['publisher_delete'])) {
    $publishers_delete = $_POST['publishers_delete'];
    $sql = "SELECT book_id FROM books WHERE publisher_id = '$publishers_delete'";
    $result = mysqli_query($connect, $sql);
    while ($row = $result->fetch_assoc()){
        $books[$i]['book_id']= $row['book_id'];
        $i++;
      }
    foreach ($books as $booksData) {
        $books_id = $booksData['book_id'];
        $sql = "DELETE FROM reservations WHERE book_id = $books_id";
        $result = mysqli_query($connect, $sql);
    }
    foreach ($books as $booksData) {
        $books_id = $booksData['book_id'];
        $sql = "DELETE FROM reviews WHERE book_id = $books_id";
        $result = mysqli_query($connect, $sql);
    }
    $sql = "DELETE FROM books WHERE publisher_id = $publishers_delete";
    $result = mysqli_query($connect, $sql);
    $sql = "DELETE FROM publisher WHERE publisher_id = $publishers_delete";
    $result = mysqli_query($connect, $sql);
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
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
</header>
      <form action="" method="POST">
        <input class="search-bar__bar" type="text" placeholder="Search..." name="search_publisher" id="search_publisher" />
		  	<button name="search_button_publisher" class="search-bar__button" type="submit">
          <i class="fa fa-search"></i>
        </button>
      </form>
    <table border="1">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($publisher)) {
            foreach ($publisher as $publisherData) {
                $name = $publisherData['publisher_name'];
                $email = $publisherData['publisher_email'];
                $phone = $publisherData['publisher_phone'];
                $publisher_id = $publisherData['publisher_id'];

                echo "<tr>";
                echo "<td>$name</td>";
                echo "<td>$email</td>";
                echo "<td>$phone</td>";

                // Opening the form and container div
                echo "<td><form action='' method='POST'>";
                echo "<div class='container' style='background-color: gray;'>";

                // Use a hidden input to store the user_id value
                echo "<input type='hidden' name='publishers_delete' value='$publisher_id' />";

                // Submit button (a button within a form should be of type 'submit')
                echo "<button name='publisher_delete' class='search-bar__button' type='submit'>Delete</button>";

                // Close the form
                echo "</form></div></td>";

                // Close the table row
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No results found.</td></tr>";
        }
        ?>
    </tbody>
</table>
</body>
</html>