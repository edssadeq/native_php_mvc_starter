<?php

namespace app;
use \PDO as PDO;

require_once "_CONSTANTS.php";
/**
 * 
 */
class Database
{
	// //db config contants

	// define('HOST','localhost');
	// define('PORT',3306);
	// define('DBNAME','products_crud');

	// define('USER','root');
	// define('PASSWORD','');

	// //db components contants
	// define('TABLENAME','product');
	

	public $pdo = null;
	// private $db = null;

	public function __construct()
	{
		$SDNSTRING = "mysql:host=".HOST."; post=".PORT."; dbname=".DBNAME."";
		$this->pdo = new PDO($SDNSTRING, USER, PASSWORD);
		//the backslash talls the engine that this PDO is in absolute namespace and not a member of this (app),
		//or just use (use \PDO as PDO;)

		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	// public static function getPDO()
	// {
	// 	if($pdo == null){
	// 		//$this->db = new Database();
	// 		self::__construct();
	// 	}
	// 	return $this->pdo;
	// }


	public function getProducts($strSearch='')
	{
		if($strSearch){ return $this->searchProducts($strSearch);}
		else{ return $this->getAllProducts();}
	}

	public function insertProduct($product){

		$insertQuery = "INSERT INTO product (prod_title, prod_description, prod_image, prod_price, prod_createdAt) VALUES (:title, :descr, :image, :price, :dateC)";
    $statement = $this->pdo->prepare($insertQuery);
    //binding data with named params
    $statement->bindValue(":title", $product->prodTitle);
    $statement->bindValue(":descr", $product->prodDescription);
    $statement->bindValue(":image", $product->prodImage);
    $statement->bindValue(":price", $product->prodPrice);
    $statement->bindValue(":dateC", $product->prodCreationDate);
    $statement->execute();
	}


	public function getProductById($id){
	 	$select_prod_query = "SELECT * FROM product WHERE prod_id = :id";
    $statement = $this->pdo->prepare($select_prod_query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $prod = $statement->fetch(PDO::FETCH_ASSOC);
    return $prod;
	}

	public function updateProduct($id, $updatedProduct){
		//update
    $updateQuery = "UPDATE product SET prod_title= :title, prod_description= :descr, prod_image= :image, prod_price= :price WHERE prod_id= :id";
    $statement = $this->pdo->prepare($updateQuery);
    //binding data with named params
    $statement->bindValue(":id", $id);
    $statement->bindValue(":title", $updatedProduct->prodTitle);
    $statement->bindValue(":descr", $updatedProduct->prodDescription);
    $statement->bindValue(":image", $updatedProduct->prodImage);
    $statement->bindValue(":price", $updatedProduct->prodPrice);
    return $statement->execute();
	}

	public function deleteProduct($id){
		$query = "DELETE FROM product WHERE prod_id=:id";
  	$statement = $this->pdo->prepare($query);
  	$statement->bindValue(':id', $id);
  	return $statement->execute();
	}


	private function getAllProducts()
	{
		 //get data
	  $statement = $this->pdo->prepare("SELECT * FROM product ORDER BY prod_createdAt DESC");
	  $statement->execute();
	  $products = $statement->fetchAll(PDO::FETCH_ASSOC);
	  return $products;

	}

	private function searchProducts($search_string)
	{
	  $search = "%$search_string%";
      $sql_search = "SELECT * FROM product
                    WHERE prod_title LIKE :search";
      $statement = $this->pdo->prepare($sql_search);
      $statement->bindValue(":search", $search);
      $statement->execute();
      $products = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $products;
	}


}