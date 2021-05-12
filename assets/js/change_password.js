const old_password=document.getElementById("old_password");
const new_password=document.getElementById("new_password");
const confirm_new_password=document.getElementById("confirm_new_password");

const form=document.getElementById("change_password_form");

if(form){
   
    form.addEventListener('submit',(e)=>{  
        document.getElementById("error_confirm_new_password").innerHTML="";
        document.getElementById("error_new_password").innerHTML="";
        document.getElementById("error_old_password").innerHTML="";
        document.getElementById("php_error").innerHTML="";
        
        if(confirm_new_password.value==''|| confirm_new_password.value==null){
            e.preventDefault();
            document.getElementById("error_confirm_new_password").innerHTML='<i class="fas fa-exclamation-circle"></i> Confirm new password';  
         }
       
         if(new_password.value==''||new_password.value==null){
            e.preventDefault();
            document.getElementById("error_new_password").innerHTML='<i class="fas fa-exclamation-circle"></i> You have not provided a new password';
         }else{
            if(CheckPassword(new_password.value)){  
               
               
                if(!confirmPassword()){
                    console.log('hi');
                    e.preventDefault();
                    document.getElementById("error_confirm_new_password").innerHTML='<i class="fas fa-exclamation-circle"></i> Passwords don\'t match';
                }else{
                   
                    console.log('jane ok');
                
                }
                
            }else{

                e.preventDefault();
                document.getElementById("error_new_password").innerHTML='<i class="fas fa-exclamation-circle"></i> Password must contain at least 8 characters,1 uppercase letter,1 lowercase letter and 1 number';
            }
         }

        if(old_password.value==''|| old_password.value==null){
            console.log('null pasw');
            e.preventDefault();
            document.getElementById("error_old_password").innerHTML='<i class="fas fa-exclamation-circle"></i> Old password is required'; 
         }
       
        
        

    })
    
}

/*- at least 8 characters
- must contain at least 1 uppercase letter, 1 lowercase letter, and 1 number
- Can contain special characters 
*/
function CheckPassword(inputtxt){ 
    var paswd=  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/gm;
    if(inputtxt.match(paswd)){ 
        return true;
    }else{ 
        return false;
    }
}  

function confirmPassword(){
    if(new_password.value.trim()===confirm_new_password.value.trim()){
        
        return true;
        
    }else{
        console.log(confirm_new_password.value);
        console.log(new_password.value);
        return false;
    }
}

/* Funksion per konfirmimin e fshirjes se account*/
function confirmAccDeletion(){
    var txt;
  if (confirm("Are you sure you want to delete your account?")) {
    txt = "You pressed OK!";
    window.location.replace("delete_account.php");
  } else {
    txt = "You pressed Cancel!";
  }
}
