<?php
require_once("includes/functions.php");

$headers = apache_request_headers();
$acces_allowed = false;

//On vérifie qu'un token est bien présent dans la requète
if (isset($headers['X-Auth-Token']))
{

    $token = $headers['X-Auth-Token'];

    connexion_bdd();
    $req = $bdd->prepare('SELECT token FROM users WHERE token = :token');
    $req->execute(array('token' => $token));
    while ($donnees = $req->fetch())
    {
    	if (isset($donnees['token']))
    	{
    		$token_exist = true;
    	}
        		
    }
    $req ->closeCursor();

    //On vérifie que le token existe bien
    if (isset($token_exist))
    {
        if (isset($_POST['new_points']))
        {
            $new_points = htmlspecialchars($_POST['new_points']);

            connexion_bdd();
            $req = $bdd->prepare('UPDATE users SET points = :points WHERE token = :token');
            $req->execute(array(
            'token' => $token,
            'points' => $new_points,
            ));
            $req ->closeCursor();
        }
        else
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
}
else
{
	header("HTTP/1.0 401 Unauthorized");
    echo "401 Unauthorized";
}

