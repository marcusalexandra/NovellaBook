<?php
include '../conn.php';
error_reporting(0);
session_start();
$user_id = "";
$user_id = $_SESSION['user_id'];

if(isset($_GET['author_id'])) {
    $author_id = mysqli_real_escape_string($connect, $_GET['author_id']);
    $sql = "SELECT * FROM authors WHERE author_id = '$author_id'";
    $result = mysqli_query($connect, $sql);
    $authorData = mysqli_fetch_assoc($result);
}

if(isset($_POST['edit_authors'])) {
    // Preiați datele introduse în formular
    $new_firstname = mysqli_real_escape_string($connect, $_POST['new_firstname']);
    $new_lastname = mysqli_real_escape_string($connect, $_POST['new_lastname']);
    $new_email = mysqli_real_escape_string($connect, $_POST['new_email']);
    $new_phone = mysqli_real_escape_string($connect, $_POST['new_phone']);

    // Actualizați datele în baza de date
    $sql = "UPDATE authors SET firstname='$new_firstname', lastname='$new_lastname', email='$new_email', phone='$new_phone' WHERE author_id='$author_id'";
    $result = mysqli_query($connect, $sql);

    // Afișați un mesaj pop-up de succes
    echo "<script>alert('Schimbările au fost realizate cu succes!');</script>";

    // Actualizați datele autorului pentru a fi afișate în câmpurile de editare
    $authorData['firstname'] = $new_firstname;
    $authorData['lastname'] = $new_lastname;
    $authorData['email'] = $new_email;
    $authorData['phone'] = $new_phone;
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
    <title>Editare Autori</title>
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
  <a href="authors.php">
    <i class="fa fa-arrow-left" aria-hidden="true" style="padding:30px; position:relative; font-size:25px; color:#333;"></i>
  </a>
<div class="container" style="padding-top:50px;padding-bottom:50px;">

<table class="table" class="table table-bordered" style="background-color:#fff; text-align:center; box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16); -moz-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16); -webkit-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16); border-radius:5px;"> <!-- Adauga clasa 'table-bordered' pentru a afisa o bordura la celulele tabelului -->
        <thead>
            <tr>
                <th style="text-align:center;">Prenume</th>
                <th style="text-align:center;">Nume</th>
                <th style="text-align:center;">Email</th>
                <th style="text-align:center;">Număr telefon</th>
                <th style="text-align:center;">Editare</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <div class='container' style='display: flex; justify-content:center;'>
                <form action="" method="POST">
                <td><input class="input-field" type="text" name="new_firstname" value="<?php echo $authorData['firstname']; ?>"></td>
                    <td><input class="input-field" type="text" name="new_lastname" value="<?php echo $authorData['lastname']; ?>"></td>
                    <td><input class="input-field" type="text" name="new_email" value="<?php echo $authorData['email']; ?>"></td>
                    <td><input class="input-field" type="text" name="new_phone" value="<?php echo $authorData['phone']; ?>"></td>
                    <td>
                        <input type="hidden" name="author_id" value="<?php echo $author_id; ?>">
                        <button name="edit_authors" class="btn" type="submit"><i class="fa fa-check" aria-hidden="true" style="margin-right:10px;"></i>Salvare</button>
                    </td>
                </form>
            </div>
            </tr>
        </tbody>
    </table>
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
  .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: none; /* Eliminăm bordurile tabelului */
        }

        .table th, .table td {
            padding: 10px;
            text-align: center;
            border: none; /* Eliminăm bordurile celulelor */
        }

        .input-field {
            width: 30%;
            padding: 5px;
            border: none;
            outline: none;
            box-shadow: none;
        }

        .btn {
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
</style>
</body>
</html>
