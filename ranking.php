<?php
  session_start();
  
  if(!isset($_SESSION['zalogowany']))
  {
	header('Location: index.php');
	exit();
  }
 ?>
 
 <!DOCTYPE HTML>
<html lang="pl">
<head>
 <meta charset="utf-8"/>
 <title>System quizów </title>
 <meta name="description" content ="Stwórz swój własny quiz lub rozwiąż quiz, żeby sprawdzić swoją wiedzę! />
 <meta name="keywords" content="quiz, system quizów, kreator quizów, stwórz quiz, rozwiąż quiz, test wiedzy" />
 <meta http-equiv="X-UA-Compatible" content=IE=edge,chrome=1" />
 <meta name="author" content="" />
 <link rel="stylesheet" href="style.css" type="text/css"/>
</head>

<body>

<div id="container">
  <div id="logo">
   <a href="index.php" title=""><h1>System quizów - wyniki quizu</h1></a> 
  </div>
  <div id="content"> 
  
  <?php

	$id = $_GET['id'];
  
	$autor=$_SESSION['user'];
	
	require_once "connect2.php";

	try
	{
		$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
		$polaczenie->query("SET NAMES 'utf8'");
		 if($polaczenie->connect_errno!=0)
		 {
			throw new Exception (mysqli_connect_errno());
		 }
		 else
		 {			
		    $id=htmlspecialchars($id, ENT_QUOTES, "UTF-8");
		
			$rezultat=$polaczenie->query(sprintf("SELECT * FROM ranking WHERE quizID='%s' ORDER BY wynik DESC, czas ASC",mysqli_real_escape_string($polaczenie,$id)));
			
			if(!$rezultat) throw new Exception($polaczenie->error);
			
			$lista=array();

			while($wiersz = $rezultat->fetch_assoc())
			{
				$rekord=array();
				
				$userID=$wiersz['loginID'];
				
				$rezultat2=$polaczenie->query("SELECT * FROM login WHERE id='$userID'");
			
				if(!$rezultat2) throw new Exception($polaczenie->error);
				
				$wiersz2 = $rezultat2->fetch_assoc();
		
				$login=$wiersz2['Login'];
				$wynik=$wiersz['wynik'];
				$czas=$wiersz['czas'];
				
				array_push($rekord,$login);
				array_push($rekord,$wynik);
				array_push($rekord,$czas);
				array_push($lista,$rekord);			
			}		
			$polaczenie->close();
		 }
	}
	catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera!</span>';
	}
 ?>
 
 <style>
	table {
	  border-collapse: collapse;
	}

	table, td, th {
	  border: 1px solid black;
	}
</style>

  <h3>Ranking:</h3>  
  
  <center><table style="width:30%">
   <tr>
    <th>Miejsce</th>
    <th>Login</th> 
    <th>Wynik (%)</th>
	<th>Czas</th>
  </tr>

	 <?php 
	  $i=1;
  foreach($lista as $item)
  { 
  ?>
    <tr>
	<td><?php echo $i; ?></td>
	<?php
	foreach($item as $item2)
	{ 
		?>
		<td><?php echo $item2; ?></td>
		<?php

	}?> 
		</tr>
	<?php
	$i++;
  } 
  ?>
	
</table></center>
  
  <br /><br />

   <div class="option"><a href="profil.php">Wróć na swoje konto!</a></div>
  <br /><br />
  </div>
</div>
</body>
</html>
