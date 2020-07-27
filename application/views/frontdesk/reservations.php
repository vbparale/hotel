
  <div style="margin-bottom: 30px; margin-left: 200px;">
    <?php if ($this->session->flashdata('success') == TRUE): ?>
      <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error') == TRUE): ?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
    <?php endif; ?>

    <!-- <a role="button" style="margin-left: 20px;" data-toggle="modal" href="#checkin" class="btn btn-primary btn-sm"><i class="btn-icon-only icon-plus"></i> Reservation</a> -->
  </div>



  <div id="calendar"></div>

<!-- INCLUDE MODALS -->
<!--  <?= $this->load->view('modals', '', TRUE) ?> -->
<!-- Loading JS Libraries -->
<script src="<?= base_url('/assets/js/jquery-3.1.0.min.js'); ?>"></script> 
<script src="<?= base_url('/assets/js/bootstrap.min.js'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?= base_url('/assets/js/full-calendar/moment.min.js'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?= base_url('/assets/js/full-calendar/jquery.min.js'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?= base_url('/assets/js/full-calendar/fullcalendar.min.js'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?= base_url('/assets/js/full-calendar/theme-chooser.js'); ?>"></script>
<script type="text/javascript">
 $(document).ready(function() {
  var date_last_clicked = null;

     $('#calendar').fullCalendar({
       header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,listWeek'
          },
          navLinks: true, // can click day/week names to navigate views
          editable: true,
          eventLimit: true, // allow "more" link when too many events
          eventSources: [
         {
           events: function(start, end, timezone, callback) {
             $.ajax({
             url: "<?php echo base_url('frontdesk/get_events'); ?>",
             dataType: 'json',
             data: {
             // our hypothetical feed requires UNIX timestamps
             start: start.unix(),
             end: end.unix()
             },
             success: function(msg) {
                   var events = msg.events;
                   callback(events);
               }
             });
          }
         },
      ], 
       eventClick: function(event) {
        if(event.url) {
          window.open(event.url);
          return false;
        }
      }
     


    });


  });
</script>

<style>

  body {
    padding: 0;
    font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
    font-size: 14px;
  }

  #calendar {
    max-width: 1000px;
    margin: 0 auto;
  }

</style>

</body>
</html>