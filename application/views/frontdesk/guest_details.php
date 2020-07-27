<?php $sum_amount = 0;  $the_amount = 0; $previous_balance = 0;?>
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">

          <!-- francis -->
        <?php if ($this->session->flashdata('success') == TRUE): ?>
          <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error') == TRUE): ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>
              <!-- end -->

 		   <div class="span5">
        <?php if($guest_details): ?>
	       <?php foreach($guest_details as $guest): ?>
	       <div style="margin-bottom: 20px;">
	       	<img src="<?= base_url('assets/img/thumbnails/'.$guest->photo) ?>" class="img-responsive" style=" right: 0; bottom: 0;" alt="">
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
         <br/>
         <a data-toggle="modal" data-id="<?= $guest->id ?>" href="#checkin_this_guest" class = "open-Guest-Checkin btn btn-default btn-xs"> <i class="icon-plus"></i> New Reservation </a>
          <a data-toggle="modal" data-id="<?= $guest->id ?>" href="#add_room" class = "open-add-room btn btn-warning btn-xs"> <i class="icon-plus"></i> Add Room </a>
          <a data-toggle="modal" data-id="<?= $guest->id ?>" href="#edit_guest_modal" class = "btn btn-success btn-xs"> <i class="icon-edit"></i> Edit User Details </a>
          <!-- francis -->
          <a data-toggle="modal" data-id="<?= $guest->id ?>" href="#ban_confirm_modal" class = "btn btn-danger btn-xs"> <i class="icon-edit"></i> Ban Guest </a>
          <!-- end -->

        <!-- Edit Guest Modal -->
          <div class="modal fade" id="edit_guest_modal" role="dialog">
              <div class="modal-dialog">

                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">×</button>
                              <h3>Edit Guest Details</h3>
                      </div>
                      <form action="<?=base_url('admin/edit_guest')?>" method="post" role="form" enctype="multipart/form-data">
                          <div class="modal-body">
                            <input type="hidden" class="form-control" id="edit_guest_id" name="edit_guest_id" value="<?= $guest->id
                             ?>">
                              <div class="col-lg-12 col-md-12">
                                  <div class="">
                                      <label for="fname">First Name</label>
                                      <input type="text" class="form-control" id="edit_fname" name="edit_fname" value="<?= $guest->firstname ?>">
                                  </div>
                                  <div class="">
                                      <label for="lname">Last Name</label>
                                      <input type="text" class="form-control" id="edit_lname" name="edit_lname" value="<?= $guest->lastname ?>">
                                  </div>
                                   <div class="">
                                      <label for="bday">Birthday</label>
                                      <input type="date" class="form-control" id="edit_birthday" name="edit_birthday" value="<?= $guest->birthday ?>">
                                  </div>
                                  <div class="">
                                      <label for="address">Address</label>
                                      <input type="text" class="form-control" id="edit_address" name="edit_address" value="<?= $guest->address ?>">
                                  </div>
                                  <div class="">
                                      <label for="contact">Contact Number</label>
                                      <input type="text" class="form-control" id="edit_contact" name="edit_contact" value="<?= $guest->contact_number ?>">
                                  </div>
                                  <div class="">
                                      <label for="note">Note</label>
                                      <textarea class="form-control" id="edit_note" name="edit_note" rows="5" ><?= $guest->note ?></textarea>
                                  </div>

                                  <div class="">
                                      <label for="photo">Photo</label>
                                      <input type="file" class="form-control" id="edit_photo" name="edit_photo" value="<?= $guest->photo ?>">
                                  </div>
                              </div>
                              <div class="modal-footer" >
                                  <button type="submit" class="btn btn-danger">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                          </div>

                      </form>
                  </div>
              </div>
          </div>
        <!-- End of Edit Guest  Modals -->

        <!-- ban Modal Francis-->
    <div class="modal fade" id="ban_confirm_modal" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                        <h3>Confirmation</h3>
                </div>
                <form action="<?=base_url('admin/banned_guest_detail')?>" method="post" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="room_name"><b>Are you sure you want to ban this guest?</b></label>
                    </div>
                        <input type="text" class="form-control hidden" id="ban_service_id" value="<?= $guest->id ?>" name="ban_service_id">
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-danger">Yes</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
            </form>
        </div>
    </div>
    </div>
    <!-- End -->



         <?php endforeach; ?>
       <?php endif; ?>

	      </div>
    <?php if($checkin_details): ?>
        <?php foreach($checkin_details as $checkin): ?>


         <?php endforeach; ?>
      <?php endif; ?>

      <div class="span12">
        <h4><span class="icon-list-alt"></span> Checkin History Details</h4>
        <?php if($checkin_details): ?>
          <a data-toggle="modal" href="#add_advance_payment<?= $checkin->service_id ?>" data-id="<?= $checkin->service_id ?>" class = "btn btn-primary btn-xs" > <i class="icon-plus"></i> Advance Payment</a>
          <!-- <a data-toggle="modal" href="#add_full_payment<?= $checkin->service_id ?>" data-id="<?= $checkin->service_id ?>" class = "btn btn-danger btn-xs" > <i class="icon-money"></i> Full Payment Method</a> -->
           <a data-toggle="modal" href="#view_full_invoice" class = "open-full-invoice btn btn-danger btn-xs"  data-id="<?= $this->uri->segment(3); ?>"> <i class="icon-money"></i> View Full Invoice</a>
          <a data-toggle="modal" id="btn_remove_advance_payment" href="#remove_balance_modal<?= $checkin->guest_id ?>" class="btn btn-danger btn-xs">Remove Balance</a>
          <a data-toggle="modal" href="#add_payment_guest<?= $this->uri->segment(3); ?>" class = "btn btn-info btn-xs" > <i class="icon-money"></i> Previous Balance Payment</a> </br></br>
         <!--  -->
        <?php else: ?>
          <a data-toggle="modal" href="#add_payment_guest<?= $this->uri->segment(3); ?>" class = "btn btn-info btn-xs" > <i class="icon-money"></i> Previous Balance Payment</a> </br></br>
        <?php endif; ?>

          <!-- Payment BY GUEST Modal -->
            <div class="modal fade" id="add_payment_guest<?= $this->uri->segment(3); ?>" role="dialog">
                <div class="modal-dialog">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                                <h3>Payment Details</h3>
                        </div>
                        <form action="<?=base_url('frontdesk/add_payment_guest')?>" method="post" role="form">
                            <div class="modal-body">

                            <div class="form-group">
                               <input type="hidden" class="form-control" id="checkin_guest_id" name="checkin_guest_id" value="<?= $this->uri->segment(3); ?>">
                            </div>
                                <div class="form-group">
                                   <?php $old_account = $this->Admin_model->_get_unpaid_old_account($this->uri->segment(3)); ?>
                                    <label for="guest_count">Remaining Balance</label>
                                  
                                    <input type="text" class="form-control" id="payment_amount_due" name="payment_amount_due" value="<?= $old_account->unpaid_balance ?>">
                                </div>
                                <div class="form-group">
                                    <label for="checkin_date">Payment Amount</label>
                                    <input type="text" class="form-control" id="payment_amount" name="payment_amount">
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Submit</button>
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
            <!-- End of  Payment BY GUEST Modals -->

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
                  <th> Action</th>
                </tr>
              </thead>
              <tbody>
                  <!-- UNPAID BALANCES -->
                <?php $old_account = $this->Admin_model->_get_unpaid_old_account($this->uri->segment(3));
                  if($old_account) : ?>
                  <tr>
                    <td>Old Account</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><span class="label label-danger">PREVIOUS BALANCE: </span><span class="label label-default">PHP <?= number_format($old_account->unpaid_balance, 2); ?></span></td>
                    <td></td>
                 </tr>
               <?php endif; ?>
                <!-- END OF UNPAID -->
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
                 $advance = $this->Admin_model->_get_advance_payment_by_guest_room($this->uri->segment(3), $checkin->room_id);
                 if($checkin->c_status < 2){ // FOR CHECKED IN OR CHECKOUT

                     if($checkin->checkout_date == "0000-00-00 00:00:00") { // OPEN TIME
                        $checkin_date =  new DateTime($checkin->checkin_date);
                        $checkout_date = new DateTime("now");
                        $interval = date_diff($checkin_date, $checkout_date);
                        if($interval->d > 1) {
                          $amount_due_payment = $interval->d * $checkin->total_amount;
                        } else {
                          $amount_due_payment = 1 * $checkin->total_amount;
                        }
                        //var_dump($amount_due_payment);exit;
                        $data = $this->Admin_model->_get_total_amount_due_payment($checkin->service_id);
                         if($data) {
                           $the_amount = $amount_due_payment - $data->payment_amount;
                        } else {
                           $amount_due_checkin = $this->Admin_model->_get_total_amount_due_checkin($checkin->service_id);
                           $the_amount = $amount_due_payment;
                        }

                     } else { // WITH CHECKOUT DATE 
                        $amount_due_payment = $this->Admin_model->_get_total_amount_due_payment($checkin->service_id);
                        $amount_due_checkin = $this->Admin_model->_get_total_amount_due_checkin($checkin->service_id);

                        if($amount_due_payment) { // single payment
                           $the_amount = $amount_due_payment->total_amount_due - $amount_due_payment->payment_amount;
                        } else { // full payment
                          $full_payment_checker = $this->Admin_model->_get_advance_checker($checkin->guest_id);
                          $full_payment_checkin = $this->Admin_model->_get_advance_checkin($checkin->service_id);
                          $data2 = $this->Admin_model->_get_total_amount_due_payment_by_guest($checkin->guest_id);
                          if($full_payment_checkin->advance_payment == 0){
                           // var_dump($amount_due_payment); exit;
                              $the_amount = $amount_due_checkin->total_amount -$data2->payment_amt ;
                          }else{
                            if($full_payment_checker) {
                              // may advance pa????
                              
                               $the_amount = $data2->total_due - $data2->payment_amt;
                            } else {
                              
                              $the_amount = $amount_due_checkin->total_amount ;
                            }
                         }


                        }
                     }
                     
                     if($advance->total_advance_payment >= $the_amount){
                        echo '<span class="label label-success"> PAID </span>';
                     }else{
                      if($the_amount == 0) { // paid
                        echo '<span class="label label-success"> PAID </span>';
                      }elseif ($the_amount != 0 && $checkin->c_status == 0) { // with advance and checkout
                        echo '<span class="label label-success"> PAID </span>';
                      } else {
                        // $the_amount = $the_amount-$advance->total_advance_payment;
                        echo '<span class="label label-danger"> UNPAID </span> &nbsp; <span class="label label-default"> PHP '.number_format($the_amount,2).'</span>';
                      }
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

                  $old_account = $this->Admin_model->_get_unpaid_old_account($this->uri->segment(3));
                  if($old_account) :
                    $previous_balance = $old_account->unpaid_balance;
                  endif;
                  $amt = $this->Admin_model->_get_total_amount_due_payment($checkin->service_id);
                  if($amt) {
                    if($amt->payment_amount <= $the_amount){
                        $sum_amount = $sum_amount + $the_amount + $previous_balance;
                      }else{
                        $sum_amount = $sum_amount + $the_amount + $total_charges + $previous_balance;
                      }
                  } else {
                    
                    $sum_amount = $sum_amount + $the_amount + $total_charges + $previous_balance;   
                  }
                 
                    
                
                ?>
                </td>
                 <td>
                  <?php if($checkin->c_status == 1){ ?> <!-- CHECKIN -->

                    <?php
                    if($checkin->c_status < 2){ // FOR CHECKED IN OR CHECKOUT

                        if($checkin->checkout_date == "0000-00-00 00:00:00") { // OPEN TIME

                           $checkin_date =  new DateTime($checkin->checkin_date);
                           $checkout_date = new DateTime("now");
                           $interval = date_diff($checkin_date, $checkout_date);
                           if($interval->d > 1) {
                              $amount_due_payment = $interval->d * $checkin->total_amount;
                            } else {
                              $amount_due_payment = 1 * $checkin->total_amount;
                            }
                           // var_dump($amount_due_payment); exit;
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
                   }
                   ?>
                    <a data-toggle="modal" data-id="<?= $guest->id ?>" href="#checkout_confirm<?= $checkin->service_id ?>" class = "btn btn-default btn-xs"> <i class="icon-reply"></i> Checkout </a>
                    <button data-id="<?= $checkin->service_id ?>" class="open-room-transfer btn btn-primary btn-xs" onclick="transfer_modal()"><i class="icon-home"></i> Tranfer Room</button>
                    <a data-toggle="modal" data-id="<?= $guest->id ?>" href="#other_charges<?= $checkin->service_id ?>" class = "btn btn-warning btn-xs"> <i class="icon-plus"></i> Charges </a>
                    <a data-toggle="modal" href="#add_payment<?= $checkin->service_id ?>" data-id="<?= $checkin->service_id ?>" class = "btn btn-danger btn-xs" > <i class="icon-money"></i> Payment</a>
                    <a data-toggle="modal" data-id="<?= $guest->id ?>" href="#cancel_reservation_modal<?= $checkin->service_id ?>" class = "btn btn-warning btn-xs"> <i class="icon-edit"></i> Cancel Reservation </a>
                   <a data-toggle="modal" data-id="<?= $guest->id ?>" href="#edit_reservation_modal<?= $checkin->service_id ?>" class = "btn btn-info btn-xs"> <i class="icon-edit"></i> Edit Reservation </a>
                   <a data-toggle="modal" href="#open_bill<?= $checkin->service_id ?>" data-id="<?= $checkin->guest_id ?>"  data-service="<?= $checkin->service_id ?>" data-payment="<?= $the_amount ?>" class = "open-bill btn btn-primary btn-xs" > <i class="icon-file"></i> View Bill </a>
                   <a data-toggle="modal" href="#cancel_checkin_modal<?= $checkin->service_id ?>" class = "btn btn-danger btn-xs"> <i class="icon-edit"></i> Cancel Checkin </a>
                 <?php } elseif($checkin->c_status == 2) { ?> <!-- RESERVED -->
                    <a data-toggle="modal" data-id="<?= $guest->id ?>" href="#checkin_confirm" class = "btn btn-success btn-xs"> <i class="icon-reply"></i> Checkin </a>
                    <a data-toggle="modal" data-id="<?= $guest->id ?>" href="#cancel_reservation_modal<?= $checkin->service_id ?>" class = "btn btn-warning btn-xs"> <i class="icon-edit"></i> Cancel Reservation </a>
                   <a data-toggle="modal" data-id="<?= $guest->id ?>" href="#edit_reservation_modal<?= $checkin->service_id ?>" class = "btn btn-info btn-xs"> <i class="icon-edit"></i> Edit Reservation </a>
                    <a data-toggle="modal" href="#add_payment<?= $checkin->service_id ?>" data-id="<?= $checkin->service_id ?>" class = "btn btn-danger btn-xs" > <i class="icon-money"></i> Payment</a>
                <?php } elseif($checkin->c_status == 0) { ?> <!-- CHECKOUT -->
                <?php } ?>
                  <?php $payment = $this->Admin_model->_get_recent_payment($checkin->service_id); ?>
                  <?php if($payment): ?>
                 <a data-toggle="modal" data-id="<?= $guest->id ?>" href="#edit_payment<?= $checkin->service_id ?>" class = "btn btn-default btn-xs"> <i class="icon-edit"></i> Edit Payment </a>
                  <?php endif; ?>
                 </td>
              </tr>


           <!-- CHECKIN Modal -->
           <div class="modal fade" id="checkin_confirm" role="dialog">
               <div class="modal-dialog modal-sm">
                   <div class="modal-content">
                       <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal">×</button>
                               <h3>Confirmation</h3>
                       </div>
                       <form action="<?=base_url('admin/checkin_confirm')?>" method="post" role="form">
                       <div class="modal-body">
                           <div class="form-group">
                               <label for="room_name"><b>Proceed to checkin this guest?</b></label>
                           </div>
                               <input type="hidden" class="form-control" id="service_id" value="<?=$checkin->service_id?>" name="service_id">
                       </div>
                       <div class="modal-footer">
                         <button type="submit" class="btn btn-danger">Checkin</button>
                         <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                   </div>
                   </form>
               </div>
             </div>
           </div>
           <!-- End of CHECKIN Modals -->


              <!-- ban Modal Francis-->
              <div class="modal fade" id="remove_balance_modal<?= $checkin->guest_id ?>" role="dialog">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h3>Confirmation</h3>
                    </div>
                    <form action="<?=base_url('frontdesk/update_advance_payment')?>" method="post" role="form">
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="room_name"><b>Are you sure you want to remove his/her balance?</b></label>
                        </div>
                        <input type="text" class="form-control hidden" id="balance_amount" name="balance_amount" value="<?= $sum_amount ?>">
                        <input type="text" class="form-control hidden" id="advance_guest_id" value=" <?= $checkin->service_id ?>" name="advance_guest_id">
                         <input type="text" class="form-control hidden" id="advance_guest_id" value=" <?= $checkin->guest_id ?>" name="advance_guest">
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <!-- End -->

              <!-- Invoice Modal -->
              <div class="modal fade" id="view_bill<?= $checkin->service_id ?>" role="dialog">
                  <div class="modal-dialog">

                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">×</button>
                                  <h3>Bill</h3>
                          </div>
                          <input type="hidden" class="form-control" id="bill_service_id" name="bill_service_id" value="<?= $checkin->service_id ?>">

                          <div class="modal-body" >
                             <img src="<?= base_url('assets/img/logo/logo.PNG') ?>" class="img-responsive" style=" right: 0; bottom: 0; width: 100%; height: 110px;" alt="">
                              <div id="bill_div"></div>
                          </div>
                          <div class="modal-footer">
                              <button class="button btn btn-primary btn-sm" onclick="print('bill_div', 'Bill');">
                                  <span class="icon-print"> Print</span></button>
                          </div>
                      </div>
                  </div>
              </div>

              <!-- End of Invoice Modals -->

              <!-- Transfer Modal -->
                <div class="modal fade" id="TransferModal" role="dialog">
                  <div class="modal-dialog">

                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h3>Room/s</h3>
                      </div>
                      <div class="modal-body">
                        <div class="col-lg-12 col-md-12 col-sm-12">

                          <div id="available">
                            <?php if($available_rooms): ?>
                              <?php foreach($available_rooms as $aroom): ?>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                  <div class="panel panel-danger">
                                    <div class="panel-heading">
                                      <span> ROOM <?= $aroom->room_name; ?></span></br>
                                      <a data-toggle="modal" href="#room_checkin<?= $aroom->room_id ?>" data-id="<?= $aroom->room_id ?>" class="open-room-checkin btn btn-xs btn-danger"><i class="icon-check"></i>Transfer</a>
                                    </div>
                                    <div class="panel-body">
                                      <!-- <input type="text" class="form-control" id="prev_room_id" name="prev_room_id" value="<?= $aroom->room_id ?>"> -->
                                      <div>
                                        <b> Type: </b> <?= $aroom->type; ?>
                                      </div>
                                      <div>
                                        <b> Floor: </b> <?= $aroom->floor; ?>
                                      </div>
                                      <div>
                                        <b> Rate: </b> PHP <?= number_format($aroom->rate,2,'.',','); ?>
                                      </div>

                                    </div>
                                  </div>
                                </div>
                              <?php endforeach; ?>
                            <?php else: ?>
                              <div class="alert alert-danger">No Available Rooms found.</div>
                            <?php endif; ?>
                          </div>

                        </div>
                        <div class="modal-footer" >
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End of Transfer Modals -->

          <!-- Checkout Modal -->
           <div class="modal fade" id="checkout_confirm<?=$checkin->service_id?>" role="dialog">
               <div class="modal-dialog modal-sm">
                   <div class="modal-content">
                       <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal">×</button>
                               <h3>Confirmation</h3>
                       </div>
                       <form action="<?=base_url('admin/checkout_confirm')?>" method="post" role="form">
                       <div class="modal-body">
                           <div class="form-group">
                               <label for="room_name"><b>Proceed to checkout?</b></label>
                           </div>
                               <input type="text" class="form-control hidden" id="service_id" value="<?=$checkin->service_id?>" name="service_id">
                       </div>
                       <div class="modal-footer">
                         <button type="submit" class="btn btn-danger">Checkout</button>
                         <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                   </div>
                   </form>
               </div>
           </div>
           </div>
           <!-- End of Checkout Modals -->

           <!-- Edit Reservation Modal -->
      <div class="modal fade" id="edit_reservation_modal<?=$checkin->service_id?>" role="dialog">
        <div class="modal-dialog">

          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">×</button>
              <h3>Edit Checkin Details</h3>
            </div>
            <form action="<?=base_url('admin/edit_reservation')?>" method="post" role="form">
              <div class="modal-body">

                <div class="form-group">
                  <input type="hidden" class="form-control" id="reserve_service_id" name="reserve_service_id" value="<?= $checkin->service_id?>">
                </div>
                <div class="form-group">
                  <label for="guest_count">Number of Guest/s</label>
                  <input type="text" class="form-control" id="edit_guest_count" name="edit_guest_count" value="<?= $checkin->guests?>">
                </div>


                <div class="form-group">
                  <label for="checkin_date">Checkin Date</label>
                  <input type="date" class="form-control" id="edit_guest_checkin_date" name="edit_checkin_date" value="<?= date('Y-m-d',strtotime($checkin->checkin_date));?>">
                </div>

                <div class="form-group">
                  <label for="checkout_date">Checkout Date</label> &nbsp;
                  <i>** Leave as blank for Open Time.</i>
                  <input type="date" class="form-control" id="edit_guest_checkout_date" name="edit_checkout_date" value="<?= date('Y-m-d',strtotime($checkin->checkout_date));?>">
                </div>
                <div class="form-group">
                  <label for="room_type">Available Rooms</label>
                  <select name="edit_this_guest_room" class="form-control" id="edit_this_guest_room">
                    <?php foreach($rooms as $room):  ?>
                      <option value="<?= $room->room_id ?>"> [<?= $room->type ?>] <?= $room->floor ?> ROOM #<?= $room->room_name ?> </option>
                    <?php endforeach?>
                  </select>
                </div>

                <div class="form-inline" style="margin-bottom: 20px;">
                  <label>Rate Per Day:</label>
                  <input type="radio" class="form-control" style="margin: 10px" name="edit_rate_per_day" value="180"> 180
                  <input type="radio" class="form-control" style="margin: 10px" name="edit_rate_per_day" value="200"> 200
                  <input type="radio" class="form-control" style="margin: 10px" name="edit_rate_per_day" value="220"> 220
                  <input type="radio" class="form-control" style="margin: 10px" name="edit_rate_per_day" value="240"> 240 </br>

                  <label>Or Enter Amount: </label>
                  <input type="text" style=" width: 130px" id="edit_other_amount" class="form-control" placeholder="Other Amount" name="edit_other_amount">
                </div>

                <div class="">
                  <label for="note">Note</label>
                  <textarea class="form-control" id="edit_checkin_note" name="edit_checkin_note" rows="5" ><?= $checkin->note ?></textarea>
                </div>

                <div class="modal-footer">
                  <button type="submit" class="btn btn-danger">Reserve</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>

            </form>
          </div>

        </div>
      </div>
      <!-- End Modals -->

      <!-- Cancel Reservation Modal -->
      <div class="modal fade" id="cancel_reservation_modal<?=$checkin->service_id?>" role="dialog">
          <div class="modal-dialog modal-sm">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                          <h3>Confirmation</h3>
                  </div>
                  <form action="<?=base_url('admin/cancel_reservation')?>" method="post" role="form">
                  <div class="modal-body">
                      <div class="form-group">
                          <label for="room_name"><b>Are you sure you want to cancel this?</b></label>
                      </div>
                          <input type="text" class="form-control hidden" id="cancel_service_id" value="<?=$checkin->service_id?>" name="cancel_service_id">
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
              </div>
              </form>
          </div>
      </div>
      </div>
      <!-- End of Modals -->

            <!-- Cancel Reservation Modal -->
      <div class="modal fade" id="cancel_checkin_modal<?=$checkin->service_id?>" role="dialog">
          <div class="modal-dialog modal-sm">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                          <h3>Confirmation</h3>
                  </div>
                  <form action="<?=base_url('admin/delete_checkin_and_payment')?>" method="post" role="form">
                  <div class="modal-body">
                      <div class="form-group">
                          <label for=""><b>Are you sure you want to cancel this?</b></label>
                      </div>
                          <input type="text" class="form-control hidden" id="cancel_service_id" value="<?=$checkin->service_id?>" name="cancel_service_id">
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
              </div>
              </form>
          </div>
      </div>
      </div>
      <!-- End of Modals -->

           <!-- Payment Modal -->
            <div class="modal fade" id="add_payment<?= $checkin->service_id ?>" role="dialog">
                <div class="modal-dialog">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                                <h3>Payment Details</h3>
                        </div>
                        <form action="<?=base_url('frontdesk/add_payment')?>" method="post" role="form">
                            <div class="modal-body">

                            <div class="form-group">
                               <input type="hidden" class="form-control" id="checkin_guest_id" name="checkin_guest_id" value="<?= $checkin->guest_id ?>">
                               <input type="hidden" class="form-control" id="checkin_service_id" name="checkin_service_id" value="<?= $checkin->service_id ?>">
                            </div>
                                <div class="form-group">

                                    <label for="guest_count">Remaining Balance</label>
                                    <?php
                                      $amount_due_payment = $this->Admin_model->_get_total_amount_due_payment($checkin->service_id);
                                      $amount = "";
                                      if($amount_due_payment) {
                                         $amount = $amount_due_payment->total_amount_due - $amount_due_payment->payment_amount;
                                      } else {
                                         $amount_due_checkin = $this->Admin_model->_get_total_amount_due_checkin($checkin->service_id);
                                         $amount = $amount_due_checkin->total_amount;
                                      }

                                       $charges = $this->Admin_model->_get_sum_charges($checkin->service_id);
                                      // var_dump($charges); exit;
                                       $total = 0;
                                      if ($charges) {
                                           $total = $amount + $charges->sum_charges;
                                        } else {
                                          $total = $amount;
                                        }
                                    ?>
                                    <input type="hidden" class="form-control" id="other_charges_txt" name="other_charges_txt" value="<?= $charges->sum_charges ?>">
                                    <input type="text" class="form-control" id="payment_amount_due" name="payment_amount_due" value="<?= $total ?>">
                                </div>
                                <div class="form-group">
                                    <label for="checkin_date">Payment Amount</label>
                                    <input type="text" class="form-control" id="payment_amount" name="payment_amount">
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Submit</button>
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
            <!-- End of  Payment  Modals -->

            

             <!-- Payment Modal -->
            <div class="modal fade" id="edit_payment<?= $checkin->service_id ?>" role="dialog">
                <div class="modal-dialog">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                                <h3>Edit Payment Details</h3>
                        </div>
                        <form action="<?=base_url('frontdesk/edit_recent_payment')?>" method="post" role="form">
                            <div class="modal-body">
                              <?php $amount_due_payment = $this->Admin_model->_get_recent_payment($checkin->service_id); ?>
                            <div class="form-group">
                               <input type="hidden" class="form-control" id="payment_id" name="payment_id" value="<?= $amount_due_payment->payment_id ?>">
                            </div>
                                <div class="form-group">
                                    <label for="guest_count">Recent Payment Amount</label>
                                    <input type="text" class="form-control" id="payment_amount_due" name="payment_amount_due" value="<?= $amount_due_payment->payment_amount ?>">
                                </div>
                                <div class="form-group">
                                    <label for="checkin_date">New Payment Amount</label>
                                    <input type="text" class="form-control" id="payment_amount" name="payment_amount">
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Submit</button>
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
            <!-- End of  Payment  Modals -->


             <!-- Other Charges Modal -->
            <div class="modal fade" id="other_charges<?= $checkin->service_id ?>" role="dialog">
                <div class="modal-dialog">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                                <h3>Other Charges Details</h3>
                        </div>
                        <form action="<?=base_url('frontdesk/add_charges')?>" method="post" role="form">
                            <div class="modal-body">

                            <div class="form-group">
                               <input type="hidden" class="form-control" id="service_id2" name="service_id2" value="<?= $checkin->service_id ?>">
                               <input type="hidden" class="form-control" id="guest_id2" name="guest_id2" value="<?= $this->uri->segment(3) ?>">
                            </div>
                               <div class="form-group">
                                    <label for="checkin_date">Description</label>
                                    <input type="text" class="form-control" id="desc" name="desc">
                                </div>
                                <div class="form-group">
                                    <label for="checkin_date">Amount</label>
                                    <input type="text" class="form-control" id="amt" name="amt">
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Submit</button>
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
            <!-- End of  Other Charges  Modals -->

            <!-- FULL Payment Modal -->
            <div class="modal fade" id="add_full_payment<?= $checkin->service_id ?>" role="dialog">
                <div class="modal-dialog">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                                <h3>Payment Details</h3>
                        </div>
                        <form action="<?=base_url('frontdesk/add_full_payment')?>" method="post" role="form">
                            <div class="modal-body">

                            <div class="form-group">
                                <input type="hidden" class="form-control" id="checkin_service_id" name="checkin_service_id" value="<?= $checkin->service_id ?>">
                               <input type="hidden" class="form-control" id="checkin_guest_id" name="checkin_guest_id" value="<?= $checkin->guest_id ?>">
                            </div>
                                <div class="form-group">

                                    <label for="guest_count">Remaining Balance</label>
                                    <input type="text" class="form-control" id="payment_amount_due" name="payment_amount_due" value="<?= $sum_amount ?>">
                                </div>
                                <div class="form-group hidden">
                                    <label for="checkin_date">Payment Amount</label>
                                    <input type="hidden" class="form-control" id="payment_amount" name="payment_amount">
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Submit</button>
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
            <!-- End of FULL Payment  Modals -->



             <!-- ADVANCE Payment Modal -->
            <div class="modal fade" id="add_advance_payment<?= $checkin->service_id ?>" role="dialog">
                <div class="modal-dialog">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                                <h3>Advance Payment Details</h3>
                        </div>
                        <form action="<?=base_url('frontdesk/add_advance_payment')?>" method="post" role="form">
                            <div class="modal-body">

                                <div class="form-group">
                                  <input type="hidden" class="form-control" id="payment_amount_due" name="payment_amount_due" value="<?= $sum_amount ?>">
                                     <input type="hidden" class="form-control" id="checkin_service_id" name="checkin_service_id" value="<?= $checkin->service_id ?>">
                                   <input type="hidden" class="form-control" id="checkin_guest_id" name="checkin_guest_id" value="<?= $checkin->guest_id ?>">
                                </div>
                                <div class="form-group">
                                    <label for="checkin_date">Payment Amount</label>
                                    <input type="text" class="form-control" id="payment_amount" name="payment_amount">
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Submit</button>
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        <!-- End of ADVANCE Payment  Modals -->


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
                  <th> Change</th>
                  <th> Payment Date</th>
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
                      <td><?php
                        if($payment->payment_amount > $payment->total_amount_due ) {
                          $result = $payment->payment_amount - $payment->total_amount_due;
                          echo $result;
                        } else {
                          echo "0";
                        }
                       ?></td>
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
              $room_with_advance = $this->Admin_model->_get_advance_payment_room_id($this->uri->segment(3));
              if($sum_amount) {
                $advance = $this->Admin_model->_get_advance_payment_by_guest_room($this->uri->segment(3), $room_with_advance->room_id);

                if($sum_amount > $advance->total_advance_payment) {
                  $text = "<b>Total Balance: </b>";
                  if($advance->total_advance_payment < 0) {
                    // negative value - once balance is removed
                    $total = $sum_amount;
                  } else {
                    $total = $sum_amount - $advance->total_advance_payment;
                  }
                  $status = '<span class="label label-danger"> UNPAID </span>';
                } elseif($sum_amount == $advance->total_advance_payment){
                  $text = "<b>Total: </b>";
                  $total = $advance->total_advance_payment - $sum_amount;
                  $status = '<span class="label label-success"> PAID </span>';
                }
                else {
                  $text = "<b>Change: </b>";
                  $total = $advance->total_advance_payment - $sum_amount;
                  $status = '<span class="label label-success"> PAID </span>';
                }

                /*$balance = $total->total_due - $data->sum_payment;*/
                // 
                if($sum_amount != $advance->total_advance_payment){

                  echo '<h5>Remaining Balance: <b>'.number_format($sum_amount,2).'</b></h5>';
                  if($advance->total_advance_payment < 0) {
                    // negative value - set to zero
                    echo '<h5> Advance Payment: <b>'.number_format(0,2).'</b></h5>';  
                  } else {
                    echo '<h5> Advance Payment: <b>'.number_format($advance->total_advance_payment,2).'</b></h5>';
                  }
                  
                  echo '<h4 style="color: maroon; padding-top: 5px;">'.$text.number_format($total,2).'</b> ' . $status . '</h4></br>';
                }else{
                  $sum_amount=0;
                  echo '<h5>Remaining Balance: <b>'.number_format($sum_amount,2).'</b></h5>';
                  echo '<h5> Advance Payment: <b>'.number_format($sum_amount,2).'</b></h5>';
                  echo '<h4 style="color: maroon; padding-top: 5px;">'. $status . '</h4></br>';
                }


              }
              if($sum_amount == 0){?>
                    <script type='text/javascript'>
                           document.getElementById("btn_remove_advance_payment").style.visibility = "hidden";
                     </script>
            <?php  }else{ ?>
              <script type='text/javascript'>
                     document.getElementById("btn_remove_advance_payment").style.visibility = "visible";
               </script>
          <?php  } ?>

          </div>


	      </div>

		</div>
	  </div>
	</div>
  </div>
</div>


<?php if($available_rooms): ?>
    <?php foreach($available_rooms as $aroom): ?>
      <!-- Checkin Modal -->
      <div class="modal fade" id="room_checkin<?= $aroom->room_id ?>" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">×</button>
              <h3>Checkin Details</h3>
            </div>

            <div class="modal-body">
              <form action="<?=base_url('admin/transfer_guest')?>" method="post" role="form">
                <input type="hidden" class="form-control" id="room_id" name="room_id" value="<?= $aroom->room_id ?>">
                <input type="hidden" class="form-control" id="room_rate" name="room_rate" value="<?= $aroom->rate ?>">
                <input type="hidden" class="form-control" id="guest_id" name="guest_id" value="<?= $this->uri->segment(3) ?>">
                <input type="text" class="form-control" id="prev_service_id" name="prev_service_id" value="">
              </hr>

              <div class="form-group">
                <label for="guest_count">Number of Guest/s</label>
                <input type="text" class="form-control" id="guest_count" name="guest_count" required>
              </div>
              <div class="form-group">
                <label for="checkout_date">Checkout Date</label>
                <input type="date" class="form-control" id="checkout_date" name="checkout_date" required>
              </div>

              <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </form>

        </div>

      </form>
    </div>
  </div>
<?php endforeach; ?>

<?php endif; ?>
<!-- End of Checkin Modals -->

       <!-- FULL PAYMENT - Invoice Modal -->
            <div class="modal fade" id="view_full_invoice" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                                <h3>Full Invoice</h3>
                        </div>
                        <input type="hidden" class="form-control" id="invoice_guest_id" name="invoice_guest_id" value="<?= $this->uri->segment(3); ?>">
<!--                         <input type="hidden" class="form-control" id="this_group_id<?= $payment->service_id ?>" name="group_id" value="<?= $payment->group_guest_id ?>">
                        <input type="hidden" class="form-control" id="this_payment_id<?= $payment->payment_id ?>" name="payment_id" value="<?= $payment->payment_id ?>"> -->
                        <div class="modal-body" >
                           <img src="<?= base_url('assets/img/logo/logo.PNG') ?>" class="img-responsive" style=" right: 0; bottom: 0; width: 100%; height: 110px;" alt="">
                            <div id="full_invoice_div"></div>
                        </div>
                        <div class="modal-footer">
                            <button class="button btn btn-primary btn-sm" onclick="print('invoice_div', 'Invoice');">
                                <span class="icon-print"> Print</span></button>
                        </div>
                    </div>
                </div>
            </div>
          <!-- FULL PAYMENT - End of Invoice Modals -->

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
/* TRANSFER ROOM */
// get prev room id //
$(document).on("click", ".open-room-transfer", function () {
     var pID = $(this).data('id');
     $(".modal-body #prev_service_id").val( pID );

});

function transfer_modal() {
  $('#TransferModal').modal('show');

}

/* END OF TRANSFER ROOM*/

// INVOICE AJAX
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
  var url = base_url + "frontdesk/view_invoice/"+sID+"/"+this_group_id+"/"+this_payment_id;
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
              '<div style="text-align: right;"><h4>Total Payment: <b>'+new Intl.NumberFormat().format(value.payment_amount)+'</b></h4></div>'+
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
                '<div style="text-align: right;"><h4>Total Amount Due:<b> '+new Intl.NumberFormat().format(value.total_amount_due)+'/b></h4></div>'+
                '<div style="text-align: right;"><h4>Total Payment:<b>< '+new Intl.NumberFormat().format(value.payment_amount)+'/b></h4></div>'+
                '<div style="text-align: right;"><h4>Balance:<b> '+new Intl.NumberFormat().format(change)+'/b></h4></div>'
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



// FULL INVOICE AJAX
var base_url =  '<?php echo base_url() ?>';
$(document).on("click", ".open-full-invoice", function () {
var sID = $(this).data('id');
var modal_val = "#view_full_invoice";
var this_guest_id = document.getElementById("invoice_guest_id").value;
console.log(this_guest_id);
 $(modal_val).modal('show');
 $(".modal-body #invoice_service_id").val( sID );
  var url = base_url + "frontdesk/view_full_invoice/"+this_guest_id;
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
      if(data.checkin_data && data.payment_data){
       //console.log(data.checkin_data);
        $.each(data.checkin_data, function (key, value) {
          $('.modal-body #full_invoice_div').append(
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
            var change = eval(value.total_due) - eval(value.total_payment);
            console.log("HERE");
            $('.modal-body #full_invoice_div').append(
             '</tbody>'+
              '</table></div>'+
              '<div style="text-align: right;"><h4>Total Amount Due: <b>'+new Intl.NumberFormat().format(value.total_due)+'</b></h4></div>'+
              '<div style="text-align: right;"><h4>Total Payment: <b>'+new Intl.NumberFormat().format(value.total_payment)+'</b></h4></div>'+
              '<div style="text-align: right;"><h4>Balance: <b>'+new Intl.NumberFormat().format(change)+'</b></h4></div>'
            );

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


<!-- AVAILABLE ROOMS -->
<script type="text/javascript">

$(document).on("change", "#the_checkout_date", function () {
  checkout = document.getElementById('the_checkout_date').value;
  checkin = document.getElementById('the_checkin_date').value;
  available_rooms(checkin, checkout);
});

$(document).on("change", "#this_guest_room_type", function () {
  checkout = document.getElementById('this_guest_checkout_date').value;
  checkin = document.getElementById('this_guest_checkin_date').value;
  room_type = document.getElementById('this_guest_room_type').value;
  console.log(room_type);
  available_rooms(checkin, checkout, room_type);
});

$(document).on("change", "#room_guest_checkout_date", function () {
  checkout = document.getElementById('room_guest_checkout_date').value;
  checkin = document.getElementById('room_guest_checkin_date').value;
  available_rooms(checkin, checkout);
});


// PASS GUEST ID TO MODAL ON "CHECKIN THIS GUEST" BUTTON CLICK
$(document).on("click", ".open-Guest-Checkin", function () {
     var gID = $(this).data('id');
     $(".modal-body #this_guest_id").val( gID );
});

// PASS SERVICE ID TO MODAL ON "AD" BUTTON CLICK
$(document).on("click", ".open-add-room", function () {
     var gID = $(this).data('id');
     $(".modal-body #room_service_id").val( gID );
});



function edit_available_rooms(xID){
//xid = document.getElementById('edit_service_id').value;
console.log(xID);
var edit_rooms = "#the_edit_rooms" +xID;
var edit_checkout_date = "edit_checkout_date" +xID;
var edit_checkin_date = "edit_checkin_date" +xID;
 checkout = document.getElementById(edit_checkout_date).value;
 checkin = document.getElementById(edit_checkin_date).value;


 var url = base_url + "frontdesk/view_available_rooms/"+checkin+"/"+checkout;
  var data = $(this).serialize();
  $.ajax({
    url: url,
    type: "GET",
    dataType: "JSON",
    data: data,
    cache: false,
    processData: false,
    success: function (data) {
     $(edit_rooms).empty();
      if(data.room_data){
        /*$('#the_rooms').append(
            '<option value="'+ value.room_id +'"> '+ value.room_name +' - ['+ value.type +']</option>'
        );*/
        $.each(data.room_data, function (key, value) {
          $(edit_rooms).append(
            '<option value="'+ value.room_id +'"> '+ value.room_name +' - ['+ value.type +']</option>'
          );
        });

        } else {
            console.log("No Data");
        }

    },
    error: function (jqXHR, textStatus, errorThrown) {
      // For debugging
      console.log('The following error occurred: ' + textStatus, errorThrown);
    }
  });
}

function available_rooms($checkin, $checkout, $room_type){
 var url = base_url + "frontdesk/view_available_rooms/"+checkin+"/"+checkout+"/"+room_type;
  var data = $(this).serialize();
  $.ajax({
    url: url,
    type: "GET",
    dataType: "JSON",
    data: data,
    cache: false,
    processData: false,
    success: function (data) {
     $('#the_rooms').empty();
     $('#this_guest_room').empty();
     $('#add_guest_room').empty();
      if(data.room_data){
        $.each(data.room_data, function (key, value) {
          $('#the_rooms').append(
            '<option value="'+ value.room_id +'"> ['+ value.type +'] '+ value.floor +' ROOM # '+ value.room_name +'</option>'
          );
          $('#this_guest_room').append(
             '<option value="'+ value.room_id +'"> ['+ value.type +'] '+ value.floor +' ROOM # '+ value.room_name +'</option>'
          );
          $('#add_guest_room').append(
             '<option value="'+ value.room_id +'"> ['+ value.type +']4 '+ value.floor +' ROOM # '+ value.room_name +'</option>'
          );
        });

        } else {
            console.log("No Data");
        }

    },
    error: function (jqXHR, textStatus, errorThrown) {
      // For debugging
      console.log('The following error occurred: ' + textStatus, errorThrown);
    }
  });
}


$(document).on("click", ".open-bill", function () {
var guest_id = $(this).data('id');
var sID = $(this).data('service');
var total = $(this).data('payment');
var modal_val = "#view_bill" + sID;

console.log(sID);
console.log(guest_id);
 $(modal_val).modal('show');
 $(".modal-body #bill_service_id").val( sID );
  var url = base_url + "frontdesk/view_bill/"+sID+"/"+guest_id;
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
     $('.modal-body #bill_div').empty();

        $.each(data.checkin_data, function (key, value) {
          $('.modal-body #bill_div').append(
            '<div style="border-top: 1px #808080 dashed; margin: 5px; padding-top: 10px; ">'+
            '<div style="width: 50%;float: left;"><b> Service #: </b> '+ value.service_id +'</br>'+
            '<b> Guest Name: </b> '+ value.firstname +' '+ value.lastname +'</br>'+
            '<b> Address: </b> '+ value.address +'</br>'+
            '</div> </br></br>'+
             '<div style="width: 100%;"><table id="bill_table_rooms" style="max-width: 100%; width: 100%; margin: 10px; padding-top: 20px; font-size: 10px;">'+
            '<thead>'+
            '<tr style="text-align: center;"><th style=" padding: 4px; text-align: center ;border-bottom: 2px solid #333333 ;">Date</th>'+
            '<th style=" padding: 4px; text-align: center ;border-bottom: 2px solid #333333 ;">Description</th>'+
            '<th style=" padding: 4px; text-align: center ;border-bottom: 2px solid #333333 ;">Rate</th>'+
            '</thead>'+
            '<tbody>'
          );
        });

        $.each(data.rooms_data, function (key, value) {
          var date1 = new Date(value.checkin_date);
          var date2 = new Date(value.checkout_date);
          var timeDiff = Math.abs(date2.getTime() - date1.getTime());
          var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
          var total_rate = diffDays * value.rate_per_day;
                 // console.log(total_rate);

          $('.modal-body #bill_div #bill_table_rooms').append(
            '<tr style="max-width: 100%; width: 100%; margin: 10px; padding-top: 20px; font-size: 10px;"><td style=" padding: 4px; text-align: center ;border-bottom: 1px dotted #999999 ;">'+ value.checkin_date +' -' +value.checkout_date+ '</td>'+
            '<td style=" padding: 4px; text-align: center ;border-bottom: 1px dotted #999999 ;">'+ value.type +' - '+ value.room_name +'</td>'+
            '<td style=" padding: 4px; text-align: center ;border-bottom: 1px dotted #999999 ;">'+new Intl.NumberFormat().format(total_rate)+'</td>'+
            '</tr>'
          );

        });

            $('.modal-body #bill_div').append(
             '</tbody>'+
              '</table></div>'+
              '<div style="text-align: right;"><h4>Total Amount Due: <b>'+new Intl.NumberFormat().format(total)+'</b></h4></div>'
            );



    },
    error: function (jqXHR, textStatus, errorThrown) {
      // For debugging
      console.log('The following error occurred: ' + textStatus, errorThrown);
    }
  });
});
</script>

</body>
</html>
