<?php
	class DatabaseStatement
	{
		var $_parameters;
		var $_stmt;
		var $_cmd;
		var $_link;
		
		function __construct($dbh, $cmd)
		{
			$this->_cmd = $cmd;
			$this->_link = $dbh;
			$this->_stmt = $this->_link->prepare($cmd);
		}
		
		function AddParameter($paramName, $paramValue)
		{
			$this->_stmt->bindParam($paramName, $paramValue);
		}
		
		function GetErrorInfo()
		{
			$errStr = "";
			foreach ($this->_stmt->errorInfo() as $key => $value)
				$errStr +=  $key . " - " . $value . "\r\n";
			
			return $errStr;
		}
		
		function Execute()
		{
			return $this->_stmt->execute();			
		}
		
		function Fetch()
		{
			return $this->_stmt->fetch();
		}
		function FetchAll()
		{
			return $this->_stmt->fetchAll();
		}
	}
?>