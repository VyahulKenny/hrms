<?php
    session_start();
    $cookiepath='/SKNGOV/';
    if (isset($_SESSION["SID"]))
        session_destroy(); 
    if(isset($_COOKIE["SKNGOVID"]))
    {
        setcookie("SKNGOVID",$row[0],0,$cookiepath);
        setcookie("Time",$time,0,$cookiepath);
    }
    if(isset($link))
        mysqli_close($link);
    if (isset($_GET['st']))
    {
        if ($_GET['st']==1)
            header('Location:../mess.php?st=10');
        else
             header('Location:../mess.php?st=9');
    }
    else
        header('Location:../mess.php?st=9');
    die();
?>