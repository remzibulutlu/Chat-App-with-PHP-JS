

const searchBar = document.querySelector(" .search input"), /*search input, search button ve users-list'i seçer*/
searchBtn = document.querySelector(" .search button"),
usersList = document.querySelector(" .users-list");

searchBtn.onclick = ()=>{
  
  searchBar.classList.toggle("show");          /* search buton'a tıklandığında search bar da aktif hale gelir*/
  searchBtn.classList.toggle("active");        /* ve arama simgesinin rengi değişererk aktif olur*/
  searchBar.focus();   
}


searchBar.onkeyup = ()=>{                     
  let searchTerm = searchBar.value;             /* search bar'a yazılan değeri query selector ile alıyoruz*/
  if(searchTerm != ""){
    searchBar.classList.add("active");          /*search bar'a yazıldığı sürece aramaya ve search barın kalması devam eder */
  }else{
    searchBar.classList.remove("active");       /* herhangi bir karakter yazılmazsa aktif olmaz*/
  }
  let xhr = new XMLHttpRequest();               /* verileri ajax ile search.php'deki sql sorgularını kullanarak yapıyoruz*/
  xhr.open("POST", "php/search.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){  /* sunucuyla iletişim başarılıysa kullanıcı listesini data olarak html şeklinde(?) tutar */
        if(xhr.status === 200){
          let data = xhr.response;
          usersList.innerHTML = data;
        }
    }
  }
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("searchTerm=" + searchTerm);   /* phpye search bar değeri html yapısında gönerilir(?) ve böylece sayfa yenilenmeden kişiler aranır */
}

setInterval(() =>{
  let xhr = new XMLHttpRequest();           /* kullanıcıların her 500 ms'de bir yenilenmesini sağlar*/
  xhr.open("GET", "php/users.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){                       /* sunucuyla iletişim kurulmuşsa kullanıcı listesi phpye html şeklinde gider(?)*/
          let data = xhr.response;
          if(!searchBar.classList.contains("active")){  /* burada hem arama yapan ajaxın hem de kullanıcı listesini güncel tutan ajaxın aynı anda yükleme yapması engellenir */
            usersList.innerHTML = data;                 /* eğer search bar'a bir şeyler yazılıyorsa, kullanıcı listesini yenilemeyi durdurur*/
          }
        }
    }
  }
  xhr.send();
}, 500);

