<?php if($form_errors): ?>
  <div class="alert alert-danger" role="alert">
    <?php foreach ($form_errors as $error):?>
      <div class="">
        <?= $error ?>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
<form action="" method="post" enctype="multipart/form-data">
  <div class="mb-3">
    <label for="title" class="form-label">Product title</label>
    <input type="text" class="form-control" id="title" name="prod_title" value="<?= $product['prod_title']?>">
  </div>

  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="price" class="form-label">Product price</label>
        <input type="number" class="form-control" step=".01" id="price" name="prod_price" value="<?= $product['prod_price']?>">
      </div>
    </div>

    <div class="col">
      <div class="mb-3">
        <label for="image" class="form-label">Product image</label>
        <input type="file" class="form-control" id="image" name="prod_image" value="">
      </div>
    </div>
  </div>

  <div class="mb-3">
    <label for="desc" class="form-label">Product description</label>
    <!-- <input type="text" class="form-control" id="desc"> -->
    <textarea  rows="8" cols="80" class="form-control" name="prod_description" value="<?= $product['prod_description']?>"></textarea>
  </div>


  <button type="submit" class="btn btn-primary ">
    <?php if(!empty($product['prod_title'])):?>  <!-- test if there is info about product, so we have the update -->
      Update
    <?php else :?>
      Create
    <?php endif;?>  
  </button>
</form>
