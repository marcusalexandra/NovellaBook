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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Adaugă o carte</title>
</head>
<body style="background-color: #e4e5e6;">
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
  <div class="row">
    <div class="col-md-12">
      <div class="card-module">
        <div class="card-content">
          <form action="" method="POST" class="login-email" enctype="multipart/form-data">
            <p class="login-text" style="font-size: 40px; margin-bottom: 70px;">Adaugă o carte</p>
          <?php
          echo "<div class='input-group email-group'>
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
			
      <?php
        echo "<div class='input-group email-group'>
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
			
      <?php
        echo "<div class='input-group email-group'>
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
      <div class="input-group email-group">
        <i class="fa fa-book" aria-hidden="true"></i>
				<input type="text" class="form-control" placeholder="Titlu" name="title" value="" required>
			</div>
      <div class="input-group email-group">
        <i class="fa fa-book" aria-hidden="true"></i>
				<input type="number" class="form-control" placeholder="Anul publicării" name="publishing_year" value="" required>
			</div>
      <div class="input-group email-group">
        <i class="fa fa-credit-card" aria-hidden="true"></i>
				<input type="number" class="form-control" placeholder="Preț" name="price" value="" required>
			</div>
      <div class="input-group email-group">
        <i class="fa fa-id-card-o" aria-hidden="true"></i>
				<input type="number" class="form-control" placeholder="Vârstă" name="age" value="" required>
			</div>
      <div class="input-group email-group">
        <i class="fa fa-file-text-o" aria-hidden="true"></i>
				<input type="number" class="form-control" placeholder="Pagini" name="pages" value="" required>
			</div>
			<div class="input-group email-group">
        <i class="fa fa-globe" aria-hidden="true"></i>
				<input type="text" class="form-control" placeholder="Limbă" name="language" value="">
			</div>
			<div class="input-group email-group">
        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
				<input type="textbox" class="form-control" placeholder="Descriere" name="description" value="">
			</div>
      <div class="input-group email-group">
        <i class="fa fa-picture-o" aria-hidden="true"></i>
        <input type="file" class="custom-file-input" name="uploadfile" id="customFileInput" aria-describedby="customFileInput">
      </div>
        <div class="input-group">
				<button name="submit" class="btn">Adaugă</button>
			</div>
    </form>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
  .card-module{
  margin-bottom:30px;
  position: relative;
  background-color: #fff;
  border-radius: 3px;
  padding: 25px;
  margin-bottom: 15px;
  width: 100%;
  height:1000px;
  box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
  -moz-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
  -webkit-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
}
.card-content{
  margin-bottom: 15px;
  word-wrap: break-word;
  text-align: center;
  width:700px;
}
.card-module {
  /* Restul stilurilor existente */
  display: flex;
  align-items: center;
  justify-content: center;
}

.sr-only{
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip:rect(0,0,0,0);
    border: 0;
    }
    .form-control{
    display: inline-block;
    width: 84%;
    padding: 10px 10px 5px 0;
    color: #9ca1af;
    border-style: none;
    border-bottom: 1px solid #eaeaec;
    border-radius: 0;
    box-shadow: none;
    }
    .input-group{
    margin-bottom: 20px;
    cursor: pointer;
    min-height: 35px;
    }
    .email-group {
    display: flex;
    align-items: center;}
    .email-group i {
    margin-right: 10px;
    margin-top: 3px;
  }
  /* Anulează stilurile implicite pentru elementele active/focus */
  .input-group input:focus {
    outline: none; /* Elimină conturul albastru la focus */
    border-color: #eaeaec; /* Setează culoarea chenarului la focus */
    box-shadow: none; /* Elimină umbra la focus */
}

/* Adaugă stil personalizat pentru casuța email */
.email-group input {
    border-radius: 0; /* Elimină colțurile rotunjite ale casuței */
}

/* Adaugă stil personalizat pentru casuța parolă */
.input-group input[type="password"] {
    border-top: none; /* Elimină partea superioară a chenarului */
    border-left: none; /* Elimină latura stângă a chenarului */
    border-right: none; /* Elimină latura dreaptă a chenarului */
    border-bottom-color: #eaeaec; /* Setează culoarea chenarului pentru partea de jos la focus */
    border-radius: 0; /* Elimină colțurile rotunjite ale casuței */
}
.btn {
    background-color: #9ca1af;
    color: #fff;
    border: none;
    border-radius: 1;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    text-align: center;
    width: 300px;
    margin-top:10px;
}
.input-group.email-group {
  margin-bottom: 20px;
}

.input-group.email-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
  color: #999; /* Lighter font color */
  width: 1000px;
  margin-right:10px;
}

.input-group.email-group select {
  width: 500%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  color: #666; /* Lighter font color */
}
@media (max-width: 767px) {
  /* Adjustments for smaller screens */
  .input-group.email-group label {
    font-size: 14px; /* Decrease font size for better readability */
    width: auto; /* Adjust width to fit content on smaller screens */
    margin-right: 5px; /* Decrease margin for better spacing */
  }

  .input-group.email-group select {
    width: 100%; /* Set select width to 100% for better layout */
  }

  .card-module {
    height: auto; /* Allow height to adjust for content on smaller screens */
  }

  .login-text {
    font-size: 30px; /* Decrease font size for a more compact header */
    margin-bottom: 30px; /* Adjust margin for improved spacing */
  }

  .btn {
    width: 100%; /* Set button width to 100% for full-width buttons */
  }
}

</style>
</body>
</html>
