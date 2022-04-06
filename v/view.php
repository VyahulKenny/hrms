<?php
    session_start();
    include_once "../ph/conn.php";
    if(!$link OR !isset($_SESSION['SID']))
    {
        session_destroy();
        die();
    }
    $count=0;
    
    //if() UNSETasdasd
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
            function resetquery()
            {
                var a =document.getElementById("up");
                a.reset();
                a.submit();
            }
            function editpop(c)
            {
                var eid=document.getElementById("EID");
                var id=document.getElementById("hdid");
                var em=document.getElementById("epop");
                id.value=c;
                eid.innerHTML=c;
                em.style.display="block";  
            }
            function editclose()
            {
                var em=document.getElementById("epop");
                em.style.display="none";  
            }
            function update()
            {
                var up=0;
                if(up==1)
                {
                    window.alert("Update Successful.");
                }
                
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
                <li><a href="#">About Us</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li id="lgout" onclick="signout()">Sign Out</li>
            </ul>
        </div>
        <div class="row">
            
            <div class="col3" id="ss"> <!--Results-->
                <div id="epop">
                            <form method="POST" action="../ph/update.php">
                                Enter changes to EID:<span id="EID"></span><br><input type="text" name="id" id="hdid">
                                Firstname: <input type="text" name="fname">
                                Lastname: <input type="text" name="lname">
                                Position: <input type="text" name="pos">
                                S_Fname: <input type="text" name="sfname">
                                <br>S_Lname: <input type="text" name="slname">
                                 <button type="button" onclick="editclose()">Close</button>
                                <input type="reset" value="Reset">
                                <input type="submit" value="Submit">
                               
                            </form>
                            
                            
                        </div>
                <?php
                    if($_SESSION["Type"]==0)
                    {
                        echo "<form id='com1' method='POST' action='sample.php'> ".
                            "SQL: <input type='text' name='SQL' size='100' required>".
                            "<input type='submit' value='Submit'><input type='reset' value='Reset'>".
                            "</form>";
                            $sql="SHOW TABLES;";
                            $result=mysqli_query($link,$sql);
                            $nrow=mysqli_num_rows($result);
                            $rows=mysqli_fetch_row($result);
                        echo "<br>";
                            for($b=0;$b<$nrow;$b++)
                            {
                                echo "Table: ".$rows[0]."<br>";
                                $dsql="DESCRIBE ".$rows[0];
                                $dresult=mysqli_query($link,$dsql);
                                $dncol=mysqli_num_fields($dresult);
                                $drows=mysqli_fetch_row($dresult);
                                while($drows)
                                {
                                    for ($x=0;$x<$dncol;$x++)
                                        echo $drows[$x]. " ";
                                    
                                    $drows=mysqli_fetch_row($dresult);
                                }
                                    
                                echo "<br><br>";
                                $rows=mysqli_fetch_row($result);
                            }
                         echo "<br><br>";
                    }else if($_SESSION["Type"]==2 OR $_SESSION["Type"]==3)
                    {
                            if ($_SESSION["GOV"]=='D')
                                $sql="SELECT * FROM DWView AS A WHERE ";
                            else if ($_SESSION["GOV"]=='G')
                                $sql="SELECT * FROM GWView AS A WHERE ";
                            
                            if (isset($_GET['fname']))
                                if (!empty($_GET['fname']))
                                    $sql.="A.Fname='$_GET[fname]' AND ";
                            if (isset($_GET['lname']))
                                if (!empty($_GET['lname']))
                                $sql.="A.Lname='$_GET[lname]' AND  ";
                            if (isset($_GET['pos']))
                                if (!empty($_GET['pos']))
                                $sql.="A.Position='$_GET[pos]' AND ";
                            if ($_SESSION["GOV"]=='D')
                            {
                                if (isset($_GET['sfname']))
                                    if (!empty($_GET['sfname']))
                                    $sql.=" A.S_Fname='$_GET[sfname]' AND";
                                if (isset($_GET['slname']))
                                    if (!empty($_GET['slname']))
                                    $sql.="A.S_Lname='$_GET[slname]' AND ";
                                if (isset($_GET['spos']))
                                    if (!empty($_GET['spos']))
                                    $sql.=" A.S_Position='$_GET[spos]' AND ";
                            }
                            if ($_SESSION["GOV"]=='D')
                                $sql.="A.Department IN (SELECT B.Department FROM DWView AS B WHERE B.EID='$_SESSION[SID]')";
                            else
                                $sql.="A.G_Office IN (SELECT B.G_Office FROM GWView AS B WHERE B.EID='$_SESSION[SID]')";
                            echo "<form method='GET' id='up' action='".htmlspecialchars($_SERVER['PHP_SELF'])."'>";
                            echo "<table><tr><td>Fname<input type='text' name='fname'></td>".
                                "<td>Lname <input type='text' name='lname'></td>".
                                "<td>Position <input type='text' name='pos'></td>";
                            if ($_SESSION["GOV"]=='D')
                                echo"<td>S_Fname <input type='text' name='sfname'></td></tr><tr>".
                                "<td>S_Lname <input type='text' name='slname'></td>".
                                "<td>S_Pos <input type='text' name='spos'></td>";
                            echo"<td><input type='submit' name='Submit'> ".
                                "<button type='button' onclick='resetquery()'>Reset</button></td></tr>".
                                "</table></form>";
                            
                       
                            echo "<table id='ser'>";
                            if ($_SESSION["Type"]==2)
                                echo "<th>Select</th>";
                            if ($_SESSION["GOV"]=='G') 
                                echo"<th>G_Office</th>";
                            else if ($_SESSION["GOV"]=='D')
                                echo "<th>Department</th><th>Dtype</th>";
                            
                            echo "<th>EID</th><th>Fname</th><th>Lname</th><th>Position</th><th>Salary</th><th>Since</th>";
                            
                            if ($_SESSION["GOV"]=='D')
                                echo "<th>S_Fname</th><th>S_Lname</th><th>S_Pos</th>";
    
                        $result=mysqli_query($link,$sql);
                        $num=mysqli_num_fields($result);
                        $row=mysqli_fetch_row($result);
                        $a=1;
                        while ($row)
                        {
                            echo "<tr>";
                            if ($_SESSION["Type"]==2)
                            {
                                echo "<td><button type='button' onclick='editpop(".($_SESSION['GOV']=='G'?$row[1]:$row[2]).")' name='sel'>Edit</button></td>";
                            }
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
                    }
                ?>
            </div>
        
        </div>
        <div id="footer">
            Footer
            </div>
    </body>

</html>











