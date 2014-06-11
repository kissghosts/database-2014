    <div class="container-fluid">
      <div class="row-fluid">
        <div class="col-sm-3 col-md-2 sidebar">
          <div class="well nav-sidebar">
            <h5><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart</h5>
          </div>
        </div>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1>Current Shopping Cart</h1>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Product</th>
                <th>Brand</th>
                <th>Quantity</th>
                <th>Delete</th>
              </tr>
            </thead>
            
            <tbody>
              <?php for ($i = 0; $i < count($cart_items); $i++) { ?>
              
              <tr>
                <td><?php echo $products[$i]->get_name();?></td>
                <td><?php echo $products[$i]->get_brand();?></td>
                <td>
                  <div class="col-xs-4">
                    <input type="text" class="form-control input-sm" value="<?php echo $cart_items[$i]->get_quantity();?>">
                  </div>
                </td>
                <td><div class="col-xs-2">
                  <button type="button" class="btn btn-link btn-xs">
                    <span class="glyphicon glyphicon-trash"> </span>
                  </button></div>
                </td>
              </tr>
              
              <?php } ?>
              
            </tbody>
          </table>

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
          
          <br><br>
          <form action="checkout.html">
            <div class="col-xs-3 pull-right">
              <button type="submit" class="btn btn-primary btn-block">
                Checkout
              </button>
            </div>
          </form>

          <div class="col-xs-3 pull-right">
            <button type="button" class="btn btn-info btn-block">
              Continue shopping
            </button>
          </div>
        </div>

      </div>
    </div> <!-- container -->
