<aside class="main-sidebar">
  <section class="sidebar" style="height: auto;">
            <!-- Sidebar user panel -->
              <div class="user-panel">
                <div class="pull-left image">
                  <span class="glyphicon glyphicon-user"></span>
                </div>
                <div class="pull-left info">
                  <p><?php echo($lname.', '.$fname); ?></p>
                </div>
              </div>
            <ul class="sidebar-menu">
              <li class="header" style="color: #fff;font-size: 14px;">MAIN NAVIGATION
              </li>
              <li role="separator" class="divider"></li>
                  <li>
                    <a href="changepass.php">
                      <i class="fa fa-cogs"></i> <span title="Profile Setting">Account Setting</span>
                    </a>
                  </li>
                  <?php if($type == "Staff"): ?>
                    <li>
                    <a href="viewRequestedRooms.php">
                      <i class="glyphicon glyphicon-list-alt"></i> <span title="My Request/s">My Request/s</span>
                    </a>
                  </li>
                    <li>
                      <a href="main.php">
                        <i class="fa fa-search"></i> <span title="Available Room/s">Available Room/s</span>
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if($type == "Dean" || $type == "CDMO" || $type == "LMO"): ?>
                    <li>
                      <a href="dv-main.php">
                        <i class="fa fa-list-alt"></i> <span title="Requested Rooms">Requested Room/s</span>
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if($type == "CDMO" || $type == "LMO"): ?>
                    <li>
                      <a href="viewInventory.php">
                        <i class="fa fa-book"></i> <span title="Equipment Inventory">Equipment Inventory</span>
                      </a>
                    </li>
                    <li>
                      <a href="viewReport.php">
                        <i class="fa fa-list"></i> <span title="Request History">Request History</span>
                      </a>
                    </li>
                  <?php endif; ?>
            </ul>
  </section>
</aside>