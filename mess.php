<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="st/ss.css" media="screen">
        <link rel="stylesheet" type="text/css" href="st/lgsu.css">
        <style>
            #lgcol{
                margin:auto;
                width:300px;
                height:339px;
                background-repeat: no-repeat;
                background-size: contain;
                display: table;
            }
            #lgcol div{
               margin: auto;
                text-align: center;
                vertical-align: middle;
                display:table-cell;
            }

            #lgcol img{
                position:absolute;
                width:300px;
                height:339px;
                z-index: -1;
                margin: 0;
                padding:0;
                opacity: 0.65;

            }
            #lgcol div form span{
                font-size: 28px;
                font-weight: 600;
                color:white;
            }
            #lgcol div form button,#su{
                margin:0 0 8px 0;
            }
            
            #su{
                width:100%;
            }
            
        </style>
        <script>
        
            setInterval(function(){
                window.location.href="home.html";
            },3000);
        
        </script>
    </head>
    <body>
        <div class="row">
                <div id="header"><img src="pf/img/bn/banner1.png"></div>
            </div>
            <div id="lgcol">
                <img src="pf/img/lg/300px-Coat_of_arms_of_Saint_Kitts_and_Nevis_(variant).svg.png">
                <div>
                    <h2 style="color:white;">
                    <?php 
                        switch($_GET["st"])
                        {
                            case 0:
                                echo "Connection Error";
                                break;
                            case 1:
                                echo "Login Fail";
                                break;
                            case 2:
                                echo "User already exists";
                                break;
                            case 3:
                                echo "Employee does not exist";
                                break;
                            case 4:
                                echo "Sign up successful";
                                break;
                            case 5:
                                echo "Email sent";
                                break;
                            case 6:
                                echo "Credential does not exist";
                                break;
                            case 7:
                                echo "User timed out";
                                break;
                            case 8:
                                echo "Credential Type Error";
                                break;
                            case 9:
                                echo "User signed out";
                                break;
                            case 10:
                                echo "User was signed in<br>Sign in Again";
                                break;
                            case 11:
                                echo "No User Loged in";
                                break;
                            case 12:
                                echo "Update Failed";
                                break;
                            default:
                                echo "Error 404...";                                
                        }
                        ?></h2>
                    <a class="su" href="home.html">Return</a>
                </div>
        </div>
        <div id="footer">
            Footer
            </div>
    </body>
</html>