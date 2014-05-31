<?php

require_once($path . 'lib/view_components.php');

?>

<div class="container-fluid">
  <div class="row-fluid">
    <div class="col-sm-3 col-md-2 sidebar">
      <div class="well nav-sidebar">
        <ul class="nav nav-list">
          <li class="nav-header">Product Categories</li>
          <?php get_all_categories()?>
        </ul>
      </div>
    </div>
    
    <!-- product info will be added later -->
    
  </div>
</div>
