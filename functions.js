function kontrolloFjalekalimin(inputtxt){ 
    var paswd=  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/gm;
    if(inputtxt.match(paswd)){ 
        return true;
    }else{ 
        return false;
    }
}  
function checkEmail(email){
if (!email.endsWith('@fti.edu.al')) {
            return false;
        }else{
            return true;
        }
}

module.exports=kontrolloFjalekalimin;
module.exports=checkEmail;
