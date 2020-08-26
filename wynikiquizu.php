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

  session_start();
  
    if(!isset($_SESSION['zalogowany']) || !isset($_SESSION['odpowiedzi']))
  {
	header('Location: index.php');
	exit();
  }
  
  $id=$_SESSION['currentquizid'];
  $odp = $_SESSION['odpowiedzi'];
  unset($_SESSION['odpowiedzi']);
 
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
		
			$rezultat=$polaczenie->query(sprintf("SELECT * FROM quiz WHERE id='%s'",mysqli_real_escape_string($polaczenie,$id)));
			
			$wiersz = $rezultat->fetch_assoc();	
			
			//$obecnanazwa=$wiersz["nazwaquizu"];
			
			if(!$rezultat) throw new Exception($polaczenie->error);
			
			
			$rezultat2=$polaczenie->query(sprintf("SELECT * FROM pytania WHERE quizID='$id'",mysqli_real_escape_string($polaczenie,$id)));
			
			//$wiersz2 = $rezultat2->fetch_assoc();	
			
			if(!$rezultat2) throw new Exception($polaczenie->error);
			
			$odp3=array();
			while($wiersz2 = $rezultat2->fetch_assoc())
			{
				$idpytania=$wiersz2['id'];
				
				$rezultat3=$polaczenie->query("SELECT tresc FROM odpowiedzi WHERE czyprawidlowa=1 AND pytanieID=$idpytania");
				
				$wiersz3 = $rezultat3->fetch_assoc();	
				
				if(!$rezultat3) throw new Exception($polaczenie->error);
				
				array_push($odp3,$wiersz3);
			}
			
			$odp2=array();
			foreach($odp as $item){
				$rezultat4=$polaczenie->query("SELECT tresc FROM odpowiedzi WHERE id=$item");
				
				$wiersz4 = $rezultat4->fetch_assoc();	
				
				if(!$rezultat4) throw new Exception($polaczenie->error);
				
				array_push($odp2,$wiersz4);
			}
			
			$rezultat6=$polaczenie->query("SELECT * FROM login WHERE Login='$autor'");
				
			$wiersz6 = $rezultat6->fetch_assoc();	
				
			if(!$rezultat6) throw new Exception($polaczenie->error);
			
			$idautora=$wiersz6['id'];
			
			$pkt=0;
			for($i=0;$i<count($odp2);$i++)
			{
				if(array_values($odp2)[$i]==array_values($odp3)[$i]) $pkt++;
			}
			$wynik=(($pkt/count($odp2))*100);
			
			$czasstartu=$_SESSION['czasstartu'];
			$czaskonca=date('H:i:s');
			$roznica=strtotime($czaskonca)-strtotime($czasstartu);
			
			//$_SESSION['roznica']=$roznica;
			
			$roznica=gmdate("H:i:s", $roznica);
			
			unset($_SESSION['czasstartu']);
			unset($_SESSION['czaskonca']);
			
			$rezultat5=$polaczenie->query(sprintf("INSERT INTO ranking VALUES(NULL,'$idautora','%s','$wynik','$roznica')",mysqli_real_escape_string($polaczenie,$id)));	
			
			if(!$rezultat5) throw new Exception($polaczenie->error);
			
			$polaczenie->close();
		 }
	}
	catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera!</span>';
	}
 ?>
 
  Udzielone odpowiedzi: <?php foreach($odp2 as $item){ foreach ($item as $i)echo $i.", ";} ?>
    <br /> <br />
  
  Prawidłowe odpowiedzi: 
  <?php foreach($odp3 as $item){ foreach ($item as $i)echo $i.", ";}  ?>
    <br /><br />
  Wynik procentowy:
  <?php 
   echo $wynik."%";
  ?>
      <br /><br />
Czas:
  <?php 
   echo $roznica;
  ?>
      <br /><br />
	  
   <div class="option"><a href="profil.php">Wróć na swoje konto!</a></div>
  <br /><br />
  </div>
</div>
</body>
</html>
