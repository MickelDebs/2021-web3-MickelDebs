<!DOCTYPE html>
<html>
    <?php
    include 'CreateAccount.php';
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
                <div class="AuthPage-container">
                <div class="navbar">
                <a href="signin.php" >Sign in</a>
                <a href="signup.php" style="color:#F3A800;text-decoration:underline">Sign up</a></div>
                <div class="login-form" id="signup-form">
                    <h2 class="title">Create new account</h2>
                    <div class="form-inner">
                    <form method="POST" onsubmit="signupfunction();" action="signup.php">
                        <div class="input-div">
                            <input type="text" name="username"id="signup-user" oninput="Check(this);" <?php if($user_error==true){echo('style="color:red"');} ?> placeholder="Username">
                            <div class="spinner-parent">
                                <div class="spinner"></div>
                                <div class="spinner-error" id="user-error"<?php 
                                    if($user_error==true)
                                    {
                                        echo('style="display:inline"');
                                    }
                                    $str="Username already exists .Suggested user names:";

                                    for($i=0;$i<count($suggested);$i++)
                                    {
                                        $str.=$suggested[$i]." ";
                                    }
                                    echo("data-title=".'"'.$str.'"');
                                ?>>
                                </div>
                            </div>
                        </div>
                        <div class="input-div">
                            <input type="text" name="email" oninput="Check(this);" placeholder="Email" id="signup-email">
                            <div class="spinner-parent">
                                <div class="spinner" id="email-spinner">
                                </div>
                                <div class="spinner-error" data-title="You need to type a valid email" id="email-error">
                                </div>
                                <div class="spinner-correct" id="email-correct" <?php if($user_error==true){echo('style="display:inline"');} ?>>
                                </div>
                            </div>
                        </div>
                        <div class="input-div">
                            <input type="password" name="password" oninput="Check(this);" placeholder="Password" id="signup-pass">
                            <div class="spinner-parent">
                                <div class="spinner" id="pass-spinner">
                                </div>
                                <div class="spinner-error" data-title="Password needs to be atleast 8 characters and 
                                        contains atleast a number and a special character" id="pass-error">
                                </div>
                                <div class="spinner-correct" id="pass-correct" <?php if($user_error==true){echo('style="display:inline"');} ?>>
                                </div>
                            </div>
                            
                        </div>
                        <div class="input-div">
                            <input type="password"  oninput="Check(this);" placeholder="Confirm Password" id="signup-cpass">
                            <div class="spinner-parent">
                                <div class="spinner" id="cpass-spinner">
                                </div>
                                <div class="spinner-error" data-title="Passwords need to match" id="cpass-error">
                                </div>
                                <div class="spinner-correct" id="cpass-correct" <?php if($user_error==true){echo('style="display:inline"');} ?>>
                                </div>
                            </div>
                        </div>
                        <p class="forget"><a href="signin.php">Already have an account ? </a></p>
                        <div class="hr">
                        </div>
                        <input type="submit" id="submit" class="submit" id="submit" value="Create account" name="signup">
                    </form>
                        </div>
                </div>
            </div>
        </div>
    </div>            
    </body>
    <script>    
    <?php
    if($user_error==true)
    {
        echo(
            '$(window).on("load", function(){
                $("#order-button").click();
                $("#signup").click();
                $("#signup-user").val('.'"'.$username.'"'.');
                $("#signup-email").val('.'"'.$email.'"'.');
                $("#signup-pass").val('.'"'.$password.'"'.');
                $("#signup-cpass").val('.'"'.$password.'"'.');
            });'
        );
    }

    ?>
         //Check Password
            var input = $('#signup-pass');

            // Init a timeout variable to be used below
            var timeout = null;

            // Listen for keystroke events
            input.keyup(function(){
                $('#pass-spinner').show();
                $('#pass-error').hide();
                $('#pass-correct').hide();

                clearTimeout(timeout);
                timeout = setTimeout(function () {
                    if(CheckPass(input.val())==true)
                    {
                        $('#pass-spinner').hide();
                        $('#pass-error').hide();
                        $('#pass-correct').show();
                    }else
                    {
                        $('#pass-spinner').hide();
                        $('#pass-error').show();
                        $('#pass-correct').hide();
                    }
                }, 400);
            });

        function CheckPass(str)
        {
            var reg=/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?& ]{8,}$/;

            if(str.match(reg))
            {
                return true;
            }
            return false;
        }
            var cinput = $('#signup-cpass');

            // Init a timeout variable to be used below
            var ctimeout = null;

            // Listen for keystroke events
            cinput.keyup(function(){
                $('#cpass-spinner').show();
                $('#cpass-error').hide();
                $('#cpass-correct').hide();

                clearTimeout(ctimeout);
                ctimeout = setTimeout(function () {
                    if(cinput.val()==$('#signup-pass').val())
                    {
                        $('#cpass-spinner').hide();
                        $('#cpass-error').hide();
                        $('#cpass-correct').show();
                    }else
                    {
                        $('#cpass-spinner').hide();
                        $('#cpass-error').show();
                        $('#cpass-correct').hide();
                    }
                }, 400);
            });

            var emailinput = $('#signup-email');

            // Init a timeout variable to be used below
            var emailtimeout = null;

            // Listen for keystroke events
            emailinput.keyup(function(){
                $('#email-spinner').show();
                $('#email-error').hide();
                $('#email-correct').hide();

                clearTimeout(emailtimeout);
                emailtimeout = setTimeout(function () {
                    if(CheckEmail(emailinput.val())==true)
                    {
                        $('#email-spinner').hide();
                        $('#email-error').hide();
                        $('#email-correct').show();
                    }else
                    {
                        $('#email-spinner').hide();
                        $('#email-error').show();
                        $('#email-correct').hide();
                    }
                }, 400);
            });
            
            function CheckEmail(str)
            {
                var reg=/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/gi;

                if(str.match(reg))
                {
                    return true;
                }
                return false;
            }
            function Check(element)
            {
                if(element.style.color=="red")
                {
                    ChangeColor(element);
                }
                var button=document.getElementById("submit");
                

                var username=document.getElementById("signup-user").value;
                var email=document.getElementById("signup-email").value;
                var password=document.getElementById("signup-pass").value;
                var cpassword=document.getElementById("signup-cpass").value;

                if(CheckUsername(username)&&
                CheckEmail(email)&&
                CheckPass(password)&&
                password==cpassword)
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
            function signupfunction()
            {
                var username=document.getElementById("signup-user");
                var email=document.getElementById("signup-email");
                var pass=document.getElementById("signup-pass");
                var cpass=document.getElementById("signup-cpass");
                
                var boolArray=[];
                    boolArray.push(CheckUsername(username.value));
                    boolArray.push(CheckEmail(email.value));
                    boolArray.push(CheckPass(pass.value));
                    boolArray.push(pass.value==cpass.value);
                    for(var i=0;i<boolArray.length;i++)
                        {
                            if(boolArray[i]==false)
                            {
                            event.preventDefault();
                            return false;
                            }
                        }
                return true;
            }
            function ChangeColor(element)
            {
                element.style.color="white";
            }
            
    </script>
</html>