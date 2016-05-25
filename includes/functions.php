<?php

function connexion_bdd()
{
    global $bdd;
    try
	{
	    $bdd = new PDO('mysql:host=localhost;dbname=doolhof', 'doolhof', 'password');
	}
	    catch (exception $e)
    {
		die('Erreur : '. $e->getMessage());
	}
}

function ip_update($user_id, $new_ip)
{
    $paid_date = date("Y-m-d");
    //connexion_bdd
    try
	{
	    $bdd = new PDO('mysql:host=localhost;dbname=doolhof', 'doolhof', 'password');
	}
	    catch (exception $e)
    {
		die('Erreur : '. $e->getMessage());
	}
    $req = $bdd->prepare('UPDATE users SET ip_last_connexion = :ip_last_connexion WHERE id = :id');
    $req->execute(array(
        'id' => $user_id,
        'ip_last_connexion' => $new_ip,
        ));
}

function name_to_user_id($name)
{
    //connexion_bdd
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=doolhof', 'doolhof', 'password');
    }
        catch (exception $e)
    {
        die('Erreur : '. $e->getMessage());
    }

    $req = $bdd->prepare('SELECT id FROM users WHERE name = :name');
    $req->execute(array('name' => $name));
    while ($donnees = $req->fetch())
    {
        $user_id = $donnees['id'];
    }
    $req ->closeCursor();
    return $user_id;
}
