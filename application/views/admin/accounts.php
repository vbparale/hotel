<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">
          <a data-toggle="modal" href="#add_accounts_modal" class="btn btn-sm btn-primary"><i class="btn-icon-only icon-plus"></i>Add User</a>
          <br><br>
          <?php if ($this->session->flashdata('success') == TRUE): ?>
           <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
          <?php endif; ?>
          <table class="table table-striped table-bordered" id="accounts_table">
            <thead>
              <tr>
                <th> Username </th>
                <th> Role </th>
                <th class="td-actions"> Actions </th>
              </tr>
            </thead>
            <tbody>
              <!-- Add Accounts Modal -->
              <div class="add_account_modal modal fade" id="add_accounts_modal" role="dialog">
                  <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">×</button>
                                  <h3>Add Accounts</h3>
                          </div>
                          <div class="modal-body">
                             <form action="<?=base_url('admin/add_account')?>" method="post" role="form">
                                  <div class="form-group">
                                      <label for="product_name">Username</label>
                                      <input type="text" class="form-control" id="add_product_name" name="add_user_name" required>
                                  </div>
                                  <div class="form-group">
                                      <label for="room_type">Password</label>
                                      <input class="form-control" type="password" id="add_quantity" name="add_password" required>
                                  </div>
                                 <div class="form-group">
                                      <label for="rate">Confirm Password</label>
                                      <input class="form-control" type="password" id="add_amount" name="add_confirm_password" required>
                                  </div>
                                  <div class="form-group">
                                      <label for="floor">Role</label>
                                      <select name="add_role" class="form-control" id="add_role">
                                        <?php foreach($roles as $roles):  ?>
                                            <option value="<?= $roles->id ?>"><?= $roles->role_name ?></option>
                                        <?php endforeach?>
                                      </select>
                                  </div>
                                  <div class="form-group">
                                      <label for="floor">Status</label>
                                      <select name="add_status" class="form-control" id="add_status">
                                         <option value="1">Active</option>
                                         <option value="0">Inactive</option>
                                      </select>
                                  </div></br>
                                  <?php if ($this->session->flashdata('add_error') == TRUE): ?>
                          		        <div class="alert alert-danger"><?php echo $this->session->flashdata('add_error'); ?></div>
                          		    <?php endif; ?>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Submit</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                      </form>
                  </div>
              </div>
              </div>
              <!-- End of Add Accounts Modals -->
              <?php if($accounts): //var_dump($accounts);exit; ?>
                <?php foreach ($accounts as $accounts):?>


                  <!-- Remove Account Modal -->
                  <div class="modal fade" id="remove_account_modal<?=$accounts->id?>" role="dialog">
                      <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">×</button>
                                      <h3>Delete Products</h3>
                              </div>
                              <form action="<?=base_url('admin/remove_account')?>" method="post" role="form">
                              <div class="modal-body">
                                  <div class="form-group">
                                      <label for="room_name"><b>Are you sure you want to remove this account?</b></label>
                                  </div>
                                      <input type="text" class="form-control hidden" id="remove_account_id" value="<?=$accounts->id?>" name="remove_account_id">
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
                  <div class="change_password_modal modal fade" id="change_password_modal<?=$accounts->id?>" role="dialog">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">×</button>
                          <h3>Change Password</h3>
                        </div>
                        <div class="modal-body">
                        <form action="<?=base_url('admin/change_password')?>" method="post" role="form">
                          <div class="form-group">
                            <label for="product_name">Old Password</label>
                            <input type="password" class="form-control" id="edit_old_password" name="edit_old_password" required>
                            <input type="text" class="form-control hidden" id="account_id" value="<?=$accounts->id?>" name="account_id" required>
                          </div>
                          <div class="form-group">
                            <label for="room_type">New Password</label>
                            <input type="password" class="form-control" id="edit_new_password" name="edit_new_password" required>
                          </div>
                          <div class="form-group">
                            <label for="rate">Confirm New Password</label>
                            <input type="password" class="form-control" id="edit_confirm_new_password" name="edit_confirm_new_password" required>
                          </div></br>
                          <?php if ($this->session->flashdata('error') == TRUE): ?>
                  		        <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
                  		    <?php endif; ?>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" id="change_pass_btn" class="btn btn-danger">Submit</button>
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


<!-- Loading JS Libraries -->
<script type="text/javascript" src="<?= base_url('assets/js/jquery-3.1.0.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/datatables/js/jquery.dataTables.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/datatables/js/dataTables.tableTools.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/datatables/js/dataTables.bootstrap.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>
<script type="text/javascript">
$(document).ready(function () {

  //data table
  var table1 = $('#accounts_table').dataTable({
    "processing": true,
    "serverSide": false,
    "deferRender": true,
    "ajax": {
      "type": "POST",
      "url": "<?php echo base_url('admin/accounts_list_json'); ?>"
    },
    "columns": [
      {"data": "username"},
      {"data": "role_name"},
      {"data": "account_id", 
        "mRender": function (data, type, row) {
          return '<a class="btn btn-xs btn-success" data-toggle="modal" href="#change_password_modal'+row['account_id']+'"><i class="btn-icon-only icon-edit"> Change Password</i></a> &nbsp;'+
          '<a data-toggle="modal" class="btn btn-danger btn-xs" href="#remove_account_modal'+row['account_id']+'"><i class="btn-icon-only icon-remove"> Remove Account</i></a>'; 
              }
      },  

],
"lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]],
"order": [[0, "desc"]],

});


});
</script>

<?php if($this->session->flashdata('error') == TRUE): ?>
  <script type="text/javascript">
    $(window).on('load',function(){
      $('.change_password_modal').modal('hide');
      $('.change_password_modal').modal('show');
    });
  </script>
<?php endif; ?>

<?php if($this->session->flashdata('add_error') == TRUE): ?>
  <script type="text/javascript">
    $(window).on('load',function(){
      $('.add_account_modal').modal('hide');
      $('.add_account_modal').modal('show');
    });
  </script>
<?php endif; ?>




</body>
</html>
