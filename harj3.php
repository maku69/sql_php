<?php include('config.php'); ?>
<table border="1">
<?php
$paring = 'SELECT * FROM albumid';
$valjund = mysqli_query($yhendus, $paring);
while($rida = mysqli_fetch_assoc($valjund)){
echo '<tr>
<td>'.$rida['Artist'].'</td>
<td>'.$rida['Album'].'</td>
<td>'.$rida['Aasta'].'</td>
<td>'.$rida['Hind'].'</td>
<td><a href="'.$_SERVER['PHP_SELF'].'?delete_id='.$rida["ID"].'">kustuta</a></td>
<td><a href="'.$_SERVER['PHP_SELF'].'?edit_id='.$rida["ID"].'">muuda</a></td>
</tr>';
}
if(isset($_GET['delete_id'])){
$id = $_GET['delete_id'];
$kustuta_paring = "DELETE FROM albumid WHERE ID='$id'";
$kustuta_valjund = mysqli_query($yhendus, $kustuta_paring);
echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$_SERVER['PHP_SELF'].'">';
}
?>
</table>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<label for="artist">Artist:</label><br>
<input type="text" id="artist" name="artist"><br>
<label for="album">Album:</label><br>
<input type="text" id="album" name="album"><br>
<label for="aasta">Aasta:</label><br>
<input type="text" id="aasta" name="aasta"><br>
<label for="hind">Hind:</label><br>
<input type="text" id="hind" name="hind"><br><br>
<input type="submit" name="submit" value="Lisa">
</form>
<?php
if (isset($_POST['submit'])) {
$artist = $_POST['artist'];
$album = $_POST['album'];
$aasta = $_POST['aasta'];
$hind = $_POST['hind'];
$lisamine_paring = $yhendus->prepare("INSERT INTO albumid (Artist, Album, Aasta, Hind) VALUES (?, ?, ?, ?)");
$lisamine_paring->bind_param("ssii", $artist, $album, $aasta, $hind);
$lisamine_paring->execute();
$lisamine_paring->close();
echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$_SERVER['PHP_SELF'].'">';
}
if (isset($_GET['edit_id'])) {
$edit_id = $_GET['edit_id'];
$result = mysqli_query($yhendus, "SELECT * FROM albumid WHERE ID=$edit_id");
$album = mysqli_fetch_assoc($result);
?>
<h2>Muuda albumit</h2>
<form method="post" action="">
<input type="hidden" name="ID" value="<?php echo $album['ID']; ?>">
<input type="text" name="artist" value="<?php echo $album['Artist']; ?>" required>
<input type="text" name="album" value="<?php echo $album['Album']; ?>" required>
<input type="number" name="aasta" value="<?php echo $album['Aasta']; ?>" required>
<input type="number" name="hind" value="<?php echo $album['Hind']; ?>" required>
<button type="submit" name="edit">Muuda albumit</button>
</form>
<?php
}
if (isset($_POST['edit'])) {
$id = $_POST['ID'];
$artist = $_POST['artist'];
$album = $_POST['album'];
$aasta = $_POST['aasta'];
$hind = $_POST['hind'];
$muutmine_paring = "UPDATE albumid SET Artist='$artist', Album='$album', Aasta='$aasta', Hind='$hind' WHERE ID='$id'";
mysqli_query($yhendus, $muutmine_paring);
echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$_SERVER['PHP_SELF'].'">';
}
mysqli_close($yhendus);
?>
