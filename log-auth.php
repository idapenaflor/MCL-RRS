 <?php
    include('connects.php');
    session_start();
      if (isset($_SESSION['id']))
      {
        $username = $_SESSION['id'];
        $type = $_SESSION['type'];
        $dept = $_SESSION['dept'];

        $result = mysql_query("SELECT * FROM account where id = $username");

          while($row = mysql_fetch_array($result))
          {
             $type = $row['type'];
             $fname = $row['fname'];
             $lname = $row['lname'];
             $mname = $row['mname'];
             $dept = $row['dept'];
             $type = $row['type'];

             $fname = htmlspecialchars($row['fname'],ENT_QUOTES);
             $lname = htmlspecialchars($row['lname'],ENT_QUOTES);
             $dept = htmlspecialchars($row['dept'],ENT_QUOTES);
          }

          /*if($type=="Staff")
          {
            include('main.php');
            include('viewRequestedRooms.php');  
          }
          else
          {
            echo "<script language='javascript'>alert('Unauthorized access.');</script>";
            echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=main.php\">";
          }

          if($type=="CDMO" || $type=="LMO")
          {
            include('dv-main.php');
            include('viewInventory.php'); 
            include('viewReport.php');  
          }
          else
          {
            echo "<script language='javascript'>alert('Unauthorized access.');</script>";
            echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=dv-main.php\">";
          }*/

      }
      else
      {
        session_destroy();
         header("location:login.php");
      }
        //mysql_close($con);
?>