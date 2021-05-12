//Validimi i formes
 const email=document.getElementById("email");
 const password=document.getElementById("password");
 const form=document.getElementById("login_form");
 const login_button=document.getElementById("login_button");
 const php_error=document.getElementById("php_error");
 
 form.addEventListener('submit',(e)=>{
   document.getElementById("error_email").innerHTML="";
   document.getElementById("error_password").innerHTML="";
     if(email.value===''|| email.value==null){     
        e.preventDefault();
        console.log("hi");
        document.getElementById("error_email").innerHTML='<i class="fas fa-exclamation-circle"></i> Email is required to log in';  
     }
    if(password.value===''||password.value==null){
        e.preventDefault();
        document.getElementById("error_password").innerHTML='<i class="fas fa-exclamation-circle"></i> Password is required to log in';
        
      }
 })

 //Boshatis inputin e gabuar
 if(php_error.innerText.trim()==="Wrong password".trim()){
    password.value="";
   }

if(php_error.innerText.trim()==="No such email was found".trim()){
    email.value="";
    password.value="";
   }

 
 