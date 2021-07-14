<?php
  $hostname = "localhost";          /* veritabanımıza bağlanıyoruz*/
  $username = "root";
  $password = "";
  $dbname = "chatapp";

  $conn = mysqli_connect($hostname, $username, $password, $dbname);
  if(!$conn){
    echo " DB connection error".mysqli_connect_error();
  }
?>
