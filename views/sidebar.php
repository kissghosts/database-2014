<!-- category info -->
<div class="col-sm-3 col-md-2 sidebar">
  <div class="well nav-sidebar">
    <ul class="nav nav-pills nav-stacked">
      <li class="nav-header">Product Categories</a></li>
      <?php foreach($categories as $c) { ?>
      <li<?php if (isset($category) && $category == $c[0]) {echo " class=\"active\"";}?>>
        <a href="<?php echo $path."index.php?category=".$c[0]; ?>"><?php echo $c[0]; ?></a>
      </li>
      <?php } ?>
    </ul>
  </div>
</div>
