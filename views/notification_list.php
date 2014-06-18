  <div class="container-fluid">
    <div class="row-fluid">
      <div class="col-sm-3 col-md-2 sidebar">
        <div class="well nav-sidebar">
          <h5><span class="glyphicon glyphicon-shopping-cart"></span> Notification</h5>
        </div>
      </div>

      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h1>Notification</h1>
        
        <?php if (empty($notifications)) {
          echo "<br><h4>There is no notification for you yet.</h4>";
        } else { ?>
        
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Date</th>
              <th>Title</th>
              <th>Status</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            
            <?php foreach ($notifications as $n) { ?>
            <tr>
              <td><?php echo $n->get_date(); ?></td>
              <td><a href="<?php echo $path; ?>notifications.php?id=<?php echo $n->get_id(); ?>"><?php echo $n->get_title(); ?></a></td>
              <td><span class="label label-<?php if ($n->get_isread_flag() == 't') {
                echo 'success';
              } else {
                echo 'warning';
              } ?>"><?php if ($n->get_isread_flag() == TRUE) {
                echo 'You have read this';
              } else {
                echo 'unread';
              } ?></span>
              
              <!-- delete -->
              <td>
                <div>
                  <form method="post" action="<?php echo $path; ?>notifications.php" accept-charset="UTF-8" class="form-horizontal" role="form">
                    <input type="hidden" name="type" value="delete">
                    <input type="hidden" name="id" id="id_<?php $n->get_id(); ?>" value="<?php echo $n->get_id(); ?>">
                    <button type="button" class="btn btn-danger btn-xs" onclick="delete_confirm(this.form);">
                      <span class="glyphicon glyphicon-trash"></span>
                    </button>
                  </form>
                </div> 
              </td>
            </tr>
            <?php } ?>
          
          </tbody>
        </table>
        
        <!-- paginations -->
        <?php if ($total_page_num > 1) {
          if ($current_page != 0) { ?>
            <div class="pull-right">
              <a href="<?php echo $path.'notifactions.php?page=' . ($current_page - 1); ?>">
                <button type="button" class="btn btn-xs btn-link">Previous</button>
              </a>
            </div>
          <?php }
           if ($currnt_page < $total_page_num - 1) { ?>
              <div class="pull-right">
                <a href="<?php echo $path.'notifactions.php?page=' . ($current_page + 1); ?>">
                  <button type="button" class="btn btn-xs btn-link">Next</button>
                </a>
              </div>
          <?php } ?>
        <?php } ?>
      <?php } ?>
        
      </div> <!-- main -->

    </div> <!-- row -->
  </div> <!-- container -->

