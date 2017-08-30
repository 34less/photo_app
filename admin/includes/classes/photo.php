<?php

	/* Definire il SITE ROOT */
	define('DS',DIRECTORY_SEPARATOR);
	define('FOTO_ROOT',SITE_ROOT. DS.'fotos');

// la classe photo rappresenta la classe per ogni foto caricata
class Photo {

	/* Variabili della classe photo condivise con database */
	public $photo_id; 
	public $title; 
	public $description; 
	public $filename; 
	public $type; 
	public $size; 

	/* Variabile per la tabella del database*/
	protected static $db_table = "photos";

	/* Variabili necessarie a maneggiare il file */
	public $tmp_path;
	public $upload_directory = "fotos";

	/* Variabile per gestire gli errori gli errori*/
	public $errors;
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


	/* Scarica tutte le foto dal database */
	public static function load_all(){
		$sql = Database::getConnection()
			->prepare('SELECT photo_id, title, filename, size FROM '.self::$db_table); //la password non viene scaricata
		$sql->execute();

		$rows = $sql->fetchAll(); 
		return $rows;
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

	/* FUNCTION PER SAVE - GESTORE*/
	public function save(){

		if ($this->photo_id)
		{
			$this->update();
		}
		else{
			if(!empty($this->errors))
				{ return false;}
			if(empty($this->filename) || empty($this->tmp_path))
				{
					$this->errors[] = "the file was not available, please check the file"; 
					return false;
				}

			if(file_exists(FOTO_ROOT.DS.$this->filename)){
				$this->errors[] = "The file {$this->filename} already exist";

				return false;
			}


			if(move_uploaded_file($this->tmp_path, FOTO_ROOT.DS.$this->filename)){
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

	/* FUNCTION PER INSERIRE I FILE NEL DB - CREATE*/
	public function create(){

		$sql = Database::getConnection()->prepare('insert into '.self::$db_table.' (`title`, `description`, `filename`, `type`, `size`)values(:title, :description, :filename, :type, :size)');
		$sql->execute(array(
				':title' => $this->title, 
				':description' => $this->description, 
				':filename' => $this->filename,
				':type' => $this->type, 
				':size' => $this->size
			));

		$this->photo_id = Database::getConnection()->lastInsertId();
	}


	/* FUNCTION PER AGGIORNARE I FILE NEL DB - UPDATE*/
	private function update(){

		$sql = Database::getConnection()->prepare('
			update '.self::$db_table.'	 set 
				`title` = :title, 
				`description` = :description,
				`filename` = :filename,
				`type` = :type, 
				`size` = :size

			where id = :id
		');
		$sql->execute(array(
				':title' => $this->title, 
				':description' => $this->description,
				':filename' => $this->filename,
				':type' => $this->type,
				':size' => $this->size
			));
	}



	// *****************************************//
	// cancella un record dal database a partire dal sui id
	// Delete
	public static function delete($id)
	{
		$sql = Database::getConnection()
			->prepare('select filename from '.self::$db_table.'	where photo_id = ?');
		$sql->execute(array($id));
		if ($sql->rowCount() == 1)
		{
			$row = $sql->fetch()['filename'];
			if (!is_null(FOTO_ROOT.DS.$row)) unlink(FOTO_ROOT.DS.$row);
		}

		$sql = Database::getConnection()
			->prepare('delete from '.self::$db_table.'	where photo_id = ?');
		$sql->execute(array($id));

	}


}



?>