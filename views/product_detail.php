<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <div class="col-xs-6 col-md-4">
    <img src="<?php echo $product->get_image_info(); ?>" class="img-responsive" alt="Generic placeholder thumbnail">
  </div>

  <div class="col-md-8">
    <br>
    <h5><?php echo $product->get_brand(); ?></h5>
    <h3><?php echo $product->get_name(); ?></h3>
    <h4><span class="text-muted">€<?php echo $product->get_price(); ?></span><h4>
    <br>
    <?php if (isset($_SESSION['valid_user'])) { ?>
      <div class="btn-group">
        <button type="button" class="btn btn-primary">Add to Cart
        </button>
      </div>
      <br>
    <?php } ?>
  </div>

  <div class="col-md-8">
    <br>
    <h4>Description</h4>
    <p><?php echo $product->get_description(); ?></p>
    
    <?php if (isset($_SESSION['staff_user'])) { ?>
      <div class="col-xs-3 pull-right">
        <button type="button" class="btn btn-primary btn-block">
          Edit
        </button>
      </div>

      <div class="col-xs-3 pull-right">
        <button type="button" class="btn btn-danger btn-block">
          Delete
        </button>
      </div>
    <?php } ?>
  </div>

</div>