<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">
          <div class="tab-content">
            <div id="daily" class="tab-pane fade in active">
              <h3>Inventory Report</h3>
              <div class="col-lg-12 col-md-12">
                <div id="inventory_report">
                  <table class="table table-striped table-bordered" id="table_value">
                    <tr>
                      <th><h4>Product Name</h4></th>
                      <th><h4>Quantity</h4></th>
                      <th><h4>Price</h4></th>
                      <th><h4>Cost</h4></th>
                      <th><h4>Expiration Date</h4></th>
                    </tr>
                    <?php if($reports): ?>
                      <?php foreach ($reports as $report):?>
                        <tr>
                        <td><?=$report->name?></td>
                        <td><?=$report->quantity?></td>
                        <td><?=$report->amount?></td>
                        <td><?=$report->cost?></td>
                        <td><?=$report->best_before?></td>
                      </tr>
                      <?php endforeach;?>
                    <?php else: ?>
                      <tr>
                      <td>No Datas Found</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <?php endif; ?>
                  </table>
                </div>
                <button class="button btn btn-primary btn-sm" onclick="print(inventory_report, 'Inventory Report');"><span class="icon-print"></span> Print</button>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript">


  //francis
  var base_url =  '<?php echo base_url() ?>';
  var daily_show  = function() {
    var url = base_url + 'admin/inventory_reports';
    var data = $(this).serialize();
    $.ajax({
      url: url,
      type: "GET",
      dataType: "JSON",
      data: data,
      cache: false,
      processData: false,
      success: function (data) {
        $('#table_value').empty();
        if(data.reports){
          $('#table_value').append('<tr><th>Product Name</th>'+
          '<th>Quantity</th>'+
          '<th>Price</th>'+
          '<th>Cost</th>'+
          '<th>Expiration Date</th>'
        );
        $.each(data.reports, function (key, value) {
          $('#table_value').append('<tr><td>'+value.name+'</td>'+
          '<td>'+value.quantity+'</td>'+
          '<td>'+new Intl.NumberFormat().format(value.amount)+'</td>'+
          '<td>'+new Intl.NumberFormat().format(value.cost)+'</td>'+
          '<td>'+value.best_before+'</td>'+
          '<td></td></tr>'
        );
      });


    }else{
      $('#table_value').append('<tr style="text-align: center;"><th>Product Name</th>'+
      '<th>Quantity</th>'+
      '<th>Price</th>'+
      '<th>Cost</th>'+
      '<th>Expiration Date</th>'
    );
    $('#table_value').append('<tr style="text-align: center;"><td>No Datas Found</td>'+
    '<td></td>'+
    '<td></td>'+
    '<td></td>'+
    '<td></td></tr>'
    );
    }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      // For debugging
      console.log('The following error occurred: ' + textStatus, errorThrown);
    }
    });
    }




function print(divId, title) {
  var content = document.getElementById('inventory_report').innerHTML;
  var mywindow = window.open('', 'Print', 'height=600,width=1000');

  mywindow.document.write('<html><head><title>'+title+'</title>');
  mywindow.document.write('</head><body style="font-size: 8px;">');
  mywindow.document.write(content);
  mywindow.document.write('</body></html>');

  mywindow.document.close();
  mywindow.focus()
  mywindow.print();
  mywindow.close();
  return true;
}

</script>
