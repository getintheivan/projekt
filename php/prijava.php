<?php

session_start();
$title = "Prijava";
$naslov = "Prijava";

require_once "includes/functions.php";
$con = spajanje();

//--------------------------------
//naš kod ide ovdje
//--------------------------------

//provjera forme
if(isset($_POST['submit'])){
	
	if(isset($_POST['username']) and isset($_POST['password'])){
		
		$username = ocisti_tekst($_POST['username']);
		$password = md5(ocisti_tekst($_POST['password']));
		
		//echo "username = " . $username;
		
		$sql = "SELECT *
				FROM users
				WHERE username = '$username'";
		
		$rezultat=mysqli_query($con,$sql);
		
		//echo "rezultat = ";
		//var_dump ($rezultat);
		
		if(mysqli_num_rows($rezultat) == 1){
			
			$user= mysqli_fetch_assoc($rezultat);
			
			if($password == $user['password']){
				
				$_SESSION['login'] = true;
				$_SESSION['username'] = $username;
				$_SESSION['uloga'] = $user['id_status_fk'];
				
				if(isset($_POST['zapamti'])){
					setcookiealive('username',$username, time()+7*24*60*60);
				}else{
					setcookiealive('username',$username, time()-7*24*60*60);
				}
				// header("Location:index.php");
				// exit();
			}
			else{
				
				$greska.="Pogrešna lozinka";
			}
		}
		else{
			
			$greska.="Nepostojeće korisničko ime";
		}
		
	}
	else{
		$greska.="Molim popunite formu!";
	}
		
}

if(!isset($_SESSION['login'])){
	
	if(isset($_COOKIE['username'])){
		
		$_SESSION['login']=true;
		$_SESSION['username'] = $_COOKIE['username'];
		
	}
}

require_once "includes/header_projekt.php";

if(isset($_GET['prijava'])){
	echo '
		<div class="alert alert-warning">
			<a href="#" class="close" 
			data-dismiss="alert" aria-label="close">&times;</a>
			
			<strong>Upozorenje!</strong> Morate se najprije prijaviti!
			
		</div>
	';
}

if(empty($_SESSION)){
	
echo '
 <header class="masthead"> 
	
      <div class="container">
        <div class="intro-text">
	
       
        </div>
		
      </div>
	
    </header>
	<div class ="container">
<form class = "form-horizontal" action="" method = "post">
	
	<div class="form-group">
		<label for="username" class="col-sm-3 control-label">Username:</label>
		<div class="col-sm-5">
			<input type="text" class="form-control" value = "" id="username" name="username"/>
		</div>
	</div>
	
	<div class="form-group">
		<label for="password" class="col-sm-3 control-label">Password:</label>
		<div class="col-sm-5">
			<input type="password" class="form-control" value = "" id="password" name="password"/>
		</div>
	</div>
	
	<div class="form-group">
		<label for="zapamti" class="col-sm-3 control-label">Zapamti me:</label>
		<div class="col-sm-5">
			<input type="checkbox" id="zapamti" name="zapamti" value="zapamti" />
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-sm-offset-6 col-sm-2">
			<button class="btn btn-primary" type="submit" id="submit" name="submit" value="submit">
				Prijava
			</button>
		</div>
	</div>
	
</form>
</div>
';

}
else{
	echo "<h2> Pozdrav, ".$_SESSION['username']."</h2>";
}



mysqli_close($con);

//--------------------------------
require "includes/footer_projekt.php";
							
?>