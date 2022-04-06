<?php
    session_start();
    include_once "conn.php";
    $count=0;
    $flag=false;
    if(!$link)
    {
        header('Location:../mess.php?st=1');
        die();
    }
    else
    {
        if(!isset($_SESSION['SID']))
        {
          header('Location:../mess.php?st=11');
          die();
        }else
        {
            if (isset($_REQUEST['fname']))
                if (!empty($_REQUEST['fname']))
                    $count++;
                if (isset($_REQUEST['lname']))
                    if (!empty($_REQUEST['lname']))
                    $count++;
            
            if (isset($_REQUEST['id']))
            {
                if (!empty($_REQUEST['id']))
                {
                    $sql="SELECT HID FROM EMPLOYEE WHERE EMPLOYEE.EID='$_REQUEST[id]';";
                    $result=mysqli_query($link,$sql);
                    if(!$result)
                        $flag=true;
                    else
                        $HID=mysqli_fetch_row($result);
                    
                    if (isset($_REQUEST['pos']))//Change POsition still need more coding to add to the
                        if (!empty($_REQUEST['pos']))//corresponding sub class this just only changes
                        {                           //EMPLOYEE.Position to ########
                            $sql="UPDATE EMPLOYEE SET EMPLOYEE.Type='$_REQUEST[pos]' WHERE EMPLOYEE.EID='$_REQUEST[id]';";
                            if(!mysqli_query($link,$sql))
                                $flag=true;
                        }
                    if (isset($_REQUEST['sfname'])AND isset($_REQUEST['slname']))
                        if (!empty($_REQUEST['sfname']) AND !empty($_REQUEST['slname']))
                        {
                            $sql="SELECT B.EID FROM EMPLOYEE AS B, HUMAN AS C WHERE C.HID=B.HID AND C.Fname='$_REQUEST[sfname]' AND C.Lname='$_REQUEST[slname]'";
                            $result=mysqli_query($link,$sql);
                            if (!$result)
                                $flag=true;
                            else
                            {
                                $temp=mysqli_fetch_row($result);
                                $sql="UPDATE EMPLOYEE SET EMPLOYEE.Super_ID='$temp[0]' WHERE EMPLOYEE.EID='$_REQUEST[id]';";
                                if (!mysqli_query($link,$sql))
                                    $flag=true;
                            }
                        }
                    $sql="UPDATE HUMAN SET ";
                    if (isset($_REQUEST['fname']))
                        if(!empty($_REQUEST['fname']))
                        {
                            $sql.="HUMAN.Fname='$_REQUEST[fname]'";
                            if ($count>1)
                            {
                                $sql.=", ";
                                $count--;
                            }
                        }
                    if (isset($_REQUEST['lname']))
                        if (!empty($_REQUEST['lname']))
                        {
                            $sql.="HUMAN.Lname='$_REQUEST[lname]'";
                            if ($count>1)
                            {
                                $sql.=", ";
                                $count--;
                            }
                        }
                    if (isset($_REQUEST['lname']) OR isset($_REQUEST['fname']))
                        if (!empty($_REQUEST['lname']) OR !empty($_REQUEST['fname']))
                        {
                            $sql.=" WHERE HUMAN.HID='$HID[0]';";
                            if(!mysqli_query($link,$sql))
                                $flag=true;
                           
                            header('Location:../v/view.php');
                        }
                     if ($flag)
                            {
                                header('Location:../v/view.php');
                            }
                            else
                                header('Location:../v/view.php');
                }else
                {
                    echo "id empty";
                }
            
            }else
                echo "Sel not Set";

        }
        
        
        
        
        
        
        
        
        
        
        
    }





?>