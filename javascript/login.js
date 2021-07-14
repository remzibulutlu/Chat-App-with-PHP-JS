


const form = document.querySelector(".login form"),   /* login.phpden gerekli alanlar alınır*/
continueBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-text");

form.onsubmit = (e)=>{    /* httprequestten once submit etmeyi engelliyoruz*/
    e.preventDefault();
}

continueBtn.onclick = ()=>{                   /* input edilen verileri login.phpden alarak sunucunun da uygun olması durumunda*/
    let xhr = new XMLHttpRequest();           /* başarılı bir bağlantı sağlandığında xml verilerini içeren formData'yı phpye göndererek */
    xhr.open("POST", "php/login.php", true);  /* users.phpyi yükler ya da hata gösterir */
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              let data = xhr.response;
              if(data === "success"){         /*login yaparken 'echo "success";' çıktısına bağlıdır*/
                location.href = "users.php";
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