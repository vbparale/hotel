<!DOCTYPE html>
<html>
  <head>
    <title><?=$page_title?></title>
    <meta charset="utf8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<link href="<?= base_url('/assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('/assets/css/bootstrap-responsive.min.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('/assets/css/font-style.css'); ?>"
	        rel="stylesheet">
	<link href="<?= base_url('/assets/css/font-awesome.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('/assets/css/style.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('/assets/css/pages/dashboard.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('/assets/css/pages/signin.css'); ?>" rel="stylesheet" type="text/css">
  <link href="<?= base_url('/assets/js/guidely/guidely.css'); ?>" rel="stylesheet"> 
  <link rel="stylesheet" href="<?= base_url('/assets/datatables/css/buttons.dataTables.min.css'); ?>" />
  <link rel="stylesheet" href="<?= base_url('/assets/js/full-calendar/fullcalendar.min.css'); ?>" />
  <link href="<?= base_url('/assets/js/full-calendar/fullcalendar.print.min.css'); ?>" media='print'/>

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	    <![endif]-->
  </head>
  <body style="margin-bottom: 50px;">
  <div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="brand" href="<?= base_url(); ?>"><i class="icon-home"></i></a>
     
          <div class="nav-collapse">
            <ul class="nav pull-right">
              <div class="dropdown">
              <!-- <a href="#" type="button" id="menu1" data-toggle="dropdown"><i class="icon-user"></i>  <b class="caret"></b></a> -->
              <button class="btn btn-info dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><i class="icon-user"></i> 
              <b class="caret" style="padding-top: 10px;"></b></button>
              <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                <li role="presentation"><a role="menuitem" href="<?= base_url('auth/signout'); ?>">Signout</a></li>
              </ul>
            </div>
             
              </ul>
             <!--  <form class="navbar-search pull-right" action="/search" method="POST">
                <input type="text" name="customer" class="search-query" placeholder="Search Customer">
              </form> -->
          </div>
          <!--/.nav-collapse --> 
      <? } ?>
    </div>
    <!-- /container --> 
  </div>
  <!-- /navbar-inner --> 
</div>
<!-- /navbar -->


<?php if($page): ?>
  <?php if(user('role') == 1): ?>
  <!-- ADMIN -->
    <div class="subnavbar">
      <div class="subnavbar-inner">
        <div class="container">
          <ul class="mainnav">
            <li <?php if($page == "dashboard"){ echo 'class="active"'; } ?>><a href="<?= base_url('admin/dashboard'); ?>"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
            <li <?php if($page == "guests" || $page == "guest_details"){ echo 'class="active"'; } ?>><a href="<?= base_url('admin/guests'); ?>"><i class="icon-user"></i><span>Guest History</span> </a> </li>
             <li <?php if($page == "status"){ echo 'class="active"'; } ?>><a href="<?= base_url('admin/status'); ?>"><i class="icon-info "></i><span>Unpaid Guest List</span> </a> </li>
            <li <?php if($page == "rooms"){ echo 'class="active"'; } ?>><a href="<?= base_url('admin/rooms'); ?>"><i class="icon-home"></i><span>Rooms</span> </a> </li>
            <li <?php if($page == "reservations"){ echo 'class="active"'; } ?>><a href="<?= base_url('admin/reservations'); ?>"><i class="icon-list-alt"></i><span>Reservations</span> </a> </li>
            <li <?php if($page == "products"){ echo 'class="active"'; } ?>><a href="<?= base_url('admin/products'); ?>"><i class="icon-shopping-cart"></i><span>Products</span> </a> </li>
             <li <?php if($page == "transaction_history"){ echo 'class="active"'; } ?>><a href="<?= base_url('admin/transaction_history'); ?>"><i class="icon-list"></i><span>Transaction History</span> </a> </li>
            <li <?php if($page == "accounts"){ echo 'class="active"'; } ?>><a href="<?= base_url('admin/accounts'); ?>"><i class="icon-user"></i><span>Accounts</span> </a> </li>
            <li <?php if($page == "reports"){ echo 'class="active"'; } ?>><a href="<?= base_url('admin/reports'); ?>"><i class="icon-file "></i><span>Reports</span> </a> </li>
            </ul>
        </div>
      </div>
    </div>

  <?php elseif(user('role') == 2): ?>
  <!-- FRONTDESK -->
  <div class="subnavbar">
      <div class="subnavbar-inner">
        <div class="container">
          <ul class="mainnav">
            <li <?php if($page == "dashboard"){ echo 'class="active"'; } ?>><a href="<?= base_url('frontdesk/dashboard'); ?>"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
            <li <?php if($page == "guests" || $page == "guest_details"){ echo 'class="active"'; } ?>><a href="<?= base_url('frontdesk/guests'); ?>"><i class="icon-user"></i><span>Guests</span> </a> </li>
            <li <?php if($page == "status"){ echo 'class="active"'; } ?>><a href="<?= base_url('frontdesk/status'); ?>"><i class="icon-info "></i><span>Unpaid Guest List</span> </a> </li>
             <li <?php if($page == "rooms"){ echo 'class="active"'; } ?>><a href="<?= base_url('frontdesk/rooms'); ?>"><i class="icon-home"></i><span>Rooms</span> </a> </li>
            <li <?php if($page == "reservations"){ echo 'class="active"'; } ?>><a href="<?= base_url('frontdesk/reservations'); ?>"><i class="icon-list-alt"></i><span>Calendar</span> </a> </li>
          </ul>
        </div>
      </div>
    </div>

  <?php elseif(user('role') == 3): ?>
  <!-- CASHIER -->
  <div class="subnavbar">
      <div class="subnavbar-inner">
        <div class="container">
          <ul class="mainnav">
            <li <?php if($page == "dashboard"){ echo 'class="active"'; } ?>><a href="<?= base_url('cashier/dashboard'); ?>"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
            <li <?php if($page == "transaction"){ echo 'class="active"'; } ?>><a href="<?= base_url('cashier/transaction'); ?>"><i class="icon-plus"></i><span>Transaction</span> </a> </li>
             <li <?php if($page == "products"){ echo 'class="active"'; } ?>><a href="<?= base_url('cashier/products'); ?>"><i class="icon-shopping-cart"></i><span>Products</span> </a> </li>
              <li <?php if($page == "transaction_history"){ echo 'class="active"'; } ?>><a href="<?= base_url('cashier/transaction_history'); ?>"><i class="icon-list"></i><span>History</span> </a> </li>
          </ul>
        </div>
      </div>
    </div>

  <?php endif;?>
<?php endif;?>