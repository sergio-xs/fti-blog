const emer=document.getElementById("emer");
const mbiemer=document.getElementById("mbiemer");
const email=document.getElementById("email");
const password=document.getElementById("fjalekalimi");
const roli=document.getElementById("roli");

const form=document.getElementById("signup_form");
const signup_button=document.getElementById("signup_button");

if(form){
    form.addEventListener('submit',(e)=>{  
        document.getElementById("error_name").innerHTML="";
        document.getElementById("error_surname").innerHTML="";
        document.getElementById("error_email").innerHTML="";
        document.getElementById("error_password").innerHTML="";
        document.getElementById("error_roli").innerHTML="";
        document.getElementById("php_error").innerHTML="";

        if(emer.value===''|| emer.value==null){
            e.preventDefault();
            document.getElementById("error_name").innerHTML='<i class="fas fa-exclamation-circle"></i> Name is required to sign up';  
         }
        if(mbiemer.value===''||mbiemer.value==null){
            e.preventDefault();
            document.getElementById("error_surname").innerHTML='<i class="fas fa-exclamation-circle"></i> Surname is required to sign up';
         }   
        if(email.value===''|| email.value==null){
           e.preventDefault();
           document.getElementById("error_email").innerHTML='<i class="fas fa-exclamation-circle"></i> Email is required to sign up';  
        }
       if(password.value===''||password.value==null){
           e.preventDefault();
           document.getElementById("error_password").innerHTML='<i class="fas fa-exclamation-circle"></i> Password is required to sign up';
        }
       if(roli.value==='Select'){
           e.preventDefault();
           document.getElementById("error_roli").innerHTML='<i class="fas fa-exclamation-circle"></i> Role field is required to sign up';
        }

        if(CheckPassword(password.value)){  
        }else{
            e.preventDefault();
            document.getElementById("php_error").innerHTML='<i class="fas fa-exclamation-triangle"></i></i> Password must contain at least 8 characters,1 uppercase letter,1 lowercase letter and 1 number';
        }

        if (!email.value.endsWith('@fti.edu.al')) {
            e.preventDefault();
            document.getElementById("php_error").innerHTML='<i class="fas fa-exclamation-triangle"></i> Email\'s domain must be \'@fti.edu.al\'</i>';
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


//Per ndryshimin e te dhenave ne about
const edit_button=document.getElementById('edit_button');
const student_form=document.getElementById('student_form');

edit_button.addEventListener('click',edit);
function edit(){
    
}

