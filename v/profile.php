<?php
    session_start();
    include_once "../ph/conn.php";
     if (!isset($_SESSION['SID']))
         header('Location:../mess.php?st=11');
    if(empty($_SESSION['SID']))
          header('Location:../mess.php?st=11');       

?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../st/ss.css" media="screen">
        <link type="text/css" href="../st/v.css" rel="stylesheet">
        <style>
            #lgcol{
                margin:auto;
                width:70%;
                height:339px;
                background-color: #ebe2ac;
                display: table;
            }
            #lgcol div{
                float:left;
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
        function cancel()
            {
                window.location.href ="home.html";
            }
        </script>
    </head>
    <body>
        <div class="row">
                <div id="header"><img src="../pf/img/bn/banner1.png"></div>
            </div>
        <div class="row">
            <div class="col1"><!--menubar-->
                <ul id="menu">
                    <li><a href="home.html">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a>Profile</a></li>
                </ul>
            </div>
        </div><br>
        <div class="row">
            <div id="lgcol">
                <div>
                <?php 
                    $sql="SELECT EmpPI.Fname,EmpPI.Lname,EmpPI.Address,EmpPI.Street,EmpPI.City,EmpPI.Parish,EmpPI.Island,EmpPI.H_Tel,EmpPI.C_Tel FROM EmpPI WHERE EmpPI.EID='$_SESSION[SID]'";
                    $result=mysqli_query($link,$sql);
                    $row=mysqli_fetch_row($result);
                    echo "<table>".
                        "<tr><th>First Name</th><td>$row[0]</td></tr>".
                        "<tr><th>Last Name</th><td>$row[1]</td></tr>".
                        "<tr><th>Address</th><td>$row[2]</td></tr>".
                        "<tr><th>Street</th><td>$row[3]</td></tr>".
                        "<tr><th>City</th><td>$row[4]</td></tr>".
                        "<tr><th>Parish</th><td>$row[5]</td></tr>".
                        "<tr><th>Island</th><td>$row[6]</td></tr>".
                        "<tr><th>Home tel number</th><td>$row[7]</td></tr>".
                        "<tr><th>Celephone number</th><td>$row[8]</td></tr>".
                        "</table>";
                
                ?>
                </div>
                <div>
                    <table>
                    <tr>
                        <th>Username</th>
                        <?php
                            $sql="SELECT CREDENTIALS.Uname FROM CREDENTIALS WHERE CREDENTIALS.EID='$_SESSION[SID]'";
                            $result=mysqli_query($link,$sql);
                            $row=mysqli_fetch_row($result);
                            echo "<td>$row[0]</td>";
                        ?>
                    </tr>
                    <tr>
                        <th>Credential Type</th>
                        <td><?=$_SESSION['Type'];?></td>
                    </tr>
                    <tr>
                        <th>Employee Sub Class</th>
                        <td><?=($_SESSION['GOV']=='G'?"Gov Officer":"Dep Officer")?></td>
                    </tr>
                    </table>
                
                    
                </div>
                <div style="float:right;margin-top:5px;">
                    <a  href="view.php" class="butt">Return</a>
                </div>
            </div>
        </div>
        <div id="footer">
            Footer
        </div>
    </body>
</html>