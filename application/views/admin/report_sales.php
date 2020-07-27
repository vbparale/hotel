<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">

          <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#daily">Daily Sales Report</a></li>
            <li><a data-toggle="tab" href="#monthly">Monthly Sales Report</a></li>
            <li><a data-toggle="tab" href="#annual">Annual Sales Report</a></li>
          </ul>

          <div class="tab-content">

            <div id="daily" class="tab-pane fade in active">
              <h3>Daily Sales Report</h3>
              <div class="col-lg-3 col-md-3">
                <!-- <form action="#" method="post" id="get_daily_report"> -->
                  <div class="add-fields" style="padding-top: 10px;">
                    <div class="field">
                      <label for="checkin_date">Select Date:</label>
                      <input type="date" id="daily_date" name="daily_date" required value=""/>
                      <a href="#" class="button btn btn-primary btn-sm" onclick="daily_show()" id="daily">View Report</a>
                    </div>

                  </div>
                <!-- </form> -->
              </div>

              <div class="col-lg-8 col-md-8">
                <div id="daily_report" > <!-- style="display: none;" -->

                  <table class="table table-striped table-bordered" id="table_value">
                    <tr style="text-align: center;">
                      <th>Product Name</th>
                      <th>Cost</th>
                      <th>Price</th>
                      <th>Purchased Qty</th>
                      <th>Total Amount</th>
                    </tr>

                  </table>


                </div>
                 <button class="button btn btn-primary btn-sm" onclick="print('daily_report', 'Daily Report');"><span class="icon-print"> Print</span></button>
              </div>

            </div>


            <div id="monthly" class="tab-pane fade">
              <h3>Monthly Sales Report</h3>
              <div class="span3">
                <div class="add-fields" style="padding-top: 10px;">
                  <div class="field">
                    <label for="checkin_date">Select Month:</label>
                    <select id="month" name="month">
                      <option value="1"> January </option>
                      <option value="2"> February </option>
                      <option value="3"> March </option>
                      <option value="4"> April </option>
                      <option value="5"> May </option>
                      <option value="6"> June </option>
                      <option value="7"> July </option>
                      <option value="8"> August </option>
                      <option value="9"> September </option>
                      <option value="10"> October </option>
                      <option value="11"> November </option>
                      <option value="12"> December </option>
                    </select>
                    <button class="button btn btn-primary btn-sm" onclick="monthly_show();">View Report</button>
                  </div>

                </div>
              </div>

              <div class="col-lg-8 col-md-8">
                <div id="monthly_report">
                  <table class="table table-striped table-bordered" id="table2_value">
                    <tr style="text-align: center;">
                      <th>Product Name</th>
                      <th>Cost</th>
                      <th>Price</th>
                      <th>Purchased Qty</th>
                      <th>Total Amount</th>
                    </tr>

                  </table>

                </div>
                   <button class="button btn btn-primary btn-sm" onclick="print('monthly_report', 'Monthly Report');"><span class="icon-print"> Print</span></button>
              </div>
            </div>

            <div id="annual" class="tab-pane fade">
              <h3>Annual Sales Report</h3>
              <div class="span3">
                <div class="add-fields" style="padding-top: 10px;">
                  <div class="field">
                    <label for="checkin_date">Select Year:</label>
                    <select id="annual_year" name="annual_year">
                      <option value="2018"> 2018 </option>
                      <option value="2019"> 2019 </option>
                      <option value="2020"> 2020 </option>
                      <option value="2021"> 2021 </option>
                      <option value="2022"> 2022 </option>

                    </select>
                    <button class="button btn btn-primary btn-sm" onclick="annual_show('annual_report', 'Annual Report');">View Report</button>
                  </div>

                </div>
              </div>

                <div class="col-lg-8 col-md-8">
                <div id="annual_report">

                  <table class="table table-striped table-bordered" id="table_value_annual">
                    <tr>
                      <th>Product Name</th>
                      <th>Cost</th>
                      <th>Selling Price</th>
                      <th>Purchased Qty</th>
                      <th>Total Amount</th>
                    </tr>
                  </table>

                </div>
                <button class="button btn btn-primary btn-sm" onclick="print('annual_report', 'Annual Report');"><span class="icon-print"> Print</span></button>
              </div>


            </div>




          </div>
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript">
function print(divId, title) {
  var content = document.getElementById(divId).innerHTML;
  var mywindow = window.open('', 'Print', 'height=600,width=800');

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
//francis
var base_url =  '<?php echo base_url() ?>';
function daily_show(){
  var expenses=0;
  var gross=0;
  var date = document.getElementById('daily_date').value;
  var url = base_url + "admin/daily_sales_reports/"+date;
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
      if(data.daily_report){
        $('#table_value').append('<tr style="text-align: center;"><th>Product Name</th>'+
        '<th>Cost</th>'+
        '<th>Selling Price</th>'+
        '<th>Purchased Qty</th>'+
        '<th>Total Amount</th></tr>'
        );
        $.each(data.daily_report, function (key, value) {
          var amount = new Intl.NumberFormat().format(eval(value.amount) * eval(value.quantity));
          $('#table_value').append('<tr style="text-align: center;"><td>'+value.name+'</td>'+
          '<td>'+new Intl.NumberFormat().format(value.cost)+'</td>'+
          '<td>'+new Intl.NumberFormat().format(value.amount)+'</td>'+
          '<td>'+value.quantity+'</td>'+
          '<td>'+amount+'</td></tr>'
          );
        });
        $.each(data.total_daily, function (key, value) {
          $('#table_value').append('<tr style="text-align: center;"><td><b>TOTAL:</b></td>'+
          '<td></td>'+
          '<td> </td>'+
          '<td><b>Gross Income</b></td>'+
          '<td><b>'+new Intl.NumberFormat().format(value.sum_total)+'</b></td></tr>'
          );
          gross=value.sum_total;
        });
        $.each(data.total_cost, function (key, value) {
          $('#table_value').append('<tr style="text-align: center;"><td></td>'+
          '<td></td>'+
          '<td> </td>'+
          '<td><b>Total Expenses</b></td>'+
          '<td><b>'+new Intl.NumberFormat().format(value.cost_total)+'</b></td></tr>'
          );
          expenses=value.cost_total;
        });
        var net =gross-expenses;
        $('#table_value').append('<tr style="text-align: center;"><td></td>'+
        '<td></td>'+
        '<td> </td>'+
        '<td><b>Net Income</b></td>'+
        '<td style="color:red;"><b>₱ '+net+'</b></td></tr>'
        );

      }else{
        $('#table_value').append('<tr style="text-align: center;"><th>Product Name</th>'+
        '<th>Cost</th>'+
        '<th>Selling Price</th>'+
        '<th>Purchased Qty</th>'+
        '<th>Total Amount</th></tr>'
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

function getvalue() {
  myOutput=document.getElementById('daily_date');
  textbox = document.getElementById('c_id');

}


function monthly_show(){
  var expenses=0;
  var gross=0;
  var date = document.getElementById('month').value;
  var url = base_url + "admin/monthly_sales_reports/"+date;
  var data = $(this).serialize();
  $.ajax({
    url: url,
    type: "GET",
    dataType: "JSON",
    data: data,
    cache: false,
    processData: false,
    success: function (data) {
      $('#table2_value').empty();
      if(data.monthly_report){
        $('#table2_value').append('<tr style="text-align: center;"><th>Product Name</th>'+
        '<th>Cost</th>'+
        '<th>Selling Price</th>'+
        '<th>Purchased Qty</th>'+
        '<th>Total Amount</th></tr>'
        );
        $.each(data.monthly_report, function (key, value) {
          var amount = new Intl.NumberFormat().format(eval(value.amount) * eval(value.quantity));
          $('#table2_value').append('<tr style="text-align: center;"><td>'+value.name+'</td>'+
          '<td>'+new Intl.NumberFormat().format(value.cost)+'</td>'+
          '<td>'+new Intl.NumberFormat().format(value.amount)+'</td>'+
          '<td>'+value.quantity+'</td>'+
          '<td>'+amount+'</td></tr>'
          );
        });

        $.each(data.total_monthly, function (key, value) {
          $('#table2_value').append('<tr style="text-align: center;"><td><b>TOTAL:</b></td>'+
          '<td></td>'+
          '<td> </td>'+
          '<td><b>Gross Income</b></td>'+
          '<td><b>'+new Intl.NumberFormat().format(value.sum_total)+'</b></td></tr>'
          );
          gross=value.sum_total;
        });
        $.each(data.total_cost, function (key, value) {
          $('#table2_value').append('<tr style="text-align: center;"><td></td>'+
          '<td></td>'+
          '<td> </td>'+
          '<td><b>Total Expenses</b></td>'+
          '<td><b>'+new Intl.NumberFormat().format(value.cost_total)+'</b></td></tr>'
          );
          expenses=value.cost_total;
        });
        var net =gross-expenses;
        $('#table2_value').append('<tr style="text-align: center;"><td></td>'+
        '<td></td>'+
        '<td> </td>'+
        '<td><b>Net Income </b></td>'+
        '<td style="color:red;"><b>₱ '+net+'</b></td></tr>'
        );

      }else{
        $('#table2_value').append('<tr style="text-align: center;"><th>Product Name</th>'+
        '<th>Cost</th>'+
        '<th>Selling Price</th>'+
        '<th>Purchased Qty</th>'+
        '<th>Total Amount</th></tr>'
        );
        $('#table2_value').append('<tr style="text-align: center;"><td>No Datas Found</td>'+
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


function annual_show(){
  var expenses=0;
  var gross=0;
  var year = document.getElementById('annual_year').value;
  var url = base_url + "admin/yearly_sales_reports/"+year;
  var data = $(this).serialize();
  $.ajax({
    url: url,
    type: "GET",
    dataType: "JSON",
    data: data,
    cache: false,
    processData: false,
    success: function (data) {
      $('#table_value_annual').empty();
      if(data.yearly_report){
        $('#table_value_annual').append('<tr><th>Service #</th>'+
        '<th>Cost</th>'+
        '<th>Selling Price</th>'+
        '<th>Purchased Qty</th>'+
        '<th>Total Amount</th></tr>'
        );
        $.each(data.yearly_report, function (key, value) {
          var amount = new Intl.NumberFormat().format(eval(value.amount) * eval(value.quantity));
          $('#table_value_annual').append('<tr style="text-align: center;"><td>'+value.name+'</td>'+
          '<td>'+new Intl.NumberFormat().format(value.cost)+'</td>'+
          '<td>'+new Intl.NumberFormat().format(value.amount)+'</td>'+
          '<td>'+value.quantity+'</td>'+
          '<td>'+amount+'</td></tr>'
          );

        });
        $.each(data.total_year, function (key, value) {
          $('#table_value_annual').append('<tr style="text-align: center;"><td><b>TOTAL:</b></td>'+
          '<td></td>'+
          '<td> </td>'+
          '<td><b>Gross Income</b></td>'+
          '<td><b>'+new Intl.NumberFormat().format(value.sum_total)+'</b></td></tr>'
          );
          gross=value.sum_total;
        });
        $.each(data.total_cost_year, function (key, value) {
          $('#table_value_annual').append('<tr style="text-align: center;"><td></td>'+
          '<td></td>'+
          '<td> </td>'+
          '<td><b>Total Expenses</b></td>'+
          '<td><b>'+new Intl.NumberFormat().format(value.cost_total)+'</b></td></tr>'
          );
          expenses=value.cost_total;
        });
        var net =gross-expenses;
        $('#table_value_annual').append('<tr style="text-align: center;"><td></td>'+
        '<td></td>'+
        '<td> </td>'+
        '<td><b>Net Income:</b></td>'+
        '<td style="color:red;"><b>₱ '+net+'</b></td></tr>'
        );


      }else{
        $('#table_value_annual').append('<tr><th>Product Name</th>'+
        '<th>Cost</th>'+
        '<th>Selling Price</th>'+
        '<th>Purchased Qty</th>'+
        '<th>Total Amount</th></tr>'
        );
        $('#table_value_annual').append('<tr><td>No Datas Found</td>'+
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

</script>
