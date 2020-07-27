<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">
			<a href="#add_product_modal" data-toggle="modal" class="btn btn-sm btn-primary"><i class="btn-icon-only icon-plus"></i>Add Product</a>
			<br><br>
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
            <!-- <th> Status </th> -->
				    <th class="td-actions"> Actions </th>
				  </tr>
				</thead>
				<tbody>
          <!-- Add Product Modal -->
        <div class="modal fade" id="add_product_modal" role="dialog">
              <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">×</button>
                              <h3>Add Products</h3>
                      </div>
                      <div class="modal-body">
                          <!-- <div class="form-group">
                              <label for="room_name">Search</label>
                              <input type="text" class="form-control" id="room_name" name="room_name" required>
                          </div> -->
                         <form action="<?=base_url('admin/add_product')?>" method="post" role="form">
                              <div class="form-group">
                                  <label for="product_name">Product Name</label>
                                  <input type="text" class="form-control" id="add_product_name" name="add_product_name" required>
                              </div>
                              <div class="form-group">
                                  <label for="room_type">Quantity</label>
                                  <input type="text" class="form-control" id="add_quantity" name="add_quantity" required>
                              </div>
                            
                              <div class="form-group">
                                   <label for="rate">Cost</label>
                                   <input type="text" class="form-control" id="add_cost" name="add_cost" required>
                               </div>
                                <div class="form-group">
                                  <label for="rate">Selling Price</label>
                                  <input type="text" class="form-control" id="add_amount" name="add_amount" required>
                              </div>
                               <div class="form-group">
                                    <label for="rate">Best Before</label>
                                    <input type="date" class="form-control" id="add_best_before" name="add_best_before" required>
                                </div>
                              <div class="form-group">
                                  <label for="floor">Status</label>
                                  <select name="add_status" class="form-control" id="add_status">
                                     <option value="Active">Active</option>
                                     <option value="Inactive">Inactive</option>
                                  </select>
                              </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                  </form>
              </div>
          </div>
          </div>
        <!-- End of Add Product Modals -->
        <?php if($products): ?>
				 <?php foreach ($products as $product):?>
           <!-- Delete Product Modal -->
           <div class="modal fade" id="delete_product_modal<?=$product->id?>" role="dialog">
               <div class="modal-dialog modal-sm">
                   <div class="modal-content">
                       <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal">×</button>
                               <h3>Delete Products</h3>
                       </div>
                       <form action="<?=base_url('admin/delete_product')?>" method="post" role="form">
                       <div class="modal-body">
                           <div class="form-group">
                               <label for="room_name"><b>Are you sure you want to delete this product?</b></label>
                           </div>
                               <input type="text" class="form-control hidden" id="delete_product_id" value="<?=$product->id?>" name="delete_product_id" required>
                       </div>
                       <div class="modal-footer">
                         <button type="submit" class="btn btn-danger">Yes</button>
                         <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                   </div>
                   </form>
               </div>
           </div>
           </div>
           <!-- End of Delete Product Modals -->
           <!-- Edit Product Modal -->
           <div class="modal fade" id="edit_product_modal<?=$product->id?>" role="dialog">
               <div class="modal-dialog modal-sm">
                   <div class="modal-content">
                       <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal">×</button>
                               <h3>Edit Products</h3>
                       </div>
                       <div class="modal-body">
                           <!-- <div class="form-group">
                               <label for="room_name">Search</label>
                               <input type="text" class="form-control" id="room_name" name="room_name" required>
                           </div> -->
                          <form action="<?=base_url('admin/edit_product')?>" method="post" role="form">
                               <div class="form-group">
                                   <label for="product_name">Product Name</label>
                                   <input type="text" class="form-control" id="product_name" value="<?=$product->name?>" name="product_name" required>
                                   <input type="text" class="form-control hidden" id="product_id" value="<?=$product->id?>" name="product_id" required>
                               </div>
                               <div class="form-group">
                                   <label for="room_type">Quantity</label>
                                   <input type="text" class="form-control" id="quantity" value="<?=$product->quantity?>" name="quantity" required>
                               </div>
                               <div class="form-group">
                                    <label for="rate">Cost</label>
                                    <input type="text" class="form-control" id="cost" value="<?=$product->cost?>" name="cost" required>
                                </div>

                              <div class="form-group">
                                   <label for="rate">Selling Price</label>
                                   <input type="text" class="form-control" id="amount" value="<?=$product->amount?>" name="amount" required>
                               </div>
                               
                                <div class="form-group">
                                     <label for="rate">Best Before</label>
                                     <input type="date" class="form-control" id="best_before" value="<?=$product->best_before?>" name="best_before" required>
                                 </div>
                               <div class="form-group">
                                   <label for="floor">Status</label>
                                   <select name="status" class="form-control" id="status">
                                      <option value="Active">Active</option>
                                      <option value="Inactive">Inactive</option>
                                   </select>
                               </div>
                       </div>
                       <div class="modal-footer">
                         <button type="submit" class="btn btn-primary">Submit</button>
                         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                   </div>
                   </form>
               </div>
           </div>
           </div>
           <!-- End of Edit Product Modals -->
         <?php endforeach;?>
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
    $(document).ready(function () {

        //data table
        var table1 = $('#product_table').dataTable({
            "processing": true,
            "serverSide": false,
            "deferRender": true,
            "ajax": {
                "type": "POST",
                "url": "<?php echo base_url('admin/product_list_json'); ?>"
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
            {"data": "amount"},
            //{"data": "status"},
            {"data": "id",
                    "mRender": function (data, type, row) {
                        return '<a class="btn btn-small btn-success" data-toggle="modal" href="#edit_product_modal'+row['id']+'"><i class="btn-icon-only icon-edit"></i></a> &nbsp;'+
                        '<a data-toggle="modal" class="btn btn-danger btn-small" href="#delete_product_modal'+row['id']+'"><i class="btn-icon-only icon-remove"></i></a>';
                    }
            },

        ],
        "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]],
        "order": [[0, "desc"]],

        });


	});




</script>
</body>
</html>
