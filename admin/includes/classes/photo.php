<?php

// la classe photo rappresenta la classe per ogni foto caricata
class Photo {

	public $photo_id;
	public $photo_title;
	public $description;
	public $filename;
	public $type;
	public $size;

	protected static $db_table = "photos";

	public $tmp_path;
	public $upload_directory = "images";
	public $custom_errors = array();
	public $upload_errors = array (
		UPLOAD_ERR_OK =>"There is no error",
		UPLOAD_ERR_INI_SIZE =>"The uploaded file exceds the upload_max_filesize directive",
		UPLOAD_ERR_FORM_SIZE =>"The uploaded file exceeds the MAX_FILE_SIZE directive",
		UPLOAD_ERR_PARTIAL =>"The uploaded file was only partially uploaded.",
		UPLOAD_ERR_NO_FILE =>"No file was uploaded",
		UPLOAD_ERR_NO_TMP_DIR =>"Missing a temporary folder",
		UPLOAD_ERR_CANT_WRITE =>"Failed to write file to disk",
		UPLOAD_ERR_EXTENSION =>"A PHP extension stopped the file upload"
		);

	//*********************************************//
	//costruttore, permette di caricare i dati dal database
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
			->prepare('select * from '.self::$db_table.' where id = ?');
		$sql->execute(array($id));
		if ($sql->rowCount() == 1)
		{
			$row = $sql->fetch(PDO::FETCH_ASSOC);
			foreach ($row as $col => $value)
			{
				if ($col == 'password') continue;
				$this->{$col} = $value;
			}
		}
	}

	//************************************//
	// carica tutti i record del database
	public static function load_all()
	{
		$sql = Database::getConnection()
			->prepare('SELECT username, first_name, last_name FROM '.self::$db_table); //la password non viene scaricata
		$sql->execute();

		$rows = $sql->fetchAll(); 
		return $rows;
	}

	//************************************************//
	//permette di salvare un utente nel database o aggiornarne i dati se già presenti (Se esiste già un ID)
	// Create e Update
	public function save()
	{
		if ($this->id > 0)
		{
			if (strlen($this->password) > 0)
			{
				$sql = Database::getConnection()->prepare('
					update '.self::$db_table.'	set 
						`password` = aes_encrypt(:password, :crypt_key) 
					where id = :id
				');
				$sql->execute(array(
					':password' => $this->password, 
					':crypt_key' => CRYPT_KEY,
					':id' => $this->id
				));
			}
			

			$sql = Database::getConnection()->prepare('
				update '.self::$db_table.'	 set 
					`username` = :username, 
					`first_name` = :first_name,
					`last` = :first_name 

				where id = :id
			');
			$sql->execute(array(
					':username' => $this->username, 
					':first_name' => $this->first_name,
					':last_name' => $this->last_name
				));
		}
		else
		{
			$sql = Database::getConnection()->prepare('insert into '.self::$db_table.' (`username`, `password`, `first_name`, `last_name`)values(:username, aes_encrypt(:password, :crypt_key), :first_name, :last_name)');
			$sql->execute(array(
					':username' => $this->username, 
					':password' => $this->password, 
					':crypt_key' => CRYPT_KEY,
					':first_name' => $this->first_name, 
					':last_name' => $this->last_name
				));

			$this->id = Database::getConnection()->lastInsertId();
		}
	}

	// *****************************************//
	// cancella un record dal database a partire dal sui id
	// Delete
	public static function delete($id)
	{
		$sql = Database::getConnection()
			->prepare('delete from '.self::$db_table.'	where id = ?');
		$sql->execute(array($id));
	}


	// ************************* //
	/* Permette di fare il login */
	public static function login($username, $password)
	{
		$sql = Database::getConnection()
			->prepare('select * from '.self::$db_table.'	where username like ? and aes_decrypt(password, ?) = ?');
		$sql->execute(array($username, CRYPT_KEY, $password));
		if ($sql->rowCount() == 1)
		{
			$user = $sql->fetch(PDO::FETCH_ASSOC);
			unset($user['password']);
			$_SESSION['login'] = $user;
			return true;
		}
		else return false;
	}

	// ************************* //
	/* Permette di fare il logout */
	public static function logout()
	{
		unset($_SESSION['login']);
		session_destroy();
	}

	// ********************************************* //
	/* Permette di Verificare che l'utente è Loggato */
	public static function isLogged()
	{
		return 
			isset($_SESSION['login']) and 
			isset($_SESSION['login']['ID']) and 
			$_SESSION['login']['ID'] > 0;
	}
}



?>