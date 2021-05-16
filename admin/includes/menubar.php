<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo (!empty($user['photo'])) ? '../images/' . $user['photo'] : '../images/profile.jpg'; ?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></p>
        <a><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class=""><a href="home.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
      <li class="header">MANAGE</li>
      <li><a href="project.php"><i class="glyphicon glyphicon-briefcase"></i> <span>Projects</span></a></li>
      <!--<li class="treeview">-->
      <!--  <a href="project.php">-->
      <!--    <i class="glyphicon glyphicon-briefcase"></i>-->
      <!--    <span>Projects</span>-->
      <!--    <span class="pull-right-container">-->
      <!--      <i class="fa fa-angle-left pull-right"></i>-->
      <!--    </span>-->
      <!--  </a>-->
      <!--  <ul class="treeview-menu">-->
      <!--    <li><a href="project.php"><i class="fa fa-circle-o"></i> Project List</a></li>-->
      <!--    <li><a href="materials_list.php"><i class="fa fa-circle-o"></i> Materials List</a></li>-->
      <!--  </ul>-->
      <!--</li>-->
      <li class="treeview">
        <a href="#">
          <i class="fa fa-users"></i>
          <span>Employee</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="employee.php"><i class="fa fa-circle-o"></i> Employee List</a></li>
          <li><a href="overtime.php"><i class="fa fa-circle-o"></i> Overtime</a></li>
          <li><a href="cashadvance.php"><i class="fa fa-circle-o"></i> Cash Advance</a></li>
        </ul>
      </li>
      <li><a href="attendance.php"><i class="fa fa-calendar"></i> <span>Attendance</span></a></li>
      <!-- <li><a href="deduction.php"><i class="fa fa-file-text"></i> <span>Deductions</span></a></li> -->



      <!--<li class="treeview">-->
      <!--  <a href="#">-->
      <!--    <i class="fa fa-users"></i>-->
      <!--    <span>Deductions</span>-->
      <!--    <span class="pull-right-container">-->
      <!--      <i class="fa fa-angle-left pull-right"></i>-->
      <!--    </span>-->
      <!--  </a>-->
      <!--  <ul class="treeview-menu">-->
      <!--    <li><a href="deduction.php"><i class="fa fa-circle-o"></i> Contributions</a></li>-->
      <!--    <li><a href="damagematerial.php"><i class="fa fa-circle-o"></i> Damage Materials</a></li>-->
      <!--  </ul>-->
      <!--</li>-->

      <li class="header">MAINTENANCES</li>
     <!--  <li><a href="schedule.php"><i class="fa fa-circle-o"></i> <span>Schedules</span></a></li> -->
      <li><a href="schedule_employee.php"><i class="fa fa-clock-o"></i> <span>Schedule</span></a></li>
      <li><a href="position.php"><i class="fa fa-address-card-o"></i> <span>Positions</span></a></li>
      <li><a href="materials.php"><i class="fa fa-cogs"></i> <span>Materials</span></a></li>
      <li><a href="list_materials.php"><i class="fa fa-wrench"></i> <span>Equipments</span></a></li>
      <li class="header">REPORTS</li>
      <li><a href="payroll.php"><i class="fa fa-files-o"></i> <span>Payroll</span></a></li>
      <li><a href="overtime_report.php"><i class="fa fa-clock-o"></i> <span>Overtime</span></a></li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>