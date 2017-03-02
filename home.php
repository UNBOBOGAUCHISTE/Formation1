<?php require_once 'inc/connect.php';?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Connexion</title>
<link rel="stylesheet" href="css/home.css" type="text/css" /> 
</head>

<body>
    <!-- Contenu -->
    <div id="container">
        <form action="home.php" method="POST">
			<span>
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" value="Votre identifiant" required onclick='javascript:this.value = "";'>
            <label for="password">Mot de passe:</label>
            <input type="text" id="password" name="password" value="Votre mot de passe" required onclick='javascript:this.value = "";this.type="password"'/>            
			<div id="lower">
                <input type="checkbox" name="stayconnect" ><label class="check" for="checkbox">Rester connecté</label>
                <input type="submit" name="Connexion" value="Connexion">
            </div><!--/ lower-->
        </form>
    </div><!--/ container-->
    <!-- Fin Contenu -->
</body>
</html>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	if(TestIdentifiants())
	{
		TestIdentifiants();
	}else{
		echo "Identifiant ou mot de passe incorrect!";
	}
}
?>

