  <div class="container-fluid">
    <div class="row-fluid">
      <div class="col-sm-3 col-md-2 sidebar">
        <div class="well nav-sidebar">
          <h5><span class="glyphicon glyphicon-shopping-cart"></span> Order</h5>
        </div>
      </div>

      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h2>Order Items</h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Product</th>
              <th>Name</th>
              <th>Quantity</th>
            </tr>
          </thead>

          <tbody>
            <?php for ($i = 0; $i < count($order_items); $i++) { ?>

            <tr> <!-- each item -->
              <td style="vertical-align: middle"><img src="<?php echo $products[$i]->get_image_info(); ?>" width="90" class="img-responsive" alt="Product image"></td>
              <td style="vertical-align: middle"><?php echo $products[$i]->get_name();?></td>

              <td style="vertical-align: middle">
                <?php if ($order->get_status() != 'processing') {
                  echo $order_items[$i]->get_quantity();
                } else { ?>
                <form method="post" action="<?php echo $path; ?>orders.php" accept-charset="UTF-8" class="form-horizontal" role="form">  
                  <div class="col-xs-4">
                    <input type="hidden" name="type" value="update">
                    <input type="hidden" name="orderid" value="<?php echo $order->get_orderid(); ?>">
                    <input type="hidden" name="itemid" value="<?php echo $order_items[$i]->get_item_id(); ?>">
                    <select name="quantity" id="quantity_<?php echo $order_items[$i]->get_item_id();?>">
                      <?php for ($j = 1; $j <= 10; $j++) {?>
                        <option value="<?php echo $j; ?>" <?php if ($j == (int)$order_items[$i]->get_quantity()) {echo ' selected';}?>><?php echo $j; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </form>
                <?php } ?>
              </td>
            </tr>

            <?php } ?>
          </tbody>
        </table>

        <h2>Order Details</h2>

        <table class="table table-striped">
          <thead>
            <tr>
              <th>Order Date</th>
              <th>Name</th>
              <th>Flight</th>
              <th>Flight Date</th>
              <th>Seat</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php echo $order->get_booking_date(); ?></td>
              <td><?php echo $order->get_user_name(); ?></td>
              <td><?php echo $order->get_flight_no(); ?></td>
              <td><?php echo $order->get_flight_date(); ?></td>
              <td><?php if ($order->get_flight_seat() != '') {
                echo $order->get_flight_seat();
              } else {
                echo 'Not choose';
              } ?>
              </td>
              <td><span class="label label-<?php if ($order->get_status() == 'processing') {
                echo 'warning';
              } else {
                echo 'success';
              } ?>"><?php echo $order->get_status(); ?></span>
              </td>
            </tr>
          </tbody>
        </table>
        <h5><strong>Requirement</strong></h5>
        <div class="well">
          <p><?php if ($order->get_requirement() != '') {
            echo $order->get_requirement();
          } else {
            echo 'No extra requirement';
          } ?>
          </p>
        </div>
        
        <div>
          <?php if ($order->get_status() == 'processing') { ?>
          <div class="col-xs-3 pull-right">
            <form method="post" action="<?php echo $path; ?>orders.php" accept-charset="UTF-8" class="form-horizontal" role="form">
              <input type="hidden" name="type" value="edit_form">
              <input type="hidden" name="orderid" value="<?php echo $order->get_orderid(); ?>">
              <button type="submit" class="btn btn-primary btn-block">Edit</button>
            </form>
          </div>
          <?php } ?>
          
          <div class="col-xs-3 pull-right">
            <a href="<?php echo $path; ?>orders.php">
              <button type="button" class="btn btn-success btn-block">Back</button>
            </a>
          </div>
        </div>
      </div>

    </div> <!-- row -->
  </div> <!-- container -->
