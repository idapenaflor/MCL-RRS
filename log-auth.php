 <?php
    include('connects.php');
    include_once('qConn.php');

    //$queries = new qConn();

    session_start();
      if (isset($_SESSION['id']))
      {
        $username = $_SESSION['id'];
        $type = $_SESSION['type'];
        $dept = $_SESSION['dept'];
        //$result = "";

        $result = SelectUser($con,$username);

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
         header("location:index.php");
      }
        //mysqli_close($con);
?>