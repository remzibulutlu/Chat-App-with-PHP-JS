<?php 
    session_start();
    if(isset($_SESSION['unique_id'])){          /* session unique id ile aynıysa veritabanına bağlan*/
        include_once "config.php";

        $outgoing_id = $_SESSION['unique_id'];  /*  gonderici id'si ile ile session unique id'si eşit */
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']); /* alıcı için id değişkeni alınır*/
        $output = "";
       
       $sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC";
        $query = mysqli_query($conn, $sql); /* alıcı ve gonderici kişilerin mesajlarının idleri birbiriyle karşılaştırılır*/
        
        if(mysqli_num_rows($query) > 0){    /* eğer sağlanan durum varsa*/
            
            while($row = mysqli_fetch_assoc($query)){
                if($row['outgoing_msg_id'] === $outgoing_id){ /* mesaj gönderici kişidir  */
                    $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>'. $row['msg'] .'</p>
                                </div>
                                </div>';
                }else{                                           /* mesaj alıcıdır*/
                    $output .= '<div class="chat incoming">
                                <img src="php/images/'.$row['img'].'" alt="">
                                <div class="details">
                                    <p>'. $row['msg'] .'</p>
                                </div>
                                </div>';
                }
            }
        }else{              /* sağlanan durum yoksa*/
            $output .= '<div class="text">No messages...</div>';
        }
        echo $output;
    }else{                      /*login sayfasına yönlendirilir*/
        header("location: ../login.php");
    }

?>