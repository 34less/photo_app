<?php

// la classe photo rappresenta la classe per ogni foto caricata
class Photo {

	public $photo_id;
	public $title;
	public $description;
	public $filename;
	public $type;
	public $size;
	public $errors;

	protected static $db_table = "photos";

	public $tmp_path;
	public $upload_directory = "images";
	public $custom_errors = array();
	public $upload_errors = array (
		UPLOAD_ERR_OK 		  =>"There is no error",
		UPLOAD_ERR_INI_SIZE   =>"The uploaded file exceds the upload_max_filesize directive",
		UPLOAD_ERR_FORM_SIZE  =>"The uploaded file exceeds the MAX_FILE_SIZE directive",
		UPLOAD_ERR_PARTIAL 	  =>"The uploaded file was only partially uploaded.",
		UPLOAD_ERR_NO_FILE 	  =>"No file was uploaded",
		UPLOAD_ERR_NO_TMP_DIR =>"Missing a temporary folder",
		UPLOAD_ERR_CANT_WRITE =>"Failed to write file to disk",
		UPLOAD_ERR_EXTENSION  =>"A PHP extension stopped the file upload"
		);


	//**************************************************//
	//costruttore, permette di caricare i dati dal database,
	//se i dati non sono presenti ($id=null) crea un vettore vuoto

	public function __construct($id = NULL)
	{
		if (!is_null($id)) $this->load($id);
	}

	//***************************************************//
	//funzione pubblica, usata di default dal costruttore per caricare i dati, viene passato l'id come mezzo di ricerca
	//Read
	public function load($id)
	{
		$sql = Database::getConnection()
			->prepare('select * from '.self::$db_table.' where photo_id = ?');
		$sql->execute(array($id));
		if ($sql->rowCount() == 1)
		{
			$row = $sql->fetch(PDO::FETCH_ASSOC);
			foreach ($row as $col => $value)
			{
				$this->{$col} = $value;
			}
		}
	}

	/* SETTER - IL METODO PERMETTE DI SALVARE I FILE DA $_FILE AL NOSTRO OGGETTO - E' ANCHE PRESENTE UN CONTROLLO SULL'ESISTENZA O MENO DEL FILE DA CARICARE E SU EVENTUALI ERRORI DI CARICAMENTO*/
	public function set_file($file){

		if (empty($file) || !$file || !is_array($file))
		{
			$this->errors[]="There was no file uploaded here";
			return false;
		}

		elseif($file['error']!=0){
			$this->errors[]=$this->upload_errors[$file['error']];
			return false;
		}
		else{
			$this->filename = basename($file['name']);
			$this->tmp_path = $file['tmp_name'];
			$this->type 	= $file['type'] ;
			$this->size 	= $file['size'];
		}
	}

	/* FUNCTION PER SAVE - CREATE*/
	public function save(){

		if ($this->photo_id){
			$this->update();
		}
		else{
			if(!empty($this->errors))
				{return false;}
			if(empty($this->filename) || empty($this->tmp_path))
				{
					$this->errors[] = "the file was not available"; 
					return false;
				}

			$target_path = SITE_ROOT . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . $this->upload_directory;

			if(file_exist($target_path)){
				$this->errors[] = "The file {$this->filename} already exist";
				return false;
			}


			if(move_uploaded_file($this->tmp_path, $target_path)){
				if ($this->create()){
					unset ($this->tmp_path);
					return true;
				}
			} else{
				$this->errors[] = "The upload failed, please check file permission of the directory";
				return false;
			}
		}

	}


}



?>