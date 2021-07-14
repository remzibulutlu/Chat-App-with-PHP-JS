<?php 
    session_start();
    if(isset($_SESSION['unique_id'])){  /*session unqiue id ile eşleşiyorsa veritabanına baglan */
        include_once "config.php";
        $outgoing_id = $_SESSION['unique_id']; /* gonderici id'yi session unique id'ye eşitliyoruz*/
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']); /* mesaj alıcı kolonu ve mesaj kolonununu eşleştirip veritabanına eklemek için değişkenler*/
        $message = mysqli_real_escape_string($conn, $_POST['message']);
        if(!empty($message)){
            $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg)        /*veritabanına eklenecek olan verinin sorgusu*/
                                        VALUES ({$incoming_id}, {$outgoing_id}, '{$message}')") or die();
        }                                                                                                   /* mesajın kimden geldiği veritabanına eklendi*/
    }else{
        header("location: ../login.php");
    }


    
?>