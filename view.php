
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Photography</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="">

<header>

<nav class="menu">
		<ul>
			<li>
				 <a href=".?page=home" class="lienmenu">Acceuil </a>
			</li>
			<li>
				 <a href=".?page=photos" class="lienmenu">Photos</a>
			</li>
			<li>
				 <a href=".?page=videos" class="lienmenu">Vidéos</a>
			</li>
			
			<?php 

			if (isset($_SESSION["connected"])) {
				echo <<<HOP
				<li>
					 <a href=".?page=compte" class="lienmenu">Mon compte</a>
				</li>
HOP;
			}
			else
				echo <<<HOP
				<li>
					 <a href=".?page=connexion" class="lienmenu">Connexion</a>
				</li>
HOP;
			 ?>
			<?php 
			if (isset($_SESSION["connected"])) {
				if ($_SESSION["admin"] == 't') {
				
				echo"<li>";
					echo "<a href='.?page=attente' class='lienmenu'>Image(s) en attente (".$nbcount.")</a>";
				echo"</li>";

			}
			}
			?>
		</ul>
	</nav>
</header>

	<section>
		<?php

		if ($page == "home") {	
			/*
		?>
		<div id="global">
			<div id="slideshow-container">
				<div id="slideshow">
					<?php $test = "1.jpg" ?>
					<img <?php echo "src='images/".$test."'"; ?> alt="Image 1" class="slideshow-image">
					<img src="images/2.jpg" alt="Image 2" class="slideshow-image">
					<img src="images/3.jpg" alt="Image 3" class="slideshow-image">
					<img src="images/4.jpg" alt="Image 4" class="slideshow-image">
					<img src="images/5.jpg" alt="Image 5" class="slideshow-image">
				</div>
			</div>
		</div>
		<script type="text/javascript" src="js/slideshow.js"></script>
		<script type="text/javascript">
			Slideshow.init();
		</script>
		<?php	*/
			echo "<div class='div1'>";
			
			echo "<h1 class='titreAcceuil'>Les dernieres infos du site : </h1>";
			echo "</br>";
			if (isset($infos)) {
				foreach($infos as $info) {
					echo "</br>";
					echo "<form method='post' action='.'>";
					echo "<p>".$info["info"]."</p>";
					if(isset($_SESSION["admin"]))
					{
						if($_SESSION["admin"] == 't')
						{
							echo "<input type='hidden' name='idinfo' 
						         value='".$info["id_info"]."'/>";
							echo "<input type='submit' name='action' value='Effacer'/>";
						}
					}
					echo "</form>";
				}
			}
			else
				echo "Il n'y a pas d'informations pour le moment";
			echo "</br>";
			echo "</div>";
		}	

		if ($page == "videos") {
			echo "videos";

		}	

		if ($page == "photos") {
			echo "<div class='div1'>";
			if (isset($vphotos)) {
				foreach ($vphotos as $vphoto) {
					echo "<section class='photo1'>";
					echo "<article class='photo2'>";
					echo "<img src=".$vphoto["image"]." class='listphoto'>" ;
					echo "</article>";
					echo "<article class='photo2' id='photo22'>";
					echo "<h3>".$vphoto["titre"]."</h3>" ;
					echo "</br>";
					echo "<p class='photo222'>";
					echo  "Genre : ".$vphoto["genre"];
					echo "</p>";
					echo "</br>";
					echo "<p class='photo222'>";
					echo  "Description : ".$vphoto["description"];
					echo "</p>";
					echo "</br>";
					echo "<p class='photo222'>";
					$name = findNamePhotograph($vphoto["id_image"]);
					echo  "ajoutée le : ".$vphoto["date_ajout"]." par ".$name;
					echo "</p>";
					echo "</article>";
					echo "<form method='post' action='.'>";
					if(isset($_SESSION["admin"]))
					{
						if($_SESSION["admin"] == 't')
						{
							echo "<article class='photo2' id='photo23'>";
							echo "<input type='hidden' name='id_image' 
							         value='".$vphoto["id_image"]."'/>";
							echo "<input type='submit' name='action' value='Supprimer' class='supPhoto'/>";
							echo "</br>";
							echo "</article>";
						}
					}
					echo "</form>";
					echo "</section>";
				}
			}
			echo "</div>";
		}

		if ($page == "connexion") {
			loadFormConnexion();
		}

		if ($page == "account") {
			loadFormCreateAccount();
		}
		if ($page == "compte") {
			include_once("compte.php");
		}
		
		if ($page == "confirmation") {
			?>
			<div class='div1'>
			<h1>Confirmation : </h1>
			<p>
			<?php
			echo "<img src=../Moi/IMG/affichage/".$_FILES['photo']['name']." class='cphoto'>" ;
			?>
			<form method='post' action='.' enctype="multipart/form-data">
					<p>
						<label>Titre de l'image : </label>
						<input class="img" type="text" name='ctitreimage' />
					</p>
					<p>
						<label>Description :  </label>
						<textarea class="img" name="cdescriptionimage"></textarea>
					</p>
					<p>
						<label>Choisir une categorie de photo : </label>
						<select name="categorie">
							<option value="nothing" selected="selected"> </option>
							<option value="Ville">Ville</option>
							<option value="Nature">Nature</option>
							<option value="Paysage">Paysage</option>
							<option value="Montagne">Montagne</option>
							<option value="Autre">Autre</option>
						</select>
					</p>
					<?php
					echo "<input type='hidden' name='nom' 
						         value='".$nom."'/>";
					?>
					<p>
						<input class="img" type="submit" name="action" value="Confirmer" />
					</p>
				</form>
			<?php
			echo "</p>";
			echo "</div>";
		}
		if ($page == "attente") {
			?>
			<div class='div1'>
			<h2>Photo(s) à valider</h2>
				<?php
				if (isset($photos)) {
					foreach ($photos as $photo) {
						echo "<section class='photo1'>";
					echo "<article class='photo2'>";
					echo "<img src=".$photo["image"]." class='listphoto'>" ;
					echo "</article>";
					echo "<article class='photo2' id='photo22'>";
					echo "<h3>".$photo["titre"]."</h3>" ;
					echo "</br>";
					echo "<p class='photo222'>";
					echo  "Genre : ".$photo["genre"];
					echo "</p>";
					echo "</br>";
					echo "<p class='photo222'>";
					echo  "Description : ".$photo["description"];
					echo "</p>";
					echo "</br>";
					echo "<p class='photo222'>";
					$name = findNamePhotograph($photo["id_image"]);
					echo  "ajoutée le : ".$photo["date_ajout"]." par ".$name;
					echo "</p>";
					echo "</article>";
					echo "<form method='post' action='.'>";
					echo "<article class='photo2' id='photo23'>";
					echo "<input type='hidden' name='id_image' 
							         value='".$photo["id_image"]."'/>";
					echo "<input type='submit' name='action' value='Valider' class='supPhoto'/>";
					echo "</br>";
					
					echo "<input type='submit' name='action' value='Refuser' class='supPhoto'/>";
					echo "</br>";
					echo "</article>";
					echo "</form>";
					echo "</section>";
				}
			}
				else
					echo "<p>Aucune photo en attente</h2>";	
				echo "</div>";
		}
		if ($page == "supprimée") {
			?>
			<div class='div1'>
			<h2>Photo(s) supprimée</h2>
				<?php
				if (isset($dphotos)) {
					foreach ($dphotos as $photo) {
						echo "<section class='photo1'>";
						echo "<article class='photo2'>";
						echo "<img src=".$photo["image"]." class='waitinglistphoto'>" ;
						echo "</article>";
						echo "<article class='photo2' id='photo22'>";
						echo "<h3>".$photo["titre"]."</h3>" ;
						echo "</br>";
						echo "<p class='photo222'>";
						echo  "Genre : ".$photo["genre"];
						echo "</p>";
						echo "</br>";
						echo "<p class='photo222'>";
						echo  "Description : ".$photo["description"];
						echo "</p>";
						echo "</br>";
						echo "<p class='photo222'>";
						$name = findNamePhotograph($photo["id_image"]);
						echo  "ajoutée le : ".$photo["date_ajout"]." par ".$name;
						echo "</p>";
						echo "</article>";
						echo "<form method='post' action='.'>";
						echo "<article class='photo2' id='photo23'>";
						echo "<input class='supPhoto' type='submit' name='action' value='Retablir'/>";
						echo "<input  type='hidden' name='idimage' 
							         value='".$photo["id_image"]."'/>";
						echo "</br>";
						echo "</article>";
						echo "</form>";
						echo "</section>";
					}
				}
				else
					echo "<p>Aucune photo supprimée</h2>";	
				echo "</div>";
		}

		?>
	</section>

</body>
</html>