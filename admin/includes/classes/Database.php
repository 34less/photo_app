<?php
	define('DATABASE_HOST', 'localhost');
	define('DATABASE_USERNAME', 'root');
	define('DATABASE_PASSWORD', '');
	define('DATABASE_NAME', 'gallery_db');
	define('PDO_DSN', 'mysql:dbname='.DATABASE_NAME.';host='.DATABASE_HOST);

	class Database
	{
		private static $connection;

		public static function getConnection()
		{
			if (is_null(self::$connection))
			{
				//tentativo di connessione al database
				try{
					self::$connection = new PDO(PDO_DSN, DATABASE_USERNAME, DATABASE_PASSWORD);
					self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					self::$connection->exec("set names utf8");
						//statment for debug
					echo "<script>console.log('connected to database')</script>";

				}
				catch(PDOException $e){
					echo "OPS something went wrong with database connection, please try again later: <br>" . $e->getMessage();
				}

			}
			return self::$connection;
		}

		// la funzione è resa privata per non poter essere usata fuori dalla classe
		private function __construct() {}

		private function __clone() {}
	}

?>
