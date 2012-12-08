<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');


require_once 'database.php';
require_once 'databasestatement.php';

function UpdateOrSaveUser() {
	$stmt = Database::Instance()->CreateStatement("select * from users");
	//$stmt->AddParameter(":id", $id);
	$result = $stmt->Execute();
				
	if (!$result)
	{
		return NULL;
	}
	
	$result = $stmt->FetchAll();
	
	var_dump($result);
}

$r = new stdClass();
$r->success = 0;
$_POST['action'] = 'UpdateOrSaveUser';
if (isset($_POST['action'])) {
	
	switch($_POST['action']) {
		case 'UpdateOrSaveUser':
			$r->success = 1;
			UpdateOrSaveUser();
			break;
	}
}
print json_encode($r);
?>