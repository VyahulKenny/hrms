<?php
    session_start();
    include_once "conn.php";
    if (isset($_SESSION['SID']))
        header('Location:../v/signout.php?st=1');
    else
    {
        if ($link && isset($_POST["Sub"]))
        {
            $sql="SELECT * FROM CREDENTIALS WHERE CREDENTIALS.Uname='$_POST[Uname]' AND CREDENTIALS.Pass='$_POST[Pass]' LIMIT 0, 1;";
            $result=mysqli_query($link,$sql);
            if(mysqli_num_rows($result)==1)
            {
                $row=mysqli_fetch_row($result);
                
                $_SESSION["SID"]=$row[0];
                $_SESSION["Type"]=$row[3];
                $g_sql="SELECT COUNT(*) FROM DepOFFICERS WHERE EID='$row[0]'";
                $g_result=mysqli_query($link,$g_sql);
                $g_row=mysqli_fetch_row($g_result);
                if ($g_row[0]==1)
                    $_SESSION["GOV"]="D";
                else
                    $_SESSION["GOV"]="G";
               setcookie("SKNGOVID",$row[0],$time+300,$cookiepath);
               setcookie("Time",$time,$time+300,$cookiepath);
                include "v/signout.php";
                //open new link HERE to DB basee on type
               switch($row[3])
                {
                    case 0:
                    case 1:
                    case 2:
                    case 3:
                        header('Location:../v/view.php');
                        break;
                    default:
                        header('Location:../v/signout.php');//CREDENTIAL TYPE NOT SUPPORTED
                        break;     
                }
            }else
            {
                header('Location:../mess.php?st=1');

            }
        }
    }
    die();

?>