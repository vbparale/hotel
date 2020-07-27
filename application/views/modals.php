<!-- Checkin Modal -->
<!-- <div class="modal fade" id="checkin" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>Reservation Details</h3>
            </div>
            <form action="<?=base_url('admin/checkin')?>" method="post" role="form">
                <div class="modal-body">

                    <div class="col-lg-12 col-md-12">
                        <div class="">
                            <label for="guest_count">Number of Guest/s</label>
                            <input type="text" class="form-control" id="guest_count" name="guest_count" required>
                        </div>
                        <div class="">
                            <label for="checkin_date">Checkin Date</label>
                            <input type="date" class="form-control" id="the_checkin_date" name="checkin_date" required>
                        </div>
                        <div class="">
                            <label for="checkout_date">Checkout Date</label>
                            <input type="date" class="form-control" id="the_checkout_date" name="checkout_date" required>
                        </div>
                        </hr>
                       <div class="">
                            <label for="room_type">Available Rooms</label>
                             <input type="hidden" class="form-control" id="room_x_id" name="room_x_id" value="" required>
                            <select name="room_id" class="form-control" id="the_rooms">
                                <?php foreach($rooms as $room):  ?>
                                    <option value="<?= $room->room_id ?>"> <?= $room->room_name ?> - [<?= $room->type ?>]</option>
                                <?php endforeach?>
                            </select>
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
</div> -->
<!-- End of Checkin Modals -->

<!-- Add Guest Modal -->
<div class="modal fade" id="add_guest" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>Guest Details</h3>
            </div>
            <form action="<?=base_url('admin/add_guest')?>" method="post" role="form" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="col-lg-12 col-md-12">
                        <div class="">
                            <label for="fname">First Name</label>
                            <input type="text" class="form-control" id="fname" name="fname" required>
                        </div>
                        <div class="">
                            <label for="lname">Last Name</label>
                            <input type="text" class="form-control" id="lname" name="lname" required>
                        </div>
                         <div class="">
                            <label for="bday">Birthday</label>
                            <input type="date" class="form-control" id="birthday" name="birthday">
                        </div>
                        <div class="">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address">
                        </div>
                        <div class="">
                            <label for="contact">Contact Number</label>
                            <input type="text" class="form-control" id="contact" name="contact">
                        </div>
                        <!-- add by francis -->
                        <div class="">
                          <label for="referred_by">Referred by</label>
                          <input class="form-control" id="referred_by" name="referred_by">
                        </div>
                        <!-- end -->
                        <div class="">
                            <label for="note">Note</label>
                            <textarea class="form-control" id="note" name="note" rows="5"></textarea>
                        </div>

                        <div class="">
                            <label for="photo">Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo">
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
<!-- End of Add Guest  Modals -->


<!-- Add Rooms Modal -->
<div class="modal fade" id="add_rooms" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>Add Rooms</h3>
            </div>
            <form action="<?=base_url('admin/add_rooms')?>" method="post" role="form">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="room_name">Room Name</label>
                        <input type="text" class="form-control" id="room_name" name="room_name" required>
                    </div>
                    <div class="form-group">
                        <label for="room_type">Room Type</label>
                        <select name="room_type" class="form-control" id="room_type">
                            <?php foreach($room_types as $type):  ?>
                                <option value="<?= $type->id ?>"> <?= $type->type ?></option>
                            <?php endforeach?>
                        </select>
                    </div>
                   <div class="form-group">
                        <label for="rate">Rate</label>
                        <input type="text" class="form-control" id="rate" name="rate" required>
                    </div>

                    <div class="form-group">
                        <label for="rate">Maximum Capacity</label>
                        <input type="text" class="form-control" id="capacity" name="capacity" required>
                    </div>
                    <div class="form-group">
                        <label for="floor">Area/Floor</label>
                        <input type="text" class="form-control" id="floor" name="floor">
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
<!-- End of Add Rooms Modals -->



<!-- Checkin This Guest Modal -->
<div class="modal fade" id="checkin_this_guest" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>Checkin Details</h3>
            </div>
            <form action="<?=base_url('admin/checkin_this_guest')?>" method="post" role="form">
                <div class="modal-body">

                <div class="form-group">
                    <input type="hidden" class="form-control guest_id" id="this_guest_id" name="guest_id" value="" readonly required>
                </div>
                    <div class="form-group">
                        <label for="guest_count">Number of Guest/s</label>
                        <input type="text" class="form-control" id="guest_count" name="guest_count" required>
                    </div>
                    <div class="form-group">
                        <label for="checkin_date">Checkin Date</label>
                        <input type="date" class="form-control" id="this_guest_checkin_date" name="checkin_date" value="<?= date('Y-m-d'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="checkout_date">Checkout Date</label> &nbsp;
                        <i>** Leave as blank for Open Time.</i>
                        <input type="date" class="form-control" id="this_guest_checkout_date" name="checkout_date">
                    </div>
                     <div class="form-group">
                        <label for="room_type">Room Type</label>
                        <select class="form-control" id="this_guest_room_type">
                            <option value="0">  </option>
                            <option value="1"> Family </option>
                            <option value="2"> Bedspace </option>
                            <option value="3"> Cubicle </option>
                            <option value="4"> Semi-Cubicle </option>
                            <option value="5"> Fan Bedspace </option>
                            <option value="6"> Fan Cubicle </option>
                            <option value="7"> Semi Room </option>
                            <option value="8"> Couples </option>
                        </select>
                    </div> 
                     <div class="form-group">
                        <label for="room_type">Available Rooms</label>
                        <select name="room_id" class="form-control" id="this_guest_room">
                            <?php foreach($rooms as $room):  ?>
                                <option value="<?= $room->room_id ?>"> [<?= $room->type ?>] <?= $room->floor ?> ROOM #<?= $room->room_name ?> </option>
                            <?php endforeach?>
                        </select>
                    </div>

                     <div class="form-inline" style="margin-bottom: 20px;">
                        <label>Rate Per Day:</label>
                        <input type="radio" class="form-control" style="margin: 10px" name="rate_per_day" value="180"> 180
                        <input type="radio" class="form-control" style="margin: 10px" name="rate_per_day" value="200"> 200
                        <input type="radio" class="form-control" style="margin: 10px" name="rate_per_day" value="220"> 220
                        <input type="radio" class="form-control" style="margin: 10px" name="rate_per_day" value="240"> 240 </br>

                        <label>Or Enter Amount: </label>
                        <input type="text" style=" width: 130px" id="other_amount" class="form-control" placeholder="Other Amount" name="other_amount">
                    </div>

                    <div class="">
                        <label for="note">Note</label>
                        <textarea class="form-control" id="checkin_note" name="checkin_note" rows="5" ></textarea>
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
<!-- End of Checkin This Guest Modals -->

<!-- Add Room Modal -->
<div class="modal fade" id="add_room" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>Additional Room</h3>
            </div>
            <form action="<?=base_url('admin/add_room_guest')?>" method="post" role="form">
                <div class="modal-body">

                <div class="form-group">
                    <input type="hidden" class="form-control" id="room_service_id" name="room_service_id" value="" readonly required>
                </div>
                    <div class="form-group">
                        <label for="guest_count">Number of Guest/s</label>
                        <input type="text" class="form-control" id="guest_count" name="guest_count" required>
                    </div>
                    <div class="form-group">
                        <label for="checkin_date">Checkin Date</label>
                        <input type="date" class="form-control" id="room_guest_checkin_date" name="checkin_date" required>
                    </div>
                    <div class="form-group">
                        <label for="checkout_date">Checkout Date</label>
                        <input type="date" class="form-control" id="room_guest_checkout_date" name="checkout_date" required>
                    </div>
                     <div class="form-group">
                        <label for="room_type">Available Rooms</label>
                        <select name="room_id" class="form-control" id="add_guest_room">
                            <?php foreach($rooms as $room):  ?>
                                <option value="<?= $room->room_id ?>"> <?= $room->room_name ?> - [<?= $room->type ?>]</option>
                            <?php endforeach?>
                        </select>
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
<!-- End of  Add Room  Modals -->

 <!-- Bulk Upload Users Modal -->
<div class="modal fade" id="bulk_user_data" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Bulk Guest Details</h3>
            </div>
            <form enctype="multipart/form-data" action="<?=base_url('admin/bulk_user_data')?>" method="post" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="userfile">Select File (bulk_user_data.csv only)</label>
                        <input type="file" name="userfile" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
      </div>
  </div>
</div>
<!-- End of Bulk Upload Users Modal -->

 <!-- Bulk Upload Users Modal -->
<div class="modal fade" id="bulk_checkin_data" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Bulk Checkin Details</h3>
            </div>
            <form enctype="multipart/form-data" action="<?=base_url('admin/bulk_checkin_data')?>" method="post" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="userfile">Select File (bulk_checkin_data.csv only)</label>
                        <p style="font-style: italic; color: red;">*NOTE: For checkin and checkout date, use dd/mm/yyy format.</p>
                        <input type="file" name="userfile" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
      </div>
  </div>
</div>
<!-- End of Bulk Upload Users Modal -->

 <!-- Bulk Upload Payments Modal -->
<div class="modal fade" id="bulk_payment_data" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Bulk Payment Details</h3>
            </div>
            <form enctype="multipart/form-data" action="<?=base_url('admin/bulk_payment_data')?>" method="post" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="userfile">Select File (bulk_payment_data.csv only)</label>
                        <input type="file" name="userfile" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
      </div>
  </div>
</div>
<!-- End of Bulk Upload Payments Modal -->


 <!-- Bulk Upload ROOM Modal -->
<div class="modal fade" id="bulk_room_data" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Bulk Room Details</h3>
            </div>
            <form enctype="multipart/form-data" action="<?=base_url('admin/bulk_room_data')?>" method="post" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="userfile">Select File (bulk_room_data.csv only)</label>
                        <input type="file" name="userfile" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
      </div>
  </div>
</div>
<!-- End of Bulk Upload ROOM Modal -->
