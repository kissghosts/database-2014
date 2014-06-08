<!-- category info -->
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
