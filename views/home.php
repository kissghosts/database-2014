<?php
  require_once('../lib/view_components.php');

  session_start();
  gen_html_header('Shopping Cart', '../');
  gen_navbar("../");
?>
    
<div class="container-fluid">
  <div class="row-fluid">
    <?php gen_product_sidebar(); ?>
  </div>
</div>

<?php
gen_footer_with_form_hash('../');

?>   
