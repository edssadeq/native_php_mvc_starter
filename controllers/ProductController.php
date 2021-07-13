<?php


namespace app\controllers;
use app\models\Product as Product;

class ProductController
{
	
	public function index($router)
	{
		$search = isset($_GET['search_string'])? $_GET['search_string'] : '';

		$productsList = $router->db->getProducts($search);
		$router->renderView("products/index", ['products'=>$productsList, 'search'=>$search]); //passing productsList

	}


	public function create($router)
	{
		$product = [
			'prod_title' => '',
			'prod_price' => '',
			'prod_description' => '',
			'prod_image' => '',
		];
		$form_errors = [];

		if($_SERVER['REQUEST_METHOD'] === "POST"){
			$product['prod_title'] = $_POST['prod_title'];
			$product['prod_description'] = $_POST['prod_description'];
			$product['prod_price'] = $_POST['prod_price'];
			//$product['prod_image'] = $_POST['prod_image'];
			$product['imageFile'] = isset($_FILES['prod_image']) ? $_FILES['prod_image'] : null;


			$prodInst = new Product();
			$prodInst->load($product);
			$form_errors = $prodInst->save();
			if(empty($form_errors)){
				//insert to db
				$router->db->insertProduct($prodInst);
				header("Location: /products");
				exit;
			}
		}

		$router->renderView("products/create", ['product'=> $product, 'form_errors'=> $form_errors]);
	}


	public function update($router)
	{
		$product = [
			'prod_title' => '',
			'prod_price' => '',
			'prod_description' => '',
			'prod_image' => '',
		];
		$form_errors = [];
		
		if(!$_GET['prod_id']){ 
			header("Location: /products"); 
			exit; 
		}

		$prodToUpdate = $router->db->getProductById($_GET['prod_id']);

		if(!$prodToUpdate){
			$form_errors[] = "Product not found, try to create one ! <a href='/products/create'><b>CREATE</b></a>";
		}

		if($_SERVER['REQUEST_METHOD'] === "POST"){
			$product['prod_title'] = $_POST['prod_title'];
			$product['prod_description'] = $_POST['prod_description'];
			$product['prod_price'] = $_POST['prod_price'];
			$product['prod_image'] = $prodToUpdate['prod_image'];
			$product['imageFile'] = isset($_FILES['prod_image']) ? $_FILES['prod_image'] : null;


			$prodInst = new Product();
			$prodInst->load($product);
			$form_errors = $prodInst->save();
			if(empty($form_errors)){
				//insert to db
				$router->db->updateProduct($_GET['prod_id'], $prodInst);
				header("Location: /products");
				exit;
			}
		}


		$router->renderView("products/update", ['product'=> $prodToUpdate, 'form_errors'=> $form_errors]);
	}


	public function delete($router)
	{
		if(!$_POST['prod_id']){
			header("Location: /products");
			exit;
		}

		//delete it
		$router->db->deleteProduct($_POST['prod_id']);
		header("Location: /products");


	}

}