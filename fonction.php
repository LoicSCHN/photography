<?php

//-----------------------FORMULAIRE INSCRIPTION---------------------------
function loadFormCreateAccount(){
	echo <<<HOP
	<form method='post' action='.'>
		<fieldset class='formAccCO'>
			<legend>Inscription : </legend>
		<p>
			<label>Name : </label>
			<input name='name' required/>
		</p>
			<p>
			<label>Surname : </label>
			<input name='surname' required/>
		</p>
		<p>
			<label>e-mail adress : </label>
			<input name='mail' required/>
		</p>
		<p>
			<label>Login : </label>
			<input name='login' required/>
		</p>
		<p>
			<label>Password : </label>
			<input type="password" name='password' required/>
		</p>
		<p>
			<label>Password confirmation : </label>
			<input type="password" name='passwordbis' required/>
		</p>
		<p>
			<label></label>
			<input name='action' value='Create' type='submit'/>
		</p>
		<p>
			<a href=".?page=connexion" class="lienFormAccount">Se connecter</a>
		</p>

		</fieldset>
	</form>
HOP;
}

//---------------INSERTION UTILISATEUR DANS LA BDD---------------------

function addAccount($var1 , $var2 , $var3 , $var4 , $var5 , $var6)
{
	$sql= "insert into moi.account(name, surname, mail, password, passwordbis, last_co, admin, login) values ('$var1','$var2','$var3','$var4','$var5','Première connexion','0' ,'$var6')";
	pg_query($sql);
}

//------------------------ CONNEXION ---------------------------------

function loadFormConnexion()
{
echo <<<HOP
	<form method='post' action='.'>
		<fieldset class='formAccCO'>
			<legend>Connexion : </legend>
		<p>
			<label>Login : </label>
			<input name='loginConnexion' class='loginConnexion'/>
		</p>
		<p>
			<label>Password : </label>
			<input type="password" name='passwordConnexion' class='passwordConnexion'/>
		</p>
		<p>
			<label></label>
			<input name='action' value='Connexion' type='submit'/>
		</p>
		<p>
			<a href=".?page=account" class="lienFormAccount">Créer un compte</a>
		</p>

		</fieldset>
	</form>
HOP;

}

//----------------------- LOAD ALL ACCOUNT ------------------------------

function loadAllAccount()
{
	$account = array();
	$sql = "select * from moi.account";
	$result = pg_query($sql);
	while($row = pg_fetch_assoc($result)) 
	{
		$account[] = $row;
	}
	return $account;

}

//----------------------- Last Connexion ------------------------------

function LastConnexion($date,$id){
	$sql= "update moi.account set last_co ='$date' where id_personne='$id' ";
	pg_query($sql);
}

//--------------------  website informations --------------------------

function LoadWebsiteInformations(){
	$sql= "select * from moi.info_website";
	$result = pg_query($sql);
	while($r = pg_fetch_assoc($result)) 
	{
		$infos[] = $r;
	}
	if (isset($infos)) {
		return $infos;
	}
	
}

function insertInfo($text)
{
	$sql = "insert into moi.info_website(info) values('$text')";
	pg_query($sql);
}

function deleteInfo($idinfo) {
	$sql = "delete from moi.info_website where id_info=$idinfo";
	pg_query($sql); 
}

//-------------------- Photo  --------------------------

function addPhoto($id,$image,$date,$description,$title,$categorie)
{
	$sql = "insert into moi.image(id_image,id_personne,image,date_ajout,description,valide,titre,genre,visible) values(DEFAULT,'$id','$image','$date','$description',DEFAULT,'$title','$categorie',DEFAULT)";
	pg_query($sql); 
}

function countWaitingListPhotoes()
{
	$sql= "select count(*) from moi.image where valide = false and visible = true";
	$result = pg_query($sql);
	$res = pg_fetch_result($result, 0, 0);
	return $res;
}

function loadWaitingListPhotoes()
{
	$sql= "select * from moi.image where valide = false and visible = true";
	$result = pg_query($sql);
	while($row = pg_fetch_assoc($result)) 
	{
		$photos[] = $row;
	}
	if (isset($photos)) {
		return $photos;
	}
	
}

function loadValidatePhotoes()
{
	$sql= "select * from moi.image where valide = true and visible = true order by id_image asc";
	$result = pg_query($sql);
	while($row = pg_fetch_assoc($result)) 
	{
		$vphotos[] = $row;
	}
	if (isset($vphotos)) {
			return $vphotos;
	}
}
function validPhotos($id)
{
	$sql= "update moi.image set valide = true where id_image='$id' ";
	pg_query($sql);
}

function refuseOrDeletePhoto($id)
{
	$sql = "update moi.image set visible = false where id_image='$id' ";
	pg_query($sql);
}

function refusePhoto($id)
{
	$sql = "update moi.image set visible = false where id_image='$id' ";
	pg_query($sql);
}

function loadDeletedPhoto()
{
	$sql= "select * from moi.image where  visible = false order by id_image asc";
	$result = pg_query($sql);
	while($row = pg_fetch_assoc($result)) 
	{
		$dphotos[] = $row;
	}
	if (isset($dphotos)) {
			return $dphotos;
	}
}

function restorePhotos($id)
{
	$sql= "update moi.image set visible = true,valide=true where id_image='$id' ";
	pg_query($sql);
}

function findNamePhotograph($id)
{
	$sql = "select distinct a.login from moi.account a join moi.image i on a.id_personne = i.id_personne where id_image = '$id' ";
	$result = pg_query($sql);
	$res = pg_fetch_result($result, 0, 0);
	return $res;

}