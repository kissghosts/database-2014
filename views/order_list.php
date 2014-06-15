  <div class="container-fluid">
    <div class="row-fluid">
      <div class="col-sm-3 col-md-2 sidebar">
        <div class="well nav-sidebar">
          <h5><span class="glyphicon glyphicon-shopping-cart"></span> Order Management</h5>
        </div>
      </div>

      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h1>Orders</h1>
        
        <?php if (empty($orders)) {
          echo "<br><h4>You have no order.</h4>";
        } else { ?>
        
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Order Date</th>
              <th>Flight</th>
              <th>Flight Date</th>
              <th>Status</th>
              <th>Details/Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            
            <?php foreach ($orders as $order) { ?>
            <tr>
              <td><?php echo $order->get_booking_date(); ?></td>
              <td><?php echo $order->get_flight_no(); ?></td>
              <td><?php echo $order->get_flight_date(); ?></td>
              <td><span class="label label-<?php if ($order->get_status() == 'processing') {
                echo 'warning';
              } else {
                echo 'success';
              } ?>"><?php echo $order->get_status(); ?></span>
              
              <!-- view/edit -->
              <td>
                <div>
                  <form method="post" action="<?php echo $path; ?>orders.php" accept-charset="UTF-8" class="form-horizontal" role="form">
                    <input type="hidden" name="type" value="view">
                    <input type="hidden" name="orderid" id="orderid_<?php $order->get_orderid(); ?>" value="<?php echo $order->get_orderid(); ?>">
                    <button type="submit" class="btn btn-primary btn-xs">
                      <span class="glyphicon glyphicon-pencil"></span>
                    </button>
                  </form>
                </div>
              </td>
               
              <!-- delete -->
              <td>
                <div>
                  <form method="post" action="<?php echo $path; ?>orders.php" accept-charset="UTF-8" class="form-horizontal" role="form">
                    <input type="hidden" name="type" value="delete">
                    <input type="hidden" name="orderid" id="orderid_<?php $order->get_orderid(); ?>" value="<?php echo $order->get_orderid(); ?>">
                    <button type="button" class="btn btn-danger btn-xs" onclick="delete_confirm(this.form);">
                      <span class="glyphicon glyphicon-trash"></span>
                    </button>
                  </form>
                </div> 
              </td>
            </tr>
            <?php } ?>
          
          </tbody>
        </table>
        
        <!-- paginations -->
        <?php if ($total_page_num > 1) {
          if ($current_page != 0) { ?>
            <div class="pull-right">
              <a href="<?php echo $path.'orders.php?page=' . ($current_page - 1); ?>">
                <button type="button" class="btn btn-xs btn-link">Previous</button>
              </a>
            </div>
          <?php }
           if ($currnt_page < $total_page_num - 1) { ?>
              <div class="pull-right">
                <a href="<?php echo $path.'orders.php?page=' . ($current_page + 1); ?>">
                  <button type="button" class="btn btn-xs btn-link">Next</button>
                </a>
              </div>
          <?php } ?>
        <?php } ?>
      <?php } ?>
        
      </div> <!-- main -->

    </div> <!-- row -->
  </div> <!-- container -->
