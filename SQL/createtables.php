<?php
//Database connection
  $servername = "localhost";
  $username = "root";
  $password = "";
  $databasename = "novellabook";
  $connect = mysqli_connect($servername, $username, $password, $databasename);
  //Checks connection and prints a message
  if($connect){
    echo "Connected Succsesfully! <br>";
    //If the connection has been succsesfull then it creates the tables
    $createtable1 = mysqli_query($connect, "CREATE TABLE users (
        user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(100),
        user_password VARCHAR(50),
        firstname VARCHAR(100),
        lastname VARCHAR(100),
        phone VARCHAR(15),
        address LONGTEXT
      )"
    );
    //Checks if the table has been created
    if($createtable1){
        echo "Users table created succsesfully! <br>";
    }else{
        echo "Failed to create users table! <br>";
    }
    $createtable2 = mysqli_query($connect, "CREATE TABLE publisher (
        publisher_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(100),
        name VARCHAR(100),
        phone VARCHAR(15)
      )"
    );
    //Checks if the table has been created
    if($createtable2){
        echo "Publisher table created succsesfully! <br>";
    }else{
        echo "Failed to create publisher table! <br>";
    }

    $createtable3 = mysqli_query($connect, "CREATE TABLE authors (
        author_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(100),
        firstname VARCHAR(100),
        lastname VARCHAR(100),
        phone VARCHAR(15)
      )"
    );
    //Checks if the table has been created
    if($createtable3){
        echo "Author table created succsesfully! <br>";
    }else{
        echo "Failed to create author table! <br>";
    }

     $createtable4 = mysqli_query($connect, "CREATE TABLE category (
        category_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100)
      )"
    );
    //Checks if the table has been created
    if($createtable4){
        echo "Category table created succsesfully! <br>";
    }else{
        echo "Failed to create category table! <br>";
    }

    $createtable5 = mysqli_query($connect, "CREATE TABLE books (
        book_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(100),
        publishing_year INT(4),
        price INT(4),
        copies INT(4),
        language VARCHAR (100),
        author_id INT UNSIGNED,
        FOREIGN KEY (author_id) REFERENCES authors(author_id),
        publisher_id INT UNSIGNED,
        FOREIGN KEY (publisher_id) REFERENCES publisher(publisher_id),
        category_id INT UNSIGNED,
        FOREIGN KEY (category_id) REFERENCES category(category_id),
        description LONGTEXT
      )"
    );
    //Checks if the table has been created
    if($createtable5){
        echo "Books table created succsesfully! <br>";
    }else{
        echo "Failed to create books table! <br>";
    }
    $createtable6 = mysqli_query($connect, "CREATE TABLE reservations (
        reservation_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(100),
        publishing_year INT(4),
        price INT(4),
        copies INT(4),
        user_id INT UNSIGNED,
        FOREIGN KEY (user_id) REFERENCES users(user_id),
        book_id INT UNSIGNED,
        FOREIGN KEY (book_id) REFERENCES books(book_id)
      )"
    );

    //Checks if the table has been created
    if($createtable6){
        echo "Reservations table created succsesfully! <br>";
    }else{
        echo "Failed to create reservations table! <br>";
    }
  }else{
    echo "Connection Failed! <br>";
  }
?>
