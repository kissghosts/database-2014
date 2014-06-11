  <div class="container-fluid">
    <div class="row-fluid">
      <div class="col-sm-3 col-md-2 sidebar">
        <div class="well nav-sidebar">
          <h5><span class="glyphicon glyphicon-shopping-cart"></span>Shopping Cart</h5>
        </div>
      </div>

      <div class="col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main">
        <h1>Order Details</h1>

        <form class="form-horizontal" role="form">
          <fieldset>

            <!-- Form Name -->
            <legend></legend>

            <!-- Text input-->
            <div class="form-group">
              <label class="col-sm-2 control-label" for="textinput">Customer Name</label>
              <div class="col-sm-5">
                <input type="text" placeholder="Firstname Surname" class="form-control">
              </div>
            </div>

            <!-- Text input-->
            <div class="form-group row">
              <label class="col-sm-2 control-label" for="textinput">Flight Number</label>
              <div class="col-sm-4">
                <input type="text" placeholder="Flight Number" class="form-control">
              </div>

              <label class="col-sm-2 control-label" for="textinput">Flight Date</label>
              <div class="col-sm-4">
                <input type="text" placeholder="yyyy-mm-dd" class="form-control">
              </div>
            </div>

            <div class="form-group row">                
              <label class="col-sm-2 control-label" for="textinput">Seat Number</label>
              <div class="col-sm-4">
                <input type="text" placeholder="Seat Number" class="form-control">
              </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
              <label class="col-sm-2 control-label" for="textinput">Other Requirements</label>
              <div class="col-sm-10">
                <textarea id="requirements" name="requirements" class="form-control" placeholder="Other requirements, e.g. meal reservation, payment methods" required></textarea>
              </div>
            </div>
            <br>

            <div>
              <div class="col-xs-3 pull-right">
                <button type="submit" class="btn btn-primary btn-block">
                  Submit
                </button>
              </div>

              <div class="col-xs-3 pull-right">
                <button type="submit" class="btn btn-default btn-block">
                  Cancel
                </button>
              </div>
            </div>

          </fieldset>
        </form>
      </div>

    </div> <!-- row -->
  </div> <!-- container -->
