<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">
          <a role="button" data-toggle="modal" href="#add_guest" class="btn btn-sm btn-default"><i class="btn-icon-only icon-plus"></i> Add Guest</a>
     <!--  <a role="button" data-toggle="modal" href="#checkin" class="btn btn-sm btn-primary"><i class="btn-icon-only icon-plus"></i> Reservation</a> -->
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
            <th> Guest # </th>
            <th> Name </th>
            <th> Address </th>
            <th> Contact Number </th>
            <th> Birthday </th>
            <th> Status </th>
            <th> Referred by </th>
            <th> Notes </th>
          </tr>
        </thead>
        <tbody>
          <?php if($data): ?>
              <?php foreach ($data as $room): ?>


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


$(document).ready(function () {
    //data table
    var table1 = $('#guest_table').dataTable({
        "processing": true,
        "serverSide": false,
        "deferRender": true,
        "ajax": {
            "type": "POST",
            "url": "<?php echo base_url('frontdesk/guest_list_json'); ?>"
        },
        "columns": [
        {"data": "guest_id"},
        {"data": "guest_id",
            "mRender": function (data, type, row) {
              /*<?= base_url('admin/guest_details/'); ?>*/
              var guest_id = base_url + "frontdesk/guest_details/"+row.guest_id;
               return '<a href="'+guest_id+'">' + row['firstname'] +' '+row['lastname'] + '</a>';
            }
        },
        {"data": "address"},
        {"data": "contact_number"},
        {"data": "birthday"},
        { "data": "is_banned",
        "mRender": function ( data, type, row ) {
          if (data == 1) {
            return '<span class="label label-danger"> BANNED </span>';
          }else{
            return '';
          }
        }
      },
      {"data": "referred_by"},
        {"data": "note"},

    ],
    "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]],
    "order": [[0, "desc"]],

    });


});



function str_pad(n) {
    return String("0" + n).slice(-2);
}

</script>




</body>
</html>
