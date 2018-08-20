<?php
session_start();
require_once "includes/functions.php";
	error_reporting(0);

$title = "Popis komponenti";

$con = spajanje();
if($_SESSION['uloga'] !== "1"){
	$sql = "SELECT
			proizvodi.id,
			proizvodi.ddr_type,
			proizvodi.socket,
			proizvodi.chipset,
			proizvodi.velicina,
			proizvodi.watt,
			proizvodi.cijena,
			proizvodi.naziv_proizvoda,
			proizvodi.url,
			proizvodac.naziv_proizvodaca,
			tipovi_komponenti.naziv
		FROM
			proizvodi
		INNER JOIN proizvodac ON proizvodac.id = proizvodi.id_proizvodac_fk	
		INNER JOIN tipovi_komponenti ON tipovi_komponenti.id = proizvodi.komponenta_tip_fk;";

$result = mysqli_query($con, $sql);

require_once "includes/header_projekt.php";


if (mysqli_num_rows($result)>0){
	// ispisi_polje(mysqli_fetch_assoc($result));
	echo '
	<table id = "table" class="table table-hover display" style="width:100%">
		<thead>
			<tr>
				<th>ID</th>
				<th>DDR tip</th>
				<th>socket</th>
				<th>chipset</th>
				<th>proizvodac</th>
                <th>tip komponente</th>
				<th>velicina</th>
				<th>watt</th>
				<th>cijena</th>
				<th>naziv proizvoda</th>
				<th></th>
			</tr>
		</thead>
		<tbody>';

	while($proizvod = mysqli_fetch_assoc($result)){
		echo "
			<tr>
				<td>".$proizvod['id']."</td>
				<td>".$proizvod['ddr_type']."</td>
				<td>".$proizvod['socket']."</td>
				<td>".$proizvod['chipset']."</td>
				<td>".$proizvod['naziv_proizvodaca']."</td>
				<td>".$proizvod['naziv']."</td>
				<td>".$proizvod['velicina']."</td>
				<td>".$proizvod['watt']."</td>
				<td>".$proizvod['cijena']."</td>
				<td>".$proizvod['naziv_proizvoda']."</td>
				<td><img src = ".$proizvod['url']." alt = 'slika' class = 'img-fluid img-thumbnail'></td>
			</tr>";
	}
	echo "</tbody></table>";
}
else {
	echo "<p>U bazi nema rezultata za ovaj upit: $sql </p>";
}
//--------------------------------
require_once "includes/footer_projekt.php";
//--------------------------------

}

else{
$sql = "SELECT
			proizvodi.id,
			proizvodi.ddr_type,
			proizvodi.socket,
			proizvodi.chipset,
			proizvodi.velicina,
			proizvodi.watt,
			proizvodi.cijena,
			proizvodi.naziv_proizvoda,
			proizvodi.url,
			proizvodac.naziv_proizvodaca,
			tipovi_komponenti.naziv
		FROM
			proizvodi
		INNER JOIN proizvodac ON proizvodac.id = proizvodi.id_proizvodac_fk	
		INNER JOIN tipovi_komponenti ON tipovi_komponenti.id = proizvodi.komponenta_tip_fk;";

$result = mysqli_query($con, $sql);


	

if(isset($_GET['obrisi']) and isset($_GET['id']) ){
	drop("proizvodi");
	header("Location:komponente.php");
	
}

require_once "includes/header_projekt.php";


if (mysqli_num_rows($result)>0){
	// ispisi_polje(mysqli_fetch_assoc($result));
	echo '
	<table id = "table" class="table table-hover display" style="width:100%">
		<thead>
			<tr>
				<th>ID</th>
				<th>DDR tip</th>
				<th>socket</th>
				<th>chipset</th>
				<th>proizvodac</th>
                <th>tip komponente</th>
				<th>velicina</th>
				<th>watt</th>
				<th>cijena</th>
				<th>naziv proizvoda</th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>';

	while($proizvod = mysqli_fetch_assoc($result)){
		echo "
			<tr>
				<td>".$proizvod['id']."</td>
				<td>".$proizvod['ddr_type']."</td>
				<td>".$proizvod['socket']."</td>
				<td>".$proizvod['chipset']."</td>
				<td>".$proizvod['naziv_proizvodaca']."</td>
				<td>".$proizvod['naziv']."</td>
				<td>".$proizvod['velicina']."</td>
				<td>".$proizvod['watt']."</td>
				<td>".$proizvod['cijena']."</td>
				<td>".$proizvod['naziv_proizvoda']."</td>
				<td><img src = ".$proizvod['url']." alt = 'slika' class = 'img-fluid img-thumbnail'></td>
	
				
				<td>
					<a href='komponenta.php?id=".$proizvod["id"]."'><button class = 'btn btn-primary' value = 'uredi' name='uredi' id='uredi''>Uredi</button></a>
				</td>
				<td>
					<a href='komponente.php?obrisi=true&id=".$proizvod['id']."' onclick='return confirm(\"Jeste li sigurni da zelite obrisati proizvod?\")'>
                        <button class = 'btn btn-primary' value = 'obrisi' name='obrisi' id='obrisi'>Obriši</button>
                    </a>
				</td>
			</tr>";
	}
	echo "</tbody></table>";
}
else {
	echo "<p>U bazi nema rezultata za ovaj upit: $sql </p>";
}
}
//--------------------------------
require_once "includes/footer_projekt.php";
//--------------------------------
							
?>
						
						
						
						
					















