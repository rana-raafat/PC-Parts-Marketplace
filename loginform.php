<html>

<head>
    <title> Log In </title>
    <?php
        session_start();
        include "Menu.php";

        
        ?>
</head>

<body>
    

    <div class="container">
        <div class="card justify-content-center">
            <div class="carda">
                <form action="" method="post" enctype="multipart/form-data" onsubmit="return validate(this);"
                    class="form-horizontal">
                    <h1>Log In</h1>
                    <div class='alert alert-danger' id="loginAlert" style="visibility: hidden">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <label id="loginError"></label>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <br>
                    <label for="Email">E-mail:</label>
                    <input type="text" name="email" placeholder="example@mail.com" class="form-control">

                    <div class='alert alert-danger' id="EmailAlert" style="visibility: hidden">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <label id="EmailError"></label>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <br>

                    <label for="Password">Password:</label>
                    <input type="Password" name="password" id="Password" placeholder="********" maxlength=50 minlength=8
                        class="form-control">

                    <div class='alert alert-danger' id="PasswordAlert" style="visibility: hidden">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <label id="PasswordError"></label>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <br>
                    <br>
                    <input type="submit" value="Submit" name="Submit">
                    <input type="reset">
                    <br>
                </form>
                
            </div>
        </div>
    </div>
 

    <script>
        
        function ajaxCall(email,pass){
            //
            const xhttp= new XMLHttpRequest();
            xhttp.onload=function(){
          
                if(this.responseText==""){
                   window.location.replace('Home.php');
                   return true;
                }
                else{
                    
                    if(this.responseText=="Incorrect email or password"){
                        document.getElementById('loginError').innerHTML = "Incorrect email or password";
                        document.getElementById('loginAlert').style.visibility = 'visible';
                    }
                    else if(this.responseText=="Invalid email"){
                        document.getElementById('EmailError').innerHTML = 'Enter a valid email';
                        document.getElementById('EmailAlert').style.visibility = 'visible';
                    }
                    return false
                }
            }
            xhttp.open("GET","LogIn.php?em="+email+"&pass="+pass);
            xhttp.send();
        }

        function validate(form) {
            
            if (form.email.value == "") {
                document.getElementById("EmailError").innerHTML = "Email required";
                document.getElementById("EmailAlert").style.visibility = "visible";
                return false;
            }
            if (form.password.value == "") {

                document.getElementById("PasswordError").innerHTML = "Password required";
                document.getElementById("PasswordAlert").style.visibility = "visible";
                return false;
            }
            
            if(ajaxCall(form.email.value, form.password.value)){
            
                return true;
            }
            else{
                
                return false;
            }
        }

    </script>

</body>

</html>