<?php
    session_start();
    include_once "config.php";                                      /*Veritabanımıza bağlanarak veriyi çekiyoruz*/
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);




    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){    /* boş alanları doldurmalıyız*/

        if(filter_var($email, FILTER_VALIDATE_EMAIL)){                              /* mail uygunluğu kontrol edilmeli*/
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");


            if(mysqli_num_rows($sql) > 0){                  /*veritabnındaki mail kolonunda aynı mail varsa hata verir yoksa fotoğraf özelliklerine geçilir*/
                echo "$email - This email exists!";
            }else{
                if(isset($_FILES['image'])){                /* yüklenecek olan fotoğrafın özellikleri*/
                    $img_name = $_FILES['image']['name'];   /* adı*/
                    $img_type = $_FILES['image']['type'];   /*tipi*/
                    $tmp_name = $_FILES['image']['tmp_name']; /*geçici adı ?*/
                    
                    $img_explode = explode('.',$img_name);  /* fotograf uzantısını nokta ile ayırmalıyız*/
                    $img_ext = end($img_explode);
    
                    $extensions = ["jpeg", "png", "jpg"];
                    
                    if(in_array($img_ext, $extensions) === true){   /* array içindeki kabul edilen uzantılar dışındaki uzantılı bir dosya yüklenmeye çalışırsa hata verir */
                        $types = ["image/jpeg", "image/jpg", "image/png"];

                        if(in_array($img_type, $types) === true){   
                            
                            
                            $time = time();
                            $new_img_name = $time.$img_name; /* fotoğrafları şimdiki zaman ile damgalayıp benzersiz isimli fotograflar yataıyoruz*/

                            if(move_uploaded_file($tmp_name,"images/".$new_img_name)){  /* fotoğrafı veritabanına değil, yerel klasore kaydediyoruz, veritabanına sadece ismini kaydediyoruz*/
                                
                                
                                $ran_id = rand(time(), 100000000);  /* random olarak sayı oluşturup bunu unique id olmak üzere kullanacağız*/
                                $status = "Active now";             /*veritabanında status varchar oluşturulacak*/
                                $encrypt_pass = md5($password);     /* şifreleme SHA256 değil*/

                                $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                                VALUES ({$ran_id}, '{$fname}','{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')");
                                /* alınan veriler veritabanına yazılır*/

                                if($insert_query){
                                    $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                    
                                    if(mysqli_num_rows($select_sql2) > 0){
                                        $result = mysqli_fetch_assoc($select_sql2);
                                        $_SESSION['unique_id'] = $result['unique_id']; /*başarılı olarak yazılmışsa( o emaile ait olan)  unique id ile session assign edilir ve logout olana kadar status active olur*/
                                        echo "success";
                                    
                                    }else{
                                        echo "This email doesn't exist!";
                                    }
                                }else{
                                    echo "Something went wrong. Please try again!";
                                }
                            }
                        }else{
                            echo "Please upload an image file - jpeg, png, jpg";
                        }
                    }else{
                        echo "Please upload an image file - jpeg, png, jpg";
                    }
                }
            }
        }else{
            echo "$email is not a valid email!";
        }
    }else{
        echo "All input fields are required!";
    }
?>