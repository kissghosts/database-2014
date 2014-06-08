<div class="container col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
  
  <?php if ($product->contains_error_attribute()) { ?>
    <br>
    <div class="alert alert-danger">
      <?php echo "<strong>Input Error: </strong>";
      foreach($product->get_error_array() as $error) {
        echo "$error <br>";
      } ?>
    </div>
  <?php } ?>
  
  <br>
  <div>
    <h1><?php echo $title; ?></h1>
    <form method="post" action="<?php echo $path; ?>product_management.php" accept-charset="UTF-8" class="form-horizontal" role="form">
      <fieldset>
        <!-- Form Name -->
        <legend></legend>

        <input type="hidden" name="type" value="<?php echo $type; ?>">
        
        <?php if ($type = 'edit') { ?>
          <input type="hidden" name="id" value="<?php echo $product->get_id(); ?>">
        <?php } ?>

        <div class="form-group row">
          <label class="col-sm-2 control-label" for="textinput">Name</label>
          <div class="col-sm-5">
            <input type="name" class="form-control" id="name" name="name" value="<?php echo $product->get_name(); ?>" required>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-2 control-label" for="textinput">Brand</label>
          <div class="col-sm-4">
            <input type="name" class="form-control" id="brand" name="brand" value="<?php echo $product->get_brand(); ?>" required>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-2 control-label" for="textinput">Category</label>
          <div class="col-sm-4">
            <input type="name" class="form-control" id="category" name="category" value="<?php echo $product->get_category(); ?>" required>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-2 control-label" for="textinput">Price</label>
          <div class="col-sm-4">
            <input type="number" step="any" class="form-control" id="price" name="price" value="<?php echo $product->get_price(); ?>" required>
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group row">
          <label class="col-sm-2 control-label" for="textinput">Image Link</label>
          <div class="col-sm-6">
            <input type="url" placeholder="Link to the product image" class="form-control" id="imagelink" name="imagelink" value="<?php echo $product->get_image_info(); ?>" required>
          </div>
          <br><br><br>
          <div class="alert alert-info">
            <strong>Note: </strong> currently this system can not handle pictures 
            in different image sizes well, so I recommend you to choose this url for 
            testing: <br>
            http://www.preordershop.fi/docroot/img/tuotekuvat/506_2013_XL.jpg
          </div>
        </div>

        <div class="form-group row ">                
          <label class="col-sm-2 control-label" for="textinput">Description</label>
          <div class="col-sm-6">
            <textarea id="description" name="description" class="form-control" placeholder="Production description" required><?php echo $product->get_description(); ?></textarea>
          </div>
        </div>

        <div>
          <div class="col-xs-3 pull-right">
            <button type="submit" class="btn btn-primary btn-block"><?php echo $button; ?></button>
          </div>
        </div>

      </fieldset>
    </form>
  </div>
</div> <!-- /container -->
