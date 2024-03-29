<?php
include '../conn.php';
error_reporting(0);
session_start();
$user_id = "";
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM books
        LEFT JOIN authors ON books.author_id = authors.author_id
        LEFT JOIN category ON category.category_id = books.category_id
        LEFT JOIN publisher ON publisher.publisher_id = books.publisher_id";

// Verificați dacă există un filtru de căutare
if (isset($_POST['search_button'])) {
    $search = mysqli_real_escape_string($connect, $_POST['search']);
    $sql .= " WHERE title LIKE '%$search%'";
}

$result = mysqli_query($connect, $sql);
$books = array();
$i = 0;

while ($row = $result->fetch_assoc()) {
    $books[$i]['book_id'] = $row['book_id'];
    $books[$i]['title'] = $row['title'];
    $books[$i]['publishing_year'] = $row['publishing_year'];
    $books[$i]['price'] = $row['price'];
    $books[$i]['language'] = $row['language'];
    $books[$i]['firstname'] = $row['firstname'];
    $books[$i]['lastname'] = $row['lastname'];
    $books[$i]['email'] = $row['email'];
    $books[$i]['category_name'] = $row['name'];
    $books[$i]['publisher_name'] = $row['publisher_name'];
    $books[$i]['publisher_email'] = $row['publisher_email'];
    $books[$i]['publisher_phone'] = $row['publisher_phone'];
    $books[$i]['book_picture'] = $row['book_picture']; // Adăugați imaginea din baza de date
    $i++;
}
if(isset($_POST['edit_books'])) {
  $book_edit = mysqli_real_escape_string($connect, $_POST['book_edit']);
  // Redirect to the edit_author.php page with the author_id as a parameter
  header("Location: edit_books.php?author_id=$book_edit");
  exit();
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
  <title>Cărți</title>
</head>
<body style="background-color: #e4e5e6;">
<?php
if ($user_id != 1) {
    echo '<header>
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
    if ($user_id == null) {
        echo '<li><a href="login.php">Conectare</a></li>';
    } else {
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
} elseif ($user_id == 1) {
    //header nou
    echo '<header>
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
                <li><a href="../index.php">Acasă</a></li>';
    echo '<li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-users" aria-hidden="true"></i> Gestiuni <span class="caret"></span></a>
                <ul class="dropdown-menu">
                <li><a href="books.php">Cărți</a></li>
                <li><a href="authors.php">Autori</a></li>
                <li><a href="categories.php">Categorii</a></li>
                <li><a href="publishers.php">Publicații</a></li>
                <li><a href="users.php">Utilizatori</a></li>
                <li><a href="reservations.php">Rezervări</a></li>
                </ul>
                  </li>';
    echo '<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user-circle-o" aria-hidden="true"></i> Profil <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                    <li><a href="profile.php">Vezi profil</a></li>
                    <li><a href="logout.php">Deconectare</a></li>
                    </ul>
                    </li>';
    echo '
                </ul>
            </div>
          </div>
        </nav>
      </header>';
}
?>
<div class="container" style="padding-top:50px;padding-bottom:50px;">
<form action="" method="POST" class="search-bar" style="width:600px; margin-bottom:50px;margin-left:350px;">
        <button name="search_button_authors" class="search-bar__button" type="submit">
            <i class="fa fa-search search-icon" style="border-right: 1px solid #888888; position:relative; padding-right:15px;"></i>
        </button>
        <input class="search-bar__bar" type="text" name="search_authors" id="search_authors"/>
    </form>
    <table class="table table-bordered" style="background-color:#fff; text-align:center; box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16); -moz-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16); -webkit-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16); border-radius:5px;">
    <thead>
        <tr>
            <th style="text-align:center;">Imagine</th>
            <th style="text-align:center;">Titlu</th>
            <th style="text-align:center;">An Publicare</th>
            <th style="text-align:center;">Preț</th>
            <th style="text-align:center;">Limba</th>
            <th style="text-align:center;">Autor</th>
            <th style="text-align:center;">Categorie</th>
            <th style="text-align:center;">Editură</th>
            <th style="text-align:center;">Editare</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if (!empty($books)) {
      foreach ($books as $bookData) {
        
            $name = $bookData['title'];
            $publishing_year = $bookData['publishing_year'];
            $price = $bookData['price'];
            $language = $bookData['language'];
            $email = $bookData['email'];
            $firstname = $bookData['firstname'];
            $lastname = $bookData['lastname'];
            $author_phone = $bookData['author_phone'];
            $category_name = $bookData['category_name'];
            $publisher_email = $bookData['publisher_email'];
            $publisher_name = $bookData['publisher_name'];
            $publisher_phone = $bookData['publisher_phone'];
            $author_id = $bookData['author_id']; 
            // Calea către imaginele din directorul "Images"
            $image_path = '../Images/' . $bookData['book_picture'];

            echo "<tr>";
            echo "<td style='padding:15px 15px 15px 15px;'><img src='$image_path' alt='$name' style='max-width: 100px; max-height: 100px;'></td>";
            echo "<td style='padding:15px 15px 15px 15px;'>$name</td>";
            echo "<td style='padding:15px 15px 15px 15px;'>$publishing_year</td>";
            echo "<td style='padding:15px 15px 15px 15px;'>$price</td>";
            echo "<td style='padding:15px 15px 15px 15px;'>$language</td>";
            echo "<td style='padding:15px 15px 15px 15px;'>$firstname $lastname</td>";
            echo "<td style='padding:15px 15px 15px 15px;'>$category_name</td>";
            echo "<td style='padding:15px 15px 15px 15px;'>$publisher_name</td>";
            echo "<td style='padding:15px 15px 15px 15px;'>$publisher_email</td>";
            echo "<td style='padding:15px 15px 15px 15px;'>$publisher_phone</td>";
            echo "<td>";
            echo "<div class='container' style='display: flex; justify-content: center;'>"; // Am schimbat "justify-content" în "center" pentru a centra butoanele

            echo "<form action='delete_book.php' method='POST' style='margin-right: 10px;'>";
            echo "<input type='hidden' name='book_id' value='{$bookData['book_id']}' />";
            echo "<button name='delete_book' class='btn btn-danger' type='submit' style='display: flex; align-items: center;'>";
            echo "<i class='fa fa-trash' aria-hidden='true' style='margin-right: 5px;'></i> Șterge";
            echo "</button>";
            echo "</form>";

            echo "<form action='edit_authors.php' method='GET' style='margin-right: 10px;'>";
            echo "<input type='hidden' name='author_id' value='$author_id' />";
            echo "<button class='btn btn-primary' type='submit' style='display: flex; align-items: center;'>";
            echo "<i class='fa fa-pencil' aria-hidden='true' style='margin-right: 5px;'></i> Editează";
            echo "</button>";
            echo "</form>";

            echo "</div>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='9'>Niciun rezultat găsit.</td></tr>"; // Schimbat colspan de la 5 la 9 pentru a acoperi toate coloanele
    }
    ?>
</tbody>
</table>
<div style="display: flex; justify-content: center;">
    <form action='book.php' method='GET' style="margin-right: 10px; display: flex; align-items: center;">
        <button name="addsubmit" type='submit' class="btn" style="width:100%; background-color:#808080; color:#fff; font-size:18px; display: flex; align-items: center; justify-content: center;"><i class='fa fa-plus' aria-hidden='true' style='margin-right: 5px;'></i>Adaugă o carte</button>
    </form>
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
    width: 100%;
    top: 0;
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
    font-size: 16px;
    color: #333; /* Culoarea pentru text */
    background-color: #D0D0D0;
}

.search-bar__button i {
  font-size: 20px;
  color: #888888;
  font-weight: lighter;
}
input:focus {
    outline: none;
}
td img {
    max-height: 300px; /* sau orice altă valoare dorită */
    height: auto;
}

</style>
</body>
</html>
