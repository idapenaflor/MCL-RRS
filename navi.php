<?php include_once('connects.php');
include_once('log-auth.php');
?>
<!--=========NAVIGATION==========-->
<nav class="navbar navbar-static-top">
  <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
  <!--=============CUSTOM NAV====================-->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle tab-notif" data-toggle="dropdown" aria-expanded=true>
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning label-notif"></span>
            </a>
            <ul class="dropdown-menu notif-menu" style="overflow: hidden">
            </ul>
        </li>
        
        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="glyphicon glyphicon-user"></span><span class="hidden-xs"><?php echo($lname.', '.$fname.' ('.$mname.')');?></span><span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">&nbsp;</li>
              <li><a href="changepass.php"><span class="glyphicon glyphicon-edit"></span>&nbsp;Change Password</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
            </ul>
        </li><!--end of li class user-->
      </ul>
    </div>
</nav>

<script src="./js/notif.js"></script>