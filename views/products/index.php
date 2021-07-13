  
    <div class="container">
        <h1>Products List</h1>
        <p>
          <a href="products/create" class="btn btn-dark text-light">Create Product</a>
        </p>
        <div class="row">
          <div class="mb-5 mt-5 col-6">
            <form class="" action="" method="get">
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search a product" name="search_string" aria-describedby="button-addon2" value="<?= $search ?>">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                  <i data-feather="search"></i>
                </button>
              </div>
            </form>
          </div>
        </div>

      <?php if(!$products):?>
          <div class="alert alert-info" role="alert">No product found!</div>
      <?php endif; ?>

      <table class="table">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Image</th>
              <th scope="col">Title</th>
              <!-- <th scope="col">Description</th> -->
              <th scope="col">Date</th>
              <th scope="col">Price</th>
              <td scope="col">Edit/Delete</td>
            </tr>
          </thead>
          <tbody>

            <?php
                foreach ($products as $prod) :?>
                  <tr>
                    <th scope="row"><?=$prod['prod_id'] ?></th>
                    <td><img src="<?=$prod['prod_image'] ?>" class='prod_image'></td>
                    <td><?=$prod['prod_title'] ?></td>
                    <!-- <td><?=$prod['prod_description'] ?></td> -->
                    <td><?=$prod['prod_createdAt'] ?></td>
                    <th scope="row"><?=$prod['prod_price'] ?></th>
                    <td>
                      <a href="products/update?prod_id=<?=$prod['prod_id'] ?>" class="btn btn-sm btn-outline-primary">
                      	<i data-feather="edit"></i>
                      </a>
                      <form  action="products/delete" method="post" style="display: inline-block;">
                        <input type="hidden" name="prod_id" value="<?=$prod['prod_id'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                        	<i data-feather="delete"></i>
                        </button>
                      </form>
                    </td>
                  </tr>

            <?php endforeach;
             ?>

          </tbody>
        </table>
    </div>