  <div class="container-fluid">
    <div class="row-fluid">
      <div class="col-sm-3 col-md-2 sidebar">
        <div class="well nav-sidebar">
          <h5><span class="glyphicon glyphicon-shopping-cart"></span>Shopping Cart</h5>
        </div>
      </div>

      <div class="col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main">
        <!-- input error message -->
        <?php if (isset($order) && $order->contains_error_attribute()) { ?>
          <br>
          <div class="alert alert-danger">
            <?php echo "<strong>Input Error: </strong>";
            foreach($order->get_error_array() as $error) {
              echo "$error <br>";
            } ?>
          </div>
        <?php } ?>
        
        <h1>Order Details</h1>

        <form class="form-horizontal" role="form" method="post" action="<?php echo $path; ?>order.php" accept-charset="UTF-8">
          <fieldset>

            <!-- Form Name -->
            <legend></legend>

            <!-- Text input-->
            <div class="form-group">
              <label class="col-sm-2 control-label" for="textinput">Customer Name</label>
              <div class="col-sm-5">
                <input type="text" name="username" placeholder="Firstname Surname" class="form-control" value="<?php 
                  if (isset($order)) {
                    echo $order->get_user_name();
                  } elseif (isset($user_name)) {
                    echo $user_name;
                  } ?>" required>
              </div>
            </div>

            <!-- Text input-->
            <div class="form-group row">
              <label class="col-sm-2 control-label" for="textinput">Flight Number</label>
              <div class="col-sm-4">
                <input type="text" name="flightno" placeholder="Flight Number" class="form-control" value="<?php if (isset($order)) {echo $order->get_flight_no();}?>" required>
              </div>

              <label class="col-sm-2 control-label" for="textinput">Flight Date</label>
              <div class="col-sm-4">
                <input type="text" name="flightdate" placeholder="yyyy-mm-dd" class="form-control" value="<?php if (isset($order)) {echo $order->get_flight_date();}?>" required>
              </div>
            </div>

            <div class="form-group row">                
              <label class="col-sm-2 control-label" for="textinput">Seat Number</label>
              <div class="col-sm-4">
                <input type="text" name="flightseat" placeholder="If you don't have your seat number yet, just leave this empty" class="form-control" value="<?php if (isset($order) && $order->get_flight_seat() != 'NULL') {echo $order->get_flight_seat();}?>">
              </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
              <label class="col-sm-2 control-label" for="textinput">Other Requirements</label>
              <div class="col-sm-10">
                <textarea id="requirements" name="requirement" class="form-control" placeholder="Other requirements, e.g. meal reservation, payment methods"><?php if (isset($order)) {echo $order->get_requirement();}?></textarea>
              </div>
            </div>
            <br>

            <div>
              <div class="col-xs-3 pull-right">
                <button type="submit" name="type" value="add" class="btn btn-primary btn-block">
                  Submit
                </button>
              </div>

              <div class="col-xs-3 pull-right">
                <button type="submit" name="type" value="cancel" class="btn btn-default btn-block">
                  Cancel
                </button>
              </div>
            </div>

          </fieldset>
        </form>
      </div>

    </div> <!-- row -->
  </div> <!-- container -->
