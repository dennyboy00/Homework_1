function verifyName(){
    const nameInput=document.querySelector('#name input');
    if(nameInput.value.length>0){
    nameInput.style.border="solid 2px green";
    document.querySelector("#name span").textContent="";
    }else{
     nameInput.style.border="solid 2px red";
     document.querySelector("#name span").textContent="Inserire un nome";
     
   }
}

function onResponse(response){
    console.log(response);
    if(!response.ok) return null;
    return response.json();
}


function onJsonUser(json){
    //console.log(json);
    if(json.exists === false){
        const userInput=document.querySelector('#user input');
        userInput.style.border="solid 2px green";
        document.querySelector("#user span").textContent="";
       

    }else{
        userInput.style.border="solid 2px red";
        document.querySelector("#user span").textContent="Username già utilizzato";
   
    }
}

function onJsonMail(json){
    console.log(json);
    if(json.exists === false){
        const mailInput=document.querySelector('#email input');
        mailInput.style.border="solid 2px green";
        document.querySelector("#email span").textContent="";
        
    }else{
        mailInput.style.border="solid 2px red";
        document.querySelector("#email span").textContent="Mail già utilizzata";
   
    }
}

function verifyUser(){
    
    const userInput=document.querySelector('#user input');
    var usernamePattern = /^[a-zA-Z0-9_-]+$/;
    if(usernamePattern.test(userInput.value)){
     fetch("verifyUser.php?q="+encodeURIComponent(userInput.value)).then(onResponse).then(onJsonUser);
     
    }else{
        userInput.style.border="solid 2px red";
        document.querySelector("#user span").textContent="Username non valido";
   
    }

}

function verifyEmail(){
 
    const mailInput=document.querySelector('#email input');
    var mailPattern=/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;

    if(mailPattern.test(mailInput.value)){
      fetch("verifyEmail.php?q="+ encodeURIComponent(mailInput.value)).then(onResponse).then(onJsonMail);
    }else{
        mailInput.style.border="solid 2px red";
        document.querySelector("#email span").textContent="Indirizzo mail non valido";
   
    }
}

function verifyPassword(){
   
    var passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
    const pwInput=document.querySelector("#password input");
    if(passwordPattern.test(pwInput.value)){
        pwInput.style.border="solid 2px green";
        document.querySelector("#password span").textContent="";
        
    }else{
        pwInput.style.border="solid 2px red";
        document.querySelector("#password span").textContent="Password non valida";
   
    }
}

function verifyConfPassword(){
   
    const confInput=document.querySelector("#conf_password input");
    if(confInput.value === document.querySelector("#password input").value){
        confInput.style.border="solid 2px green";
        document.querySelector("#conf_password span").textContent="";
        
    }else{
        confInput.style.border="solid 2px red";
        document.querySelector("#conf_password span").textContent="le password non coincidono";
   
    }
}

document.querySelector('#name input').addEventListener('blur', verifyName);
document.querySelector('#user input').addEventListener('blur', verifyUser);
document.querySelector('#email input').addEventListener('blur', verifyEmail);
document.querySelector('#password input').addEventListener('blur', verifyPassword);
document.querySelector('#conf_password input').addEventListener('blur', verifyConfPassword);






