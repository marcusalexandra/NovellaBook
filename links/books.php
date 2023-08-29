<?php
  include '../conn.php';
  error_reporting(0);
  session_start();
  $user_id = "";
  $user_id = $_SESSION['user_id'];
  if(isset($_POST['search_button'])) {
    $search = $_POST['search'];
    $sql = "SELECT * FROM books
    LEFT JOIN authors ON books.author_id = authors.author_id
    LEFT JOIN category ON category.category_id = books.category_id
    LEFT JOIN publisher ON publisher.publisher_id = books.publisher_id
    WHERE title RLIKE('$search')";
    $result = mysqli_query($connect, $sql);
    $book = array();
    $i = 0;
    while ($row = $result->fetch_assoc()){
              $book[$i]['book_id']= $row['book_id'];
              $book[$i]['title']= $row['title'];
              $book[$i]['publishing_year']= $row['publishing_year'];
              $book[$i]['price']= $row['price'];
              $book[$i]['language']= $row['language'];
              $book[$i]['email']= $row['email'];
              $book[$i]['firstname']= $row['firstname'];
              $book[$i]['lastname']= $row['lastname'];
              $book[$i]['author_phone']= $row['phone'];
              $book[$i]['category_name']= $row['name'];
              $book[$i]['publisher_email']= $row['publisher_email'];
              $book[$i]['publisher_name']= $row['publisher_name'];
              $book[$i]['publisher_phone']= $row['publisher_phone'];
              $i++;
            }
  }
  if(isset($_POST['delete'])) {
    $book_delete = $_POST['book_delete'];
    $sql = "DELETE FROM books WHERE book_id = '$book_delete'";
    $result = mysqli_query($connect, $sql);
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cărți</title>
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
        <input class="search-bar__bar" type="text" placeholder="Search..." name="search" id="search" />
		  	<button name="search_button" class="search-bar__button" type="submit">
          <i class="fa fa-search"></i>
        </button>
      </form>
      <?php
      if ($book != null) {
    $count = count($book);
    for ($j = 0; $j < $count; $j++) {
        $book_id = $book[$j]['book_id'];
        $title = $book[$j]['title'];
        $publishing_year = $book[$j]['publishing_year'];
        $price = $book[$j]['price'];
        $language = $book[$j]['language'];
        $email = $book[$j]['email'];
        $firstname = $book[$j]['firstname'];
        $lastname = $book[$j]['lastname'];
        $author_phone = $book[$j]['author_phone'];
        $category_name = $book[$j]['category_name'];
        $publisher_email = $book[$j]['publisher_email'];
        $publisher_name = $book[$j]['publisher_name'];
        $publisher_phone = $book[$j]['publisher_phone'];

        // Opening the form and container div
        echo "<form action='' method='POST'>";
        echo "<div class=container style='background-color:gray;'>";

        // Output the user information within a <p> tag
        echo "<p>$title</p>";
        echo "<p>$publishing_year</p>";
        echo "<p>$price</p>";
        echo "<p>$language</p>";
        echo "<p>$email</p>";
        echo "<p>$firstname</p>";
        echo "<p>$lastname</p>";
        echo "<p>$author_phone</p>";
        echo "<p>$category_name</p>";
        echo "<p>$publisher_email</p>";
        echo "<p>$publisher_name</p>";
        echo "<p>$publisher_phone</p>";

        // Use a hidden input to store the user_id value
        echo "<input type='hidden' name='book_delete' value='$book_id' />";

        // Closing the container div
        echo "</div>";

        // Submit button (a button within a form should be of type 'submit')
        echo "<button name='delete' class='search-bar__button' type='submit'>Delete</button>";

        // Close the form
        echo "</form>";

        // Adding line breaks
        echo "<br><br>";
    }
  }
?>
<?php
  if ($book != null) {
    echo '<table border="1" cellpadding="5" cellspacing="0">
      <tr>
        <th>Titlu</th>
        <th>Anul Publicării</th>
        <th>Preț</th>
        <th>Limbă</th>
        <th>Email Autor</th>
        <th>Prenume Autor</th>
        <th>Nume Autor</th>
        <th>Telefon Autor</th>
        <th>Categorie</th>
        <th>Email Editor</th>
        <th>Nume Editor</th>
        <th>Telefon Editor</th>
        <th>Acțiuni</th>
      </tr>';

    $count = count($book);
    for ($j = 0; $j < $count; $j++) {
      // ... Restul codului

      // Output the table rows
      echo "<tr>
        <td>$title</td>
        <td>$publishing_year</td>
        <td>$price</td>
        <td>$language</td>
        <td>$email</td>
        <td>$firstname</td>
        <td>$lastname</td>
        <td>$author_phone</td>
        <td>$category_name</td>
        <td>$publisher_email</td>
        <td>$publisher_name</td>
        <td>$publisher_phone</td>
        <td>
          <!-- Adaugă un buton de ștergere pentru fiecare carte -->
          <form action='' method='POST'>
            <input type='hidden' name='book_delete' value='$book_id' />
            <button name='delete' class='search-bar__button' type='submit'>Delete</button>
          </form>
          <form action='edit_book.php' method='GET'>
            <input type='hidden' name='book_id' value='$book_id' />
            <button class='search-bar__button' type='submit'>Editează</button>
          </form>
        </td>
      </tr>";
    }

    echo '</table>';
  }
  ?>
  <div>
    <form action='book.php' method='GET'>
      <button class='search-bar__button' type='submit'>Adaugă o carte</button>
    </form>
  </div>
</body>
</html>
