<?php


namespace app;

class Router
{
	
	public  $getRoutes = [];
	public  $postRoutes = [];
	public $db;

	public function __construct()
	{
		$this->db = new Database();
	
	}

	public function get($url, $function){
		$this->getRoutes[$url]=$function;
	}

	public function post($url, $function){
		$this->postRoutes[$url]=$function;
	}

	public function resolve(){
		//using $_SERVER to findout request 
		//REQUEST_URI // shows query strings
		//REQUEST_METHOD 
		//PATH_INFO //does not show query strings

		//take the path uri
		//getting only what is before ? question mark of query string
		$queryStringPosition = strpos($_SERVER['REQUEST_URI'], "?");
		$pathURL = $queryStringPosition ? substr($_SERVER['REQUEST_URI'], 0, $queryStringPosition) : $_SERVER['REQUEST_URI'];
		$currentURL = $_SERVER['REQUEST_URI'] ? $pathURL  : '/'; 

		// echo "<pre>";
		// 	var_dump($currentURL);
		// echo "</pre>";

		$reqMethod = $_SERVER['REQUEST_METHOD'];
		$function = null; //function to be executed
		if($reqMethod === 'GET'){
			$function = !isset($this->getRoutes[$currentURL]) ? null :  $this->getRoutes[$currentURL];

		}
		else{
			$function = !isset($this->postRoutes[$currentURL]) ? null :  $this->postRoutes[$currentURL];
		}

		if($function){
			call_user_func($function, $this); //passing this object to the function as a parameter
		}
		else{
			// echo "<h2 style='text-align: center;'>Page not found ! </h2>";
			// echo "<p style='text-align: center;'>
			// 	    <a href=\"/products\" class=\"btn btn-primary\"> <i data-feather=\"arrow-left\"></i> back to product list</a>
			// 	  </p>";
			  $this->RenderView("/products/notFound404");
		}

		
	}

	public function RenderView($view, $data=[]) //$data (associative array['products'=>...]
	{
		//creating variables using the $data array keys
		foreach ($data as $key => $value) {
			$$key = $value; // each key will become a independent variable
		}
		//get the view Content
		ob_start(); //caching content in a buffer 
		include_once __DIR__."/views/$view.php"; // $data will be available in view
		$content = ob_get_clean(); //returns content and cleanup the buffer
		include_once __DIR__."/views/_layout.php"; // $content variable will be accessable in _layout.php
	}
}