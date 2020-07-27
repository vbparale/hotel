<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12">
			
			<br><br>
			    <?php if ($this->session->flashdata('success') == TRUE): ?>
			      <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
			    <?php endif; ?>

			    <?php if ($this->session->flashdata('error') == TRUE): ?>
			        <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
			    <?php endif; ?>
			
      
            <div class="">

              <div class="col-lg-6 col-md-6">
                <div class="">
                  <input type="text" class="form-control" id="search" name="search" placeholder="Search..">
                </div>
                <div id="prescrollable" class="pre-scrollable" style="border-top: 1px dashed #808080; margin-top: 20px; margin-bottom: 20px">
                    <label for="products">Products</label>
                    <?php if($products): ?>
                      <?php foreach($products as $product):  ?>
                      <div>
                        <a role="button" href="<?= base_url('cashier/add_item/'.$product->id);?>" class="btn btn-block btn-default"> <?= $product->name ?></a>
                      </div>
                          
                      <?php endforeach?>
                 
                  <?php endif; ?>
                </div>
              </div>

               <div class="col-lg-6 col-md-6">  
                <div class="">
                    <label for="user">User: </label>
                    <input type="text" class="form-control" id="user" name="user" value="CASHIER-JOHN" readonly>
                </div>
                <div class="container-fluid" style="padding-top: 20px;">
                  <table class="table table-striped table-bordered" id="products_table" style="width: 600px;">
                    <thead>
                      <tr>
                        <th> Item Name </th>
                        <th> Price </th>
                        <th> Quantity </th>
                        <th> Grand Total </th>
                        <th class="td-actions"> Actions </th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if($temps): ?>
                      <?php foreach ($temps as $temp): ?>

                       <!-- Edit Temp Modal -->
                            <div class="modal fade" id="edit_temp<?= $temp->id ?>" role="dialog">
                                <div class="modal-dialog">
                                
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">×</button>
                                                <h3>Edit Item</h3>
                                        </div>
                                       
                                        <form action="<?=base_url('cashier/edit_item/'.$temp->id)?>" method="post" role="form">
                                          <div class="modal-body">
                                            <input type="hidden" class="form-control" name="temp_id" value="<?= $temp->id ?>">
                                             <div class="">
                                                <label for="sub_total">Product:</label>
                                                <input type="text" class="form-control" id="product_name" name="product_name" value="<?= $temp->name; ?>" readonly>
                                            </div>
                                            <div class="">
                                                <label for="sub_total">Quantity:</label>
                                                <input type="text" class="form-control" id="prod_quantity" name="prod_quantity" value="<?= $temp->quantity; ?>" required>
                                            </div>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger" style="margin-top: 20px;">Update</button>
                                            <button type="button" class="btn btn-default" style="margin-top: 20px;" data-dismiss="modal">Close</button>
                                          </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End of Edit Temp Modals -->

                      <?php endforeach; ?>
                    <?php endif; ?>

                    </tbody>
                  </table>
                </div>
                
              </div>
              <div class="col-lg-12 col-md-12"></div>
              <form action="<?=base_url('cashier/checkout_product')?>" method="post" role="form">
                <div class="col-lg-6 col-md-6">
                  <div class="">
                      <label for="total_amount">Total Charges:</label>
                      <?php $total = $this->Admin_model->sum_temp_data(user('id')); ?>
                      <input type="text" class="form-control" id="total_amount" name="total_amount" value="<?= $total->total_amount?> " readonly>
                  </div>
                  <div class="">
                      <label for="other_charges">Other Charges:</label>
                      <input type="text" class="form-control" id="other_charges" name="other_charges">
                  </div>
                  <div class="">
                      <label for="sub_total">Subtotal:</label>
                      <input type="text" class="form-control" id="sub_total" name="sub_total" readonly>
                  </div>
                </div>

                <div class="col-lg-6 col-md-6" style="border-left: 1px dashed #808080; margin-top: 20px;">
                   <div class="">
                      <label for="amount_paid">Amount Paid:</label>
                      <input type="text" class="form-control" id="amount_paid" name="amount_paid">
                  </div>
                  <div class="">
                      <label for="change">Change:</label>
                      <input type="text" class="form-control" id="change" name="change">
                  </div>
                 
                </div>
                
                <div class="col-lg-12 col-md-12">
                  <button type="submit" class="btn btn-danger" id="submit" style="margin-top: 20px;">Submit</button>
                  <a role="button" href="<?= base_url('cashier/delete_all_temp');?>" class="btn btn-default" style="margin-top: 20px;">Cancel</a>
                </div>
            </form>
        </div>
      <!-- </form> -->

             
			
		</div>
	  </div>
	</div>
  </div>
</div>


 <!-- Loading JS Libraries -->
<script type="text/javascript" src="<?= base_url('assets/js/jquery-3.1.0.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/datatables/js/jquery.dataTables.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/datatables/js/dataTables.tableTools.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/datatables/js/dataTables.bootstrap.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>

<script type="text/javascript">
var base_url =  '<?php echo base_url() ?>';

 $("#other_charges").val(0);
/*  var event_amount_paid  = "#amount_paid";*/
  var defamount_paid  = "amount_paid";
  var deftotal  = "total_amount";
  var defother  = "other_charges";
  var def_subtotal  = "sub_total";

  $(document).on("focus", "#amount_paid", function () {
      compute_total();
  });
  $(document).on("change", "#amount_paid", function () {
      compute_change();
  });

 $(document).on("change", "#search", function () {
    product = document.getElementById("search").value;
    search_products(product);
  });

 /*FUNCTIONS*/
  function compute_total() {
       total = document.getElementById("total_amount").value;
       other_charges = document.getElementById("other_charges").value;
      if (other_charges <= 0 ) {
        $("#sub_total").val( total);
      } else {
         total2 = eval(total) + eval(other_charges);
         console.log(total2);
        $("#sub_total").val( total2);
      }
      
  }


function compute_change() {
     amount_paid = document.getElementById("amount_paid").value;
     sub_total = document.getElementById("sub_total").value;

    
    if (amount_paid <= 0 ) {
        $("#change").val( sub_total );
      } else {
        var change = amount_paid - sub_total;
        $("#change").val( change );
      }
  }

  function search_products(product) {
    var prescrollable = "#prescrollable";
    var url = base_url + "cashier/search_products/"+product;
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
        if(data.product_data){
          $(prescrollable).empty();
          $.each(data.product_data, function (key, value) {
            $(prescrollable).append(
              '<a role="button" href="<?= base_url('cashier/add_item/') ?>'+ value.id +'" class="btn btn-block btn-default"> '+ value.name +'</a>'
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
</script>

<script type="text/javascript">
    $(document).ready(function () {
        //data table
        var table1 = $('#products_table').dataTable({
            "processing": true,
            "serverSide": false,
            "deferRender": true,
            "paging":   false,
            "bFilter": false,
            "info":     false,
            "ajax": {
                "type": "POST",
                "url": "<?php echo base_url('cashier/product_temp_list_json'); ?>"
            },
            "columns": [
            {"data": "name"},
            {"data": "amount"},
            {"data": "quantity"},
            {"data": "amount", 
              "mRender": function (data, type, row) {
                 var amount = data;
                 var quantity = row.quantity;
                 var grand_total = eval(amount) * eval(quantity);
                 return grand_total;
              }
            },  
            {"data": "name", 
              "mRender": function (data, type, row) {
                  return '<a data-toggle="modal" data-id="'+row['id'] + '" href="#edit_temp'+row['id'] + '" class="btn btn-success btn-xs"> Edit </a> <a href="<?= base_url('cashier/delete_item').'/'?>' + row['id'] + '" class="btn btn-danger btn-xs"> Remove </a> ';
              }
            },  

            
        ],
        "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]],
        "order": [[0, "desc"]],

        });


  });

  // PASS GUEST ID TO MODAL ON "CHECKIN THIS GUEST" BUTTON CLICK  
  $(document).on("click", ".open-Guest-Checkin", function () {
       var gID = $(this).data('id');
       $(".modal-body #this_guest_id").val( gID );
  });
  


</script>



</body>
</html>