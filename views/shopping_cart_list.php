  
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="col-sm-3 col-md-2 sidebar">
        <div class="well nav-sidebar">
          <h5><span class="glyphicon glyphicon-shopping-cart"></span>Shopping Cart</h5>
        </div>
      </div>

      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h1>Current Shopping Cart</h1>
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

            <tr>
              <td style="vertical-align: middle"><img src="<?php echo $products[$i]->get_image_info(); ?>" width="90" class="img-responsive" alt="Product image"></td>
              <td style="vertical-align: middle"><?php echo $products[$i]->get_name();?></td>
              <td style="vertical-align: middle">
                <div class="col-xs-4">
                  <input type="text" class="form-control input-sm" value="<?php echo $cart_items[$i]->get_quantity();?>">
                </div>
              </td>
              <td style="vertical-align: middle"><div class="col-xs-2">
                <button type="button" class="btn btn-link btn-xs">
                  <span class="glyphicon glyphicon-trash"></span>
                </button></div>
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
        <form action="checkout.html">
          <div class="col-xs-3 pull-right">
            <button type="submit" class="btn btn-primary btn-block">
              Checkout
            </button>
          </div>
        </form>

        <div class="col-xs-3 pull-right">
          <a href="<?php echo $path; ?>index.php">
            <button type="button" class="btn btn-info btn-block">
              Continue shopping
            </button>
          </a>
        </div>
      </div>

    </div>
  </div> <!-- container -->
