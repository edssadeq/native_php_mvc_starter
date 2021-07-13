<?php
	namespace app\models;

	require_once "../_CONSTANTS.php";
	
	use app\utils\Utils as Utils;
	

	/**
	 * Mapping with database
	 */
	class Product
	{
		public $prodID;
		public $prodTitle;
		public $prodDescription;
		public $prodImage;
		public $prodPrice;
		public $prodCreationDate;

		public $imageFile = array(); //uploaded image

		public function __construct()
		{
			// code...
		}

		public function load($data)
		{
			 $this->prodID = isset($data['prod_id']) ? $data['prod_id'] : null;
			 $this->prodTitle = $data['prod_title'];
			 $this->prodDescription = isset($data['prod_description']) ? $data['prod_description'] : '';
			 $this->prodImage = isset($data['prod_image']) ? $data['prod_image'] : null;
			 $this->prodPrice = (float)$data['prod_price'];
			 $this->prodCreationDate = date(SQL_DATE_FROMAT);
			 $this->imageFile = isset($data['imageFile']) ? $data['imageFile'] : null;

		}

		public function save() // validate inputs + move uploadded image
		{
			//validation 
			$form_errors = [];
			if(empty($this->prodTitle) || strlen($this->prodTitle)<3){
				$form_errors[] = 'Product title is required !';
			}

			if(empty($this->prodPrice) || !is_float((float)$this->prodPrice) ||  (float)$this->prodPrice < 0 ){
				$form_errors[] = 'Product price is required !';
			}

			//create directory
			//create images folder if it is not exist
		    if(!is_dir(UPLOAD_FOLDER)){
		      mkdir(UPLOAD_FOLDER);
		    }

		    //insert to database
		    if(!$form_errors){
		      //move file somewhere else
		      if($this->imageFile && $this->imageFile['tmp_name']){
		        //generate path
		        //../uploaded_images/d_"."/".genarateRandStr(8);
		        $dir_path= UPLOAD_FOLDER."/".Utils::genarateRandStr(8);
		        //create the directory if not exist
		        if(!is_dir($dir_path)){
		          mkdir($dir_path);
		        }
		        $newPath = $dir_path.'/'.$this->imageFile['name']; //rand str with 6 chars

		        $this->prodImage = $newPath;
		        //if the image is there, delete it
		        if(file_exists($this->prodImage)){
		        	unlink($this->prodImage);
		        }

		        move_uploaded_file($this->imageFile['tmp_name'], $this->prodImage);
		      }
		      
		    }

		    return $form_errors;
		}
	}


?> 