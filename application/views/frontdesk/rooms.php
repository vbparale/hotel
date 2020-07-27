<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="" style="padding: 30px;">
          <div class="col-lg-12 col-md-12">
            <!-- <a role="button" data-toggle="modal" href="#add_rooms" class="btn btn-sm btn-primary"><i class="btn-icon-only icon-plus"></i>Add Room</a> -->
          <br><br>
              <?php if ($this->session->flashdata('success') == TRUE): ?>
                <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
              <?php endif; ?>

              <?php if ($this->session->flashdata('error') == TRUE): ?>
                  <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
              <?php endif; ?>
             
                <div class="col-lg-3 col-md-3">
                    <label for="checkin_date">Checkin Date</label>
                    <input type="date" class="form-control" id="this_checkin" name="checkin_date" required> 
                </div>
                <div class="col-lg-3 col-md-3">
                    <label for="checkout_date">Checkout Date</label>
                    <input type="date" class="form-control" id="this_checkout" name="checkout_date" required>
                </div>
                <div class="col-lg-3 col-md-3" style="margin-top: 25px; margin-bottom: 20px;">
                  <select name="room_type" class="form-control" id="this_room_type">
                    <option value="0"> </option>
                      <?php foreach($room_types as $type): ?>
                          <option value="<?= $type->id ?>"> <?= $type->type ?></option>
                      <?php endforeach?>
                  </select>
                </div>

                 <div class="col-lg-3 col-md-3" style="margin-top: 25px; margin-bottom: 20px;">
                  <button id="view_room_btn" type="submit" class="btn btn-danger"> View Available Room</button>
                </div>

              <ul class="nav nav-tabs">
                <li id="occ_tab" class="active"><a data-toggle="tab" href="#occupied">Occupied Rooms</a></li>
                <li id="ava_tab"><a data-toggle="tab" href="#available">Available Rooms</a></li>
              </ul>

              <div class="tab-content">
                <div id="occupied" class="tab-pane fade in active">
                  <?php if($occupied_rooms):  ?>
                  <?php foreach($occupied_rooms as $room): ?>
                    <div class="col-lg-3 col-md-3">
                     <div class="panel panel-info">
                        <div class="panel-heading">
                          <span style="text-transform: uppercase;"> <?= $room->firstname; ?> <?=$room->lastname;?></span>
                          <a data-toggle="modal" data-id="<?= $room->service_id ?>" href="#checkout_confirm<?= $room->service_id ?>" class="open-checkout btn btn-primary btn-xs pull-right"><i class="icon-reply"></i> Checkout</a>
                        </div>
                        <div class="panel-body">
                          <div>
                            <b> Checkin: </b> <?php $date = new DateTime($room->checkin_date); echo date_format($date, 'M d, Y H:i A'); ?>
                          </div>
                          <div>
                            <b> Checkout: </b> <?php $date = new DateTime($room->checkout_date); echo date_format($date, 'M d, Y H:i A'); ?>
                          </div>
                          <div>
                            <b> Contact Number: </b> <?= $room->contact_number; ?>
                          </div>
                          <div class="panel-bottom">
                            ROOM <i class="icon-arrow-down"></i>
                          </div>
                          <div style="text-align: center; padding: 5px;">
                            <span class="badge"><?= $room->room_name ?> - <?= $room->type ?></span>                        
                          </div>

                        </div>
                      </div>
                    </div>

                     <!-- Checkout User Modal -->
                    <div class="modal fade" id="checkout_confirm<?= $room->service_id ?>" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <form action="<?=base_url('frontdesk/checkout')?>" method="post" role="form">
                              <div class="modal-body">
                                  <input type="hidden" class="form-control" id="service_id" name="service_id" value="<?= $room->service_id ?>">
                                   <div class="col-lg-6 col-md-6">  
                                     <div style="border-bottom: 1px #808080 dashed; margin: 15px;">
                                      <b> Guest Name: </b> <?= $room->firstname; ?> <?= $room->lastname; ?></br>
                                      <b> Room: </b> <?= $room->room_name; ?></br>
                                      <b> Type: </b> <?= $room->type; ?></br>
                                      <b> No. of Guest/s: </b> <?= $room->guests; ?></br>
                                    </div>
                                    <div class="">
                                        <label for="checkin_date">Checkin Date:</label>
                                        <input type="datedeparts" class="form-control" id="checkin_date" name="checkin_date" value="<?= date('m/d/Y', strtotime($room->checkin_date));?>">
                                    </div>
                                    <div class="">
                                        <label for="rate">Rate/Day:</label>
                                        <input type="text" class="form-control" id="rate" name="rate" value="<?= $room->rate?>">
                                    </div>
                                    <div class="">
                                        <label for="checkout_date">Checkout Date:</label>
                                        <input type="datedepart" class="form-control" id="checkout_date" name="checkout_date" value="<?= date('m/d/Y', strtotime($room->checkout_date));?>">
                                    </div>
                                  </div>
                                  <div class="col-lg-6 col-md-6">
                                    <?php
                                      $rate = $room->rate;
                                      $checkin = new DateTime($room->checkin_date);
                                      $checkout = new DateTime($room->checkout_date);
                                      $date_diff = date_diff($checkin, $checkout);
                                      $total_amount = $rate * $date_diff->d;

                                   ?>
                                    <div class="">
                                        <label for="total_amount">Total Charges:</label>
                                        <input type="text" class="form-control" id="total_amount<?= $room->service_id ?>" name="total_amount" value="<?= $total_amount ?>" readonly>
                                    </div>
                                    <div class="">
                                        <label for="other_charges">Other Charges:</label>
                                        <input type="text" class="form-control" id="other_charges<?= $room->service_id ?>" name="other_charges">
                                    </div>
                                    <div class="">
                                        <label for="sub_total">Subtotal:</label>
                                        <input type="text" class="form-control" id="sub_total<?= $room->service_id ?>" name="sub_total" readonly>
                                    </div>
                                   <!--  <div class="">
                                        <label for="discount">Discount:</label>
                                        <input type="text" class="form-control" id="discount" placeholder="0.00" name="discount">
                                    </div> -->
                                     <div class="" style="border-top: 1px dashed #808080; margin-top: 20px;">
                                        <label for="amount_paid">Amount Paid:</label>
                                        <input type="text" class="form-control" id="amount_paid<?= $room->service_id ?>" name="amount_paid">
                                    </div>
                                    <div class="">
                                        <label for="change">Change:</label>
                                        <input type="text" class="form-control" id="change" name="change">
                                    </div>
                                  </div>
                                  
                                  <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger" style="margin-top: 20px;">Continue Checkout</button>
                                    <button type="button" class="btn btn-default" style="margin-top: 20px;" data-dismiss="modal">Close</button>
                                  </div>
                            </div>
                          </form>
                         
                        </div>

                      </div>
                    </div> 
                    <!-- END OF MODAL -->


                  <?php endforeach; ?>

                  <?php else: ?>
                    <div class="alert alert-danger">No Occupied Rooms found.</div>
                  <?php endif; ?>
                </div>



                <div id="available" class="tab-pane fade">
                  <?php if($available_rooms): ?>
                  <?php foreach($available_rooms as $aroom): ?>
                     <div class="col-lg-3 col-md-3">
                       <div class="panel panel-danger">
                          <div class="panel-heading">
                            <span> ROOM <?= $aroom->room_name; ?></span>
                            <!-- <a data-toggle="modal" href="#edit_room<?= $aroom->room_id ?>" class="btn btn-xs btn-success pull-right"><i class="icon-edit"></i> Edit</a>&nbsp; -->
                            <!-- <a data-toggle="modal" href="#room_checkin<?= $aroom->room_id ?>" class="open-room-checkin btn btn-xs btn-danger pull-right"><i class="icon-check"></i> Checkin</a> -->
                          </div>
                          <div class="panel-body">
                            <div>
                              <b> Type: </b> <?= $aroom->type; ?>
                            </div>
                            <div>
                              <b> Floor: </b> <?= $aroom->floor; ?>
                            </div>
                            <div>
                              <b> Rate: </b> PHP <?= number_format($aroom->rate,2,'.',','); ?>
                            </div>
                            <div>
                              <b> Max Capacity: </b> <?= $aroom->max_capacity ?>
                            </div>
                          </div>
                        </div>
                      </div>

                 

                  <?php endforeach; ?>

                  <?php else: ?>
                    <div class="alert alert-danger">No Available Rooms found.</div>
                  <?php endif; ?>
                </div>

                  <?php if($available_rooms): ?>
                  <?php foreach($available_rooms as $aroom): ?>
                      <!-- Checkin Modal -->
                  <!-- <div class="modal fade" id="room_checkin<?= $aroom->room_id ?>" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">×</button>
                                      <h3>Checkin Details</h3>
                              </div>
                            
                                <div class="modal-body">
                                    <input type="hidden" class="form-control" id="room_id" name="room_id" value="<?= $aroom->room_id ?>">
                                    <div class="form-group">
                                        <label for="fname">First Name</label>
                                        <input type="text" class="form-control" id="fname" name="fname" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="lname">Last Name</label>
                                        <input type="text" class="form-control" id="lname" name="lname" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" id="address" name="address">
                                    </div>
                                    <div class="form-group">
                                        <label for="contact">Contact Number</label>
                                        <input type="text" class="form-control" id="contact" name="contact" required>
                                    </div>
                                    
                                    </hr>
                            
                                    <div class="form-group">
                                        <label for="guest_count">Number of Guest/s</label>
                                        <input type="text" class="form-control" id="guest_count" name="guest_count" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="checkin_date">Checkin Date</label>
                                        <input type="date" class="form-control" id="checkin_date" name="checkin_date" required> 
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
                                      
                              </div>
                                 
                            </form>
                        </div>
                    </div> -->
                  <!-- End of Checkin Modals -->

                  <?php endforeach; ?>

                  <?php endif; ?>

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

<script type="text/javascript">
/*$("#ava_tab").hide();*/
/*$("#view_room_btn").click(function () {
  
});
*/

var base_url =  '<?php echo base_url() ?>';
$(document).on("click", "#view_room_btn", function () {
  var checkin =  document.getElementById("this_checkin").value;
  var checkout = document.getElementById("this_checkout").value;
  var room_type = document.getElementById("this_room_type").value;
  $("#occupied").removeClass('in active');
  $("#occ_tab").removeClass('active');
 //$("#occ_tab").hide();
  //$("#ava_tab").show();
  $("#ava_tab").addClass('active');
  $("#available").addClass('in active');

  $('#available').empty();
  if(checkin == '' && checkout == '') {
    checkin = "0";
    checkout = "0";
  }
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
     $('#available').empty();
      if(data.room_data){
        $('available').append(
        '<div style="text-align: center; padding-top: 30px;">LOGO HERE</div>'
        );
        $.each(data.room_data, function (key, value) {
          $('#available').append(
            '<div class="col-lg-3 col-md-3">'+
               '<div class="panel panel-danger">'+
                  '<div class="panel-heading">'+
                    '<span> ROOM '+ value.room_name +'</span>'+
                 /*  '<a data-toggle="modal" href="#edit_room'+value.room_id+'" class="btn btn-xs btn-success pull-right"><i class="icon-edit"></i> Edit</a>'+
                  '<a data-toggle="modal" href="#room_checkin'+value.room_id+'" class="open-room-checkin btn btn-xs btn-danger pull-right"><i class="icon-check"></i> Checkin</a>'+*/
                  '</div>'+
                  '<div class="panel-body">'+
                    '<div>'+
                      '<b> Type: </b> '+ value.type +''+
                    '</div>'+
                    '<div>'+
                      '<b> Floor: </b> '+ value.floor +''+
                    '</div>'+
                    '<div>'+
                      '<b> Rate: </b> PHP '+ value.rate +''+
                    '</div>'+

                  '</div>'+
                '</div>'+
              '</div>'
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
});

  // PASS ID TO MODAL ON "CHECKIN THIS GUEST" BUTTON CLICK  
$(document).on("click", ".open-checkout", function () {
   var gID = $(this).data('id');
   $(".modal-body #service_id").val( gID );

    var event_amount_paid  = "#amount_paid" +gID;
    var defamount_paid  = "amount_paid" +gID;
    console.log(defamount_paid);
    var deftotal  = "total_amount" +gID;
    var defother  = "other_charges" +gID;
    var def_subtotal  = "sub_total" +gID;
    var newsubtotal = ".modal-body #sub_total" +gID;
    var newchange = ".modal-body #change" +gID;

    $(document).on("focus", event_amount_paid, function () {
        compute_total();
    });
    $(document).on("change", event_amount_paid, function () {
        compute_change();
    });

     /*FUNCTIONS*/
      function compute_total() {
           total = document.getElementById(deftotal).value;
           other_charges = document.getElementById(defother).value;
          if (other_charges <= 0 ) {
            $(newsubtotal).val( total);
          } else {
             total2 = eval(total) + eval(other_charges);
            $(newsubtotal).val( total2);
          }

          
      }

      function compute_change() {
           amount_paid = document.getElementById(defamount_paid).value;
           sub_total = document.getElementById(def_subtotal).value;

          console.log(amount_paid);
          if (amount_paid <= 0 ) {
              $('#change').val( sub_total );
            } else {
              var change = amount_paid - sub_total;
              $('#change').val( change );
            }

        }


});

</script>

</body>
</html>
