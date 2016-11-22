<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>MCL Room Reservation</title>
    <?php include('includes.php'); ?>
  </head>

  <body class="hold-transition sidebar-mini">
     <?php
      include('connects.php');
      include_once('log-auth.php');
    ?>
    <div class="wrapper">
  <header class="main-header">
    <?php include ('header.php');?>
    <?php include ('navi.php');?>
  </header>
  <!--==========SIDE BAR===========-->
    <?php include('sidebar.php');?>

  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
              Available Room/s
            </h1>
            <ol class="breadcrumb">
              <li class="active"><a href="main.php"><i class="fa fa-dashboard"></i> Home</a></li>
            </ol>
          </section>
          <!-- Main content -->
          <section class="content"> <hr/>
            <!--============FORM=============-->
              <div class="row" style="padding-top: 10px;">
                <div class="col-xs-12">
                  <div class="box">
                    <div class="box-header">
                      <form method="post" action="">
                        <label id="dis" style="width:250px;"></label><br/><br/>
                        <section class="col-md-3">

                          <div class="form-group">
                            <span class="label label-primary" style="font-size: 12pt">Date of Use</span><!-- <br/><br/> -->
                            <div class="input-group" style="padding-left: 0px; height: 0px;">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input type="text" name='datetimepicker' id="datetimepicker" style="font-size:20px;t" required="required"/>
                            </div>
                          </div>
                          <span class="label label-primary" style="font-size: 12pt;">Time of Use</span><br/><br/>
                          <span><select class="combo" name="cmbFrom" id="cmbFrom" onchange="ValidateSelect()" required="required">
                                    <option value="1">7:00am</option>
                                    <option value="2">8:30am</option>
                                    <option value="3">10:00am</option>
                                    <option value="4">11:30am</option>
                                    <option value="5">1:00pm</option>
                                    <option value="6">2:30pm</option>
                                    <option value="7">4:00pm</option>
                                    <option value="8">5:30pm</option>
                                    <option value="9">7:00pm</option>
                                  </select>
                                  -
                                 <select class="combo" name="cmbTo" id="cmbTo" required="required">
                                    <option value="2">8:30am</option>
                                    <option value="3">10:00am</option>
                                    <option value="4">11:30am</option>
                                    <option value="5">1:00pm</option>
                                    <option value="6">2:30pm</option>
                                    <option value="7">4:00pm</option>
                                    <option value="8">5:30pm</option>
                                    <option value="9">7:00pm</option>
                                    <option value="10">8:30pm</option>
                                  </select>
                            </span><br/><br/>

                            <!-- ====RADIO GROUP==== -->
                            <span class="label label-info" style="font-size: 12pt">Filter By:</span><br/><br/>
                  
                            <label class="r"><input type="radio" name="filterby" class="radio-all" value="all" id="filterby"> All Rooms</label><br/>
                            <label class="r"><input type="radio" name="filterby" class="radio-lecture" value="Lecture Room" id="filterby"> Lecture Rooms</label><br/>
                            <label class="r"><input type="radio" name="filterby" class="radio-lab" value="Laboratory" id="filterby"> Laboratories</label><br/>
                            <label class="r"><input type="radio" name="filterby"  class="radio-outdoor" value="Outdoors" id="filterby"> Outdoors</label> <br/><br/>

                            <!-- ===BUTTON==== -->
                            <input type="button" class="btn btn-block btn-success btn-search" name="btn-search" value="Search" id="btn-search"/> <br/><br/>
                            <input type='hidden' name='hiddenType' id='hiddenType' value='all'/> 
                        </section>
                        <section class="col-md-9 table-search">     
                            <table class="table table-striped" style="width: auto;text-align:center;z-index:840;">
                            <thead class="tstyle" style="background-color:#3c8dbc;color:white;display:block;border-radius:5px;">
                              <center>
                              <th style="font-size: 12pt;padding-left:75pt;padding-right: 75pt;text-align:center;">Room Name</th>
                              <th style="font-size: 12pt;padding-left:70pt;padding-right: 70pt;text-align:center;">Type</th>
                              <th style="font-size: 12pt;padding-left:70pt;padding-right: 70pt;text-align:center;">Action</th>
                              </center>
                            </thead>
                              <?php
                                include('connects.php');
                                include('searchRoom.php');
                              ?>
                            </table>
                        </section>
                      </form>
                    </div>
                  </div><!--======END OF DIV box===========-->
                </div>
              </div><!--======END OF DIV ROW===========-->
          </section>
    </div>
  <!--==========FOOTER========-->
    <footer class="main-footer">
      <?php include ('footer.php');?>
    </footer>
  </div><!--end of wrapper-->
  
  <!--==========JAVASCRIPT=======-->
   <!--  <script src="./js/jquery-2.2.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="./js/jquery.datetimepicker.full.js"></script>
    <script src="./js/app.min.js"></script>
    <script src="./js/searchroom.js"></script> -->

   <script>
    $("#datetimepicker").datetimepicker(
      {
      timepicker:false,
      format: 'm/d/Y',

      onSelect: function()
      {
       var dateObject = $(this).datetimepicker('getDate');
        console.log('asd');
       //alert(dateObject);
      }
    });
  </script>
 </body>
</html>
