<?php
require_once("includes/functions.php");

if (isset($_POST['name']) && isset($_POST['password']))
{
    $password = htmlspecialchars($_POST['password']);
    $name = strtolower(htmlspecialchars($_POST['name']));
            
    connexion_bdd();
    $req = $bdd->prepare('SELECT name, password FROM users WHERE name = :name');
    $req->execute(array('name' => $name));
    while ($donnees = $req->fetch())
    {
        if (isset($donnees['name']))
        {
        	$name_exist = true;
        }
        $password_hash = $donnees['password'];
    }
    $req ->closeCursor();

    if (isset($name_exist)) 
    {
        //Name existe
        //Vérification mdp
        if (password_verify($password, $password_hash))
        {
            //Mdp OK
            $new_ip = $_SERVER['REMOTE_ADDR'];
            $user_id = name_to_user_id($name);
            $_SESSION['user_id'] = $user_id;
            ip_update($user_id, $new_ip);
                
            connexion_bdd();
		   	$req = $bdd->prepare('SELECT token FROM users WHERE id = :id');
		   	$req->execute(array('id' => $user_id));
		   	while ($donnees = $req->fetch())
		   	{
		   		$token = $donnees['token'];
		   	}
		   	$req ->closeCursor();

		   	//On affiche le token
		   	echo $token;
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
}
else
{
	header("HTTP/1.0 400 Bad Request");
	echo "400 Bad Request";
}

