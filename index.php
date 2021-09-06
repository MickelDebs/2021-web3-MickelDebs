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
        <div class="root">
            <!--pc interface-->
            <div class="pc-header">
                <div class="header">
                    <div class="header-div">
                        <div class="logo">
                            <div class="logo-img"><img src="./images/logo.png"></div>
                            <a class="logo-text" href="index.php">BFE</a>
                        </div>
                        <div class="header-container">
                            <a href="BuyPage.php">Menu</a>
                        </div>
                        <div class="header-container">
                            <a href="about.php">About</a>
                        </div>
                        <div class="header-container" style="flex-grow:10">
                            <div class="searchDiv">
                                <div class="searchIcon"><img src="./images/icons/search.png"></div>
                                <input type="text" class="searchMealsInput" placeholder="Search meals">
                            </div>
                        </div>
                        <!-- To do in php-->
                        <div class="header-container" onclick="location.href='admin.php';">
                            <img src="./images/icons/admin-icon.png">
                        </div>
                        <!-- -->
                        <div class="header-container">
                            <input type="button" value="Sign in" id="signin" onclick="location.href='signin.php';">
                        </div>
                    </div>
                </div>
            </div>
            <!--Mobile interface-->
            <div class="mobile-header">
                <div class="header">
                    <div class="header-div">
                        <div class="header-container" style="width:45px;margin-left:7px" onclick="openMenu()">
                            <img src="./images/icons/menu.png" id="menu-img">
                        </div>
                        <div class="logo">
                            <div class="logo-img"><img src="./images/logo.png"></div>
                            <a class="logo-text" href="index.php">BFE</a>
                        </div>
                        <div class="header-container" id="searchButton">
                            <img src="./images/icons/search.png">
                        </div>
                        <div class="header-container" id="loginButtonMobile" onclick="location.href='signin.php';">
                            <img src="./images/icons/profile-icon.png">
                        </div>
                        <!-- To do in php-->
                        <div class="header-container" onclick="location.href='admin.php';">
                            <img src="./images/icons/admin-icon.png">
                        </div>
                        <!-- -->
                    </div>
                    <div class="searchDiv" id="searchDiv">
                        <div class="innerSearchDiv">
                            <div class="searchImage">
                                <img src="./images/icons/search.png">
                            </div>
                            <input type="text" placeholder="Search meals">
                            <div class="closeSearchImage" id="searchCloseButton">
                                <img src="./images/icons/close.png">
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        <div class="background-flex">
            <div class="flex-column background-div-1">
                <div class="background-div-3">
                    <span class="s1">JUICY & HOT FOOD</span>
                    <span class="s2">Delivering now all accross lebanon!</span>
                    <input type="button" class="start-button" value="Order Now" id="order-button">
                </div>
            </div>
            <div class="flex-column background-div-2">
            </div>
            <div class="mobile-menu" id="menu">
                <div class="menu">
                    <div onclick="location.href='BuyPage.php';">Menu</div>
                    <div onclick="location.href='about.php';">About</div>
                </div>
            </div>
        </div>
        </div>
    </body>
    <script>
        //Scripts for mobile only
        $("#searchButton").click(function()
        {
            $("#searchDiv").slideToggle("fast");
            $("#searchDiv").css("display","flex");
        });

        $("#searchCloseButton").click(function()
        {
            $("#searchDiv").slideToggle("fast");
        });
        $('#loginButtonMobile').click(function()
        {
            $('#login-box').show(400);
        });
        
        var cnt=0;
        function openMenu()
        {
            var menu=$('#menu');
            var img=$("#menu-img");
            cnt++;

            if(menu.css("display")=="none")
            {
                if(cnt==1)
                {
                menu.css("display","flex");
                menu.animate({"width":"100%"},500);
                img.fadeOut(250,function()
                {
                    img.attr('src','./images/icons/close.png');
                    img.fadeIn(250);
                });
                cnt=0;
                }
            }else
            {
                if(cnt=1)
                {
                    img.fadeOut(250,function()
                    {
                        img.attr('src','./images/icons/menu.png');
                        img.fadeIn(250);
                    });
                    menu.animate({"width":"0"},500,function()
                    {
                        menu.css("display","none");
                        cnt=0;
                    })
                }
            }
        }
        //End of scripts for mobile only

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
        
        $('#signin').click(function()
        {
            $('#login-box').show(400);
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
            var loginbox=$('#login-box');

            loginform.fadeOut({duration:400,queue:false})
            loginform.animate({"left":"-1000px"},{duration:400,queue:false});
            signupform.fadeIn({duration:400,queue:false});
            signupform.animate({"left":"0px"},{duration:400,queue:false});
           
            //Check if on mobile or pc
            if(loginbox.css("overflow-y")=="hidden")
            {
                $('#login-box').animate({"height":"65%"},"medium");
            }
            return false;
         });
        
         $('#login').click(function(){
            var loginform = $('#login-form');
            var signupform = $('#signup-form');
            var loginbox=$('#login-box');

            loginform.fadeIn({duration:400,queue:false})
            loginform.animate({"left":"0"},{duration:400,queue:false});
            signupform.fadeOut({duration:400,queue:false});
            signupform.animate({"left":"1000px"},{duration:400,queue:false});
            
            //Check if on mobile or pc
            if(loginbox.css("overflow-y")=="hidden")
            {
                $('#login-box').animate({"height":"50%"},"medium");
            }
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