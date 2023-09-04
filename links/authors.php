<?php
include '../conn.php';
error_reporting(0);
session_start();
$user_id = "";
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM authors"; // Selectează toți autorii din baza de date
$result = mysqli_query($connect, $sql);
$author = array();
$i = 0;
if(isset($_POST['search_button_authors'])) {
    $search_query = mysqli_real_escape_string($connect, $_POST['search_authors']);
    $sql = "SELECT * FROM authors WHERE firstname LIKE '%$search_query%' OR lastname LIKE '%$search_query%'";
    $result = mysqli_query($connect, $sql);
    $author = array();
    $i = 0;
    while ($row = $result->fetch_assoc()){
        $author[$i]['author_id'] = $row['author_id'];
        $author[$i]['firstname'] = $row['firstname'];
        $author[$i]['lastname'] = $row['lastname'];
        $author[$i]['email'] = $row['email'];
        $author[$i]['phone'] = $row['phone'];
        $i++;
    }
}
while ($row = $result->fetch_assoc()){
    $author[$i]['author_id'] = $row['author_id'];
    $author[$i]['firstname'] = $row['firstname'];
    $author[$i]['lastname'] = $row['lastname'];
    $author[$i]['email'] = $row['email'];
    $author[$i]['phone'] = $row['phone'];
    $i++;
}
if(isset($_POST['delete_authors'])) {
    $author_delete = mysqli_real_escape_string($connect, $_POST['author_delete']);
    $sql = "SELECT book_id FROM books WHERE author_id = $author_delete";
    $result = mysqli_query($connect, $sql);
    $book = array();
    $i = 0;
    while ($row = $result->fetch_assoc()){
        $book[$i]['book_id'] = $row['book_id'];
        $i++;
    }
    foreach ($book as $bookData) {
        $book_id = $bookData['book_id'];
        $sql = "DELETE FROM reservations WHERE book_id = $book_id";
        $result = mysqli_query($connect, $sql);
    }
    foreach ($book as $bookData) {
        $book_id = $bookData['book_id'];
        $sql = "DELETE FROM reviews WHERE book_id = $book_id";
        $result = mysqli_query($connect, $sql);
    }
    $sql = "DELETE FROM books WHERE author_id = $author_delete";
    $result = mysqli_query($connect, $sql);
    $sql = "DELETE FROM authors WHERE author_id = $author_delete";
    $result = mysqli_query($connect, $sql);
    header("Refresh:0");
}

if(isset($_POST['edit_authors'])) {
    $author_edit = mysqli_real_escape_string($connect, $_POST['author_edit']);
    // Redirect to the edit_author.php page with the author_id as a parameter
    header("Location: edit_authors.php?author_id=$author_edit");
    exit();
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
    <title>Autori</title>
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
    }elseif($user_id == 1){
      //header nou
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
    <table class="table table-bordered" style="background-color:#fff; text-align:center; box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16); -moz-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16); -webkit-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16); border-radius:5px;"> <!-- Adauga clasa 'table-bordered' pentru a afisa o bordura la celulele tabelului -->
        <thead>
        <tr>
            <th style="text-align:center;">Prenume</th>
            <th style="text-align:center;">Nume</th>
            <th style="text-align:center;">Email</th>
            <th style="text-align:center;">Număr telefon</th>
            <th style="text-align:center; width:25%;">Editare</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($author)) {
            foreach ($author as $authorData)  {
                $firstname = $authorData['firstname'];
                $lastname = $authorData['lastname'];
                $email = $authorData['email'];
                $phone = $authorData['phone'];
                $author_id = $authorData['author_id'];

                echo "<tr>";
                echo "<td style='padding:15px 15px 15px 15px;'>$firstname</td>";
                echo "<td style='padding:15px 15px 15px 15px;'>$lastname</td>";
                echo "<td style='padding:15px 15px 15px 15px;'>$email</td>";
                echo "<td style='padding:15px 15px 15px 15px;'>$phone</td>";

                echo "<td>";
                echo "<div class='container' style='display: flex; justify-content:center;'>";

echo "<form action='' method='POST' style='margin-right: 10px;'>";
echo "<input type='hidden' name='author_delete' value='$author_id' />";
echo "<button name='delete_authors' class='btn btn-danger' type='submit' style='display: flex; align-items: center;'>";
echo "<i class='fa fa-trash' aria-hidden='true' style='margin-right: 5px;'></i> Șterge";
echo "</button>";
echo "</form>";

                echo "<form action='edit_authors.php' method='GET' style='margin-right: 10px;'>";
                echo "<input type='hidden' name='author_id' value='{$author_id}' />";
                echo "<button class='btn btn-primary' type='submit' style='display: flex; align-items: center;'>";
                echo "<i class='fa fa-pencil' aria-hidden='true' style='margin-right: 5px;'></i> Editează";
                echo "</button>";
                echo "</form>";

                echo "</div>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No results found.</td></tr>";
        }
        ?>
        </tbody>
    </table>
    <div style="display: flex; justify-content: center;">
    <form action='authors_publications.php' method='GET' style="margin-right: 10px; display: flex; align-items: center;">
        <button name="addsubmit" type='submit' class="btn" style="width:100%; background-color:#808080; color:#fff; font-size:18px; display: flex; align-items: center; justify-content: center;"><i class='fa fa-plus' aria-hidden='true' style='margin-right: 5px;'></i>Adaugă un autor</button>
    </form>
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
</style>
</body>
</html>
