<!-- product info -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

  <?php if (empty($products)) {
    echo "<h2>No related produtc found!!!</h2>";
  } else {
    foreach($products as $pdt) { ?>
      <div class="col-xs-6 col-md-3 thumbnails">
        <article class="thumbnails">
          <a href="<?php echo $path."product_info.php?id=".$pdt->get_id(); ?>">
            <img src="<?php echo $pdt->get_image_info(); ?>" class="img-responsive" alt="Generic placeholder thumbnail">
          </a>
          <h5><?php echo $pdt->get_brand(); ?></h5>
          <a href="<?php echo $path."product_info.php?id=".$pdt->get_id(); ?>">
            <h4><?php echo $pdt->get_name(); ?></h4>
          </a>
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
              <button type="button" class="btn btn-xs btn-link">Previous
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
                <button type="button" class="btn btn-xs btn-link">Next
                </button>
              </a>
            </div>
        <?php } ?>
      <?php }
     } ?>
    
</div> <!-- main -->