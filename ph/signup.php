<?php
    session_start();
    if (isset($_SESSION["SID"]))
        session_destroy(); 
    include_once "conn.php";
    if ($link)
    {
        $sql="SELECT COUNT(*) FROM CREDENTIALS WHERE CREDENTIALS.EID='$_POST[ed]' LIMIT 0,1;";
        $result=mysqli_query($link, $sql);
        $row=mysqli_fetch_row($result);
        if ($row[0]==0)
        {
            $sql="SELECT COUNT(EID) FROM EMPLOYEE, ADULT, HUMAN WHERE HUMAN.HID=ADULT.HID AND ADULT.HID=EMPLOYEE.HID AND HUMAN.Fname='$_POST[fn]' AND HUMAN.Mname='$_POST[mn]' AND HUMAN.Lname='$_POST[ln]' AND ADULT.SSN='$_POST[sn]' AND EMPLOYEE.EID='$_POST[ed]' AND ADULT.Email='$_POST[em]' LIMIT 0, 1;";
            $result=mysqli_query($link, $sql);
            $row=mysqli_fetch_row($result);
            if ($row[0]==1)
            {
               $sql="INSERT INTO CREDENTIALS(EID,Uname,Pass,Type) VALUES ('$_POST[ed]','$_POST[un]','$_POST[pw]','3');";
                $result=mysqli_query($link, $sql);
                header('Location:../mess.php?st=4');
            }
            else
                header('Location:../mess.php?st=3');
        
        }
        else
        {
            header('Location:../mess.php?st=2');
            
        }   
    }else
        header('Location:../mess.php?st=0');
    die();

?>