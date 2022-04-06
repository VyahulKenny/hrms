<?php
    $domain="skngov.xyz";
    $DBname="u639364697_govn";
    if (isset($_SESSION['SID']))
    {
        switch($_SESSION['Type'])
        {
            case 0:
                $user="u639364697_lgreq";
                $pass="LG0SKN";
                break;
            case 1:
                $user="u639364697_lgreq";
                $pass="LG0SKN";
                break;
            case 2:
               $user="u639364697_lgreq";
                $pass="LG0SKN";
                break;
            case 3:
               $user="u639364697_lgreq";
                $pass="LG0SKN";
                break;
            default:
                include "../v/signout.php";
                die();
        }  
    }else
    {
                $user="u639364697_lgreq";
                $pass="LG0SKN";
    }
    $link=@mysqli_connect($domian,$user,$pass,$DBname);
   if (mysqli_connect_errno())
    {
        header('Location:../mess.php?st=0');
        die();
    }
?>