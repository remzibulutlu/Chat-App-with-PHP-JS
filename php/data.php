<?php
    while($row = mysqli_fetch_assoc($query)){


        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['unique_id']}
                OR outgoing_msg_id = {$row['unique_id']}) AND (outgoing_msg_id = {$outgoing_id} 
                OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
        
        /* gelen ve giden mesajların en sonuncularını(limit 1) unique id'lerine göre eşleştiriyoruz (????) */
        
        $query2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($query2);
        
        (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result ="No message available";
        (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;   /* user list'te mesajları böler, 28 karakterden fazlaysa*/
        
        if(isset($row2['outgoing_msg_id'])){
            ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = ""; /* user list'te en on kimin mesaj attığı görnür */
        }else{
            $you = "";
        }
        ($row['status'] == "Offline now") ? $offline = "offline" : $offline = ""; /* status kontrolu*/
        ($outgoing_id == $row['unique_id']) ? $hid_me = "hide" : $hid_me = ""; /* ??? gönderici durumunu gizler */

                                                     /* chat için girilen kişinin unique id'si url olarak görünür ve diğer detaylar chat içinde görünür*/
        $output .= '<a href="chat.php?user_id='. $row['unique_id'] .'">
                    <div class="content">
                    <img src="php/images/'. $row['img'] .'" alt="">
                    <div class="details">
                        <span>'. $row['fname']. " " . $row['lname'] .'</span>
                        <p>'. $you . $msg .'</p>
                    </div>
                    </div>
                    <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                </a>';
    }
?>
