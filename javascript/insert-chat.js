const form = document.querySelector(".typing-area"),           /* chat.php'den gerekli alanlar alınır*/
incoming_id = form.querySelector(".incoming_id"),              /* mesajların yüklenmesi için alıcının id değerinin phpye gönderilmesi gerekir*/
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");

form.onsubmit = (e)=>{
    e.preventDefault();             /* httprequestten önce submit engellenir*/
}

inputField.focus();
inputField.onkeyup = ()=>{
    if(inputField.value != ""){
        sendBtn.classList.add("active");        /* en az bir karakter yazdıktan sonra gönder butonu aktif hale gelir*/
    }else{
        sendBtn.classList.remove("active");
    }
}

sendBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){   /*başarılı bir bağlantı sağlandığında xml verilerini içeren formData'yı phpye gönder*/
          if(xhr.status === 200){
              inputField.value = "";        /* mesaj gönderildikten sonra mesaj kutusunu boş bırakır*/
              scrollToBottom();             /* chat en altta tutulur*/
          }
      }
    }
    let formData = new FormData(form);      /* xml formdata verisi  phpye yollanır*/
    xhr.send(formData);
}
chatBox.onmouseenter = ()=>{        /* mouse ile tıklandıgında veya scroll edildiğnde otomatik scroll durur*/
    chatBox.classList.add("active");
}

chatBox.onmouseleave = ()=>{
    chatBox.classList.remove("active"); /* mouse başka yere tıklandıgında chat box aktıflıgı kalkar*/
}

setInterval(() =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/get-chat.php", true);      /* get-chat.php'den verileri alır*/
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){                   /* başarılı şekilde bağlantı kurulursa*/
            let data = xhr.response;
            chatBox.innerHTML = data;               /* formdata html yapısında gönderilir*/
            if(!chatBox.classList.contains("active")){
                scrollToBottom();                      /* mouse devreye girmedğinde chatbox sürekli yenilenerek altta durmaya itilir*/
              }
          }
      }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("incoming_id="+incoming_id.value);     /*alıcı id değeri ajax ile gönderilir*/
}, 500);

function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;   /* otomatik olarak chatbox'ı kaydırır*/
  }
  