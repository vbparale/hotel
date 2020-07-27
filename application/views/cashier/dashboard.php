<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">

        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="widget widget-nopad" id="target-1">
            <div class="widget-header"> <i class="icon-bell"></i>
              <h3> Today's Stats</h3>
            </div>

            <div class="widget-content">
              <div class="widget big-stats-container">
                <div class="widget-content">
                  <h5 class="bigstats" style="padding: 10px;"> What happened today? </h5>
                  <div id="big_stats" class="cf">
                     <div class="stat"> <i class="icon-shopping-cart"></i> <span class="value"><?= count($this->Admin_model->_get_all_products()); ?></span> <br>Products</div>
                    <div class="stat"> <i class="icon-list-alt"></i> <span class="value"><?= count($this->Admin_model->_get_transactions()); ?></span> <br>Transaction Count </div>
                    <div class="stat"> <i class="icon-info"></i> <span class="value"><?= count($this->Admin_model->_get_all_products_low_quantity()); ?></span> <br>Low Quantity </div>
                   
                  </div>
                </div>
                
              </div>
            </div>
          </div>

            <div class="widget widget-table action-table" id="target-3">
              <div class="widget-header"> <i class="icon-th-list"></i>
                <h3>Recent Transactions</h3>
              </div>
              <div class="widget-content">
               
                  
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th> # </th>
                      <th> Total Amount </th>
                      <th> Date </th>
                      <th> Cashier</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                   <?php if($recent_transaction): ?>
                      <?php foreach ($recent_transaction as $recent): ?>
                        <tr>
                          <td> <?= $recent->trans_id ?> </td>
                          <td> PHP <?= number_format($recent->total_amount,2,'.',','); ?> </td>
                          <td> <?= $recent->date_time ?> </td>
                          <td> <?= $recent->username ?> </td>
                         
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                       
                      </td>
                    </tr>
                  </tbody>
                </table>
                
              </div>
            </div>

           
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="widget">
              <div class="widget-header"> <i class="icon-bookmark"></i>
                <h3>Important Shortcuts</h3>
              </div>

              <div class="widget-content">
                <div class="shortcuts">
                    <a href="<?= base_url('cashier/transaction'); ?>" class="shortcut"><i class="shortcut-icon icon-plus"></i><span class="shortcut-label">Transactions</span> </a>
                  <a href="<?= base_url('cashier/products'); ?>" class="shortcut"><i class="shortcut-icon icon-shopping-cart"></i><span class="shortcut-label">Products</span> </a>
                  <a href="<?= base_url('auth/signout'); ?>" class="shortcut"><i class="shortcut-icon icon-off"></i><span class="shortcut-label">Logout</span> </a>
                  
                </div>
              </div>
            </div>

        

          <div class="widget" id="target-2">
            <div class="widget-header"> <i class="icon-group"></i>
              <h3>Products with Low Quantity</h3>
            </div>
            <div class="widget-content">
              <!-- <canvas id="area-chart" class="chart-holder" height="250" width="538"> </canvas> -->
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th> Name </th>
                    <th> Quantity </th>
                    <th> Amount </th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($products): ?>
                    <?php foreach($products AS $products1): ?>
                      <tr>
                        <td> <?= $products1->name ?>  </td>
                        <td> <?= $products1->quantity ?> </td>
                        <td> <?= $products1->amount ?> </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>


                </tbody>
              </table>
            </div>

          </div>

          </div>

      </div>

    </div>

  </div>

</div>

