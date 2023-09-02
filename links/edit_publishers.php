<?php
include '../conn.php';
error_reporting(0);
session_start();
$user_id = "";
$user_id = $_SESSION['user_id'];

if(isset($_GET['publisher_id'])) {
    $publisher_id = mysqli_real_escape_string($connect, $_GET['publisher_id']);
    $sql = "SELECT * FROM publisher WHERE publisher_id = '$publisher_id'";
    $result = mysqli_query($connect, $sql);
    $publisherData = mysqli_fetch_assoc($result);
}

if(isset($_POST['edit_publishers'])) {
    $publisher_id = mysqli_real_escape_string($connect, $_GET['edit_publishers']);
    $sql = "SELECT * FROM publisher WHERE publisher_id = '$publisher_id'";
    $result = mysqli_query($connect, $sql);
    $publisherData = mysqli_fetch_assoc($result);
    // Preiați datele introduse în formular
    $new_publisher_name = mysqli_real_escape_string($connect, $_POST['new_publisher_name']);
    $new_publisher_email = mysqli_real_escape_string($connect, $_POST['new_publisher_email']);
    $new_publisher_phone = mysqli_real_escape_string($connect, $_POST['new_publisher_phone']);

    // Actualizați datele în baza de date
    $sql = "UPDATE publisher SET publisher_name='$new_publisher_name', publisher_email='$new_publisher_email', publisher_phone='$new_publisher_phone' WHERE publisher_id='$publisher_id'";
    $result = mysqli_query($connect, $sql);

    // Afișați un mesaj pop-up de succes
    echo "<script>alert('Schimbările au fost realizate cu succes!');</script>";

    // Actualizați datele editorului pentru a fi afișate în câmpurile de editare
    $publisherData['publisher_name'] = $new_publisher_name;
    $publisherData['publisher_email'] = $new_publisher_email;
    $publisherData['publisher_phone'] = $new_publisher_phone;
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
    <title>Editare Editori</title>
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
    } elseif($user_id == 1) {
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

<a href="publishers.php">
    <i class="fa fa-arrow-left" aria-hidden="true" style="padding:30px; position:relative; font-size:25px; color:#333;"></i>
</a>
<div class="container" style="padding-top:50px;padding-bottom:50px;">
    <table class="table" class="table table-bordered" style="background-color:#fff; text-align:center; box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16); -moz-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16); -webkit-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16); border-radius:5px;">
        <thead>
            <tr>
                <th style="text-align:center;">Nume</th>
                <th style="text-align:center;">Email</th>
                <th style="text-align:center;">Număr Telefon</th>
                <th style="text-align:center;">Editare</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <div class='container' style='display: flex; justify-content:center;'>
                    <form action="" method="POST">
                    <td><input class="input-field" type="text" name="new_publisher_name" value="<?php echo htmlspecialchars($publisherData['publisher_name']); ?>"></td>
                    <td><input class="input-field" type="text" name="new_publisher_email" value="<?php echo htmlspecialchars($publisherData['publisher_email']); ?>"></td>
                    <td><input class="input-field" type="text" name="new_publisher_phone" value="<?php echo htmlspecialchars($publisherData['publisher_phone']); ?>"></td>

                        <td>
                            <input type="hidden" name="publisher_id" value="<?php echo $publisher_id; ?>">
                            <button name="edit_publishers" class="btn" type="submit"><i class="fa fa-check" aria-hidden="true" style="margin-right:10px;"></i>Salvare</button>
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
