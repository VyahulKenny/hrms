<?php
    session_start();
    include_once "../ph/conn.php";
    if(!$link OR !isset($_SESSION['SID']))
    {
        session_destroy();
        die();
    }
    
?>
<!DOCTYPE html>
<html>
    <head>
        <link type="text/css" href="../st/ss.css" rel="stylesheet" media="screen">
        <link type="text/css" href="../st/v.css" rel="stylesheet">
        <style>
          
        </style>
        <script>
            function signout()
            {
                window.location.href ="signout.php";
            }
            
        </script>
    </head>
    <body>
        <div class="row">
                <div id="header"><img src="../pf/img/bn/banner1.png"></div>
        </div>
        <div class="col1"><!--menubar-->
            <ul id="menu">
                <li><a href="../home.html">Home</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li id="lgout" onclick="signout()">Sign Out</li>
            </ul>
        </div>
        <div class="row">
            <div class="col3">
                <?php
                    if (isset($_REQUEST['SQL']))
                    {
                        if(!empty($_REQUEST['SQL']))
                        {
                            $sql="$_REQUEST[SQL]";
                            $result=mysqli_query($link,$sql);
                            if($result)
                            {
                                $col=mysqli_num_fields($result);
                                $row=mysqli_fetch_row($result);
                                echo "<br><br><table>";
                                while ($row)
                                {
                                    echo "<tr>";
                                    for ($i=0;$i<$col;$i++)
                                    {
                                        echo "<td>".$row[$i]."</td>";
                                    }
                                    echo "</tr>";
                                     $row=mysqli_fetch_row($result);
                                }
                                echo "</table>";
                            }else
                                header('Location:view.php');
                        }else
                            header('Location:view.php'); 
                    }else
                        header('Location:view.php');

                    ?>
            <a href="view.php" class="butt" style="padding:1px 5px;">Return</a>
            </div>
        </div>
    </body>

</html>











