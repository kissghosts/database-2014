  <div class="container-fluid">
    <div class="row-fluid">
      <div class="col-sm-3 col-md-2 sidebar">
        <div class="well nav-sidebar">
          <h5><span class="glyphicon glyphicon-shopping-cart"></span> Notification</h5>
        </div>
      </div>


      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <br>
        <h3><?php echo $notification->get_title(); ?></h3>
        <br>
        <h4>Message</h4>
        <p><?php echo $notification->get_message(); ?></p>

        <div class="col-md-3 pull-right">
          <a href="<?php echo $path; ?>notifications.php">
            <button type="button" class="btn btn-primary btn-block">
              Back
            </button>
          </a>
        </div>
      </div> <!-- main -->
      
    </div> <!-- row -->
  </div> <!-- container -->