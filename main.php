<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content-="width=device-width, initial-scale=1">
    <!-- <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> -->
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
              <form method="post" action="" id="eventForm">
              <div class="row" style="padding-top: 10px;">
                <div class="col-xs-3">
                  <div class="box" style="height:350pt;">
                    <div class="box-header" style="background-color: none;">
                      <div><i class="fa fa-plus-square" style="font-size:1.5em"></i>
                          <span style="font-size:14pt">&nbsp;Request</span>
                      </div><br/>
    
                          <div class="form-group">
                            <span style="font-size: 12pt">
                              Date of Use:
                              <label id="valid" style="float:right;color:red"></label>
                            </span>
                            <div class="input-group" style="padding-left: 0px; height: 0px;">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input type="text" name='datetimepicker' id="datetimepicker" style="font-size:18px;" required="required"/>
                            </div>
                          </div>
                          <span style="font-size:12pt;">Time of Use:
                            <label id="valid2" style="float:right;color:red"></label>
                          </span><br/><br/>

                          <span><select class="combo" name="cmbFrom" id="cmbFrom" onchange="ValidateSelect()" required="required" style="width:80pt">
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
                                 <select class="combo" name="cmbTo" id="cmbTo" required="required" style="width:80pt" onchange="ValidateSelect()">
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
                            <span style="font-size: 12pt">Filter By:</span><br/>
                  
                            <label class="r"><input type="radio" name="filterby" class="radio-all" checked value="all" id="filterby"> All Rooms</label><br/>
                            <label class="r"><input type="radio" name="filterby" class="radio-lecture" value="Lecture Room" id="filterby"> Lecture Rooms</label><br/>
                            <label class="r"><input type="radio" name="filterby" class="radio-lab" value="Laboratory" id="filterby"> Laboratories</label><br/>
                            <label class="r"><input type="radio" name="filterby"  class="radio-outdoor" value="Outdoors" id="filterby"> Outdoors</label> <br/><br/>

                            <!-- ===BUTTON==== -->
                            <input type="button" class="btn btn-block btn-success btn-search" name="btn-search" value="Search" id="btn-search"/> <br/><br/>
                            <input type='hidden' name='hiddenType' id='hiddenType' value='all'/> 
                    </div>
                  </div>
                </div>

                        
                <div class="col-xs-9">
                  <div class="box" style="height:350pt;overflow:hidden;">
                    <div class="box-header" style="background-color: none;">
                    <div><i class="fa fa-list-alt" style="font-size:1.5em"></i>
                          <span style="font-size:14pt">&nbsp;&nbsp;List of Available Facilities</span>
                      </div><br/>
                      <center>
                      <section class="table-search" id="bodySelect">
                        <div id="bodySelect-span"> No selection yet. </div>
                      </section>
                      </center>
                    </div>
                  </div>
                </div>                      
            </form>
          </section>
    </div>
  <!--==========FOOTER========-->
    <footer class="main-footer">
      <?php include ('footer.php');?>
    </footer>
  </div><!--end of wrapper-->

   <script>
    $(function ()
    {
      var date = new Date();
      date.setDate(date.getDate());
      $("#datetimepicker")
      .datetimepicker(
        {
        timepicker:false,
        format: 'm/d/Y',
        showTodayButton: true,
        showClear: true,
        minDate: date,
        onSelect: function()
        {
         var dateObject = $(this).datetimepicker('getDate');
        }
      });
    });
  </script>
 </body>
</html>
