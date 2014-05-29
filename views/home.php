<?php
  require_once('../lib/view_components.php');

  gen_html_header('Shopping Cart', '../');
  gen_navbar("../");
?>
    
<div class="container-fluid">
  <div class="row-fluid">
    <?php gen_product_sidebar(); ?>
  </div>
</div>

<?php
  gen_footer('../');

?>   
