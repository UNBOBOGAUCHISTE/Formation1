<?php
require_once 'db.php';
require_once 'functions.php';

function logged_only(){
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    if(!isset($_SESSION['id'])){
        $_SESSION['flash']['danger'] = "Test";
        exit();
    }}

function TestIdentifiants()
{
	$resultat = false;
	if(!empty($_POST) && !empty($_POST['username']) && !empty ($_POST['password']))
	{
		$pdo = new PDO("mysql:dbname=formationppe;host=localhost", "root", "");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		$sth = $pdo->prepare("SELECT * FROM employe WHERE nom = :username AND mdp = :password");
		$sth->execute(['username' => $_POST['username'],'password' => $_POST['password']]);

		$return = $sth->execute();
		if ($return)
		{
			$return = $sth->fetch();
		}
		if (!empty($return))
		{
			if (session_status() == PHP_SESSION_NONE)
            {
                session_start();
            }
			$_SESSION['id'] = $return->idEmploye;
			$_SESSION['nom'] = $return->nom;
			$_SESSION['credit']  = $return->Credit;
			$_SESSION['type'] = $return->typeEmploye;
			$resultat = true;
			
			if($_SESSION['type'] == 1){
				header('Location:catalogueAdmin.php');
			}else{
				header('Location:catalogue.php');
			}
		}
		return $resultat;
	}
}
?>