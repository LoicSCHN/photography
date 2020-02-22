<?php		
				//echo $_SESSION["admin"] ;
				echo "</br>";
				
				echo "</br>";
				echo "Il y a $nbcount photo(s) à valider";
				?>
				<form method='post' action='.'>
					<label>Poster une information : </label>
					<textarea name="info"></textarea>
					<input name='action' value='Poster' type='submit'/>
				</form>
				<?php
			echo "</br>";
			   ?>
			<a href=".?page=supprimée" class="photoSupLien">Photos supprimées </a>
					
			<?php 
			echo "</br>";
			if (isset($erreur)) {
				echo "<p>";
				echo "$erreur";
				echo "</p>";
			}
			echo "</br>";
			
?>
			
				
				