<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="Fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css2/style.css">
</head>
<body>

    <div class="main">

        <section class="signup">
            <!-- <img src="images/signup-bg.jpg" alt=""> -->
            <div class="container">
                <div class="signup-content">
                    <form method="POST" action="" id="signup-form" class="signup-form">
                        <h2 class="form-title">Create account</h2>
                        <div class="form-group">
                            <input type="text" class="form-input" name="name" id="name" placeholder="Your Name" required/>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-input" name="username" id="email" placeholder="Username" required/>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-input" name="password" id="password" placeholder="Password" required/>
                            <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-input" name="re_password" id="re_password" placeholder="Repeat your password" required/>
                            
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" required/>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" class="form-submit" value="Sign up"/>
                        </div>
                    </form>
                    <p class="loginhere">
                        Have already an account ? <a href="loginForm.php" class="loginhere-link">Login here</a>
                    </p>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="vendor2/jquery/jquery.min.js"></script>
    <script src="js2/main.js"></script>
    <script>
        const name = document.getElementById("name");
        const userName = document.getElementById("email");
        const pass = document.getElementById("password");
        const cPass = document.getElementById("re_password");
        const submit = document.getElementById("submit");
        submit.addEventListener("click", function(){
            let xhttp = new XMLHttpRequest();
            let data = {"name": name.value, 
                        "userName": userName.value,
                        "pass": pass.value,
                        "cPass": cPass.value};
            console.log(data); 
            if (pass.value !== cPass.value){
                alert ("Passwords didn't match! Try again!")
            } else{
                xhttp.onreadystatechange = function() {
                  if (xhttp.readyState == 4 && xhttp.status == 200) {
                    if (xhttp.responseText == "This username already exists! Try another one!!"){
                        alert(xhttp.responseText);
                    }else if(xhttp.responseText == ""){
                        alert("Signed up successfully");
                        window.location.href = "loginForm.php";
                    }
                   }
               
            } 
            let sendData = JSON.stringify(data);            
                xhttp.open("POST", "Register.php");
                xhttp.send(sendData);         
           
        }
    })
    </script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>