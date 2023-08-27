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

  $sql = "SELECT a.title, a.publishing_year, a.price, a.pages, a.author_id, a.category_id, a.age, a.book_picture, au.firstname AS firstname, au.lastname AS lastname, c.name AS name
        FROM books a JOIN authors au ON a.author_id = au.author_id JOIN category c ON a.category_id = c.category_id
        LIMIT $offset, $booksPerPage";
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
    $i++;
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
                <li><a href="logout.php">Deconectare</a></li>
                <li><a href="all_books.php">Toate cărțile</a></li>';
        }
        ?>
			<li><a href="#footer">Contact</a></li>
		</ul>
	</nav>
</header>
</body>
  <?php
  for ($i = 0; $i < count($books_array); $i++) {
    echo '<div>';
    echo '<h2>' . $books_array[$i]['title'] . '</h2>';
    echo '<p>Publishing Year: ' . $books_array[$i]['publishing_year'] . '</p>';
    echo '<p>Price: ' . $books_array[$i]['price'] . '</p>';
    echo '<p>Pages: ' . $books_array[$i]['pages'] . '</p>';
    echo '<p>Author: ' . $books_array[$i]['author_firstname'] . ' ' . $books_array[$i]['author_lastname'] . '</p>';
    echo '<p>Category: ' . $books_array[$i]['name'] . '</p>';
    echo '<p>Age: ' . $books_array[$i]['age'] . '</p>';
    echo '<img src="' . $books_array[$i]['book_picture'] . '" alt="' . $books_array[$i]['title'] . '">';
    echo '</div>';
  }
  ?>
  <div class="pagination">
        <?php
        for ($page = 1; $page <= $totalPages; $page++) {
            echo '<a href="?page=' . $page . '">' . $page . '</a>';
        }
        ?>
    </div>
</html>