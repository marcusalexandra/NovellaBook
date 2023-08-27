<?php
  include '../conn.php';
  error_reporting(0);
  session_start();
  $user_id = "";
  $user_id = $_SESSION['user_id'];
  if(isset($_POST['search_button'])) {
    $search = $_POST['search'];
    $sql = "SELECT * FROM users WHERE user_id <>'1' AND lastname RLIKE('$search') ";
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
    <table border="1">
    <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($user)) {
            foreach ($user as $userData) {
                $firstname = $userData['firstname'];
                $lastname = $userData['lastname'];
                $email = $userData['email'];
                $phone = $userData['phone'];
                $user_id = $userData['user_id'];

                echo "<tr>";
                echo "<td>$firstname</td>";
                echo "<td>$lastname</td>";
                echo "<td>$email</td>";
                echo "<td>$phone</td>";

                // Opening the form and container div
                echo "<td><form action='' method='POST'>";
                echo "<div class='container' style='background-color: gray;'>";

                // Use a hidden input to store the user_id value
                echo "<input type='hidden' name='user_delete' value='$user_id' />";

                // Submit button (a button within a form should be of type 'submit')
                echo "<button name='delete' class='search-bar__button' type='submit'>Delete</button>";

                // Close the form
                echo "</form></div></td>";

                // Close the table row
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No results found.</td></tr>";
        }
        ?>
    </tbody>
</table>

      
    </tbody>
</table>
</body>
</html>
