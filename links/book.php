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
    $age = $_POST['age'];
    $pages = $_POST['pages'];
    $language = $_POST['language'];
    $description = $_POST['description'];
    $selectedAuthor = $_POST['authors'];
    $selectedCategory = $_POST['category'];
    $selectedPublisher =  $_POST['publisher'];
    $names = explode(" ", $selectedAuthor);
    $book_picture = '';
    $sql = "SELECT category_id FROM category WHERE name = '$selectedCategory'";
    $result = mysqli_query($connect, $sql);
    while ($row = $result->fetch_assoc()){
              $category_id = $row['category_id'];
            }

    $sql = "SELECT publisher_id FROM publisher WHERE publisher_name = '$selectedPublisher'";
    $result = mysqli_query($connect, $sql);
    while ($row = $result->fetch_assoc()){
              $publisher_id = $row['publisher_id'];
            }
    $sql = "SELECT author_id FROM authors WHERE firstname = '$names[0]' AND lastname = '$names[1]'";
    $result = mysqli_query($connect, $sql);
    while ($row = $result->fetch_assoc()){
              $author_id = $row['author_id'];
            }

    $sql = "INSERT INTO books(title, publishing_year, price, age, pages, language, author_id, publisher_id, category_id, description, book_picture)
            VALUES ('$title', '$publiYear', '$price', $age, $pages, '$language', '$author_id', '$publisher_id', '$category_id', '$description', '$book_picture')";
    $result = mysqli_query($connect, $sql);
    $sql = "SELECT book_id FROM books WHERE title = '$title' AND publishing_year = '$publiYear' AND price = '$price' AND language = '$language' AND author_id = '$author_id' AND publisher_id = '$publisher_id' AND category_id = '$category_id' AND description = '$description'";
    $result = mysqli_query($connect, $sql);
    while ($row = $result->fetch_assoc()){
      $book_id = $row['book_id'];
    }
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $extension = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_EXTENSION);
    $folder = '../photos/' . $book_id . '.' . $extension;
    if($filename != NULL){
      $sql = "UPDATE books SET book_picture = '$folder' WHERE book_id = '$book_id'";
      mysqli_query($connect, $sql);
      move_uploaded_file($tempname, $folder);
    }
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
		<form action="" method="POST" class="login-email" enctype="multipart/form-data">
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
            echo "</select>";
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
            echo "</select>";
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
              $sql = mysqli_query($connect, "SELECT publisher_name FROM publisher WHERE publisher_id = '$pub_id[$i]'");
              while ($row = $sql->fetch_assoc()){
                $name = $row['publisher_name'];
                echo '<option name = "'.$name.'" value="'.$name.' ">' . $name.'</option>';
              }
            }
            echo "</select>";
            echo "</div>";

      ?>
      <div class="input-group">
				<input type="number" placeholder="Preț" name="price" value="" required>
			</div>
      <div class="input-group">
				<input type="number" placeholder="Vârstă" name="age" value="" required>
			</div>
      <div class="input-group">
				<input type="number" placeholder="Pagini" name="pages" value="" required>
			</div>
			<div class="input-group">
				<input type="text" placeholder="Limbă" name="language" value="">
			</div>
			<div class="input-group">
				<input type="textbox" placeholder="Descriere" name="description" value="">
			</div>
      <div class="input-group">
        <input type="file" class="custom-file-input" name="uploadfile" id="customFileInput" aria-describedby="customFileInput">
      </div>
        <div class="input-group">
				<button name="submit" class="btn">Adaugă</button>
			</div>
    </form>
</div>
</body>
</html>
