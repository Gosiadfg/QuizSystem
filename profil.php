<?php

  session_start();
  
  if(!isset($_SESSION['zalogowany']))
  {
	header('Location: index.php');
	exit();
  }
  
   if(isset($_SESSION['fr_nazwaquizu']))unset($_SESSION['fr_nazwaquizu']);
     if(isset($_SESSION['fr_kategoria']))unset($_SESSION['fr_kategoria']);
  if(isset($_SESSION['fr_pytanie1']))unset($_SESSION['fr_pytanie1']);
  if(isset($_SESSION['fr_odp1']))unset($_SESSION['fr_odp1']);
  if(isset($_SESSION['fr_odp2']))unset($_SESSION['fr_odp2']);
  if(isset($_SESSION['fr_answer1']))unset($_SESSION['fr_answer1']);
		
  if(isset($_SESSION['e_nazwaquizu']))unset($_SESSION['e_nazwaquizu']);
    if(isset($_SESSION['e_kategoria']))unset($_SESSION['e_kategoria']);
  if(isset($_SESSION['e_pytanie1']))unset($_SESSION['e_pytanie1']);
  if(isset($_SESSION['e_odp1']))unset($_SESSION['e_odp1']);
  if(isset($_SESSION['e_odp2']))unset($_SESSION['e_odp2']);
  if(isset($_SESSION['e_answer1']))unset($_SESSION['e_answer1']);
  
		if(isset($_SESSION['licznikodpowiedzi1']))for($i=3;$i<=$_SESSION['licznikodpowiedzi1'];$i++)
		{	
			 if(isset($_SESSION['fr_odp'.$i]))unset($_SESSION['fr_odp'.$i]);
			 if(isset($_SESSION['e_odp'.$i]))unset($_SESSION['e_odp'.$i]);
		}

		if(isset($_SESSION['licznikpytan']))for($i=2;$i<=$_SESSION['licznikpytan'];$i++)
		{		
		    if(isset($_SESSION['fr_pytanie'.$i]))unset($_SESSION['fr_pytanie'.$i]);
			if(isset($_SESSION['e_pytanie'.$i]))unset($_SESSION['e_pytanie'.$i]);
			if(isset($_SESSION['fr_answer'.$i]))unset($_SESSION['fr_answer'.$i]);
			if(isset($_SESSION['e_answer'.$i]))unset($_SESSION['e_answer'.$i]);
			 
			if(isset($_SESSION['licznikodpowiedzi'.$i]))
			{
				for($j=1;$j<=$_SESSION['licznikodpowiedzi'.$i];$j++)
				{	
					if(isset($_SESSION['fr_odp'.$i.$j]))unset($_SESSION['fr_odp'.$i.$j]);
					if(isset($_SESSION['e_odp'.$i.$j]))unset($_SESSION['e_odp'.$i.$j]);	
				}	
				unset($_SESSION['licznikodpowiedzi'.$i]);
			}
		}
		
		unset($_SESSION['licznikodpowiedzi1']); 
		unset($_SESSION['licznikpytan']);
  
 ?>
 
 <!DOCTYPE HTML>
<html lang="pl">

<head>
 <meta charset="utf-8"/>
 <title>System quizów </title>
 <meta name="description" content ="Stwórz swój własny quiz lub rozwiąż quiz, żeby sprawdzić swoją wiedzę! />
 <meta name="keywords" content="quiz, system quizów, kreator quizów, stwórz quiz, rozwiąż quiz, test wiedzy" />
 <meta http-equiv="X-UA-Compatible" content=IE=edge,chrome=1" />
 <meta name="author" content="Małgorzata Sierbin" />
 <link rel="stylesheet" href="style.css" type="text/css"/>
 <link rel="stylesheet" href="css/fontello.css" type="text/css"/>
</head>

<body>
 <div id="container">
  <div id="logo">
   <a href="" title=""><h1>System quizów - profil</h1></a>
   </div>
  <div id="content">
   <?php
 
     echo "<p>Witaj ".$_SESSION['user'].'!</p>';

   ?>
	
	<style>
	input[type=submit]
    {
	   background-color: #999999;
	   border-radius:0px;
    }
	
	input[type=submit]:hover
    {
	   background-color: gray;
    }
	
	.wszystkiequizy
	{
		width:290px;
		background-color:#26b03c;
		font-size:20px;
		color:white;
		padding:15px 10px;
		margin-top:10px;
		margin:10px;
		border:none;
		border-radius:5px;
		cursor:pointer;
		letter-spacing:2px;
		outline:none;
		text-align:right;
		float:right;
	}

	.wszystkiequizy:hover
	{
		background-color: #2bc543;
	}
	
	.option2
	{
		margin-right:0;
	   	float:left;
		width:690px;
	}
	
	.ranking
	{
		height:25px;
		font-size:18px;
		padding:10px;
		margin-top:0px;	
		
		width:100px;
		background-color:gray;
		color:white;
		border:none;
		border-radius:5px;
		cursor:pointer;
		letter-spacing:2px;
		outline:none;
		text-align:right;
		float:right;
	}

	.ranking:hover
	{
		background-color: #999999;
	}
	</style>
	
	<form action = "wyszukaj.php" method="get">
	<input type="text" name="wyszukaj" placeholder="wyszukaj quiz"/>
  <!-- <div class="search:hover">-->
	<input type="submit" value="&#xe800;" class="icon-search" style="color:white;width:50px;font-size:18px;font-family:fontello"/>
	<!-- <a href="wyszukaj.php?id=
	<?php 
	//echo $_POST['wyszukaj']; 
	?>
	title=""><i class="icon-search"></i>
	</a></div>-->

	</form>
	<div id="menu1">
	
	<?php 
	$autor=$_SESSION['user'];
	
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
			$rezultat=$polaczenie->query("SELECT * FROM login JOIN quiz ON autorID=login.id WHERE Login='$autor'");
			

			if(!$rezultat) throw new Exception($polaczenie->error);
			
			$ile_quizow=$rezultat->num_rows;
			 if($ile_quizow>0){
					
			 for ( $i=0;$i<$ile_quizow; $i++ )
             { 	
		        $wiersz = $rezultat->fetch_assoc();	
		?>

				<div class="pencil"><a href="edycja.php?id=<?php echo $wiersz['id']; ?>" title=""><i class="icon-pencil" ></i></a>	</div> 
				<div class="trash"><a href="delete.php?id=<?php echo $wiersz['id']; ?>" title=""><i class="icon-trash"></i></a></div> 
				<div class="option2"><a href="wypelnij.php?id=<?php echo $wiersz['id']; ?>" title=""> 
	<?php
												
				echo $wiersz['nazwa'];
				
	?>			
				</a>
				</div> 
				<div class="ranking"><a href="ranking.php?id=<?php echo $wiersz['id']; ?>" title="">Ranking</a></div>
	<?php
			 }}
			 		
			$rezultat->free_result();
		 }	
		$polaczenie->close();		 
	
	}

	catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera!</span>';
	}
	?>
	<div class="plus"><a href="tworzenie.php" title=""><i class="icon-plus"></i></a></div> 
    </div>
	<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>

	<div class="wyloguj"><a href="logout.php" title="">Wyloguj</a></div>
	<div class="wszystkiequizy"><a href="wyszukaj.php?wyszukaj=" title="">Zobacz wszystkie quizy</a></div>
	
    <div style="clear:both"></div>
   </div>
   

  </div>
 
  <div id="footer">
   <h1>&copy; Wszelkie prawa zastrzeżone</h1>
  </div>
 </div>
</body>
</html>