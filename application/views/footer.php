<?php if($page != "guests" && $page != "products" && $page != "rooms" && $page != "reservations" && $page != "accounts" && $page != "transaction"  && $page != "transaction_history" && $page != "guest_details"): ?>
<div class="footer">
  <div class="footer-inner">
    <div class="container">
      <div class="row">
        <div class="span12"> &copy; 2018 <a href="#">Hotel Management and Inventory System</a>. 
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('/assets/js/jquery-3.1.0.min.js'); ?>"></script> 
<script src="<?= base_url('/assets/js/excanvas.min.js'); ?>"></script> 
<script src="<?= base_url('/assets/js/chart.min.js'); ?>" type="text/javascript"></script> 
<script src="<?= base_url('/assets/js/bootstrap.js'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?= base_url('/assets/js/full-calendar/fullcalendar.min.js'); ?>"></script>



</body>
</html>
<?php endif; ?>
