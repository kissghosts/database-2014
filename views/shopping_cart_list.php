  
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="col-sm-3 col-md-2 sidebar">
        <div class="well nav-sidebar">
          <h5><span class="glyphicon glyphicon-shopping-cart"></span>Shopping Cart</h5>
        </div>
      </div>

      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h1>Current Shopping Cart</h1>
        <?php if (count($cart_items) > 0) { ?>
        
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Product</th>
              <th>Name</th>
              <th>Quantity</th>
              <th>Delete</th>
            </tr>
          </thead>

          <tbody>
            <?php for ($i = 0; $i < count($cart_items); $i++) { ?>

            <tr> <!-- each item -->
              <td style="vertical-align: middle"><img src="<?php echo $products[$i]->get_image_info(); ?>" width="90" class="img-responsive" alt="Product image"></td>
              <td style="vertical-align: middle"><?php echo $products[$i]->get_name();?></td>
              
              <td style="vertical-align: middle">
                <form method="post" action="<?php echo $path; ?>shopping_cart.php" accept-charset="UTF-8" class="form-horizontal" role="form">  
                  <div class="col-xs-4">
                    <input type="hidden" name="type" value="update">
                    <input type="hidden" name="itemid" id="itemid" value="<?php echo $cart_items[$i]->get_item_id(); ?>">
                    <select name="quantity" id="quantity_<?php echo $cart_items[$i]->get_item_id();?>">
                      <?php for ($j = 1; $j <= 10; $j++) {?>
                        <option value="<?php echo $j; ?>" <?php if ($j == (int)$cart_items[$i]->get_quantity()) {echo ' selected';}?>><?php echo $j; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </form>
              </td>
                  
              <td style="vertical-align: middle">
                <div class="col-xs-2">
                  <form method="post" action="<?php echo $path; ?>shopping_cart.php" accept-charset="UTF-8" class="form-horizontal" role="form">
                    <input type="hidden" name="type" value="delete">
                    <input type="hidden" name="itemid" id="itemid" value="<?php echo $cart_items[$i]->get_item_id(); ?>">
                    <button type="submit" class="btn btn-link btn-xs">
                      <span class="glyphicon glyphicon-trash"></span>
                    </button>
                  </form>
                 </div>
              </td>
            </tr>

            <?php } ?>

          </tbody>
        </table>
        <br>

        <!-- paginations -->
        <?php if ($total_page_num > 1) {
          if ($current_page != 0) { ?>
            <div class="pull-right">
              <a href="<?php echo $path.'shopping_cart.php?page=' . ($current_page - 1); ?>">
                <button type="button" class="btn btn-xs btn-link">Previous</button>
              </a>
            </div>
          <?php }
           if ($currnt_page < $total_page_num - 1) { ?>
              <div class="pull-right">
                <a href="<?php echo $path.'shopping_cart.php?page=' . ($current_page + 1); ?>">
                  <button type="button" class="btn btn-xs btn-link">Next</button>
                </a>
              </div>
          <?php } ?>
        <?php } ?>

        <br>
        <div class="col-xs-3 pull-right">
          <a href="<?php echo $path; ?>checkout.php">
            <button type="button" class="btn btn-primary btn-block">
              Checkout
            </button>
          </a>
        </div>

        <div class="col-xs-3 pull-right">
          <a href="<?php echo $path; ?>index.php">
            <button type="button" class="btn btn-info btn-block">
              Continue shopping
            </button>
          </a>
        </div>
        <?php } else { ?>
        <br>
        <h4>Your shopping cart is empty now!</h4>
        <?php } ?>
        
      </div> <!-- main body -->

    </div>
  </div> <!-- container -->
