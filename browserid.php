<?php
function verify_assertion($assertion, $cabundle = NULL) {
	$audience = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'];
	$postdata = 'assertion=' . urlencode($assertion) . '&audience=' . urlencode($audience);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://verifier.login.persona.org/verify");
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
	if (substr(PHP_OS, 0, 3) == 'WIN') {
		if (!isset($cabundle)) {
			$cabundle = dirname(__FILE__).DIRECTORY_SEPARATOR.'cabundle.crt';
		}
		curl_setopt($ch, CURLOPT_CAINFO, $cabundle);
	}
	$json = curl_exec($ch);
	curl_close($ch);

	return json_decode($json);
}

if (!empty($_POST)) {
    $result = verify_assertion($_POST['assertion']);
    if ($result->status === 'okay') {
    	//meaning the data sent was verified..
    	//lets get the data from the database from his email address
    	
    	
        //print_header($result->email);
        //echo "<p>Logged in as: " . $result->email . "</p>";
        //echo '<p><a href="javascript:navigator.id.logout()">Logout</a></p>';
        //json_encode($result);
    } // else {
        //print_header();
        //echo "<p>Error: " . $result->reason . "</p>";
    //}
    //echo "<p><a href=\"browserid.php\">Back to login page</p>";
} else {
	$result = new stdClass();
	$result->status = 'failure';
	$result->reason = 'no data sent';
}
//echo "</body></html>";
print json_encode($result);
?>