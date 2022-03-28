
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta charset="utf-8" />
<title>Kalkulator raty kredytu</title>
</head>
<body>
<h1> Kalkulator raty kredytu </h1>

<form action="<?php print(_APP_URL);?>/app/calc.php" method="post">
	<label for="id_N">Kwota kredytu: </label>
	<input id="id_N" type="text" name="N" value="<?php if (isset($N)) print($N); ?>" /><br/><br/>
	<label for="id_o">Okres spłaty: </label>
	<input id="id_o" type="text" name="o" placeholder="Ile lat"   value="<?php if (isset($o)) print($o); ?>" /><br/><br/>
	<label for="id_r">Oprocentowanie: </label>
	<input id="id_r" type="text" name="r" placeholder="6.5" value="<?php if (isset($r)) print($r); ?>" /><br/>
	<input type="submit" value="Oblicz" />
</form>	

<?php
//wyświeltenie listy błędów, jeśli istnieją
if (isset($messages)) {
	if (count ( $messages ) > 0) {
		echo '<ol style="margin: 20px; padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #f22; width:300px;">';
		foreach ( $messages as $key => $msg ) {
			echo '<li>'.$msg.'</li>';
		}
		echo '</ol>';
	}
}
?>

<?php if (isset($result)){ ?>
<div style="margin: 20px; padding: 10px; border-radius: 5px; background-color: #0f0; width:300px;">
<?php echo 'Rata miesięczna wynosi: '.$result.'zł'; ?>
</div>
<?php } ?>

</body>
</html>