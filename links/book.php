<?php
  include '../conn.php';
  error_reporting(0);
  session_start();
  $user_id = "";
  $user_id = $_SESSION['user_id'];
  if(isset($_POST['submit'])) {
    $title = $_POST['title'];
    $publiYear = $_POST['publishing_year'];
    $price = $_POST['price'];
    $copies = $_POST['copies'];
    $language = $_POST['language'];
    $description = $_POST['description'];
    $selectedAuthor = $_POST['authors'];
    $selectedCategory = $_POST['category'];
    $selectedPublisher =  $_POST['publisher'];
    $names = explode(" ", $selectedAuthor);

    $sql = "SELECT category_id FROM category WHERE name = '$selectedCategory'";
    $result = mysqli_query($connect, $sql);
    while ($row = $result->fetch_assoc()){
              $category_id = $row['category_id'];
            }

    $sql = "SELECT publisher_id FROM publisher WHERE name = '$selectedPublisher'";
    $result = mysqli_query($connect, $sql);
    while ($row = $result->fetch_assoc()){
              $publisher_id = $row['publisher_id'];
            }

    $sql = "SELECT author_id FROM authors WHERE firstname = '$names[0]' AND lastname = '$names[1]'";
    $result = mysqli_query($connect, $sql);
    while ($row = $result->fetch_assoc()){
              $author_id = $row['author_id'];
            }

    $sql = "INSERT INTO books(title, publishing_year, price, copies, language, author_id, publisher_id, category_id, description)
            VALUES ('$title', '$publiYear', '$price', '$copies', '$language', '$author_id', '$publisher_id', '$category_id', '$description')";
        $result = mysqli_query($connect, $sql);
        $title = "";
        $publiYear = "";
        $price = "";
        $copies = "";
        $language = "";
        $description = "";
        $selectedAuthor = "";
        $selectedCategory = "";
        $selectedPublisher = "";
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
  <title>Adaugă carte</title>
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
          <p class="login-text" style="font-size: 2rem; font-weight: 800;">Adaugă o carte</p>
          <?php
         echo "<div class='input-group'>
                <label for='authors'>Selectează un autor existent:</label>
                <select name='authors' >
                <option name = 'NULL' value = ''></option>";
        $sql = mysqli_query($connect, "SELECT author_id FROM authors");
            $i = 0;
            $aut_id = array();
            while ($row = $sql->fetch_assoc()){
              $aut_id[$i] = $row['author_id'];
              $i++;
            }
            $count = count($aut_id);
            for($i = 0; $i < $count; $i++){
              $sql = mysqli_query($connect, "SELECT firstname, lastname FROM authors WHERE author_id = '$aut_id[$i]'");
              while ($row = $sql->fetch_assoc()){
                $name = $row['firstname'];
                $lastname = $row['lastname'];
                echo '<option name = "'.$name.'" value="'.$name.' '.$lastname.'">' . $name.' '. $lastname. '</option>';
              }
            }
            echo "</div>";
        ?>
			<div class="input-group">
				<input type="text" placeholder="Titlu" name="title" value="" required>
			</div>
      <?php
        echo "<div class='input-group'>
                <label for='category'>Selectează o categorie existentă:</label>
                <select name='category' >
                <option name = 'NULL' value = ''></option>";
        $sql = mysqli_query($connect, "SELECT category_id FROM category");
            $i = 0;
            $cat_id = array();
            while ($row = $sql->fetch_assoc()){
              $cat_id[$i] = $row['category_id'];
              $i++;
            }
            $count = count($cat_id);
            for($i = 0; $i < $count; $i++){
              $sql = mysqli_query($connect, "SELECT name FROM category WHERE category_id = '$cat_id[$i]'");
              while ($row = $sql->fetch_assoc()){
                $name = $row['name'];
                echo '<option name = "'.$name.'" value="'.$name.' ">' . $name.'</option>';
              }
            }
            echo "</div>";

      ?>
			<div class="input-group">
				<input type="number" placeholder="Anul publicării" name="publishing_year" value="" required>
			</div>
       <?php
        echo "<div class='input-group'>
                <label for='publisher'>Selectează o publicație existentă:</label>
                <select name='publisher' >
                <option name = 'NULL' value = ''></option>";
        $sql = mysqli_query($connect, "SELECT publisher_id FROM publisher");
            $i = 0;
            $pub_id = array();
            while ($row = $sql->fetch_assoc()){
              $pub_id[$i] = $row['publisher_id'];
              $i++;
            }
            $count = count($pub_id);
            for($i = 0; $i < $count; $i++){
              $sql = mysqli_query($connect, "SELECT name FROM publisher WHERE publisher_id = '$pub_id[$i]'");
              while ($row = $sql->fetch_assoc()){
                $name = $row['name'];
                echo '<option name = "'.$name.'" value="'.$name.' ">' . $name.'</option>';
              }
            }
            echo "</div>";

      ?>
      <div class="input-group">
				<input type="number" placeholder="Preț" name="price" value="" required>
			</div>
      <div class="input-group">
				<input type="number" placeholder="Număr copii" name="copies" value="" required>
			</div>
			<div class="input-group">
				<input type="text" placeholder="Limbă" name="language" value="">
			</div>
			<div class="input-group">
				<input type="textbox" placeholder="Descriere" name="description" value="">
			</div>
        <div class="input-group">
				  <button name="submit" class="btn">Adaugă</button>
			</div>
		</form>
</div>
</body>
</html>
