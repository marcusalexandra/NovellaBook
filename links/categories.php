<?php
include '../conn.php';
error_reporting(0);
session_start();
$user_id = "";
$user_id = $_SESSION['user_id'];

if(isset($_POST['search_button_category'])) {
    $search_category = mysqli_real_escape_string($connect, $_POST['search_category']);
    $sql = "SELECT * FROM category WHERE name RLIKE('$search_category') ";
    $result = mysqli_query($connect, $sql);
    $category = array();
    $i = 0;
    while ($row = $result->fetch_assoc()){
        $category[$i]['category_id']= $row['category_id'];
        $category[$i]['name']= $row['name'];
        $i++;
    }
}

if(isset($_POST['delete_category'])) {
    $category_delete = mysqli_real_escape_string($connect, $_POST['category_delete']);
    $sql = "SELECT book_id FROM books WHERE category_id = $category_delete";
    $result = mysqli_query($connect, $sql);
    $book= array();
    $i = 0;
    while ($row = $result->fetch_assoc()){
        $book[$i]['book_id']= $row['book_id'];
        $i++;
    }
    foreach ($book as $bookData) {
        $book_id = $bookData['book_id'];
        $sql = "DELETE FROM reservations WHERE book_id = $book_id";
        $result = mysqli_query($connect, $sql);
    }
    foreach ($book as $bookData) { // Change $books to $book
        $book_id = $bookData['book_id'];
        $sql = "DELETE FROM reviews WHERE book_id = $book_id";
        $result = mysqli_query($connect, $sql);
    }
    $sql = "DELETE FROM books WHERE category_id = $category_delete";
    $result = mysqli_query($connect, $sql);
    $sql = "DELETE FROM category WHERE category_id = $category_delete";
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
        <input class="search-bar__bar" type="text" placeholder="Search..." name="search_category" id="search_category" />
        <button name="search_button_category" class="search-bar__button" type="submit">
            <i class="fa fa-search"></i>
        </button>
    </form>
    <table border="1">
        <thead>
        <tr>
            <th>Name</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($category)) {
            foreach ($category as $categoryData) {
                $name = $categoryData['name'];
                $category_id = $categoryData['category_id'];

                echo "<tr>";
                echo "<td>$name</td>";

                // Opening the form and container div
                echo "<td><form action='' method='POST'>";
                echo "<div class='container' style='background-color: gray;'>";

                // Use a hidden input to store the category_delete value
                echo "<input type='hidden' name='category_delete' value='$category_id' />";

                // Submit button (a button within a form should be of type 'submit')
                echo "<button name='delete_category' class='search-bar__button' type='submit'>Delete</button>";

                // Close the form
                echo "</div></form></td>";

                // Close the table row
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No results found.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</body>
</html>