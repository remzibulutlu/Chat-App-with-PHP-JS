<?php 
    session_start();
    if(isset($_SESSION['unique_id'])){          /* session unique id ile aynıysa veritabanına bağlan*/
        include_once "config.php";

        $outgoing_id = $_SESSION['unique_id'];  /*  gonderici id'si ile ile session unique id'si eşit */
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']); /* alıcı için id değişkeni alınır*/
        $output = "";
       
        $sql = "SELECT * FROM messages JOIN users ON users.unique_id = messages.outgoing_msg_id WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
        OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id ASC"; /* sql sorgusu düzeltildi, mesajlar id'lerine göre sıralanmış(en son en altta) düzgün çalışıyor*/
                                                                                                    /* fotoğrafların mesaj yanında görünmesi için tablolar left join edilmiş fakat
                                                                                                    inner,left, right joinlerinin hepsi de çalışyor ???*/
        $query = mysqli_query($conn, $sql); /* alıcı ve gonderici kişilerin mesajlarının idleri birbiriyle karşılaştırılır*/
        
        if(mysqli_num_rows($query) > 0){    /* eğer sağlanan durum varsa*/
            
            while($row = mysqli_fetch_assoc($query)){
                if($row['outgoing_msg_id'] === $outgoing_id){ /* mesaj gönderici kişinin mesajıdır  */
                    $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>'. $row['msg'] .'</p>
                                </div>
                                </div>';
                }else{                                           /* mesaj alıcının mesajıdır ve gelen mesaja fotoğrafı eklenir */
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