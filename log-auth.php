 <?php
    include('connects.php');
    session_start();
      if (isset($_SESSION['id']))
      {
        $username = $_SESSION['id'];
        $type = $_SESSION['type'];
        $dept = $_SESSION['dept'];

        $query = "SELECT * FROM account where id = $username";
        $result = mysqli_query($con,$query);

          while($row = mysqli_fetch_array($result))
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

      }
      else
      {
        session_destroy();
         header("location:login.php");
      }
        //mysqli_close($con);
?>