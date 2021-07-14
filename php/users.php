<?php
    session_start();
    include_once "config.php";      /* veritabanı için gerekli olan dosyayı include ediyoruz*/
    $outgoing_id = $_SESSION['unique_id'];

    $sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} ORDER BY user_id DESC";
    /* kendi unique id'miz haricindeki kullanıcıları user id'lerine göre azalan sırada sıralıyoruz*/
    $query = mysqli_query($conn, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){       /* eğer hiç kayıtlı kullanıcı yoksa*/
        $output .= "No users are available to chat";
    }elseif(mysqli_num_rows($query) > 0){   /* eğer en az bir tane kayıtlı kullanıcı varsa*/
        include_once "data.php";            /* data phpyi include ediyoruz*/
    }
    echo $output;                         /* output olarak kullanıcıları yüklüyoruz*/
?>