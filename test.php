<?php
   session_start();
    /*$row[0]=3;
    $row[3]=3;
    $row[2]=time();
if (isset($_SESSION['SID']))
    {
        echo "<br>Set.";
        echo $_SESSION['Count']++;
        if ($_SESSION['Count']>5)
          session_destroy();
    }
    else
    {
        echo "<br>unSet.";
        $_SESSION['SID']=$row[0];
        $_SESSION['Count']=1;
    }    */

if (isset($_SESSION["SID"]))
    {
        session_destroy();
        echo "Session destroyed"; 
    }else
        echo "Session doesnt exist";
          
?>