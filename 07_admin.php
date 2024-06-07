<!DOCTYPE html>
<html lang="et">
<head>
<meta charset="UTF-8">
<title>Salajane info</title>
</head>
<body>
<h1>Salajane info</h1>
<p>Salainfo</p>
<form action="07_logout.php" method="post">
<input type="submit" value="Logi välja" name="logout">
</form>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<label for="artist">Kasutaja</label><br>
<input type="text" id="artist" name="kasutaja"><br>
<label for="album">Parool</label><br>
<input type="password" id="album" name="parool"><br>
<input type="submit" name="submit" value="Lisa">
</form>
<?php
session_start();
if (!isset($_SESSION['tuvastamine'])) {
header('Location: 07_login.php');
exit();
}
include('config.php');
if (isset($_POST['submit'])) {
$artist = htmlspecialchars(trim($_POST['kasutaja']));
$album = htmlspecialchars(trim($_POST['parool']));
if (strlen($album) < 8) {
die('parool pole 8 tähte pikk');
}
$a3 = $yhendus->prepare('SELECT COUNT(*) FROM kasutajad WHERE kasutaja = ?');
$a3->bind_param("s", $artist);
$a3->execute();
$a3->bind_result($count);
$a3->fetch();
$a3->close();
if ($count > 0) {
die('Kasutajanimi juba eksisteerib.');
}
$sool = 'taiestisuvalinetekst';
$kryp = crypt($album, $sool);
$maxid = "SELECT MAX(id) AS max_id FROM kasutajad";
$res = mysqli_query($yhendus, $maxid);
$a1 = mysqli_fetch_assoc($res);
$id2 = $a1['max_id'] + 1;
$lisamine_paring = $yhendus->prepare("INSERT INTO kasutajad (id, kasutaja, parool) VALUES (?, ?, ?)");
$lisamine_paring->bind_param("iss", $id2, $artist, $kryp);
$lisamine_paring->execute();
$lisamine_paring->close();
echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$_SERVER['PHP_SELF'].'">';
}
?>
</body>
</html>
