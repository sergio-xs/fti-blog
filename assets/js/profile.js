//Realizon klikimin e butonit submit ne momentin qe zgjidhet foto qe do te vendoset ne menyre qe te fshihet si buton mos te klikohet nga perdoruesi
let upload_button=document.getElementById("upload_button");
let save_changes=document.getElementById("save_changes");
upload_button.addEventListener('change',submit_form);

function submit_form(){
   save_changes.click();
}



let relationship_button=document.getElementById("relationship_button");

//Metode qe ben nje kerkese Ajax
function sendAjaxRequest(url, cFunction) {
   var xhttp;
   xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
     if (this.readyState == 4 && this.status == 200) {
       cFunction(this);
     }
   };
   xhttp.open("GET", url, true);  //true eshte per asynchronous
   xhttp.send();
 }

function myFunction1(xhttp) {
  // action goes here
  var relationship_status=JSON.parse(xhttp.responseText);

  console.log("hi"+relationship_status['status']);
  if(relationship_status['status']==1){
   relationship_button.innerHTML='<i class="fas fa-user-friends"></i> <i class="fas fa-angle-down"></i>';
  }else if(relationship_status['status']==0){
   relationship_button.innerHTML='<i class="fas fa-user-plus">';
  }else if(relationship_status['status']==2){
   relationship_button.innerHTML='<i class="fas fa-user-plus">';
   relationship_button.disabled=true;
  }
}

//Per pjesen e relationship button
window.addEventListener('load', (event) => {

   sendAjaxRequest("relationship_button.php",myFunction1)
  
 });

if(relationship_button!=null){
relationship_button.addEventListener('click', (event) => {

   sendAjaxRequest("relationship_actions.php",myFunction1);
  
 });
}
//Per pjesen e notifications

