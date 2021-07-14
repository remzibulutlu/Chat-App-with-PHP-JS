<?php 
  session_start();
  include_once "php/config.php";
  if(!isset($_SESSION['unique_id'])){   /*session eğer unique id'ye eşit değilse login'e yönlendir*/
    header("location: login.php");
  }
?>
<?php include_once "header.php"; ?>     <!-- header.php include et-->
<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php 
          $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);   /* user id'nin unique id'ye eşit olduğu satırlar(sohbetler) varsa getirir*/
          $unique_id = mysqli_real_escape_string($conn, $_SESSION['unique_id']);
          $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
          if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
          }else{                                  /* yoksa kullanıcı listesine gelir */
            header("location: users.php");
          }
        ?>
        <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a> <!--chatboxta geri gitme( users.php'ye) linki ok resmi-->
        <img src="php/images/<?php echo $row['img']; ?>" alt="">           <!-- aynı zamanda yerel fotoğraf adresi, isim soy isim ve ativite durumları da eklenir-->
        <div class="details">
          <span><?php echo $row['fname']. " " . $row['lname'] ?></span>
          <p><?php echo $row['status']; ?></p>
        </div>
      </header>
      <div class="chat-box">

      </div>
      <form action="#" class="typing-area">
      <input type="text" class="outgoing_id" name="outgoing_id" value="<?php echo $unique_id; ?>" hidden>
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden> <!-- mesaj alıcı user id'si gizlenir-->
        <input type="text" name="message" class="input-field" placeholder="Type a message here..."> <!-- mesaj yazma alanı-->
        <button><i class="fab fa-telegram-plane"></i></button> <!-- gönderme butonu olarak telegram iconu (font awesome'dan)-->
      </form>
    </section>
  </div>

  <script src="javascript/insert-chat.js"></script>

</body>
</html>
