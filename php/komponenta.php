<?php
session_start();
require_once "includes/functions.php";
$con = spajanje();
$title = "Proizvod";
if($_SESSION['uloga'] !== "1"){
	die('<div class="alert" style="background:yellow;"> 
	<a href="index.php" class="close" data-dismiss="alert" aria-label="close">
	&times;
	</a>
	<strong>Nemate ovlasti za pristup ovoj stranici!</strong>
	
	</div>');
}
else{
if(!empty($_POST['spremi'])){
	
		$ddr_type = ocisti_tekst($_POST['ddr_type']);
        $socket = ocisti_tekst($_POST['socket']);
        $chipset = ocisti_tekst($_POST['chipset']);
        $id_proizvodac_fk  = ocisti_tekst($_POST['id_proizvodac_fk']);
        $komponenta_tip_fk = ocisti_tekst($_POST['komponenta_tip_fk']);
        $velicina = ocisti_tekst($_POST['velicina']);
        $watt = ocisti_tekst($_POST['watt']); 
        $cijena = ocisti_tekst($_POST['cijena']); 
        $naziv_proizvoda = ocisti_tekst($_POST['naziv_proizvoda']); 
	

	$sql = "UPDATE proizvodi 
			SET
				ddr_type='$ddr_type',
				socket='$socket',
				chipset='$chipset',
				id_proizvodac_fk = $id_proizvodac_fk,
				komponenta_tip_fk = $komponenta_tip_fk, 
				velicina='$velicina',              
				watt='$watt',
				cijena='$cijena',
				naziv_proizvoda='$naziv_proizvoda'
			WHERE
				id = {$_GET['id']}
			;";
	
	$rez = mysqli_query($con, $sql);
	echo mysqli_error($con);

	
}

if(!isset($_GET['id'])){
	die("Nije predan id parametar!");
}

$id = $_GET['id'];
$sql = "SELECT * 
		FROM proizvodi 
		WHERE id = $id;";


$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result)==1){
	$proizvodi = mysqli_fetch_assoc($result);
}
else {
	$proizvodi = null;
	die('<div class="alert" style="background:yellow;"> 
        <a href="index.php" class="close" data-dismiss="alert" aria-label="close">
        &times;
        </a>
        <strong>Nije odabran niti jedan proizvod!</strong>
        
        </div>');
}
}
require_once "includes/header_projekt.php";

?>
<div class = "container">
<form class="form-horizontal" action ="" method = "post">
	
	<div class="form-group">
		<label for="id_proizvodi" class="col-sm-2 control-label">ID</label>
		<div class="col-sm-5">
		  <input type="text" class="form-control" placeholder="id_proizvodi" value="<?php if(isset($proizvodi['id'])) echo  $proizvodi['id'];?>" disabled="disabled">
		  <input type="text" id="id_proizvodi" name="id_proizvodi" placeholder="id_proizvodi" value="<?php if(isset($proizvodi['id'])) echo $proizvodi['id'] ?>" hidden="hidden">
		</div>
	</div>
	
	
	<div style = "margin-top:10px;" class="form-group">
		    <label for ="ddr_type" class="col-sm-2 control-label">DDR tip</label>
		        <div class = "col-sm-7">
			        <input type="text" id="ddr_type" name="ddr_type" class ="form-control" value="<?=$proizvodi['ddr_type'];?>" >
		        </div>
	    </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="socket">Unesite socket:</label>
                <div class = "col-sm-7">
                    <input class ="form-control" type="text" name='socket' id='socket'  value = "<?=$proizvodi['socket'];?>" > 
                </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-2 control-label" for="chipset">Unesite chipset:</label>
                <div class = "col-sm-7">
                    <input class ="form-control" type="text" name='chipset' id='chipset'  value = "<?=$proizvodi['chipset'];?>" >
                </div>
        </div>

         <!-- select -->
        <div class="form-group">
          <label class="col-sm-2 control-label" for="id_proizvodac_fk">Odaberite proizvodača:</label>
            <div class = "col-sm-7">
                <select class ="form-control" type="text" name='id_proizvodac_fk' id='id_proizvodac_fk' required>
                
                <option value="NULL" selected disabled>--</option>

                <?php 
                
                $sql = "SELECT * FROM proizvodac;";

				$res = mysqli_query($con, $sql);

				if(mysqli_num_rows($res)>0){
					while($maker = mysqli_fetch_assoc($res)){
						error_reporting(0);

						echo '<option value="'.$maker['id'].'"';
						
						if($maker['id'] == $proizvodi['id_proizvodac_fk'])
							echo "selected";
					
						echo '>';
						echo $maker['naziv_proizvodaca'];
						echo '</option>';
					}
				}
                ?>

                </select>
            </div>
        </div>
		<!-- select -->
        <div class="form-group">
          <label class="col-sm-2 control-label" for="komponenta_tip_fk">Odaberite tip komponente:</label>
            <div class = "col-sm-7">
                <select class ="form-control" type="text" name='komponenta_tip_fk' id='komponenta_tip_fk' required>
                
                <option value="NULL" selected disabled>--</option>

                <?php 
                
                $sql = "SELECT * FROM tipovi_komponenti;";

				$res = mysqli_query($con, $sql);

				if(mysqli_num_rows($res)>0){
					while($type = mysqli_fetch_assoc($res)){
						error_reporting(0);

						echo '<option value="'.$type['id'].'"';
						
						if($type['id'] == $proizvodi['komponenta_tip_fk'])
							echo "selected";
					
						echo '>';
						echo $type['naziv'];
						echo '</option>';
					}
				}

                ?>

                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="velicina">Unesite veličinu:</label>
                <div class = "col-sm-7">
                    <input class ="form-control" type="text" name='velicina' id='velicina' value = "<?=$proizvodi['velicina'];?>" >
                </div>
        </div>

        <div class="form-group"> 
            <label class="col-sm-2 control-label" for="watt">Upišite snagu:</label>
                <div class = "col-sm-7">
                    <input class ="form-control" type="text" name='watt' id='watt' value = "<?=$proizvodi['watt'];?>">
                </div>
        </div>



        <div class="form-group"> 
            <label class="col-sm-2 control-label" for="cijena">Upišite cijenu:</label>
                <div class = "col-sm-7">
                    <input class ="form-control" type="text" name='cijena' id='cijena' value = "<?=$proizvodi['cijena'];?>" step = "0.01" required>
                </div>
        </div>
		
		 <div class="form-group"> 
            <label class="col-sm-2 control-label" for="naziv_proizvoda">Upišite naziv proizvoda:</label>
                <div class = "col-sm-7">
                    <input class ="form-control" type="text" name='naziv_proizvoda' id='naziv_proizvoda' value = "<?=$proizvodi['naziv_proizvoda'];?>" required>
                </div>
        </div>


        <div class="form-group">
          <div class="col-sm-2 col-sm-offset-5">
            <input class ="form-control btn btn-primary" id="spremi" value = "spremi" name="spremi" type="submit">
          </div>
        </div>
    </form>   
</div>


<?php

//--------------------------------
require "includes/footer_projekt.php";
							
?>