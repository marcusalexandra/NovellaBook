<?php
  include '../conn.php';
  error_reporting(0);
  session_start();
  $user_id = "";
  $user_id = $_SESSION['user_id'];

  if(isset($_POST['asubmit'])) {
    $anumber = "";
    $aemail = "";
    $afname = $_POST["afname"];
    $alname = $_POST["alname"];
    if($_POST['anumber'] != null) {
        $anumber = $_POST["anumber"];
    }
    if($_POST['aemail'] != null) {
        $aemail = $_POST["aemail"];
    }
    $sql = "INSERT INTO authors (email, firstname, lastname, phone)
            VALUES ('$aemail', '$afname', '$alname', '$anumber')";
        $result = mysqli_query($connect, $sql);
        $afname = "";
        $alname = "";
        $anumber = "";
        $aemail = "";
        echo "Bravo!";
  }

  if(isset($_POST['csubmit'])) {
    $cname = $_POST["cname"];
    $sql = "INSERT INTO category (name)
            VALUES ('$cname')";
        $result = mysqli_query($connect, $sql);
        $cname = "";
        echo "Bravo!";
  }

  if(isset($_POST['psubmit'])) {
      $pnumber = "";
      $pemail = "";
      $pname = $_POST["pname"];
      if($_POST['pnumber'] != null) {
        $pnumber = $_POST["pnumber"];
    }
    if($_POST['pemail'] != null) {
        $pemail = $_POST["pemail"];
    }
      $sql = "INSERT INTO publisher (publisher_email, publisher_name, publisher_phone)
              VALUES ('$pemail', '$pname', '$pnumber')";
          $result = mysqli_query($connect, $sql);
          $pname = "";
          $pnumber = "";
          $pemail = "";
          echo "Bravo!";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <title>Autori și publicații</title>
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
<div class="container">
		<form action="" method="POST" class="login-email">
          <p class="login-text" style="font-size: 2rem; font-weight: 800;">Adaugă autori</p>
			<div class="input-group">
				<input type="text" placeholder="First Name" name="afname" value="<?php echo $afname ?>" required>
			</div>
			<div class="input-group">
				<input type="text" placeholder="Last Name" name="alname" value="<?php echo $alname ?>" required>
			</div>
			<div class="input-group">
				<input type="text" placeholder="Number" name="anumber" pattern="[0-9]{10}" value="<?php echo $anumber ?>">
			</div>
			<div class="input-group">
				<input type="email" placeholder="Email" name="aemail" value="<?php echo $aemail ?>">
			</div>
			<br>
			<div class="input-group">
				<button name="asubmit" class="btn">Adaugă</button>
			</div>
		</form>

    <form action="" method="POST" class="login-email">
          <p class="login-text" style="font-size: 2rem; font-weight: 800;">Adaugă o categorie</p>
			<div class="input-group">
				<input type="text" placeholder="Name" name="cname" value="<?php echo $cname ?>" required>
			</div>
			<br>
			<div class="input-group">
				<button name="csubmit" class="btn">Adaugă</button>
			</div>
		</form>

    <form action="" method="POST" class="login-email">
              <p class="login-text" style="font-size: 2rem; font-weight: 800;">Adaugă o publicație</p>
          <div class="input-group">
            <input type="text" placeholder="Name" name="pname" value="<?php echo $pname ?>" required>
          </div>
          <div class="input-group">
            <input type="text" placeholder="Number" name="pnumber" pattern="[0-9]{10}" value="<?php echo $pnumber ?>">
          </div>
          <div class="input-group">
            <input type="email" placeholder="Email" name="pemail" value="<?php echo $pemail ?>">
          </div>
          <br>
          <div class="input-group">
            <button name="psubmit" class="btn">Adaugă</button>
          </div>
        </form>

	</div>
</body>
</html>
