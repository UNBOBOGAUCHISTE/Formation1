<?php
require 'db.php';

function debug($variable)
{
	echo '<pre>' . print_r($variable, true) . '</pre>';
}
class db
{
	private $db;
	public function __construct()
	{
		$this->db=new PDO('mysql:host=localhost;dbname=formationppe;charset=utf8', 'root', '');
	}
	
public function afficherFormation(){
    $sth=$this->db->prepare("SELECT * from formation join prestataire on formation.idPrestataire=prestataire.idPrestataire ");
	$sth->execute();
	$result= $sth->fetchAll(PDO::FETCH_OBJ);
    return $result;
}

public function formationUser($id){
    $sth=$this->db->prepare("SELECT formation.idFormation,employe.idEmploye, titre, date, etat, duree,etat from employe join selectionner on employe.idEmploye = selectionner.idEmploye
					   join formation on formation.idFormation = selectionner.idFormation where employe.idEmploye='$id'");
    $sth->execute();
    $result= $sth->fetchAll(PDO::FETCH_OBJ);
    return $result;
}

public function choixFormation($id, $idform){
    $sql="insert into selectionner values (:idEmploye, :idFormation, 'Attente Validation')";
    $stmt = $this->db->prepare($sql);
    $stmt->BindValue(':idEmploye', $id);
	$stmt->BindValue(':idFormation',$idform);
    $result = $stmt->execute();
    return $result;
}

public function updateEtat($id,$idForm){
	$sql="Update selectionner SET etat='Attente Validation' WHERE idEmploye='$id' AND idFormation='$idForm'";
	$stmt = $this->db->prepare($sql);
	$result = $stmt->execute();
	return $result;
}

public function formationEnAtt($id){
    $sth=$this->db->prepare("SELECT formation.idFormation,employe.idEmploye, titre, date, etat, duree,etat from employe JOIN selectionner on employe.idEmploye = selectionner.idEmploye
					   JOIN formation on formation.idFormation = selectionner.idFormation WHERE employe.idEmploye='$id' AND selectionner.etat='Attente Validation'");
    $sth->execute();
    $result= $sth->fetchAll(PDO::FETCH_OBJ);
    return $result;
}

public function formValidees($id){
    $sth=$this->db->prepare("SELECT formation.idFormation,employe.idEmploye, titre, date, etat, duree,etat from employe JOIN selectionner on employe.idEmploye = selectionner.idEmploye
					   JOIN formation on formation.idFormation = selectionner.idFormation WHERE employe.idEmploye='$id' AND selectionner.etat='Formation Validée'");
    $sth->execute();
    $result= $sth->fetchAll(PDO::FETCH_OBJ);
    return $result;
}

public function formRefusees($id){
    $sth=$this->db->prepare("SELECT formation.idFormation,employe.idEmploye, titre, date, etat, duree,etat from employe JOIN selectionner on employe.idEmploye = selectionner.idEmploye
					   JOIN formation on formation.idFormation = selectionner.idFormation WHERE employe.idEmploye='$id' AND selectionner.etat='Formation Refusée'");
    $sth->execute();
    $result= $sth->fetchAll(PDO::FETCH_OBJ);
    return $result;
}

public function calculCredit($id, $idform){
	$sql="Update employe AS e JOIN selectionner on e.idEmploye = selectionner.idEmploye JOIN formation ON formation.idFormation = selectionner.idFormation 
		  SET e.Credit = e.Credit - formation.credit WHERE e.idEmploye = :idEmploye AND formation.idFormation = :idFormation";
	$stmt = $this->db->prepare($sql);
	$stmt->BindValue(':idEmploye',$id);
	$stmt->BindValue(':idFormation',$idform);
	$result = $stmt->execute();
	return $result;
	header('Location:catalogue.php');
}

public function selectCredit($id){
	$sth=$this->db->prepare("SELECT credit FROM employe where idEmploye = '$id'");
	$sth->execute();
	$result = $sth->fetch();
    return $result['credit'];
}

public function afficherFormationAValider(){
    $sth=$this->db->prepare("SELECT formation.idFormation, selectionner.etat, employe.idEmploye, employe.nom, formation.titre, formation.date, formation.duree, prestataire.nomPrestataire FROM selectionner JOIN employe on employe.idEmploye = selectionner.idEmploye
					   JOIN formation on formation.idFormation = selectionner.idFormation JOIN prestataire on formation.idPrestataire = prestataire.idPrestataire WHERE selectionner.etat = 'Attente Validation'");
	$sth->execute();
	$result= $sth->fetchAll(PDO::FETCH_OBJ);
    return $result;
}

public function validerFormation($id, $idform){
    $sql="UPDATE selectionner SET etat='Formation Validée' where idEmploye=:idEmploye and idFormation=:idFormation";
    $stmt = $this->db->prepare($sql);
    $stmt->BindValue(':idFormation',$idform);
    $stmt->BindValue(':idEmploye',$id);
    $result=$stmt->execute();
    return $result;
	header('Location:validationAdmin.php');
}

public function refusFormation($id, $idform){
    $sql="UPDATE selectionner set etat='Formation Refusée' WHERE idFormation=:idform AND idEmploye=:id";
    $stmt = $this->db->prepare($sql);
    $stmt->BindValue(':idform',$idform);
    $stmt->BindValue(':id',$id);
    $result=$stmt->execute();
    return $result;
	header('Location:validationAdmin.php');
}

public function refusCalcul($id, $idform){
	$sql="Update employe AS e JOIN selectionner on e.idEmploye = selectionner.idEmploye JOIN formation ON formation.idFormation = selectionner.idFormation 
		  SET e.Credit = e.Credit + formation.credit WHERE e.idEmploye = :idEmploye AND formation.idFormation = :idFormation";
	$stmt = $this->db->prepare($sql);
	$stmt->BindValue(':idFormation',$idform);
	$stmt->BindValue(':idEmploye', $id);
	$result=$stmt->execute();
	return $result;
}

public function testChoix($id, $idForm){
	$result = false;
	$sth=$this->db->prepare("SELECT idEmploye, idFormation FROM selectionner WHERE idEmploye='$id' AND idFormation='$idForm' AND etat='Attente Validation'");
	$sth->execute();
    $result= $sth->fetchAll(PDO::FETCH_OBJ);
	if($result)
	{
		$result = true;
	}
	return $result;
}
}
/*public function formParAnnee($id, $form){
		$sth=$this->db->prepare("
}*/
