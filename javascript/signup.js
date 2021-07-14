const form = document.querySelector(".signup form"),    /* index.phpden gerekli alanları alıyoruz*/
continueBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-text");

form.onsubmit = (e)=>{      /* form submiti önlemeliyiz çünkü önce htmlhttprequest'in çalışmasını istiyoruz*/
    e.preventDefault();
}

continueBtn.onclick = ()=>{                       /* gerekl bilgileri girdikten sonra 'devam et' butonuna basıp*/
    let xhr = new XMLHttpRequest();               /* verileri ajax (bir xml yaratarak) ile veritabanından çekmeyi*/
    xhr.open("POST", "php/signup.php", true);     /* signup.php'deki sql sorgularını kullanarak yapıyoruz*/
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){                   /* sunucu isteği başararıyla atılırsa ve cevap olarak olumlu dönülürse*/
              let data = xhr.response;              /* zaten signup.php ile unique id'li bir session başlamış olacağı için*/
              if(data === "success"){               /* signup olurken 'echo "success";' değerine bağlıdır, phpye formData kullanılarak sorgunun anahtar-değer ilişkisini içeren bir dosya gönderir ve kullanıcıların göründüğü sayfayı yükler*/
                location.href="users.php";          /* ya da error-text'teki hatayı gösterecektir (none, block vs.) ?????? */
              }else{                                
                errorText.style.display = "block";
                errorText.textContent = data;
              }
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}