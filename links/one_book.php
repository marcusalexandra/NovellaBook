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
        $books_array['publisher_name'] = $row_publisher["publiser_name"];
        $books_array['publisher_email'] = $row_publisher["publiser_email"];
        $books_array['publisher_phone'] = $row_publisher["publiser_phone"];
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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
  <title></title>
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
        <?php

          $title = $books_array['title'];
          $photo = $books_array['photo'];
          echo "<div style= 'background-color:blue;'><p>$title</p></div>";

          echo "<img src='$photo' style = 'height:90px; width:90px;' alt='$title'>";

        ?>
        <?php
        if($user_id != NULL){
          echo "<form action='' method ='POST' >
          <label for='checkin'>Check-In Date:</label>
          <input type='text' id='checkin' name='checkin'>

          <label for='checkout'>Check-Out Date:</label>
          <input type='text' id='checkout' name='checkout'>

            <button name='reserve' class='search-bar__button' type='submit'>Rezerva</button>
            </form>";
        }

        ?>
    <?php
      if($user_id != NULL){
        echo "<div class='container'>
            <form action='' method='POST'>
            <h4>Rate this book:</h4>
            <div class='star-rating'>
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
            <div class='input-group'>
              <input type='textbox' placeholder='Adaugă o recenzie' name='reviews' value='' required>
            </div>
              <button name='review' class='search-bar__button' type='submit'>Adaugă o recenzie</button>
            </form>
        </div>";
      }
  ?>
   <div id="booking-calendar"></div>
  <?php
      $avg_query = "SELECT AVG(rating) AS avg_rating FROM reviews WHERE book_id = $book_id";
      $result = mysqli_query($connect, $avg_query);
      $row = mysqli_fetch_assoc($result);
      $average_rating = $row['avg_rating'];
      $avg = number_format((float)$average_rating, 2, '.', '');
      echo "<div><p>Nota: $avg /5</p></div>";
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
  <h4>Reviews</h4>
  <div style="overflow-y: scroll; max-height: 300px; background-color: gray;">
    <?php
    foreach ($reviews as $review) {
      $authorFullName = $review['firstname'] . ' ' . $review['lastname'];
      $reviewContent = $review['review'];
      $rating = $review['rating'];

      echo "<div class='review'>
              <p><strong>Author:</strong> $authorFullName</p>
              <p><strong>Review:</strong> $reviewContent</p>
              <p><strong>Rating:</strong> $rating</p>
            </div>";
    }
    ?>
  </div>
</div>

</body>
</html>