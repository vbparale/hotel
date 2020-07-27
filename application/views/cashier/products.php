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
			<table class="table table-striped table-bordered" id="product_table">
				<thead>
				  <tr>
				    <th> Product ID </th>
				    <th> Name </th>
				    <th> Quantity Left</th>
				    <th> Amount </th>
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
        var table1 = $('#product_table').dataTable({
            "processing": true,
            "serverSide": false,
            "deferRender": true,
            "ajax": {
                "type": "POST",
                "url": "<?php echo base_url('cashier/product_list_json'); ?>"
            },
            "columns": [
            {"data": "id"},
            {"data": "name"},
            {"data": "quantity", 
                    "mRender": function (data, type, row) {
                        if(data <= 5) {
                          return '<span style="color: red; font-weight: bolder;">' + row['quantity'] + '</span>';
                        } else {
                          return '<span>' + row['quantity'] + '</span>';
                        }
                       
                    }
            },  
            {"data": "amount"}
              
        ],
        "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]],
        "order": [[0, "desc"]],

        });


	});




</script>
</body>
</html>

