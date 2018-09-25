<?php
session_start();
require_once "includes/functions.php";
	error_reporting(0);

$title = "Napajanje";

$con = spajanje();

	$sql="SELECT
    proizvodi.id,
    proizvodi.watt,
    proizvodi.cijena,
    proizvodi.naziv_proizvoda,
    proizvodi.url,
    tipovi_komponenti.naziv,
    proizvodac.naziv_proizvodaca
FROM
    proizvodi
INNER JOIN tipovi_komponenti ON proizvodi.komponenta_tip_fk = tipovi_komponenti.id
INNER JOIN proizvodac ON proizvodac.id = proizvodi.id_proizvodac_fk
WHERE
    proizvodi.komponenta_tip_fk = '3';";

$result = mysqli_query($con, $sql);

require_once "includes/header_projekt.php";


if (mysqli_num_rows($result)>0){
	// ispisi_polje(mysqli_fetch_assoc($result));
	echo '
	<table id = "table" class="table table-hover display" style="width:100%">
		<thead>
			<tr>
				<th>ID</th>
				<th>watt</th>
				<th>proizvodac</th>
                <th>tip komponente</th>
				<th>cijena</th>
				<th>naziv proizvoda</th>
				<th></th>
			</tr>
		</thead>
		<tbody>';

	while($proizvod = mysqli_fetch_assoc($result)){
		echo "
			<tr class = 'clickable-row-item' id = ".$proizvod['id'].">
				<td>".$proizvod['id']."</td>
				<td>".$proizvod['watt']."</td>
				<td>".$proizvod['naziv_proizvodaca']."</td>
				<td>".$proizvod['naziv']."</td>
				<td>".$proizvod['cijena']."</td>
				<td>".$proizvod['naziv_proizvoda']."</td>
				<td><img  src = ".$proizvod['url']." alt = 'slika' class = 'img-fluid small-thumbnail'></td>
			</tr>";
	}
	echo "</tbody></table>";
}


(ispisi_polje($proizvod));
//--------------------------------
require_once "includes/footer_projekt.php";
//--------------------------------

?>
						
						
						
						
					















