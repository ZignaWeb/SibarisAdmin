<div class="margenes">
	<div class="cuadro">
    	<?
		if ($_GET["e"]!=""){
			echo "<p>".$error[$_GET["e"]]."</p>";
		}
        ?>
        
        <form id="login" action="logincheck.php" method="post">
            <label><span>Nombre de usuario</span><input name="usr" id="usr" type="text" value=""></label><br />
            <label><span>Contrase&ntilde;a</span><input name="psw" id="psw" type="password" value=""></label><br />
            <input type="submit" />
        </form>
	</div>
</div>