<?php
     include_once "conn.php";
    if($link)
    {
        $sql="SELECT CREDENTIALS.Uname,CREDENTIALS.Pass FROM EMPLOYEE, ADULT, CREDENTIALS WHERE ADULT.HID=EMPLOYEE.HID AND EMPLOYEE.EID=CREDENTIALS.EID AND ADULT.Email='$_POST[em]';";
        $result=mysqli_query($link,$sql);
        
        if (mysqli_num_rows($result)==1)
        {
            $row=mysqli_fetch_row($result);
            $msg="Username: $row[0] Password: $row[1]";
            //EMAIL SHIT FROM the EMAIL SENT
            mail($_POST['em'],'Forget password',$msg);
        }
            
        else
            header('Location:../mess.php?st=6');     
    }else
        header('Location:../mess.php?st=0');
    die();
?>