<!-- category info -->
<div class="container-fluid">
  <div class="row-fluid">
    <div class="col-sm-3 col-md-2 sidebar">
      <div class="well nav-sidebar">
        <ul class="nav nav-list">
          <li class="nav-header">Product Categories</li>
          <?php 
            foreach($categories as $c) { ?>
              <li><a href="<?php echo $path."index.php?category=".$c[0]; ?>">
                <?php echo $c[0]; ?></a>
              </li>
          <?php
            }
          ?>
        </ul>
      </div>
    </div>
    
    <!-- product info -->
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      
      <?php foreach($products as $pdt) { ?>
      <div class="col-xs-6 col-md-3 thumbnails">
        <article class="thumbnails">
          <a href="#">
            <img src="<?php echo $pdt->get_image_info(); ?>" class="img-responsive" alt="Generic placeholder thumbnail">
          </a>
          <h5><?php echo $pdt->get_brand(); ?></h5>
          <a href="#"><h4><?php echo $pdt->get_name(); ?></h4></a>
          <span class="text-muted">€<?php echo $pdt->get_price(); ?></span>
        </article>
      </div>
      <?php } ?>
    
      <!-- paginations -->
      <?php if ($total_page_num > 1) {
        if ($current_page != 0) { ?>
          <div class="pull-right">
            <a href="<?php
              if (isset($category)) {
                $link = "index.php?category=" . $category . "?page=" . ($current_page - 1);
              } else {
                $link = "index.php?page=" . ($current_page - 1);
              }
              echo $path . $link; ?>">
              <button type="button" class="btn btn-xs btn-default">Previous
              </button>
            </a>
          </div>
        <?php } 
          if ($currnt_page < $total_page_num - 1) { ?>
            <div class="pull-right">
              <a href="<?php
                if (isset($category)) {
                  $link = "index.php?category=" . $category . "?page=" . ($current_page + 1);
                } else {
                  $link = "index.php?page=" . ($current_page + 1);
                }
                echo $path . $link; ?>">
                <button type="button" class="btn btn-xs btn-default">Next
                </button>
              </a>
            </div>
        <?php } ?>
      <?php } ?>
    
    </div> <!-- main -->
    
  </div>
</div>
