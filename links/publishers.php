<?php
include '../conn.php';
  error_reporting(0);
  session_start();
  $user_id = "";
  $user_id = $_SESSION['user_id'];
  if(isset($_POST['search_button_publisher'])) {
    $search_publisher = $_POST['search_publisher'];
    $sql = "SELECT * FROM publisher WHERE publisher_name RLIKE('$search_publisher') ";
    $result = mysqli_query($connect, $sql);
    $publisher = array();
    $i = 0;
    while ($row = $result->fetch_assoc()){
              $publisher[$i]['publisher_id']= $row['publisher_id'];
              $publisher[$i]['publisher_name']= $row['publisher_name'];
              $publisher[$i]['publisher_email']= $row['publisher_email'];
              $publisher[$i]['publisher_phone']= $row['publisher_phone'];
              $i++;
            }
  }
  while ($row = $result->fetch_assoc()){
    $publisher[$i]['publisher_id']= $row['publisher_id'];
    $publisher[$i]['publisher_name']= $row['publisher_name'];
    $publisher[$i]['publisher_email']= $row['publisher_email'];
    $publisher[$i]['publisher_phone']= $row['publisher_phone'];
    $i++;
  }
  if(isset($_POST['publisher_delete'])) {
    $publishers_delete = $_POST['publishers_delete'];
    $sql = "SELECT book_id FROM books WHERE publisher_id = '$publishers_delete'";
    $result = mysqli_query($connect, $sql);
    while ($row = $result->fetch_assoc()){
        $books[$i]['book_id']= $row['book_id'];
        $i++;
      }
    foreach ($books as $booksData) {
        $books_id = $booksData['book_id'];
        $sql = "DELETE FROM reservations WHERE book_id = $books_id";
        $result = mysqli_query($connect, $sql);
    }
    foreach ($books as $booksData) {
        $books_id = $booksData['book_id'];
        $sql = "DELETE FROM reviews WHERE book_id = $books_id";
        $result = mysqli_query($connect, $sql);
    }
    $sql = "DELETE FROM books WHERE publisher_id = $publishers_delete";
    $result = mysqli_query($connect, $sql);
    $sql = "DELETE FROM publisher WHERE publisher_id = $publishers_delete";
    $result = mysqli_query($connect, $sql);
  }
  if(isset($_POST['edit_publishers'])) {
    $publisher_edit = mysqli_real_escape_string($connect, $_POST['publisher_edit']);
    // Redirect to the edit_publisher.php page with the publisher_id as a parameter
    header("Location: edit_publisher.php?publisher_id=$publisher_edit");
    exit();
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
  <title>Publicații</title>
</head>
<body style="background-color: #e4e5e6;">
<p>ANA</p>
</body>
</html>
