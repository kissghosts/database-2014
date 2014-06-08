<div class="container col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
  <h1>Add New Product</h1>
  <form method="post" action="<?php echo $path; ?>product_management.php" accept-charset="UTF-8" class="form-horizontal" role="form">
    <fieldset>
      <!-- Form Name -->
      <legend></legend>

      <input type="hidden" name="type" value="add">

      <div class="form-group row">
        <label class="col-sm-2 control-label" for="textinput">Name</label>
        <div class="col-sm-5">
          <input type="name" class="form-control" id="name" name="name" required>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-2 control-label" for="textinput">Brand</label>
        <div class="col-sm-4">
          <input type="name" class="form-control" id="brand" name="brand" required>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-2 control-label" for="textinput">Category</label>
        <div class="col-sm-4">
          <input type="name" class="form-control" id="category" name="category" required>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-2 control-label" for="textinput">Price</label>
        <div class="col-sm-4">
          <input type="number" step="any" class="form-control" id="price" name="price" required>
        </div>
      </div>

      <!-- Text input-->
      <div class="form-group row">
        <label class="col-sm-2 control-label" for="textinput">Image Link</label>
        <div class="col-sm-6">
          <input type="url" placeholder="Link to the product image" class="form-control" id="imagelink" name="imagelink" required>
          <br>
          <div class="alert alert-info">
            <strong>Note: </strong> image size
          </div>
        </div>
      </div>

      <div class="form-group row ">                
        <label class="col-sm-2 control-label" for="textinput">Description</label>
        <div class="col-sm-6">
          <textarea id="description" name="description" class="form-control" placeholder="Production description" required></textarea>
        </div>
      </div>

      <div>
        <div class="col-xs-3 pull-right">
          <button type="submit" class="btn btn-primary btn-block">
            Add
          </button>
        </div>
      </div>

    </fieldset>

</div> <!-- /container -->
