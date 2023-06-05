<?php
  //Database connection
  $servername = "localhost";
  $username = "root";
  $password = "";
  $connect = mysqli_connect($servername, $username, $password);
  //Checks connection and prints a message
  if($connect){
    echo "Connected Succsesfully! <br>";
    //If the connection has been succsesfull then it creates the medicalwarehouse database
    $query = "CREATE DATABASE novellabook";
    $createdatabase = mysqli_query($connect, $query);
    if($createdatabase){
      echo "Database created succsesfully! <br>";
    }else{
      echo "Failed to create database! <br>";
    }
  }else{
    echo "Connection Failed! <br>";
  }
?>
