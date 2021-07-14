<?php
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";          /* kullanıcı giriş durumundaysa logout için session değişken oluşturulur yoksa login'e yönlendirilir*/
        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
        
        if(isset($logout_id)){          
                                    /* eğer logout olunursa, kullanıcı durumu da  active now'dan offline now'a alınır */
            $status = "Offline now";
            $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id={$_GET['logout_id']}");
            if($sql){
                session_unset();
                session_destroy();          /*session kapatılır ve login sayfasına yonlendirilir*/
                header("location: ../login.php");
            }
        }else{
            header("location: ../users.php");
        }
    }else{  
        echo("location: ../login.php");
    }
?>