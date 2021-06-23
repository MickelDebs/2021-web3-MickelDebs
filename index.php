<!DOCTYPE html>
<html>
    <?php 
    include 'CreateAccount.php';
    include 'Login.php';

    if(isset($_SESSION['username']))
    {
        header('location:testpage.php');
    }
    ?>
    <head>
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
        <script src="jQuery.js"></script>
    </head>
    <body>
        <div class="background-flex">
            <div class="flex-column logo-div ">
                <div class="background-div-1 ">
                        <div class="background-div-1_1 "></div>
                        <div class="background-div-1_2 "><span>BFE</span></div>
                </div>
                <div class="background-div-3">
                    <span class="div-3-span-1">JUICY & HOT FOOD</span>
                    <br><br>
                    <span class="div-3-span-2">Delivering now all accross lebanon!</span>
                    <br><br><br>
                    <input type="button" class="start-button" value="Order Now" id="order-button">
                </div>
            </div>
            <div class="flex-column background-div-2">
            </div>
        </div>
        <div class="login-box" id="login-box">
            <div class="login-toolbar">
                <div class="toolbar-x" id="toolbar-x"></div>
            </div>
            <div class="login-div" id="login-div">
                <!--Login-->
                <div class="login-form" id="login-form">
                    <h2 class="login-text">Login</h2>
                    <form method="POST" onsubmit="loginfunction();" action="index.php">
                        <div class="input-div">
                            <input type="text" oninput="ChangeColor(this);" placeholder="Username" <?php if($invalidLogin==true){echo('style="color:red"');}?>name="login-username" id="login-user"> 
                            <div class="spinner-parent">
                                <div class="spinner" id="user-login-spinner">
                                </div>
                                <div class="spinner-error" id="user-login-error">
                                    <div class="tooltiptext" >Username cannot contain spaces.</div>
                                </div>
                                <div class="spinner-correct" id="user-login-correct">
                                </div>
                            </div>
                        </div>
                        <div class="input-div">
                            <input type="password" placeholder="Password" name="login-password" id="login-pass">
                        </div>
                        <?php
                            if($invalidLogin==true)
                            {
                                echo('<div class="input-div">
                                <p class="forget" style="color:red">Invalid Login</p>
                                </div>
                                ');
                            }
                        ?>
                        <div class="input-div">
                            <input type="submit" value="Login" name="login">
                        </div>
                        <p class="forget">Forgot password ? <a href="#">Click Here</a></p>
                        <p class="forget">Don't have an account ? <a id="signup" href="">Sign up</a></p>
                    </form>
                </div>
                <!--Sign_up-->
                <div class="signup-form" id="signup-form">
                    <h2 class="login-text">Sign-up</h2>
                    <form method="POST" onsubmit="signupfunction();" action="index.php">
                        <div class="input-div">
                            <input type="text" name="username"id="signup-user" oninput="ChangeColor(this);" <?php if($user_error==true){echo('style="color:red"');} ?> placeholder="Username">
                            <div class="spinner-parent">
                                <div class="spinner"></div>
                            <div class="spinner-error"<?php if($user_error==true){echo('style="display:inline"');}?>>
                                    <div class="tooltiptext"><?php echo("Username already exists.<br>Suggested user names:<br>");
                                    for($i=0;$i<count($suggested);$i++)
                                    {
                                        echo($suggested[$i]." ");
                                    }
                                    ?>
                                    </div>
                            </div>
                            </div>
                        </div>
                        <div class="input-div">
                            <input type="text" name="email" placeholder="Email" id="signup-email">
                            <div class="spinner-parent">
                                <div class="spinner" id="email-spinner">
                                </div>
                                <div class="spinner-error" id="email-error">
                                    <div class="tooltiptext" >You need to type a valid email.</div>
                                </div>
                                <div class="spinner-correct" id="email-correct" <?php if($user_error==true){echo('style="display:inline"');} ?>>
                                </div>
                            </div>
                        </div>
                        <div class="input-div">
                            <input type="password" name="password" placeholder="Password" id="signup-pass">
                            <div class="spinner-parent">
                                <div class="spinner" id="pass-spinner">
                                </div>
                                <div class="spinner-error" id="pass-error">
                                    <div class="tooltiptext" >Password needs to be atleast 8 characters and 
                                        contains atleast a number and a special character</div>
                                </div>
                                <div class="spinner-correct" id="pass-correct" <?php if($user_error==true){echo('style="display:inline"');} ?>>
                                </div>
                            </div>
                            
                        </div>
                        <div class="input-div">
                            <input type="password" placeholder="Confirm Password" id="signup-cpass">
                            <div class="spinner-parent">
                                <div class="spinner" id="cpass-spinner">
                                </div>
                                <div class="spinner-error" id="cpass-error">
                                    <div class="tooltiptext" >Passwords need to match</div>
                                </div>
                                <div class="spinner-correct" id="cpass-correct" <?php if($user_error==true){echo('style="display:inline"');} ?>>
                                </div>
                            </div>
                        </div>
                        <div class="input-div">
                            <input type="submit" name="signup" id="signup-submit" value="Sign-up">
                        </div>
                        <p class="forget">Already have an account ? <a id="login" href="#">Login</a></p>
                    </form>
                </div>
            </div>
        </div>
    </body>
    <script>
    <?php
    if($invalidLogin==true)
    {
        echo('$(window).on("load", function(){
            $("#order-button").click();
            $("#login-user").val('.'"'.$loginUsername.'"'.');
            $("#login-pass").val('.'"'.$loginPass.'"'.');
        });
        ');
    }

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

        $('#order-button').click(function()
        {
            $('#login-box').show(400);
        });
        $('#toolbar-x').click(function()
        {
            $('#login-box').hide(400);
        });

        $('#signup').click(function(){
            var loginform = $('#login-form');
            var signupform = $('#signup-form');

            loginform.animate({"left":"-1000px"}, "medium");
            signupform.animate({"left":"0px"},"medium");
            $('#login-box').animate({"height":"65%"},"medium");
            return false;
         });
        
         $('#login').click(function(){
            var loginform = $('#login-form');
            var signupform = $('#signup-form');

            loginform.animate({"left":"0px"}, "medium");
            signupform.animate({"left":"1000px"},"medium");
            $('#login-box').animate({"height":"50%"},"medium");
            return false;
         });
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