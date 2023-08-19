<?php
  include '../conn.php';
  error_reporting(0);
  session_start();
  $user_id = "";
  $user_id = $_SESSION['user_id'];
  if(isset($_POST['search_button'])) {
    $search = $_POST['search'];
    $sql = "SELECT * FROM users WHERE user_id <>'1' AND lastname = '$search' ";
    $result = mysqli_query($connect, $sql);
    $user = array();
    $i = 0;
    while ($row = $result->fetch_assoc()){
              $user[$i]['user_id']= $row['user_id'];
              $user[$i]['firstname']= $row['firstname'];
              $user[$i]['lastname']= $row['lastname'];
              $user[$i]['email']= $row['email'];
              $user[$i]['phone']= $row['phone'];
              $i++;
            }
  }
  if(isset($_POST['delete'])) {
    $user_delete = $_POST['user_delete'];
    $sql = "DELETE FROM users WHERE user_id = '$user_delete'";
    $result = mysqli_query($connect, $sql);
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Utilizatori</title>
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
      <form action="" method="POST">
        <input class="search-bar__bar" type="text" placeholder="Search..." name="search" id="search" />
		  	<button name="search_button" class="search-bar__button" type="submit">
          <i class="fa fa-search"></i>
        </button>
      </form>
   <?php
    if ($user != null) {
     $count = count($user);
    for ($j = 0; $j < $count; $j++) {
        $firstname = $user[$j]['firstname'];
        $lastname = $user[$j]['lastname'];
        $email = $user[$j]['email'];
        $phone = $user[$j]['phone'];
        $user_id = $user[$j]['user_id'];

        // Opening the form and container div
        echo "<form action='' method='POST'>";
        echo "<div class=container style='background-color:gray;'>";

        // Output the user information within a <p> tag
        echo "<p>$firstname, $lastname, $email, $phone</p>";

        // Use a hidden input to store the user_id value
        echo "<input type='hidden' name='user_delete' value='$user_id' />";

        // Closing the container div
        echo "</div>";

        // Submit button (a button within a form should be of type 'submit')
        echo "<button name='delete' class='search-bar__button' type='submit'>Delete</button>";

        // Close the form
        echo "</form>";

        // Adding line breaks
        echo "<br><br>";
    }
}

      ?>
</body>
</html>
