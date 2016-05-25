<?php

$headers = apache_request_headers();
$acces_allowed = false;

if ($headers['X-Auth-Token'] == "HGReFA1CcNTKYzPIG302vC4NfgxlSRJWLbD7ZRPBabg")
	{
		$acces_allowed = true;
	}

if ($acces_allowed)
{
	echo 'Super !<br/>';
	if (!isset($_POST['name']))
	{
		header("HTTP/1.0 400 Bad Request");
		echo "400 Bad Request";
	}
}
else
{
	header("HTTP/1.0 401 Unauthorized");
	echo "401 Unauthorized";
}

