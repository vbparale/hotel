<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">
          <!-- <a role="button" data-toggle="modal" href="#add_guest" class="btn btn-sm btn-default"><i class="btn-icon-only icon-plus"></i> Add Guest</a> -->
          <!-- <a role="button" data-toggle="modal" href="#checkin" class="btn btn-sm btn-primary"><i class="btn-icon-only icon-plus"></i> Reservation</a> -->
          <br><br>
          <?php if ($this->session->flashdata('success') == TRUE): ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
          <?php endif; ?>

          <?php if ($this->session->flashdata('error') == TRUE): ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
          <?php endif; ?>
          <table class="table table-striped table-bordered" id="guest_table">
            <thead>
              <tr>
                <th> Service # </th>
                <th> Name </th>
                <th> Address </th>
                <th> Contact Number </th>
                <th> Room </th>
                <th> Status & Balance </th>
                <th> Last Payment Date </th>
                <th> Checkin Date </th>
                <!-- <th class="td-actions"> Actions </th> -->
              </tr>
            </thead>
            <tbody>
              <?php if($checkin_distinct): ?>
                <?php foreach($checkin_distinct as $checkin): ?><?php
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
                <tr>
                  <td><?= $checkin->service_id ?></td>
                  <td><a href="<?= base_url('frontdesk/guest_details/'.$checkin->guest_id); ?>"><?= $checkin->firstname ?> <?= $checkin->lastname ?></a></td>
                  <td><?= $checkin->address ?></td>
                  <td><?= $checkin->contact_number ?></td>
                  <td><?= $checkin->type ?> - <?= $checkin->room_name ?></td>
                  <td><span class="label label-danger">UNPAID</span> <span class="label label-default"><?= number_format($total,2,'.',','); ?></span></td>
                  <td><?= $checkin->date_time ?></td>
                  <td><?= $checkin->checkin_date ?> TO <?= $checkin->checkout_date ?></td>
                </tr>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
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
var base_url =  '<?php echo base_url() ?>';

// AVAILABLE ROOM IN SELECT
$(document).on("click", ".open-checkout", function () {
  var xID = $(this).data('id');
  $(".modal-body #edit_guest_id").val( xID );
  var edit_checkout_date = "#edit_checkout_date" + xID;
  $(document).on("change", edit_checkout_date, function () {
    edit_available_rooms(xID);
  });
});


$(document).on("change", "#the_checkout_date", function () {
  checkout = document.getElementById('the_checkout_date').value;
  checkin = document.getElementById('the_checkin_date').value;
  available_rooms(checkin, checkout);
});

$(document).on("change", "#this_guest_checkout_date", function () {
  checkout = document.getElementById('this_guest_checkout_date').value;
  checkin = document.getElementById('this_guest_checkin_date').value;
  available_rooms(checkin, checkout);
});

$(document).on("change", "#room_guest_checkout_date", function () {
  checkout = document.getElementById('room_guest_checkout_date').value;
  checkin = document.getElementById('room_guest_checkin_date').value;
  available_rooms(checkin, checkout);
});


function available_rooms($checkin, $checkout){
  var url = base_url + "admin/view_available_rooms/"+checkin+"/"+checkout;
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
            '<option value="'+ value.room_id +'"> '+ value.room_name +' - ['+ value.type +']</option>'
          );
          $('#this_guest_room').append(
            '<option value="'+ value.room_id +'"> '+ value.room_name +' - ['+ value.type +']</option>'
          );
          $('#add_guest_room').append(
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

function edit_available_rooms(xID){
  //xid = document.getElementById('edit_guest_id').value;
  console.log(xID);
  var edit_rooms = "#the_edit_rooms" +xID;
  var edit_checkout_date = "edit_checkout_date" +xID;
  var edit_checkin_date = "edit_checkin_date" +xID;
  checkout = document.getElementById(edit_checkout_date).value;
  checkin = document.getElementById(edit_checkin_date).value;


  var url = base_url + "admin/view_available_rooms/"+checkin+"/"+checkout;
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

// $(document).ready(function () {
//     //data table
//     var table1 = $('#guest_table').dataTable({
//         "processing": true,
//         "serverSide": false,
//         "deferRender": true,
//         "ajax": {
//             "type": "POST",
//             "url": "<?php echo base_url('admin/guest_list_json'); ?>"
//         },
//         "columns": [
//         {"data": "guest_id"},
//         {"data": "guest_id",
//             "mRender": function (data, type, row) {
//               /*<?= base_url('admin/guest_details/'); ?>*/
//               var guest_id = base_url + "admin/guest_details/"+row.guest_id;
//               console.log(guest_id);
//                return '<a href="'+guest_id+'">' + row['firstname'] +' '+row['lastname'] + '</a>';
//             }
//         },
//         {"data": "address"},
//         {"data": "contact_number"},
//         {"data": "birthday"},
//         {"data": "note"},
//
//
//     ],
//     "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]],
//     "order": [[0, "desc"]],
//
//     });
//
//
// });

// PASS GUEST ID TO MODAL ON "CHECKIN THIS GUEST" BUTTON CLICK
$(document).on("click", ".open-Guest-Checkin", function () {
  var gID = $(this).data('id');
  $(".modal-body #this_guest_id").val( gID );
});

// PASS SERVICE ID TO MODAL ON "AD" BUTTON CLICK
$(document).on("click", ".open-add-room", function () {
  var gID = $(this).data('id');
  $(".modal-body #room_guest_id").val( gID );
});


function str_pad(n) {
  return String("0" + n).slice(-2);
}

</script>



<script type="text/javascript">


// PASS ID TO MODAL ON "CHECKIN THIS GUEST" BUTTON CLICK
$(document).on("click", ".open-checkout", function () {
  var gID = $(this).data('id');
  $(".modal-body #invoice_guest_id").val( gID );

  var event_amount_paid  = "#amount_paid" +gID;
  var defamount_paid  = "amount_paid" +gID;
  var deftotal  = "total_amount" +gID;
  var defother  = "other_charges" +gID;
  var def_subtotal  = "sub_total" +gID;
  var newsubtotal = ".modal-body #sub_total" +gID;
  var newchange = ".modal-body #change" +gID;
  var checkout_group_id = "checkout_group_id" +gID;

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


    if (amount_paid <= 0 ) {
      $(newchange).val( sub_total );
    } else {
      var change = amount_paid - sub_total;
      $(newchange).val( change );
    }

  }


});


</script>
</body>
</html>
