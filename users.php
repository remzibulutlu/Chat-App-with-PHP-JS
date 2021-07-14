

<?php 
  session_start();
  include_once "php/config.php";
  if(!isset($_SESSION['unique_id'])){   /* session unique id ile aynı değilse logine yönlendir*/
    header("location: login.php");
  }
?>
<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="users">
      <header>
        <div class="content">
          <?php 
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
            if(mysqli_num_rows($sql) > 0){
              $row = mysqli_fetch_assoc($sql);  /* bütün kolonları veritabanından çeker*/
            }
          ?>
          <img src="php/images/<?php echo $row['img']; ?>" alt=""> <!--fotograf veritabanında olmadığı için yerel klasörden sürekli olarak çekme isteği gider-->
          <div class="details">
            <span><?php echo $row['fname']. " " . $row['lname'] ?></span> <!-- isim soyisim göster-->
            <p><?php echo $row['status']; ?></p>    <!-- status login veya signed up durumda iken aktif olur-->
          </div>
        </div>
        <a href="php/logout.php?logout_id=<?php echo $row['unique_id']; ?>" class="logout">Logout</a>
        <!-- logout butonu-->

      </header>

      <div class="search">  <!-- Search bar-->
        <span class="text">Select an user to start chat</span>
        <input type="text" placeholder="Enter name to search...">
        <button><i class="fas fa-search"></i></button> <!-- search bar' aktive etmek için tıklama butonu-->
      </div>
      <div class="users-list">
  
      </div>
    </section>
  </div>

  <script src="javascript/users.js"></script>

</body>
</html>
