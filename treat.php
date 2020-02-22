<?php

$nbcount=countWaitingListPhotoes();

if (isset($_GET["page"])) {
	$page = $_GET["page"];

} 
else {
	$page = "home";
	
}
if($page == "home")
{
	$infos = LoadWebsiteInformations();
}
if ($page == "compte" || $page == "attente") 
{
	$photos = loadWaitingListPhotoes();
}
if ($page == "photos") 
{
	$vphotos = loadValidatePhotoes();
}
if (isset($_POST["action"])) {

	if ($_POST["action"] == "Create") {

	$name = $_POST["name"];
	$surname = $_POST["surname"];
	$mail = $_POST["mail"];
	$login = $_POST["login"];
	$password = $_POST["password"];
	$passwordbis = $_POST["passwordbis"];

	addAccount(strip_tags(pg_escape_string($name)), strip_tags(pg_escape_string($surname)), strip_tags(pg_escape_string($mail)), strip_tags(pg_escape_string($password)), strip_tags(pg_escape_string($passwordbis)), strip_tags(pg_escape_string($login)));
	header('Location:.?page=connexion');
	}

	if ($_POST["action"] == "Connexion"){
		$account = loadAllAccount();

		if (!isset($_SESSION["connected"])) {
			foreach($account as $acc) {
				if ($_POST["loginConnexion"] == $acc["login"] && $_POST["passwordConnexion"] == $acc["password"]) {
					$_SESSION["connected"] = True;
					$_SESSION["name"] = $acc["name"];
					$_SESSION["surname"] = $acc["surname"];
					$_SESSION["mail"] = $acc["mail"];
					$_SESSION["login"] = $acc["login"];
					$_SESSION["password"] = $acc["password"];
					$_SESSION["id"] = $acc["id_personne"];
					$_SESSION["last_co"] = $acc["last_co"];
					LastConnexion(date('l jS \of F Y h:i:s A'),$_SESSION["id"]);
					$_SESSION["admin"] = $acc["admin"];
					header('Location:.?page=compte');
				}
			}
		}
		
	}

	if ($_POST["action"]== "Deconnexion") {
		
		//$_SESSION["connected"] = false;
		unset($_SESSION["connected"]);
		unset($_SESSION["admin"]);
		header('Location:.?page=connexion');
	}

	if ($_POST["action"]== "Poster") {
			$winfo = strip_tags(pg_escape_string($_POST["info"])) ;
			insertInfo($winfo);
			$page = "compte";
	}

	if ($_POST["action"] == "Effacer") {
		deleteInfo($_POST["idinfo"]);
		$infos = LoadWebsiteInformations();
		$page = "home";
	}

	if ($_POST["action"] == "Envoyer") {
		if (($_FILES["photo"]['size']) != 0) {
			$nom = "../Moi/IMG/affichage/".$_FILES['photo']['name'];
			$resultat = move_uploaded_file($_FILES['photo']['tmp_name'],$nom);
			$page = "confirmation";
		}
		else{
			$page = "compte";
			$erreur = 'Veuillez choisir une photo';
		}
	}
		
	if ($_POST["action"] == "Confirmer") {
		$date = date("j/n/Y");
		addPhoto($_SESSION["id"],strip_tags(pg_escape_string($_POST["nom"])),$date,strip_tags(pg_escape_string($_POST["cdescriptionimage"])),strip_tags(pg_escape_string($_POST["ctitreimage"])),$_POST["categorie"]);
		header('Location:.?page=home');
	}
	
	if ($_POST["action"] == "Valider") {
		validPhotos($_POST["id_image"]);
		$page = "attente";
	}	

	if ($_POST["action"] == "Refuser") {
		refuseOrDeletePhoto($_POST["id_image"]);
		header('Location:.?page=attente');
	}	

	if ($_POST["action"] == "Supprimer") {
		refusePhoto($_POST["id_image"]);
		header('Location:.?page=photos');
	}	
	if ($_POST["action"] == "Retablir") {
		restorePhotos($_POST["idimage"]);
		header('Location:.?page=supprimée');
	}	


}
if ($page == "supprimée") 
{
	$dphotos = loadDeletedPhoto();
}