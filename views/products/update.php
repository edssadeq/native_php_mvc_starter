<div class="container mt-5">
  <p>
    <a href="/products" class="btn btn-primary"> <i data-feather="arrow-left"></i> back to product list</a>
  </p>
	<h1>Update Product <b>[<?= $product['prod_title'] ?>]</b></h1>
	<?php if($product['prod_image']){ ?>
          <div style="width: 250px">
            <img src="../<?= $product['prod_image'] ?>" class="rounded" alt="..." style="width: 100%">
          </div>
        <?php }else{?>
          <div class="alert alert-info" role="alert">This product does not have an image!</div>
        <?php } ?>
	<?php include_once __DIR__."/_form.php" ?>
</div>