<?php
session_start();
require_once 'inc/headerAdmin.php';
require_once 'inc/footer.php';
require_once 'inc/functions.php';
require_once 'inc/connect.php';
?>
<div class="container">
<?php
$db = new db();
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{		
	if(isset($_POST['Validation']))
	{
		$db->validerFormation($_POST['idEmploye'], $_POST['choix']);
		echo "<div class='alert alert-success'><strong>Formation validée!</strong></div>";
	}
	if(isset($_POST['Refus']))
	{
		$db->refusFormation($_POST['idEmploye'], $_POST['choix']);
		$db->refusCalcul($_POST['idEmploye'], $_POST['choix']);
		echo "<div class='alert alert-danger'><strong>Formation Refusée!</strong></div>";
	}
}
?>
      <div class="jumbotron">
        <table class="table">
			<thead>
			  <tr>
				<th>Nom de l'employé</th>
				<th>Titre</th>
				<th>Date</th>
				<th>Durée</th>
				<th>Prestataire</th>
				<th>État</th>
			  </tr>
			</thead>
			<?php
				$formationEmploye = $db->afficherFormationAValider();
				foreach($formationEmploye as $uneFormation)
				{
					echo "<form action='validationAdmin.php' name='catalogue' role='form'  method='post' accept-charset='utf-8'>";
					echo "<tr>";
					echo "<td>$uneFormation->nom </td>";
					echo "<td>$uneFormation->titre </td>";
					echo "<td class='date'>$uneFormation->date</td>";
					echo "<td class='duree'>$uneFormation->duree</td>";
					echo "<td>$uneFormation->nomPrestataire</td>";
					echo "<td>$uneFormation->etat</td>";
					echo "<td><input type='submit' class='btn btn-danger btn-md' name='Refus' value='Refuser'></input>";
					echo "<td><input type='submit' class='btn btn-primary btn-md' name='Validation' value='Valider'></input>";
					echo "</tr>";
					echo "<input type='hidden' name='choix' value='$uneFormation->idFormation'/>";
					echo "<input type='hidden' name='idEmploye' value='$uneFormation->idEmploye'/>";
					echo "</form>";
				}
			?>
		</table>
      </div>
    </div><!-- /container -->
   
    