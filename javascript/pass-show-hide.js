const pswrdField = document.querySelector(".form input[type='password']"), /*formdaki ilk password kısmını seçer*/
toggleIcon = document.querySelector(".form .field i"); /* formdaki ilk field'daki id'yi getirir (fas fa eye)*/

toggleIcon.onclick = () =>{
  if(pswrdField.type === "password"){ /*tıklayınca password'ü texte çevirir ve fas fa eye'i açar*/
    pswrdField.type = "text";
    toggleIcon.classList.add("active");
  }else{
    pswrdField.type = "password"; /* ya da text durumda ise password'e çevirir ve fas fa eye'i kaldırır*/
    toggleIcon.classList.remove("active");
  }
}
