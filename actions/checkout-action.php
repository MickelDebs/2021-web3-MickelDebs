<?php
session_start();
    if(isset($_POST['action']))
    {
        if($_POST['action']=="checkout")
        {
            if(isset($_SESSION['cart_item']))
            {
                $cartItems=$_SESSION['cart_item'];
                if(count($cartItems)!=0)
                {
                    if(empty($_SESSION['user']['firstname'])|
                    empty($_SESSION['user']['lastname'])|
                    empty($_SESSION['user']['lastname']))
                    {

                        echo('
                        <div class="checkout-header">
                            <h2>Personal Info</h2>
                        </div>
                        <div class="checkout-items">
                            <div id="md" class="md">Some informations are not filled.</div>');
                            
                                    if(!empty($_SESSION['user']['firstname']))
                                    {
                                        echo('<div class="info">
                                            <input type="text" id="firstname" oninput="checkInfo()" placeholder="First Name" class="input-enabled"
                                            
                                            style="color:#747778" disabled value="'.$_SESSION['user']['firstname'].'">');
                                    }else
                                    {
                                        echo('<div class="info" style="border:1px solid red">
                                            <input type="text" id="firstname" oninput="checkInfo()" placeholder="First Name" class="input-enabled">');
                                    }
                                    if(!empty($_SESSION['user']['firstname']))
                                    {
                                        echo('<img src="./images/icons/lock.png" class="info-lock" onclick="unlockInfo(this)">');
                                    }
                                    echo('</div>');
                                    if(!empty($_SESSION['user']['lastname']))
                                    {
                                        echo('<div class="info">
                                            <input type="text" id="lastname" oninput="checkInfo()" placeholder="Last Name" class="input-enabled"
                                            
                                            style="color:#747778" disabled value="'.$_SESSION['user']['lastname'].'">');
                                    }else
                                    {
                                        echo('<div class="info" style="border:1px solid red">
                                            <input type="text" id="lastname" oninput="checkInfo()" placeholder="Last Name" class="input-enabled">');
                                    }
                                            if(!empty($_SESSION['user']['lastname']))
                                            {
                                                echo('<img src="./images/icons/lock.png" class="info-lock" onclick="unlockInfo(this)">');
                                            }
                                        echo('</div>
                                        <div class="subtitle">
                                            Birthday
                                        </div>');
                                        if(!empty($_SESSION['user']['birthday']))
                                        {
                                            echo('<div class="info">
                                                <input type="date" id="date" oninput="checkInfo()"
                                                
                                                style="color:#747778" disabled value="'.$_SESSION['user']['birthday'].'">');
                                        }else
                                        {
                                            echo('<div class="info" style="border:1px solid red">
                                                <input type="date" id="date" oninput="checkInfo()"');
                                        }
                                            if(!empty($_SESSION['user']['birthday']))
                                            {
                                                echo('<img src="./images/icons/lock.png" class="info-lock" onclick="unlockInfo(this)">');
                                            }
                                        echo('</div>
                                        </div>
                                        <div class="choose-payment-footer">
                                        <img src="./images/icons/info.png">
                                        <div class="text">You can choose default payment method in your <a href="./account.php">account settings</a></div>
                                            <div class="pinfo-save button-disabled" id="pinfo-save" onclick="updateInfo()">
                                                Save
                                            </div>
                                        </div>
                                    </div>
                                    </div>');
                    }else
                    {
                        $payment=$_SESSION['user']['payment'];
                        if(isset($_POST['payment']))
                        {
                            if($_POST['payment']!="")
                            {
                                $payment=$_POST['payment'];
                            }
                        }
                        if($payment=="Always ask")
                        {
                            echo('
                                <div class="checkout-header">
                                    <h2>Choose your payment method:</h2>
                                </div>
                                <div class="checkout-items">
                                    <div class="payment-option" onclick="SetPayment(\'Credit Card\')">
                                        Credit Card
                                    </div>
                                    <div class="payment-option" onclick="SetPayment(\'Cash on delivery\')">
                                        Cash on delivery
                                    </div>
                                </div>
                                <div class="choose-payment-footer">
                                    <img src="./images/icons/info.png">
                                    <div class="text">You can choose default payment method in your <a href="./account.php">account settings</a></div>
                                </div>
                                
                            ');
                        }else
                        {
                            /*if(isset($_POST['payment']))
                            {
                                if($_POST['payment']!="")
                                {
                                    $payment=$_POST['payment'];
                                }
                            }*/
                            if($payment=="Credit Card")
                            {
                                $defaultcard='';
                                if(isset($_SESSION['user']['card']))
                                {
                                    $defaultcard=$_SESSION['user']['card'];
                                }
                                if($defaultcard=='Always ask')
                                {
                                    echo('
                                    <div class="checkout-header">
                                        <h2>Your credit cards</h2>
                                    </div>
                                    ');
                                    $cards=$_SESSION['user']['cards'];
                                    echo('<div class="checkout-items" id="checkout-cards-select"');
                                    if(!empty($cards))
                                    {
                                        echo('style="display:block">');
                                        foreach($cards as $card)
                                        {
                                            echo('
                                            <div class="payment-option" onclick="SelectCard(\''.$card['number'].'\')">
                                                <img src="./images/icons/creditcard.png">
                                                <div class="payment-card-num">
                                                    '.$card['number'].'
                                                </div>
                                            </div>
                                            ');
                                        }
                                        echo('</div>');
                                    }else
                                    {
                                        echo('style="display:none"></div>');
                                        echo('
                                        <div class="empty-cards" id="checkout-cards-empty">
                                            <div class="checkout-cards-empty">
                                                <img src="./images/icons/emptycc.png">
                                                <div class="checkout-cards-title">You have no cards added.</div>
                                            </div>
                                        </div>
                                        ');
                                    }
                                    echo('
                                    <div style="margin:10px 0px;width:100%;display:flex;justify-content:flex-end;">
                                        <div class="add-cards button-enabled" onclick="addCard()">
                                            Add card
                                        </div>
                                    </div>
                                    <div class="choose-payment-footer">
                                        <img src="./images/icons/info.png">
                                        <div class="text">You can select your default card in your <a href="./account.php">account settings</a></div>
                                    </div>
                                    ');
                                }else
                                {
                                    $allcards=$_SESSION['user']['cards'];
                                    $cardID=array();
                                    $cardID['card_id']=$defaultcard;

                                    $cardnum='';
                                    foreach($allcards as $cards)
                                    {
                                        foreach($cards as $k =>$v)
                                        {
                                            if($k=='card_id')
                                            {
                                                if($v == $defaultcard)
                                                {
                                                    $cardID['number']=$cards['number'];
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                    echo(json_encode($cardID));
                                }
                            }else
                            {
                                echo('
                                <div class="checkout-location-header">');
                                if(isset($_POST['card_number']))
                                {
                                    echo('<h4 style="margin-bottom:5px">Paying with '.$_POST['card_number'].'</h4>');
                                }else
                                {
                                    echo('<h4 style="margin-bottom:5px">Paying on delivery</h4>');
                                }
                                
                                    echo('<h2>Choose your location</h2>
                                </div>
                                <div class="checkout-location">
                                    <div id="map"></div>
                                    <div style="margin-bottom:14px;width:100%;display:flex;justify-content:flex-end;">
                                        <div disabled class="add-cards button-disabled" id="accept-location" style="text-align:center">
                                            Accept Location
                                        </div>
                                    </div>
                                </div>
                                <div class="choose-payment-footer">
                                    <img src="./images/icons/info.png">
                                    <div class="text">Having errors using the map? input your location <a style="cursor:pointer" onclick="goManual()">manually</a></div>
                                </div>
                                ');
                            }
                        }
                    }
                }else
                {
                    echo('fail');
                }
            }else
            {
                echo('fail');
            }
        }
    }
?>