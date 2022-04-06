<?php
    session_start();
    include_once "../ph/conn.php";
    if(!$link OR !isset($_SESSION['SID']))
    {
        session_destroy();
        die();
    }
    //if() UNSETasdasd
?>
<!DOCTYPE html>
<?php


    switch($_SESSION["Type"])
    {
        case 0:
            
            echo "<table>";
            break;
        case 1:
            
            echo "<table>";
            break;
        case 2:
            
            echo "<table>";
            break;
        case 3:
            $sql="SELECT * FROM DWView AS A WHERE A.Department IN (SELECT B.Department FROM DWView AS B WHERE B.EID=3);";
            echo "<form method='GET' action='".htmlspecialchars($_SERVER['PHP_SELF'])."'>";
            echo "Department<input type='text' name='dep'> ".
                "Dtype<input type='text' name='dtype'> ".
                "Fname<input type='text' name='fname'> ".
                "Lname<input type='text' name='lname'><br> ".
                "Position<input type='text' name='pos'> ".
                "S_fname<input type='text' name='sfname'> ".
                "<input type='submit' name='Submit'>".
                "<input type='reset' name='Reset'>".
                "</form>";
                echo "<table>";
            echo "<th>Department</th><th>Dtype</th><th>EID</th><th>Fname</th><th>Lname</th><th>Position</th><th>Salary</th><th>Since</th><th>S_Fname</th><th>S_Lname</th><th>S_Pos</th>";
            break;
    }
    $result=mysqli_query($link,$sql);
    $num=mysqli_num_fields($result);
    $row=mysqli_fetch_row($result);
    
    while ($row)
    {
        echo "<tr>";
        for ($i=0;$i<$num;$i++)
        {
            echo "<td>";
            echo $row[$i];
            echo "</td>";

        }
        $row=mysqli_fetch_row($result);
        echo "</tr>";
    }
    echo "</table>";
?>