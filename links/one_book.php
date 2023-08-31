<?php
  include '../conn.php';
  error_reporting(0);
  session_start();
  $user_id = "";
  $user_id = $_SESSION['user_id'];
  $book_id = $_SESSION['one_book'];
    $sql = "SELECT * FROM books WHERE book_id = '$book_id'";
    $result = mysqli_query($connect, $sql);
    $books_array = array();
    while ($row = $result->fetch_assoc()){
      $books_array['title'] = $row['title'];
      $books_array['publishing_year']=$row['publishing_year'];
      $books_array['price']=$row['price'];
      $books_array['age'] = $row ['age'];
      $books_array['pages'] = $row['pages'];
      $books_array['description'] = $row['description'];
      $books_array['language']=$row['language'];
      $books_array['photo'] = $row['book_picture'];
      $author_id = $row['author_id'];
      $sql = "SELECT *  FROM authors WHERE author_id = '$author_id'";
      $result_author = mysqli_query($connect, $sql);
      while($row_author = $result_author -> fetch_assoc()) {
        $books_array['author_firstname'] = $row_author["firstname"];
        $books_array['author_lastname'] = $row_author["lastname"];
        $books_array['author_email'] = $row_author["email"];
        $books_array['author_phone'] = $row_author["phone"];
      }
      $category_id = $row['category_id'];
      $sql = "SELECT *  FROM category WHERE category_id = '$category_id'";
      $result_category = mysqli_query($connect, $sql);
      while($row_category = $result_category -> fetch_assoc()) {
        $books_array['category_name'] = $row_category["name"];
      }
      $publisher_id = $row['publisher_id'];
      $sql = "SELECT *  FROM publisher WHERE publisher_id = '$publisher_id'";
      $result_publisher = mysqli_query($connect, $sql);
      while($row_publisher = $result_publisher -> fetch_assoc()) {
        $books_array['publisher_name'] = $row_publisher["publisher_name"];
        $books_array['publisher_email'] = $row_publisher["publisher_email"];
        $books_array['publisher_phone'] = $row_publisher["publisher_phone"];
      }
      $books_array['description']=$row['description'];
    }
    if(isset($_POST['review'])) {
      $reviews = $_POST['reviews'];
      $rating = $_POST['rating'];
      $sql = "INSERT INTO reviews(review, rating, user_id, book_id)
            VALUES ('$reviews', '$rating', '$user_id', '$book_id')";
      mysqli_query($connect,$sql);
      header("Refresh:0");
    }
      $reserved_dates = array();

      $sql = "SELECT reservation_date, return_date FROM reservations WHERE book_id = '$book_id'";
      $result = mysqli_query($connect, $sql);

      while ($row = mysqli_fetch_assoc($result)) {
      $start_date = $row['reservation_date'];
      $end_date = $row['return_date'];
      $reserved_dates = array_merge($reserved_dates, generateDateRange($start_date, $end_date));
      }
      function generateDateRange($start_date, $end_date) {
      $dates = array();
      $current_date = strtotime($start_date);

      while ($current_date <= strtotime($end_date)) {
          $dates[] = date('Y-m-d', $current_date);
          $current_date = strtotime('+1 day', $current_date);
      }
      return $dates;
      }
      if (isset($_POST['reserve'])) {
        $reserve_date = $_POST['checkin'];
        $return_date = $_POST['checkout'];

        $reserve_date_obj = new DateTime($reserve_date);
        $return_date_obj = new DateTime($return_date);

        $sql = "SELECT * FROM reservations WHERE book_id = '$book_id'
                AND reservation_date <= '$return_date' AND return_date >= '$reserve_date'";
        $result = mysqli_query($connect, $sql);

        if (mysqli_num_rows($result) == 0) {
            $sql = "INSERT INTO reservations (reservation_date, return_date, user_id, book_id)
                    VALUES ('$reserve_date', '$return_date', '$user_id', '$book_id')";
            if (mysqli_query($connect, $sql)) {
              header("Refresh:0");
                exit();
            } else {
                echo "Error: " . mysqli_error($connect);
              }
        } else {
            echo "Error: The selected date range overlaps with an existing reservation. Please choose different dates.";
        }
    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> <!-- Add this line for the sidebar icons -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
  $(function () {
    // Initialize Datepicker for check-in and check-out inputs
    $("#checkin, #checkout").datepicker({
      dateFormat: "yy-mm-dd", // Set your desired date format
      minDate: 0, // Disable past dates
      onSelect: function (selectedDate) {
        var option = this.id == "checkin" ? "minDate" : "maxDate",
          instance = $(this).data("datepicker"),
          date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
        dates.not(this).datepicker("option", option, date);
      },
      beforeShowDay: function (date) {
        var stringDate = $.datepicker.formatDate('yy-mm-dd', date);
        return [reserved_dates.indexOf(stringDate) == -1]; // Gray out reserved dates
      }
    });
  });

  var reserved_dates = <?php echo json_encode($reserved_dates); ?>;
</script>
<title>Detalii carte</title>
  <style>
  label {
  display: block;
  margin-bottom: 10px;
}

input[type="text"] {
  width: 100px;
}
.star-rating {
  display: inline-block;
  font-size: 0; /* Remove extra spacing between radio buttons */
  direction: rtl; /* Set the direction to right-to-left */
}

.star-rating input[type="radio"] {
  display: none;
}

.star-rating label {
  font-size: 24px;
  color: #ccc;
  cursor: pointer;
  display: inline-block; /* Display the stars next to each other */
  margin-right: 5px; /* Add some spacing between stars */
}

.star-rating label:before {
  content: "\2605"; /* Unicode character for star */
}

.star-rating input[type="radio"]:checked ~ label {
  color: gold;
}
</style>
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
    }elseif($user_id == 1){
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
                  echo '<li><a href="books.php">Cărți</a></li>
                  <li><a href="authors_publications.php">Autori și publicații</a></li>
                  <li><a href="users.php">Utilizatori</a></li>';
                echo '<li><a href="reservations.php">Rezervări</a></li>
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user-circle-o" aria-hidden="true"></i> Profil <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                    <li><a href="profile.php">Vezi profil</a></li>
                    <li><a href="logout.php">Deconectare</a></li>
                    </ul>
                    </li>';
                echo '<li><a href="#footer">Contact</a></li>
                </ul>
            </div>
          </div>
        </nav>
      </header>';
    }
  ?>
 <div id="booking-calendar"></div>
  <?php
      $avg_query = "SELECT AVG(rating) AS avg_rating FROM reviews WHERE book_id = $book_id";
      $result = mysqli_query($connect, $avg_query);
      $row = mysqli_fetch_assoc($result);
      $average_rating = $row['avg_rating'];
      $avg = number_format((float)$average_rating, 2, '.', '');
      //echo "<div><p>Nota: $avg /5</p></div>";
       $sql = "SELECT r.book_id, r.user_id, r.review, r.rating, u.firstname, u.lastname
                    FROM reviews AS r
                    JOIN users AS u ON r.user_id = u.user_id
                    WHERE r.book_id = '$book_id'";
        $result = mysqli_query($connect, $sql);
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $reviews[$i]['firstname'] = $row['firstname'];
            $reviews[$i]['lastname']= $row['lastname'];
            $reviews[$i]['review'] = $row['review'];
            $reviews[$i]['rating'] = $row['rating'];
            $i++;
        }
        $num_of_reviews = count($reviews);
  ?>
  <div class="container">
    <h4 style="font-size: 16px;">Recenzii</h4>
    <div class="reviews-container">
      <?php
      foreach ($reviews as $review) {
        $authorFullName = $review['firstname'] . ' ' . $review['lastname'];
        $reviewContent = $review['review'];
        $rating = $review['rating'];

        echo "<div class='review'>
                <p><strong>Autor:</strong> $authorFullName</p>
                <p><strong>Recenzie:</strong> $reviewContent</p>
                <p><strong>Rating:</strong> $rating</p>
              </div>";
      }
      ?>
    </div>
  </div>
</div>
<?php
$title = $books_array['title'];
$photo = $books_array['photo'];
echo '<div class="card-container">
  <div class="card-image">
    <img src="' . $photo . '" style="max-height: 300px; width: 100%;" alt="' . $title . '">
  </div>
  <div class="card-content">
  <div class="book-details">
      <div class="book-details-content">
    <div class="card-title"><p>' . $title . '</p></div>';

if ($books_array["publisher_phone"] != null) {
    echo "<p>Publisher phone: " . $books_array["publisher_phone"] . "</p>";
}

if ($books_array["publisher_email"] != null) {
    echo "<p>Publisher email: " . $books_array["publisher_email"] . "</p>";
}

echo "<p>Author name: " . $books_array['author_firstname'] . " " . $books_array['author_lastname'] . "</p>";

if ($books_array["author_email"] != null) {
    echo "<p>Author email: " . $books_array["author_email"] . "</p>";
}

if ($books_array["author_phone"] != null) {
    echo "<p>Author phone: " . $books_array["author_phone"] . "</p>";
}

echo '<p class="card-details">Preț: ' . $books_array['price'] . '</p>
  <p class="card-details">Vârstă: ' . $books_array['age'] . '</p>
  <p class="card-details">Pagini: ' . $books_array['pages'] . '</p>
  <p class="card-details">Limbă: ' . $books_array['language'] . '</p>
  <p class="card-details">Anul publicării: ' . $books_array['publishing_year'] . '</p>
  <p class="card-details">Numele editurii: ' . $books_array["publisher_name"] . '</p>
  <p class="card-details">Nota:' . $avg . '/5</p>
  <p class="card-description" style="text-align:justify;">Descriere: ' . $books_array['description'] . '</p>
</div>';
if ($user_id != NULL) {
    echo "<div class='container' style='max-width: 400px;
      margin: 0 auto;
      padding: 20px;
      background-color: #f7f7f7;
      border-radius: 1px;
      box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
    -moz-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
    -webkit-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);margin-top:50px; margin-bottom:30px; margin-right:300px;'>
      <form action='' method ='POST' >
      <h5 style='font-size:16px;'>Data împrumutării:</h5>
      <input type='text' id='checkin' name='checkin'>

      <h5 style='font-size:16px;'>Data returnării:</h5>
      <input type='text' id='checkout' name='checkout'>

      <button name='reserve' class='search-bar__button' type='submit' style='background-color: #D0D0D0;
      border: none;
      border-radius: 5px;
      color: #333;
      cursor: pointer;
      padding: 6px 12px;
      font-size: 16px;
      margin-right: 10px; width:300px; left:30px; position:relative;'>Rezervă</button>
      </form>
      </div>";
}

if ($user_id != NULL) {
    echo "<div class='container'style='max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f7f7f7;
    border-radius: 1px;
      box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
    -moz-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
    -webkit-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);margin-top:50px; margin-bottom:30px; margin-right:300px;'>
        <form action='' method='POST'>
        <h5 style='font-size:16px; left:80px; position:relative;'>Evaluează această carte:</h5>
        <div class='star-rating'style='left:120px;position:relative;'>
          <input type='radio' id='star5' name='rating' value='5'>
          <label for='star5'></label>
          <input type='radio' id='star4' name='rating' value='4'>
          <label for='star4'></label>
          <input type='radio' id='star3' name='rating' value='3'>
          <label for='star3'></label>
          <input type='radio' id='star2' name='rating' value='2'>
          <label for='star2'></label>
          <input type='radio' id='star1' name='rating' value='1'>
          <label for='star1'></label>
        </div>
        <div class='input-group'style='left:30px;width:80%;'>
          <input type='textbox' placeholder='Adaugă o recenzie' name='reviews' value='' required>
        </div>
        <button name='review' class='search-bar__button' type='submit' style='background-color: #D0D0D0;
        border: none;
        border-radius: 5px;
        color: #333;
        cursor: pointer;
        padding: 6px 12px;
        font-size: 16px;
        margin-right: 10px;width:300px; left:30px; position:relative;'>Adaugă o recenzie</button>
        </form>
    </div>";
}
echo '</div>';
?>


   <div id="booking-calendar"></div>
  <?php
      $avg_query = "SELECT AVG(rating) AS avg_rating FROM reviews WHERE book_id = $book_id";
      $result = mysqli_query($connect, $avg_query);
      $row = mysqli_fetch_assoc($result);
      $average_rating = $row['avg_rating'];
      $avg = number_format((float)$average_rating, 2, '.', '');
      //echo "<div><p>Nota: $avg /5</p></div>";
       $sql = "SELECT r.book_id, r.user_id, r.review, r.rating, u.firstname, u.lastname
                    FROM reviews AS r
                    JOIN users AS u ON r.user_id = u.user_id
                    WHERE r.book_id = '$book_id'";
        $result = mysqli_query($connect, $sql);
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $reviews[$i]['firstname'] = $row['firstname'];
            $reviews[$i]['lastname']= $row['lastname'];
            $reviews[$i]['review'] = $row['review'];
            $reviews[$i]['rating'] = $row['rating'];
            $i++;
        }
        $num_of_reviews = count($reviews);
  ?>
  <div class="container">
    <h4 style="font-size: 16px;">Recenzii</h4>
    <div class="reviews-container">
      <?php
      foreach ($reviews as $review) {
        $authorFullName = $review['firstname'] . ' ' . $review['lastname'];
        $reviewContent = $review['review'];
        $rating = $review['rating'];

        echo "<div class='review'>
                <p><strong>Autor:</strong> $authorFullName</p>
                <p><strong>Recenzie:</strong> $reviewContent</p>
                <p><strong>Rating:</strong> $rating</p>
              </div>";
      }
      ?>
    </div>
  </div>
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

.card-container {
    display: flex;
    max-width: 1100px;
    margin: 0 auto;
    padding: 20px;
    margin-top:100px;
    margin-bottom:250px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
    -moz-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
    -webkit-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
  }

  .card-image {
    flex: 1;
    max-height: 500px;
    padding-top: 20px;
  }
  .card-image img {
    max-height: 500px;
  width: 300%;
  border-radius: 10px 0 0 10px;
  }

  .card-content {
    flex: 2;
    padding-left: 20px;
    padding-right: 20px;
    text-align: justify;
  width: 100%;
  text-align: left;

  }
  .card-details {
  margin: 10px 0;
}

  .card-title {
    font-size: 22px;
    margin-bottom: 10px;
  }

  .card-description {
    font-size: 16px;
    margin-top: 15px;
    text-align: center; /* Aliniaza descrierea pe mijloc */
  }
  .book-details {
  flex: 1; /* Se extinde pentru a ocupa spațiul disponibil */
  padding: 20px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
  .book-details-content .card-title p {
  font-size: 22px;
  font-weight: bold;
  margin: 0;
}
.search-bar__button,
.container button {
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  cursor: pointer;
  transition: background-color 0.3s ease-in-out;
}

.search-bar__button:hover,
.container button:hover {
  background-color: #0056b3;
}
/* Stilizare pentru input-uri */
.container input[type="text"],
.container input[type="textbox"] {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 16px;
}
/* Stilizare pentru star-rating */
.star-rating {
  display: inline-block;
  margin-bottom: 10px;
}

.star-rating input[type="radio"] {
  display: none;
}

.star-rating label {
  display: inline-block;
  cursor: pointer;
  font-size: 24px;
  color: #ffd700;
  transition: color 0.3s ease-in-out;
}

.star-rating label:hover,
.star-rating input[type="radio"]:checked ~ label {
  color: #ffbc00;
}
input:focus{
  outline: none;
}
.reviews-container {
  /*overflow-y: scroll;*/
  box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
    -moz-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
    -webkit-box-shadow: 0px 2px 5px 0px rgba(6, 6, 6, 0.16);
  max-height: 300px;
  display: flex;
  border-radius: 1px;
  margin-bottom: 150px;
  flex-direction: column;
  align-items: center; /* Așează conținutul pe mijlocul vertical */
}
</style>
</body>

</html>

