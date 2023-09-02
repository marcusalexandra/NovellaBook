<?php
include '../conn.php';
error_reporting(0);
session_start();
$user_id = "";
$user_id = $_SESSION['user_id'];

if (isset($_GET['book_id'])) {
    $book_id = mysqli_real_escape_string($connect, $_GET['book_id']);
    $sql = "SELECT * FROM books WHERE book_id = '$book_id'";
    $result = mysqli_query($connect, $sql);
    $bookData = mysqli_fetch_assoc($result);
}

if (isset($_POST['edit_books'])) {
    // Preiați datele introduse în formular
    $new_title = mysqli_real_escape_string($connect, $_POST['new_title']);
    $new_publishing_year = mysqli_real_escape_string($connect, $_POST['new_publishing_year']);
    $new_price = mysqli_real_escape_string($connect, $_POST['new_price']);
    $new_language = mysqli_real_escape_string($connect, $_POST['new_language']);

    // Actualizați datele în baza de date
    $sql = "UPDATE books SET title='$new_title', publishing_year='$new_publishing_year', price='$new_price', language='$new_language' WHERE book_id='$book_id'";
    $result = mysqli_query($connect, $sql);

    // Afișați un mesaj pop-up de succes
    echo "<script>alert('Schimbările au fost realizate cu succes!');</script>";

    // Actualizați datele cărții pentru a fi afișate în câmpurile de editare
    $bookData['title'] = $new_title;
    $bookData['publishing_year'] = $new_publishing_year;
    $bookData['price'] = $new_price;
    $bookData['language'] = $new_language;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <title>Editare Cărți</title>
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
<a href="all_books.php">
    <i class="fa fa-arrow-left" aria-hidden="true" style="padding:30px; position:relative; font-size:25px; color:#333;"></i>
</a>
<div class="container" style="padding-top:50px;padding-bottom:50px;">
    <table class="table" class="table table-bordered"
           style="background-color:#fff; text-align:center; box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16); -moz-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16); -webkit-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16); border-radius:5px;">
        <thead>
        <tr>
            <th style="text-align:center;">Titlu</th>
            <th style="text-align:center;">An publicare</th>
            <th style="text-align:center;">Preț</th>
            <th style="text-align:center;">Limba</th>
            <th style="text-align:center;">Editare</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <div class='container' style='display: flex; justify-content:center;'>
                <form action="" method="POST">
                    <td><input class="input-field" type="text" name="new_title" value="<?php echo $bookData['title']; ?>"></td>
                    <td><input class="input-field" type="text" name="new_publishing_year"
                               value="<?php echo $bookData['publishing_year']; ?>"></td>
                    <td><input class="input-field" type="text" name="new_price"
                               value="<?php echo $bookData['price']; ?>"></td>
                    <td><input class="input-field" type="text" name="new_language"
                               value="<?php echo $bookData['language']; ?>"></td>
                    <td>
                        <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                        <button name="edit_books" class="btn" type="submit"><i class="fa fa-check" aria-hidden="true"
                                                                              style="margin-right:10px;"></i>Salvare
                        </button>
                    </td>
                </form>
            </div>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
