<?php include('config.php'); ?>
<?php
echo '<span style="font-size: 30px;">Artistid 10 kaupa</span><br>';
$paring = 'SELECT * FROM albumid LIMIT 10';
$valjund = mysqli_query($yhendus, $paring);
//päringu vastuste arv
$tulemusi = mysqli_num_rows($valjund);

while($rida = mysqli_fetch_assoc($valjund)){
echo $rida['Artist'].'<br>';
}

echo '<span style="font-size: 30px;">Artistid ja albumid</span><br>';
$paring = 'SELECT * FROM albumid LIMIT 10';
$valjund = mysqli_query($yhendus, $paring);
//päringu vastuste arv
$tulemusi = mysqli_num_rows($valjund);

while($rida = mysqli_fetch_assoc($valjund)){
echo $rida['Artist'].' - '.$rida['Album'].'<br>';
}
echo '<span style="font-size: 30px;">artist ja album read, mille aasta on 2010 ja uuemad</span><br>';
$paring = 'SELECT * FROM albumid WHERE aasta > 2010 LIMIT 10;';
$valjund = mysqli_query($yhendus, $paring);
//päringu vastuste arv
$tulemusi = mysqli_num_rows($valjund);
while($rida = mysqli_fetch_assoc($valjund)){
echo $rida['Artist'].' - '.$rida['Album'].'<br>';
}
echo '<span style="font-size: 30px;">palju erinevaid albumeid on andmebaasis, mis on nende keskmine hind ja koguväärtus (summa)</span><br>';
$paring = 'SELECT COUNT(*) AS Albumite_arv, AVG(hind) AS kesk_hind, SUM(hind) AS kokku FROM albumid;';
$valjund = mysqli_query($yhendus, $paring);
//päringu vastuste arv
$tulemusi = mysqli_num_rows($valjund);

while($rida = mysqli_fetch_assoc($valjund))
echo 'Albumeid on kokku='.$rida['Albumite_arv'].'<br>'. 'Keskmine hind on='.$rida['kesk_hind']. '<br>'.'Kokku maksavad kõik='.$rida['kokku'].'<br>';
echo '<span style="font-size: 30px;">Kõige vanem album ja selle nimi</span><br>';
$paring = 'SELECT Album AS album_name, aasta AS album_year FROM albumid WHERE aasta = (SELECT MIN(aasta) FROM albumid)';         
$valjund = mysqli_query($yhendus, $paring);
$tulemusi = mysqli_num_rows($valjund);
while ($rida = mysqli_fetch_assoc($valjund)) {
echo $rida['album_name'].' aastast '.$rida['album_year'].'<br>';
}
echo '<span style="font-size: 30px;">albumid, mille hind on kogu keskmisest suurem</span><br>';
$paring = 'SELECT album AS album1, hind AS hind1 FROM albumid WHERE hind > (SELECT AVG(hind) FROM albumid);';
$valjund = mysqli_query($yhendus, $paring);
$tulemusi = mysqli_num_rows($valjund);
while($rida = mysqli_fetch_assoc($valjund)){
echo $rida['album1'].' mille hind on '.$rida['hind1'].'<br>';
}
echo '<span style="font-size: 30px;">paringukast</span><br>';
if (!empty($_GET['otsi'])) {
$otsi = $_GET['otsi'];
$otsi = htmlspecialchars(trim($otsi));
if (isset($_GET['otsi_mis'])) {
if ($_GET['otsi_mis'] == 'artist') {
$paring = 'SELECT artist AS nimi, album AS pealkiri, aasta AS ilmumisaasta FROM albumid WHERE artist LIKE "%'.$otsi.'%"';
} elseif ($_GET['otsi_mis'] == 'album') {
$paring = 'SELECT artist AS nimi, album AS pealkiri, aasta AS ilmumisaasta FROM albumid WHERE album LIKE "%'.$otsi.'%"';
}
}
$valjund = mysqli_query($yhendus, $paring);
$tulemusi = mysqli_num_rows($valjund);
echo 'Otsingusõna: '.$otsi.'<br>';
echo 'Vastused: <br>';
if ($tulemusi == 0) {
echo "Leiti 0 vastust!";
}
while($rida = mysqli_fetch_assoc($valjund)){
echo $rida['nimi'].' - '.$rida['pealkiri'].' - '.$rida['ilmumisaasta'].'<br>';
}
mysqli_free_result($valjund);
mysqli_close($yhendus); 
}
?>
<form method="get" action="">
    Otsi <input type="text" name="otsi">
    <select name="otsi_mis">
        <option value="artist">Artist</option>
        <option value="album">Album</option>
    </select>
    <input type="submit" value="Otsi...">
</form>