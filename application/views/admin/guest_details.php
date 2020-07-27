<?php $sum_amount = 0;  $the_amount = 0;?>
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">

 		<div class="span5">
      <?php if($guest_details): ?>
	       <?php foreach($guest_details as $guest): ?>
	       <div style="margin-bottom: 20px;">
	       	<img src="<?= base_url('assets/img/thumbnails/'.$guest->photo) ?>" class="img-responsive" style=" right: 0; bottom: 0; width: 200px;" alt="">
	       </div>
	    </div>
	    <div class="span5">
	       <div>
	       		<input type="hidden" class="form-control" id="this_guest_id" name="guest_id" value="<?= $guest->id ?>">
	       		<span style="font-weight: bolder; font-size: 25px;"> <?= $guest->lastname ?>, <?= $guest->firstname ?></span>
	       </div>
	       <div>
	       		<span><b>Address:</b> <?= $guest->address ?></span>
	       </div>
	       <div>
	       		<span><b>Birthday:</b> <?= $guest->birthday ?></span>
	       </div>
	       <div>
	       		<span><b>Contact Number:</b> <?= $guest->contact_number ?></span>
	       </div>
         <!-- francis -->
      <?php if($guest->is_banned==1): ?>
        <div>
           <span><b>Status:</b><font style="color:red"><b> Banned</b></font></span>
        </div>
     <?php endif; ?>
     <!-- end -->
	       <div>
	       		<i> <?= $guest->note ?></i>
	       </div>
	       <?php endforeach; ?>
          <?php endif; ?>
	      </div>

	         <?php if($checkin_details): ?>
        <?php foreach($checkin_details as $checkin): ?>

        <?php endforeach; ?>
      <?php endif; ?>

      <div class="span12">
          <h4><span class="icon-list-alt"></span> Checkin History Details</h4>
          <table class="table table-striped table-bordered" id="guest_table">
              <thead>
                 <tr>
                  <th> Service # </th>
                  <th> Rooom</th>
                  <th> Guest/s</th>
                  <th> Reservation Date</th>
                  <th> Checkin Date</th>
                  <th> Status</th>
                  <th> Payment Status</th>
                  <th> Extra Charges</th>
                </tr>
              </thead>
               <tbody>
                <?php if($checkin_details):  ?>
                <?php foreach($checkin_details as $checkin): ?>
                <tr>
                 <td><?= $checkin->service_id ?></td>
                 <td><?= $checkin->type ?> - <?= $checkin->room_name ?></td>
                 <td><?= $checkin->guests ?></td>
                 <td><?= $checkin->reservation_date ?></td>
                 <td><?= $checkin->checkin_date ?> TO <?= $checkin->checkout_date ?></td>

                 <td><?php if($checkin->c_status == 1){
                     echo '<span class="label label-success"> CHECKED-IN </span>';
                 } elseif($checkin->c_status == 2) {
                     echo '<span class="label label-warning"> RESERVED </span>';
                 } elseif($checkin->c_status == 0) {
                     echo '<span class="label label-danger"> CHECKED-OUT </span>';
                 }
                 ?></td>
                 <td><?php
                 if($checkin->c_status < 2){ // FOR CHECKED IN OR CHECKOUT

                     if($checkin->checkout_date == "0000-00-00 00:00:00") { // OPEN TIME
                        $checkin_date =  new DateTime($checkin->checkin_date);
                        $checkout_date = new DateTime("now");
                       /* $interval = date_diff($checkin_date, $checkout_date);*/
                        $amount_due_payment = 1 * $checkin->total_amount;

                        $data = $this->Admin_model->_get_total_amount_due_payment($checkin->service_id);
                         if($data) {
                           $the_amount = $amount_due_payment - $data->payment_amount;
                        } else {
                           $amount_due_checkin = $this->Admin_model->_get_total_amount_due_checkin($checkin->service_id);
                           $the_amount = $amount_due_payment;
                        }

                     } else { // WITH CHECKOUT DATE
                        $amount_due_payment = $this->Admin_model->_get_total_amount_due_payment($checkin->service_id);

                        if($amount_due_payment) {
                           $the_amount = $amount_due_payment->total_amount_due - $amount_due_payment->payment_amount;
                        } else {
                           $amount_due_checkin = $this->Admin_model->_get_total_amount_due_checkin($checkin->service_id);
                           $the_amount = $amount_due_checkin->total_amount;
                        }
                     }




                      if($the_amount < 0) {
                        echo '<span class="label label-success"> PAID </span>';
                      } else {
                        echo ' <span class="label label-danger"> UNPAID </span>&nbsp;<span class="label label-default"> PHP '.number_format($the_amount,2).'</span>';
                      }




                }
                ?></td>
                <td>
                  <?php
                  $charges = $this->Admin_model->_get_charges($checkin->service_id);
                    $total_charges = 0;
                    if ($charges) {
                      foreach($charges AS $charge) {
                         //if($charges[0]->sum_charges > 0) {

                          echo '<span class="label label-default">' .$charge->description.' '.number_format($charge->amount,2).'</span></br>';
                          $total_charges = $total_charges + $charge->amount;
                       //}
                      }


                    }

                    $sum_amount = $sum_amount + $the_amount + $total_charges;
                ?>
                </td>

              </tr>


              <?php endforeach; ?>
            <?php endif; ?>
              </tbody>
          </table>


        </div>


        <div class="span12" style="border-top: 1px dashed #808080; margin-top: 20px;">
          <h4><span class="icon-money"></span> Payment History Details</h4>
          <table class="table table-striped table-bordered" id="guest_table">
              <thead>
                <tr>
                  <th> Payment # </th>
                  <th> Service # </th>
                  <th> Total Amount Due</th>
                  <th> Payment Amount</th>
                  <th> Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if($payment_details): ?>
                <?php foreach($payment_details as $payment): ?>
                <tr>
                 <td><?= $payment->payment_id ?></td>
                 <td><?= $payment->service_id ?></td>
                 <td><?= number_format($payment->total_amount_due,2) ?></td>
                 <td><?= number_format($payment->payment_amount,2) ?></td>
                 <td><?= $payment->date_time ?></td>
                 <td>
                    <a data-toggle="modal" href="#open_invoice<?= $payment->service_id ?>" data-id="<?= $payment->service_id ?>" data-payment="<?= $payment->payment_id ?>" class = "open-invoice btn btn-primary btn-xs" > <i class="icon-file"></i> View Invoice </a>
                 </td>
              </tr>


            <!-- Invoice Modal -->
            <div class="modal fade" id="view_invoice<?= $payment->service_id ?>" role="dialog">
                <div class="modal-dialog">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                                <h3>Invoice</h3>
                        </div>
                        <input type="hidden" class="form-control" id="invoice_service_id" name="service_id" value="<?= $payment->service_id ?>">
                        <input type="hidden" class="form-control" id="this_group_id<?= $payment->service_id ?>" name="group_id" value="<?= $payment->group_guest_id ?>">
                        <input type="hidden" class="form-control" id="this_payment_id<?= $payment->payment_id ?>" name="payment_id" value="<?= $payment->payment_id ?>">
                        <div class="modal-body" >
                          <img src="<?= base_url('assets/img/logo/logo.PNG') ?>" class="img-responsive" style=" right: 0; bottom: 0; width: 100%; height: 110px;" alt="">
                          <div id="invoice_div"></div>
                        </div>
                        <div class="modal-footer">
                            <button class="button btn btn-primary btn-sm" onclick="print('invoice_div', 'Invoice');">
                                <span class="icon-print"> Print</span></button>
                        </div>
                    </div>
                </div>
            </div>
          <!-- End of Invoice Modals -->



              <?php endforeach; ?>
            <?php endif; ?>
              </tbody>
            </table>


          <div style="float: right;">
           <?php
              /*$total = $this->Admin_model->_get_total_due_by_guest($this->uri->segment(3));
              $data = $this->Admin_model->_get_sum_payment_by_guest($this->uri->segment(3));*/
              if($sum_amount) {
                $advance = $this->Admin_model->_get_advance_payment_by_guest($this->uri->segment(3));

                if($sum_amount > $advance->total_advance_payment) {
                  $text = "<b>Total Balance: </b>";
                  $total = $sum_amount - $advance->total_advance_payment;
                  $status = '<span class="label label-danger"> UNPAID </span>';
                } else {
                  $text = "<b>Change: </b>";
                  $total = $advance->total_advance_payment - $sum_amount;
                  $status = '<span class="label label-success"> PAID </span>';
                }

                /*$balance = $total->total_due - $data->sum_payment;*/
                echo '<h5>Remaining Balance: <b>'.number_format($sum_amount,2).'</b></h5>';
                echo '<h5> Advance Payment: <b>'.number_format($advance->total_advance_payment,2).'</b></h5>';
                echo '<h4 style="color: maroon; padding-top: 5px;">'.$text.number_format($total,2).'</b> ' . $status . '</h4>';
              }

            ?>
          </div>
        </div>



		</div>
	  </div>
	</div>
  </div>
</div>
<!-- INCLUDE MODALS -->
 <?= $this->load->view('modals', '', TRUE) ?>
 <!-- Loading JS Libraries -->
<script type="text/javascript" src="<?= base_url('assets/js/jquery-3.1.0.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/datatables/js/jquery.dataTables.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/datatables/js/dataTables.tableTools.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/datatables/js/dataTables.bootstrap.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>
<!-- INVOICE -->
<script>
var base_url =  '<?php echo base_url() ?>';
$(document).on("click", ".open-invoice", function () {
var sID = $(this).data('id');
var pID = $(this).data('payment');
var modal_val = "#view_invoice" + sID;
var group_id_val = "this_group_id" + sID;
var payment_id_val = "this_payment_id" + pID;
var this_group_id = document.getElementById(group_id_val).value;
var this_payment_id = document.getElementById(payment_id_val).value;

 $(modal_val).modal('show');
 $(".modal-body #invoice_service_id").val( sID );
  var url = base_url + "admin/view_invoice/"+sID+"/"+this_group_id+"/"+this_payment_id;
  console.log(url);
  var data = $(this).serialize();
  $.ajax({
    url: url,
    type: "GET",
    dataType: "JSON",
    data: data,
    cache: false,
    processData: false,
    success: function (data) {
     $('.modal-body #invoice_div').empty();
      if(data.checkin_data && this_group_id <= 0){
       console.log(data.checkin_data);
        $.each(data.checkin_data, function (key, value) {
          $('.modal-body #invoice_div').append(
            '<div style="border-top: 1px #808080 dashed; margin: 5px; padding-top: 10px; ">'+
            '<div style="width: 50%;float: left;"><b> Service #: </b> '+ value.service_id +'</br>'+
            '<b> Guest Name: </b> '+ value.firstname +' '+ value.lastname +'</br>'+
            '<b> Address: </b> '+ value.address +'</br>'+
            '<b> Room: </b> '+ value.room_name +'</br>'+
            '<b> Type: </b> '+ value.type +'</br></div>'+
            '<div style="width: 50%; float: left;"><b> No. of Guest/s: </b> '+ value.guests +'</br>'+
            '<b> Arrival: </b> '+ value.checkin_date +'</br>'+
            '<b> Departure: </b> '+ value.checkout_date +'</br></div>'+
            '</div> </br></br>'+
             '<div style="width: 100%;"><table style="max-width: 100%; width: 100%; margin: 10px; padding-top: 20px; font-size: 10px;">'+
            '<thead>'+
            '<tr style="text-align: center;"><th style=" padding: 4px; text-align: center ;border-bottom: 2px solid #333333 ;">Date</th>'+
            '<th style=" padding: 4px; text-align: center ;border-bottom: 2px solid #333333 ;">Description</th>'+
            '<th style=" padding: 4px; text-align: center ;border-bottom: 2px solid #333333 ;">Rate</th>'+
            '<b> Remarks: </b> '+ value.checkin_note +'</br></div>'+
            '</thead>'+
            '<tbody>'+
             '<tr><td style=" padding: 4px; text-align: center ;border-bottom: 1px dotted #999999 ;">'+ value.checkin_date +'</td>'+
            '<td style=" padding: 4px; text-align: center ;border-bottom: 1px dotted #999999 ;">'+ value.type +' - '+ value.room_name +'</td>'+
            '<td style=" padding: 4px; text-align: center ;border-bottom: 1px dotted #999999 ;">'+new Intl.NumberFormat().format(value.rate)+'</td>'
          );


        });
        $.each(data.payment_data, function (key, value) {
            var change = eval(value.total_amount_due) - eval(value.payment_amount);

            $('.modal-body #invoice_div').append(
             '</tbody>'+
              '</table></div>'+
              '<div style="text-align: right;"><h4>Total Amount Due: <b>'+new Intl.NumberFormat().format(value.total_amount_due)+'</b></h4></div>'+
              '<div style="text-align: right;"><h4>Total Payment: <b> '+new Intl.NumberFormat().format(value.payment_amount)+'</b></h4></div>'+
              '<div style="text-align: right;"><h4>Balance: <b>'+new Intl.NumberFormat().format(change)+'</b></h4></div>'
            );

          });

        } else {
            $.each(data.checkin_data, function (key, value) {
              $('.modal-body #invoice_div').append(
                '<div style="border-top: 1px #808080 dashed; margin: 5px; padding-top: 10px; ">'+
                '<div style="width: 50%;float: left;"><b> Service #: </b> '+ value.service_id +'</br>'+
                '<b> Guest Name: </b> '+ value.firstname +' '+ value.lastname +'</br>'+
                '<b> Address: </b> '+ value.address +'</br>'+
                '<b> Room: </b> '+ value.room_name +'</br>'+
                '<b> Type: </b> '+ value.type +'</br></div>'+
                '<div style="width: 50%; float: left;"><b> No. of Guest/s: </b> '+ value.guests +'</br>'+
                '<b> Arrival: </b> '+ value.checkin_date +'</br>'+
                '<b> Departure: </b> '+ value.checkout_date +'</br></div>'+
                '</div> </br></br>'+
                 '<div style="width: 100%;"><table style="max-width: 100%; width: 100%; margin: 10px; padding-top: 20px; font-size: 10px;" id="table_rooms">'+
                '<thead>'+
                '<tr style="text-align: center;"><th style=" padding: 4px; text-align: center ;border-bottom: 2px solid #333333 ;">Date</th>'+
                '<th style=" padding: 4px; text-align: center ;border-bottom: 2px solid #333333 ;">Description</th>'+
                '<th style=" padding: 4px; text-align: center ;border-bottom: 2px solid #333333 ;">Rate</th>'+
                '<b> Remarks: </b> '+ value.checkin_note +'</br></div>'+
                '</thead>'+
                '<tbody>'

            );

            $.each(data.rooms_data, function (key, value) {
              $('.modal-body #invoice_div #table_rooms').append(
                '<tr style="max-width: 100%; width: 100%; margin: 10px; padding-top: 20px; font-size: 10px;"><td style=" padding: 4px; text-align: center ;border-bottom: 1px dotted #999999 ;">'+ value.checkin_date +'</td>'+
                '<td style=" padding: 4px; text-align: center ;border-bottom: 1px dotted #999999 ;">'+ value.type +' - '+ value.room_name +'</td>'+
                '<td style=" padding: 4px; text-align: center ;border-bottom: 1px dotted #999999 ;">'+new Intl.NumberFormat().format(value.rate)+'</td>'+
                '</tr>'
              );

            });

            /*$('.modal-body #invoice_div').append(
               '</tbody>'+
                '</table></div>'+
                '<div style="text-align: right;"><b>Total Charges:</b> '+new Intl.NumberFormat().format(value.total_amount)+'</div>'+
                '<div style="text-align: right;"><b>Total Payment:</b> '+new Intl.NumberFormat().format(value.total_amount_paid)+'</div>'+
                '<div style="text-align: right;"><b>Balance:</b> '+new Intl.NumberFormat().format(value.change_amount)+'</div>'
              );*/
            $.each(data.payment_data, function (key, value) {
              var change = eval(value.total_amount_due) - eval(value.payment_amount);
              $('.modal-body #invoice_div').append(
               '</tbody>'+
                '</table></div>'+
                '<div style="text-align: right;"><h4>Total Amount Due: <b>'+new Intl.NumberFormat().format(value.total_amount_due)+'</b></h4></div>'+
                '<div style="text-align: right;"><h4>Total Payment:<b> '+new Intl.NumberFormat().format(value.payment_amount)+'</b></h4></div>'+
                '<div style="text-align: right;"><h4>Balance:<b> '+new Intl.NumberFormat().format(change)+'</b></h4></div>'
              );

            });

        });


        }

    },
    error: function (jqXHR, textStatus, errorThrown) {
      // For debugging
      console.log('The following error occurred: ' + textStatus, errorThrown);
    }
  });
});


function print(divId, title) {
  var content = document.getElementById(divId).innerHTML;
  var mywindow = window.open('', 'Print', 'height=600,width=800');

  mywindow.document.write('<html><head><title>'+title+'</title>');
  mywindow.document.write('</head><body style="font-family:verdana, arial, sans-serif; font-size: 10px;">');
  mywindow.document.write('<img src="<?= base_url('assets/img/logo/logo.PNG') ?>" class="img-responsive" style=" right: 0; bottom: 0; width: 100%; height: 110px;" alt="">');
  mywindow.document.write(content);
  mywindow.document.write('</body></html>');

  mywindow.document.close();
  mywindow.focus()
  mywindow.print();
  mywindow.close();
  return true;
}
</script>
