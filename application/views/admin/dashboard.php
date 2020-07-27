<?php $sum_amount = 0;  $the_amount = 0;?>
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">

        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="widget widget-nopad" id="target-1">
            <!-- francis -->
        <?php if ($this->session->flashdata('success') == TRUE): ?>
          <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error') == TRUE): ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>
              <!-- end -->
            <div class="widget-header"> <i class="icon-bell"></i>
              <h3> Today's Stats</h3>
            </div>

            <div class="widget-content">
              <div class="widget big-stats-container">
                <div class="widget-content">
                  <h5 class="bigstats" style="padding: 10px;"> What happened today? </h5>
                  <div id="big_stats" class="cf">

                    <div class="stat"> <i class="icon-home"></i> <span class="value"><?= count($this->Admin_model->_get_available_rooms());?> </span> <br>Available Rooms</div>
                    <div class="stat"> <i class="icon-user"></i> <span class="value"><?= count($this->Admin_model->_checkin_guests_this_day());?></span> <br>Guests Today </div>
                    <div class="stat"> <i class="icon-reply"></i> <span class="value"><?= count($this->Admin_model->_checkout_guests_this_day());?></span> <br>For Checkout </div>

                   <!--  <div class="stat"> <i class="icon-shopping-cart"></i> <span class="value"><?= count($this->Admin_model->_get_available_rooms());?></span> <br>Purchased Orders </div> -->
                  </div>
                  <div id="big_stats" class="cf">
                    <div class="stat"> <i class="icon-shopping-cart"></i> <span class="value"><?= count($this->Admin_model->_get_all_products()); ?></span> <br>Products</div>
                     <div class="stat"> <i class="icon-list-alt"></i> <span class="value"><?= count($this->Admin_model->_get_transactions()); ?></span> <br>Transaction Count </div>
                    <div class="stat"> <i class="icon-info"></i> <span class="value"><?= count($this->Admin_model->_get_all_products_low_quantity()); ?></span> <br>Low Quantity </div>
                  </div>
                </div>

              </div>
            </div>
          </div>

<!--
           <div class="widget widget-table action-table" id="target-3">
            <div class="widget-header"> <i class="icon-th-list"></i>
              <h3>Pending Balances</h3>
            </div>
              <table class="table table-striped table-bordered" id="guest_table">
                  <thead>
                    <tr>
                      <th> Service # </th>
                      <th> Rooom</th>
                      <th> Guest</th>
                      <th> Status</th>
                      <th> Total Balance</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php if($checkin_details): ?>
                    <?php foreach($checkin_details as $checkin): ?><?php
                      $amount_due_payment = $this->Admin_model->_get_total_amount_due_payment($checkin->service_id);
                      $amount = "";
                      if($amount_due_payment) {
                         $amount = $amount_due_payment->total_amount_due - $amount_due_payment->payment_amount;
                      }
                      else {
                         $amount_due_checkin = $this->Admin_model->_get_total_amount_due_checkin_dashboard($checkin->service_id);
                         $amount = $amount_due_checkin->total_amount_due;
                      }
                      if($amount > 0) {?>
                        <tr>
                         <td><?= $checkin->service_id ?></td>
                         <td><?= $checkin->type ?> - <?= $checkin->room_name ?></td>
                         <td><a href="<?= base_url('admin/guest_details/'.$checkin->guest_id); ?>"><?= $checkin->firstname ?> <?= $checkin->lastname ?></a></td>
                         <td><span class="label label-danger">UNPAID</span> <span class="label label-default"></span></td>
                         <td><?= number_format($amount,2,'.',','); ?></td>

                    <?php  }
                      ?>


                  </tr>

                  <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
              </table>


            </div> -->

            <div class="widget widget-table action-table" id="target-3">
              <div class="widget-header"> <i class="icon-th-list"></i>
                <h3>Most Recent Guests</h3>
              </div>
              <div class="widget-content">
                <?php if($guests_today): ?>

                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th> Service # </th>
                      <th> Name </th>
                      <th> Room </th>
                      <th> Guest/s</th>
                      <th> Status </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($guests_today AS $guest): ?>
                    <tr>
                      <td> <?= $guest->service_id ?> </td>
                      <td><a href="<?= base_url('admin/guest_details/'.$guest->guest_id); ?>"><?= $guest->firstname ?> <?= $guest->lastname ?></a> </td>
                      <td> <?= $guest->type ?> - <?= $guest->room_name ?> </td>
                      <td> <?= $guest->guests ?> </td>
                      <td>
                        <?php if($guest->status == 1): ?>
                          <?php if($guest->checkin_date > date("Y-m-d") ): ?>
                          <span class="label label-danger">Reserved</span>
                          <?php else: ?>
                            <span class="label label-success">Checkin</span>
                          <?php endif; ?>

                        <?php else: ?>
                        <span class="label label-warning">Checkout</span>
                        <?php endif; ?>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>

              <?php endif; ?>
              </div>
            </div>

            <div class="widget widget-nopad">
              <div class="widget-header"> <i class="icon-list-alt"></i>
                <h3> Calendar</h3>
              </div>

                <div id="calendar"></div>

            </div>


          </div>

          <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="widget">
              <div class="widget-header"> <i class="icon-bookmark"></i>
                <h3>Important Shortcuts</h3>
              </div>

              <div class="widget-content">
                <div class="shortcuts">
                  <a href="<?= base_url('admin/rooms'); ?>" class="shortcut"><i class="shortcut-icon icon-home"></i><span class="shortcut-label">Rooms</span> </a>
                  <a href="<?= base_url('admin/products'); ?>" class="shortcut"><i class="shortcut-icon icon-user-md"></i><span class="shortcut-label">Products</span> </a>
                  <a href="<?= base_url('admin/reports'); ?>" class="shortcut"><i class="shortcut-icon icon-file"></i><span class="shortcut-label">Reports</span> </a>
                  <a href="<?= base_url('auth/signout'); ?>" class="shortcut"><i class="shortcut-icon icon-off"></i><span class="shortcut-label">Logout</span> </a>
                  <!-- francis -->
                  <a onclick="banned_customer_modal()" class="shortcut"><i class="shortcut-icon icon-user" style="color:red"></i><span class="shortcut-label">Banned Guest</span> </a>
                  <!-- end -->
                </div>
              </div>
            </div>



           <?php if($checkin_distinct): ?>
            <div class="widget">
              <!-- NOTIFICATION -->
              <?php $count = 0; ?>
              <table class="table table-striped table-bordered blinker" id="balance_table" style="box-shadow: 0 0 10px #a94442; height: 80px;">
              <thead>
                <tr>
                  <th> Service # </th>
                  <th> Name</th>
                  <th> Balance</th>
                </tr>
              </thead>
              <tbody>

              <?php foreach($checkin_distinct as $checkin): ?>
              <?php
              $amount_due_payment = $this->Admin_model->_get_total_amount_due_payment_by_guest($checkin->guest_id);
              $amount = "";
              if($amount_due_payment) {
                 $amount = $amount_due_payment->total_due - $amount_due_payment->payment_amt;
              } else {
                 $amount_due_checkin = $this->Admin_model->_get_total_amount_due_checkin_by_id($checkin->guest_id);
                 $amount = $amount_due_checkin->total_checkin_amount;
              }

              /* CHARGES */
              $charges = $this->Admin_model->_get_charges_by_guest($checkin->guest_id);
              $total_charges = 0;
              $sum_amount = 0;
              if ($charges) {
                $total_charges = $total_charges + $charges->total_charges;
              }

              $sum_amount = $amount + $total_charges; ?>
              <?php /* ADVANCE PAYMENT */
              $advance = $this->Admin_model->_get_advance_payment_by_guest($checkin->guest_id);
              if ($advance) {
                 $total = $sum_amount - $advance->total_advance_payment;
               }
                if($total > 0 ) : ?>
                <?php $count = $count +1; ?>
                 <tr>
                  <td><?= $checkin->service_id ?></td>
                  <td> <a href="<?= base_url('admin/guest_details/'.$checkin->guest_id); ?>"><?= $checkin->firstname ?> <?= $checkin->lastname ?></a></td>
                  <td> PHP <?= number_format($sum_amount, 2 ); ?> </td>
                 </tr>
                  <!--  <div class="col-md-4 col-lg-4">
                    <div class="alert alert-danger blinker" style="box-shadow: 0 0 10px #a94442; height: 80px;">
                      <strong><i class="icon-warning-sign"></i> OVERDUE:   </strong>
                      # <?= $checkin->service_id ?> </br>
                      <a href="<?= base_url('frontdesk/guest_details/'.$checkin->guest_id); ?>"><?= $checkin->firstname ?> <?= $checkin->lastname ?></a>
                      <!-- PHP <?= $sum_amount ?> -->
                    <!-- </div>
                  </div> -->

                   <?php endif; ?>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <?php echo "<span style='color: maroon;'><b>TOTAL OVERDUE: ". $count ."</b></span>" ?>
              </div>
            <?php endif; ?>





            <div class="widget" id="target-2" style="color: #a94442; font-weight: 600;">
              <div class="widget-header"> <i class="icon-info"></i>
                <h3>Products with Low Quantity</h3>
              </div>
              <div class="widget-content">
                <!-- <canvas id="area-chart" class="chart-holder" height="250" width="538"> </canvas> -->
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th> Name </th>
                      <th> Quantity </th>
                      <th> Amount </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if ($products): ?>
                      <?php foreach($products AS $products1): ?>
                        <tr>
                          <td> <?= $products1->name ?>  </td>
                          <td> <?= $products1->quantity ?> </td>
                          <td> <?= $products1->amount ?> </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>


                  </tbody>
                </table>
              </div>

            </div>

            <div class="widget" id="target-2">
              <div class="widget-header"> <i class="icon-group"></i>
                <h3> Incoming Guests this week</h3>
              </div>
              <div class="widget-content">
                <!-- <canvas id="area-chart" class="chart-holder" height="250" width="538"> </canvas> -->
                <?php if($guests_this_week): ?>
                 <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th> Checkin Date </th>
                      <th> Name </th>
                      <th> Room </th>
                      <th> Checkin Count </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($guests_this_week AS $guest): ?>
                    <tr>
                      <td> <?php $date = new DateTime($guest->checkin_date); echo date_format($date, 'M d, Y H:i A'); ?> </td>
                      <td> <?= $guest->firstname ?> <?= $guest->lastname ?> </td>
                      <td> <?= $guest->type ?> - <?= $guest->room_name ?> </td>
                      <td> <?= $guest->guests ?> </td>

                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                <?php endif; ?>
              </div>

            </div>

            <div class="widget widget-table action-table" id="target-3">
              <div class="widget-header"> <i class="icon-th-list"></i>
                <h3>Recent Transactions</h3>
              </div>
              <div class="widget-content">


                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th> # </th>
                      <th> Total Amount </th>
                      <th> Date </th>
                      <th> Cashier</th>
                    </tr>
                  </thead>
                  <tbody>

                   <?php if($recent_transaction): ?>
                      <?php foreach ($recent_transaction as $recent): ?>
                        <tr>
                          <td> <?= $recent->trans_id ?> </td>
                          <td> PHP <?= number_format($recent->total_amount,2,'.',','); ?> </td>
                          <td> <?= $recent->date_time ?> </td>
                          <td> <?= $recent->username ?> </td>

                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>

                      </td>
                    </tr>
                  </tbody>
                </table>

              </div>
            </div>


          </div>


          </div>

      </div>

    </div>

  </div>

</div>

<!-- Banned Guest Modal Francis-->
    <div class="modal fade" id="banned_customer_modal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <!-- <button type="button" class="close" data-dismiss="modal">×</button> -->
            <span><button type="submit" class="btn btn-primary pull-right" onclick="add_banned_cutomer_modal()">Add Customer</button>
              <h3>Banned Customer</h3></span>
            </div>
            <div class="modal-body">
              <div class="col-md-6" id="banned_data">

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>

<!-- End of Modal -->

<!-- Add Banned Guest Modal Francis-->
<div class="modal fade" id="add_banned_customer_modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal">×</button> -->
        <h3>Add Banned Customer</h3>
      </div>
      <form action="<?=base_url('frontdesk/add_banned_guest')?>" method="post" role="form" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="">
            <label for="fname">First Name</label>
            <input type="text" class="form-control" id="firstname" name="firstname">
          </div>

          <div class="">
            <label for="fname">Last Name</label>
            <input type="text" class="form-control" id="lastname" name="lastname">
          </div>

          <div class="">
            <label for="photo">Photo</label>
            <input type="file" class="form-control" id="picture" name="picture">
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" >Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>

  </div>
</div>
<!-- End of Modal -->

<!-- INCLUDE MODALS -->
 <?= $this->load->view('modals', '', TRUE) ?>
<!-- Loading JS Libraries -->
<script src="<?= base_url('/assets/js/jquery-3.1.0.min.js'); ?>"></script>
<script src="<?= base_url('/assets/js/bootstrap.min.js'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?= base_url('/assets/js/full-calendar/moment.min.js'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?= base_url('/assets/js/full-calendar/jquery.min.js'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?= base_url('/assets/js/full-calendar/fullcalendar.js'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?= base_url('/assets/js/full-calendar/theme-chooser.js'); ?>"></script>
<script type="text/javascript">
var base_url =  '<?php echo base_url() ?>';
 $(document).ready(function() {
   function blinker() {
      $('.blinker').fadeOut(500);
      $('.blinker').fadeIn(500);
    }
    setInterval(blinker, 1000);

     $('#calendar').fullCalendar({
       header: {
            left: 'today',
            center: 'title',
            right: 'month'
          },
          navLinks: true, // can click day/week names to navigate views
          editable: true,
          eventLimit: true, // allow "more" link when too many events
          eventSources: [
         {
             events: function(start, end, timezone, callback) {
                 $.ajax({
                 url: "<?php echo base_url('admin/get_events'); ?>",
                 dataType: 'json',
                 data: {
                 // our hypothetical feed requires UNIX timestamps
                 start: start.unix(),
                 end: end.unix()
                 },
                 success: function(msg) {
                       var events = msg.events;
                       callback(events);
                   }
                 });
             }
         },
      ]


    });


  });

  //francis
function add_banned_guest(){
  var url = base_url + 'frontdesk/add_banned_guest';
  $.ajax({
    url : url,
    type: "POST",
    data: $('#add_banned_guest_form').serialize(),
    dataType: "JSON",
    success: function(data)
    {
      if(data.status){
        $('#add_banned_customer_modal').modal('hide');
        document.getElementById("add_banned_guest_form").reset();
      }
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      alert('Error adding / update data');
    }
  });
}

//Franics Dy
function banned_customer_modal(){
$('#banned_customer_modal').modal('show');
 var url = base_url + "admin/get_all_banned_customer";
  var data = $(this).serialize();
  $.ajax({
    url: url,
    type: "GET",
    dataType: "JSON",
    data: data,
    cache: false,
    processData: false,
    success: function (data) {
      $('#banned_data').empty();
      if(data.banned_customer){
        $.each(data.banned_customer, function (key, value) {
          $('#banned_data').append(
            '<div class="col-md-12">'+
            '<div class="panel panel-default">'+
            '<div class="panel-body">'+
            '<div class="form-group">'+
            '<div ">'+
            '<img src="'+base_url+'assets/img/thumbnails/'+value.photo+'" class="img-responsive" style=" right: 0; bottom: 0; width: 300px;" alt="">'+
            '</div>'+
            '</div>'+
            '<div class="form-group">'+
            '<label for="Name">Name: '+value.firstname+' '+value.lastname+' </label>'+
            '</div>'+
            '</div>'+
            '</div>'+
            '</div>'
          );
        });

        } else {
          $('#banned_data').append(
        '<label>No datas found</label>');
          console.log("No Data");
            console.log("No Data");
        }

    },
    error: function (jqXHR, textStatus, errorThrown) {
      // For debugging
      console.log('The following error occurred: ' + textStatus, errorThrown);
    }
  });
}

//Franics Dy
function add_banned_cutomer_modal(){
$('#banned_customer_modal').modal('hide');
$('#add_banned_customer_modal').modal('show');
}
</script>

<style>

  body {
    padding: 0;
    font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
    font-size: 14px;
  }

  #calendar {
    max-width: 1000px;
    margin: 0 auto;
  }

</style>

</body>
</html>
