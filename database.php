<?php
	class Database
	{
		var $_link;
		static $_instance = NULL;
		
	 	private function __construct()
		{
			$this->_link = new PDO('mysql:host=localhost;dbname=jtimer', 'root', 'root');
			$statement = "SET NAMES 'utf8'"; //setting all names to utf-8
			$stmt = $this->CreateStatement($statement);
			$result = $stmt->Execute();
		}
		
		public static function Instance()
		{
			try
			{
				if (Database::$_instance == NULL)
					Database::$_instance = new Database();
			}
			catch (exception $e)
			{
				Log::Instance()->Fatal("Database error", $e);						
				throw new ErrorException("Database error.");
			}								
			
			return Database::$_instance;
		}
		
		function GetErrorInfo()
		{
			$errStr = "";
			foreach ($this->_link->errorInfo() as $key => $value)
				$errStr +=  $key . " - " . $value . "\r\n";
			
			return $errStr;
		}
		function __destruct()
		{
			$this->_link = NULL;
		}
		
		function GetLastInsertId()
		{
			return $this->_link->lastInsertId();
		}
		
		function CreateStatement($cmd)
		{
			return new DatabaseStatement($this->_link, $cmd);
		}		
	}
?>