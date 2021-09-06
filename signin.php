<!DOCTYPE html>
<html>
    <?php
    include 'Login.php';

    if(isset($_SESSION['username']))
    {
        header('location:index.php');
    }
    ?>
    <head>
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
        <script src="jQuery.js"></script>
    </head>
    <body>
        <div class="root">
            <div class="AuthPage">
                <div class="AuthPage-header">
                    <div class="logo">
                        <div class="logo-img"><img src="./images/logo.png"></div>
                        <a class="logo-text" href="index.php">BFE</a>
                    </div>
                    <div class="close" onclick="location.href='index.php';">
                        <img src="./images/icons/close.png">
                    </div>
                </div>
                <div class="AuthPage-login">
                <!--Login-->
                <div class="AuthPage-container">
                <div class="navbar">
                <a href="signin.php" style="color:#F3A800;text-decoration:underline">Sign in</a>
                <a href="signup.php">Sign up</a></div>
                <div class="login-form" id="login-form">
                    <h2 class="title">Sign in to your account</h2>
                    <div class="form-inner">
                    <form method="POST" onsubmit="loginfunction();" action="signin.php">
                        <div class="input-div">
                            <input type="text" oninput="Check(this)" placeholder="Username" <?php if($invalidLogin==true){echo('style="color:red"');}?>name="login-username" id="login-user"> 
                            
                            <div class="spinner-parent">
                                <div class="spinner" id="user-login-spinner">
                                </div>
                                <div class="spinner-error" data-title="Username can't be empty and cannot contain spaces." id="user-login-error">
                                </div>
                                <div class="spinner-correct" id="user-login-correct">
                                </div>
                            </div>
                        </div>
                        <div class="input-div">
                            <input type="password" oninput="Check(this)" placeholder="Password" name="login-password" id="login-pass">
                        </div>
                        <?php
                            if($invalidLogin==true)
                            {
                                echo('
                                <p class="forget" style="color:red;margin-bottom:20px">Invalid Login</p>
                                ');
                            }
                        ?>
                        <p class="forget"><a href="#">Forgot password ? </a></p>
                        <p class="forget"><a href="signup.php">Don't have an account ? </a></p>
                        <div class="hr">
                        </div>
                        <input type="submit" id="submit" class="submit" value="Sign in" name="login">
                    </form>
                        </div>
                </div>
            </div>
        </div>
    </div>            
    </body>
    <script>
    <?php
    if($invalidLogin==true)
    {
        echo('$(window).on("load", function(){
            $("#login-user").val('.'"'.$loginUsername.'"'.');
        });
        ');
    }
    ?>
        
        var loginUserInput = $('#login-user');

        // Init a timeout variable to be used below
        var loginUsertimeout = null;

        // Listen for keystroke events
        loginUserInput.keyup(function(){
            $('#user-login-spinner').show();
            $('#user-login-error').hide();
            $('#user-login-correct').hide();

            clearTimeout(loginUsertimeout);
            loginUsertimeout = setTimeout(function () {
                if(CheckUsername(loginUserInput.val()))
                {
                    $('#user-login-spinner').hide();
                    $('#user-login-error').hide();
                    $('#user-login-correct').show();
                }else
                {
                    $('#user-login-spinner').hide();
                    $('#user-login-error').show();
                    $('#user-login-correct').hide();
                }
            }, 400);
        });

 function Check(element)
            {
                if(element.style.color=="red")
                {
                    ChangeColor(element);
                }
                var button=document.getElementById("submit");
                
                var bool=false;

                var username=document.getElementById("login-user").value;
                var password=document.getElementById("login-pass").value;

                if(CheckUsername(username)&&password!="")
                {
                    button.style.backgroundColor="#F3A800";
                    button.style.cursor="pointer";
                    button.style.color="white";
                }else
                {
                    button.style.backgroundColor="#323738";
                    button.style.cursor="default";
                    button.style.color="#747778";
                }
            }
            function CheckUsername(str)
            {
                var reg=/\s/gi;
                if(str!=""){
                    if(!str.match(reg))
                    {
                        return true;
                    }
                }
                return false;
            }
            
            function ChangeColor(element)
            {
                element.style.color="white";
            }
            function loginfunction()
            {
                var username=document.getElementById("login-user");
                var pass=document.getElementById("login-pass");

                if(username.value!=""&pass.value!=""){
                    if(CheckUsername(username.value))
                    {
                        return true;
                    }
                }
                event.preventDefault();
                return false;
            }
            
    </script>
</html>