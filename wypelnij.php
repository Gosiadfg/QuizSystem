<?php
  session_start();

    if(!isset($_SESSION['zalogowany']))
  {
	header('Location: index.php');
	exit();
  }
  
  $wszystko_OK=true;
   if(!isset($_SESSION['odpowiedzi'])) $_SESSION['odpowiedzi']= array();
  
  if(isset($_POST['submitbutton']))
  {
	$submitbutton= $_POST['submitbutton'];

	if ($submitbutton){
	
		for($i=1;$i<=$_SESSION['liczbapytan'];$i++)
		{
			if(isset($_POST['odp'.$i]))
			{
				$_SESSION['radio_odp'.$i] = true;
				//$_POST['odp'.$i].checked == "checked";
			}
			else
			{
				$wszystko_OK=false;
				$_SESSION['e_radiobutton'.$i]='<span style="color:red">Zaznacz odpowiedź!</span>';
			}
		}
		
		if($wszystko_OK==true)
		{		
			for($i=1;$i<=$_SESSION['liczbapytan'];$i++)
			{
				echo $_POST['odp'.$i];
				array_push($_SESSION['odpowiedzi'],$_POST['odp'.$i]);
			}
			
			$_SESSION['zaznaczonaodp']=true;
			//$_SESSION['odp'.$i] = $_POST['odp'.$i];
			
			header('Location: wynikiquizu.php');
			exit();
		}
	}
 }
?>

<!DOCTYPE HTML>
<html lang="pl">

<head>
 <meta charset="utf-8"/>
 <title>System quizów </title>
 <meta name="description" content ="Stwórz swój własny quiz lub rozwiąż quiz, żeby sprawdzić swoją wiedzę! />
 <meta name="keywords" content="quiz, system quizów, kreatro quizów, stwórz quiz, rozwiąż quiz, test wiedzy" />
 <meta http-equiv="X-UA-Compatible" content=IE=edge,chrome=1" />
 <meta name="author" content="Małgorzata Sierbin" />
 <link rel="stylesheet" href="style.css" type="text/css"/>
 
   <style>
	.odpowiedz
	{
		text-align:left;
		float:center;
		margin-left:160px;
		margin-right:auto;
		min-width:50px;
		height:25px;
		font-size:15px;
		padding:5px;
	}
  </style>
  
</head>

<body>
 <div id="container">
  <div id="logo">
   <a href="index.php" title=""><h1>System quizów - wypełnij quiz</h1></a> 
  </div>
 
  <div id="content">
	
<?php	
    //session_start();
  
 	$autor=$_SESSION['user'];
	$id=$_GET['id'];
	$_SESSION['currentquizid'] = $_GET['id'];
	
	
	require_once "connect2.php";

	try
	{
		$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
		$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
			
		 if($polaczenie->connect_errno!=0)
		 {
			throw new Exception (mysqli_connect_errno());
		 }
		 else
		 {	
			$id=htmlspecialchars($id, ENT_QUOTES, "UTF-8");
		
			$rezultat=$polaczenie->query(sprintf("SELECT * FROM quiz WHERE id='%s'",mysqli_real_escape_string($polaczenie,$id)));
			
			if(!$rezultat) throw new Exception($polaczenie->error);
			
			$wiersz = $rezultat->fetch_assoc();	
			
			?>

<form method="post">
	  
   <div class="option3">Nazwa quizu: <?php echo $wiersz['nazwa']; ?> </div> <br/>

   <?php   
			$_SESSION['czasstartu']=date('H:i:s');
			
            $rezultat2=$polaczenie->query(sprintf("SELECT * FROM pytania WHERE quizID='%s'",mysqli_real_escape_string($polaczenie,$id)));
			
			if(!$rezultat2) throw new Exception($polaczenie->error);
			
			$_SESSION['liczbapytan']= $rezultat2->num_rows;
			$i=1;
			while( $wiersz2 = $rezultat2->fetch_assoc())
			{
				$idpytania= $wiersz2['id'];
			
				$rezultat3=$polaczenie->query("SELECT * FROM odpowiedzi WHERE pytanieID='$idpytania'");
			
				if(!$rezultat3) throw new Exception($polaczenie->error);		
    ?>	
				<p>
		   <div class="option3">Pytanie nr  <?php echo  $i.':'.' '.$wiersz2['tresc']; ?> </div>
	
			<?php
			
			while( $wiersz3 = $rezultat3->fetch_assoc())
			{				
				$idodp= $wiersz3['id'];
			?>
			<label>
			  <div class="odpowiedz">
			  
			  <input type="radio" name="odp<?php echo $i?>" value="<?php echo $idodp.'"'; if(isset($_POST['odp'.$i]))if($_POST['odp'.$i]==$idodp)echo 'checked="checked"';?>> 
			  <?php echo $wiersz3['tresc']; 

			  if(isset($_SESSION['radio_odp'.$i]))
			  {
				//echo "checked";
				unset($_SESSION['radio_odp'.$i]);	
			  } 
			
			  ?>	  
			  <p>
			  </div>
			</label> 

	<?php
			};
			if(isset($_SESSION['e_radiobutton'.$i]))
			  {
				echo '<div class="error">'.$_SESSION['e_radiobutton'.$i].'</div>';
				unset($_SESSION['e_radiobutton'.$i]);
			  }
			    $i++;
		};
	  
	?>
	
	<br /><br /><br />
	<input type="submit" name="submitbutton" value="Sprawdź wynik">
	 </form>
	 
	<?php

	}
	$polaczenie->close();
    }
	catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera!</span>';
	}
	?>
	<div class="wyloguj"><a href="profil.php" title=""><center>Wróć</center></a></div>
	 <div style="clear:both"></div>
  </div>
 
  <div id="footer">
   <h1>&copy; Wszelkie prawa zastrzeżone</h1>
  </div>
 </div>
</body>
</html>