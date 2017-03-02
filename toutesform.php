<?php
session_start();
require_once 'inc/header.php';
require_once 'inc/footer.php';
require_once 'inc/functions.php';
require_once 'inc/connect.php';
?>
	<div class="container">
      <div class="jumbotron">
        <table class="table">
			<thead>
				<tr>
					<th>Titre</th>
					<th>Date</th>
					<th>Duree</th>
					<th>État</th>
				</tr>
			</thead>
		<?php
			$db = new db();
			$formationEmploye = $db->formationUser($_SESSION['id']);
				foreach($formationEmploye as $uneFormation)
				{

					echo "<tr>";
					echo "<td>$uneFormation->titre </td>";
					echo "<td class='date'>$uneFormation->date</td>";
					echo "<td class='duree'>$uneFormation->duree</td>";
					echo "<td>$uneFormation->etat</td>";
					echo "</tr>";
				}
		?>
		</table>
	  </div>
	</div>