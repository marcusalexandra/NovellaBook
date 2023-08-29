<?php
include '../conn.php';
error_reporting(0);
session_start();
$user_id = "";
$user_id = $_SESSION['user_id'];

if(isset($_POST['search_button_authors'])) {
    $search_authors = mysqli_real_escape_string($connect, $_POST['search_authors']);
    $sql = "SELECT * FROM authors WHERE lastname RLIKE('$search_authors')";
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        <input class="search-bar__bar" type="text" placeholder="Search..." name="search_authors" id="search_authors" />
        <button name="search_button_authors" class="search-bar__button" type="submit">
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
        if (!empty($author)) {
            foreach ($author as $authorData) {
                $firstname = $authorData['firstname'];
                $lastname = $authorData['lastname'];
                $email = $authorData['email'];
                $phone = $authorData['phone'];
                $author_id = $authorData['author_id'];

                echo "<tr>";
                echo "<td>$firstname</td>";
                echo "<td>$lastname</td>";
                echo "<td>$email</td>";
                echo "<td>$phone</td>";

                // Opening the form and container div
                echo "<td><form action='' method='POST'>";
                echo "<div class='container' style='background-color: gray;'>";

                // Use a hidden input to store the author_delete value
                echo "<input type='hidden' name='author_delete' value='$author_id' />";

                // Submit button (a button within a form should be of type 'submit')
                echo "<button name='delete_authors' class='search-bar__button' type='submit'>Delete</button>";
                echo "<td>
                <form action='edit_author.php' method='GET'>
                    <input type='hidden' name='author_id' value='$author_id' />
                    <button class='search-bar__button' type='submit'>Editează</button>
                </form>
            </td>
            
            <td>
                <form action='authors_publications.php' method='GET'>
                    <button class='search-bar__button' type='submit'>Adaugă autor</button>
                </form>
            </td>";
                // Close the form
                echo "</div></form></td>";

                // Close the table row
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No results found.</td></tr>";
            
}
        
        ?>
        </tbody>
    </table>
</body>
</html>