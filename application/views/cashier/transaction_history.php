<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">
		
			<?php if ($this->session->flashdata('success') == TRUE): ?>
		      <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
		    <?php endif; ?>

		    <?php if ($this->session->flashdata('error') == TRUE): ?>
		        <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
		    <?php endif; ?>
			<table class="table table-striped table-bordered" id="history_table">
				<thead>
				  <tr>
				    <th> # </th>
				    <th> Product Name </th>
				    <th> Quantity</th>
				    <th> Amount </th>
                    <th> Date </th>
                    <th> Cashier </th>
				  </tr>
				</thead>
				<tbody>
       
      
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
    $(document).ready(function () {

        //data table
        var table1 = $('#history_table').dataTable({
            "processing": true,
            "serverSide": false,
            "deferRender": true,
            "ajax": {
                "type": "POST",
                "url": "<?php echo base_url('cashier/history_list_json'); ?>"
            },
            "columns": [
            {"data": "transaction_id"},
            {"data": "product_name"},
            {"data": "quantity"},  
            {"data": "amount"},  
            {"data": "date_time"},
            {"data": "cashier"},

              
        ],
        "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]],
        "order": [[0, "desc"]],

        });


	});




</script>
</body>
</html>

