<?php		

			echo "<div class='div1'>";
			if (isset($_SESSION["connected"])) {
				echo "<h1 class='bienvenueCompte'> Bienvenue sur votre compte ".$_SESSION["name"]."</h1>";
				echo "</br>";
				echo "</br>";
				//echo date("j/n/Y");
				echo "Statut : ";
					if (isset($_SESSION["connected"])) {
						if ($_SESSION["admin"] == 't') {
							echo "Admin";
						}
						else
							echo "Membre";
					}
				if($_SESSION["admin"] == 't')
				{
					include_once("admin.php");
				}
				?>
				<h2>Poster une image : </h2>
					<form method='post' action='.' enctype="multipart/form-data">
						<p>
							<label for="photo">Choose a photo :</label>
							<input class="img"  type="file"  name="photo" id="photo" accept="image/png, image/jpeg">
						</p>
						<p>
							<input class="img" type="submit" name="action" value="Envoyer" />
						</p>
					</form>
					<form method='post' action='.'>
						<input name='action' value='Deconnexion' type='submit'/>
					</form>
				</br>
				<?php
				echo "<footer>Derniere connexion : ".$_SESSION["last_co"] ."</footer>";
				echo "</div>";
			}
			else{
				echo "Veuillez vous connecter pour accéder à cette page.";
				
				?>
				<p>
					<a href=".?page=connexion" class="lienFormAccount">Se connecter</a>
				</p>
				<?php
			}
?>