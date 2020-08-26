<!DOCTYPE HTML>
<html lang="pl">

<head>
 <meta charset="utf-8"/>
 <title>System quizów </title>
 <meta name="description" content ="Stwórz swój własny quiz lub rozwiąż quiz, żeby sprawdzić swoją wiedzę! />
 <meta name="keywords" content="quiz, system quizów, kreatro quizów, stwórz quiz, rozwiąż quiz, test wiedzy" />
 <meta http-equiv="X-UA-Compatible" content=IE=edge,chrome=1" />
 <meta name="author" content="" />
 <link rel="stylesheet" href="style.css" type="text/css"/>
  <link rel="stylesheet" href="css/fontello.css" type="text/css"/>
</head>

<body>
 <div id="container">
  <div id="logo">
   <a href="index.php" title=""><h1>System quizów</h1></a> 
  </div>
 
  <div id="content">
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
	
	.option3
	{
		margin-right:0;
	   	float:left;
		width:590px;
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
	
	.wszystkiequizy
	{
		width:150px;
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
		text-align:center;
		float:right;
	}

	.wszystkiequizy:hover
	{
		background-color: #2bc543;
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
	
	<!--<div class="search"><a href="" title=""><i class="icon-search"></i></a></div> 
   <input type="text" name="wyszukaj" placeholder="wyszukaj quiz">-->
   	<?php 
	//$autor=$_SESSION['user'];
	
	session_start();
	
	  if(!isset($_SESSION['zalogowany']))
	  {
		header('Location: index.php');
		exit();
	  }
	if(!isset($_GET['kategoria']) && !isset($_GET['wyszukaj']) )
	  {
		header('Location: index.php');
		exit();
	  }
	  
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
			//if($wyszukaj!=NULL)
			//{
				
			if(isset($_GET['wyszukaj']))
			{
				$wyszukaj = $_GET['wyszukaj'];
				$wyszukaj=htmlspecialchars($wyszukaj, ENT_QUOTES, "UTF-8");
				$rezultat=$polaczenie->query(sprintf("SELECT * FROM quiz WHERE nazwa LIKE '%%%s%%'",mysqli_real_escape_string($polaczenie,$wyszukaj)));
			}
			
			if(isset($_GET['kategoria']))
			{
				$kategoria = $_GET['kategoria'];
				$kategoria=htmlspecialchars($kategoria, ENT_QUOTES, "UTF-8");
				$rezultat=$polaczenie->query(sprintf("SELECT * FROM quiz WHERE kategoriaID='%s'",mysqli_real_escape_string($polaczenie,$kategoria)));
			}

			if(!$rezultat) throw new Exception($polaczenie->error);
			
			$ile_quizow=$rezultat->num_rows;
			 if($ile_quizow>0){
					
			 for ( $i=0;$i<$ile_quizow; $i++ )
             { 	
		        $wiersz = $rezultat->fetch_assoc();	
		?>
				
				<div class="rozwiaz"><a href="wypelnij.php?id=<?php echo $wiersz['id']; ?>" title="">Rozwiąż quiz</a></div>
                <div class="option3">
	<?php
												
				echo $wiersz['nazwa'];
	?>				
				</div></a>
				<div class="ranking"><a href="ranking.php?id=<?php echo $wiersz['id']; ?>" title="">Ranking</a></div>
	<?php
			 }}
			 		
			$rezultat->free_result();
		 }	//}
		$polaczenie->close();		 
	
	}

	catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera!</span>';
	}
	?>
	
 <!--  
<div class="rozwiaz"><a href="" title="">Rozwiąż quiz</a></div>
<div class="option3">Przykładowy quiz</div>
<div class="rozwiaz"><a href="" title="">Rozwiąż quiz</a></div>
<div class="option3">Przykładowy quiz</div>
<div class="rozwiaz"><a href="" title="">Rozwiąż quiz</a></div>
<div class="option3">Przykładowy quiz</div>-->
	<div class="wyloguj"><a href="profil.php" title=""><center>Wróć</center></a></div>
	<div class="wszystkiequizy"><a href="kategorie.php" title="">Kategorie</a></div>
	 <div style="clear:both"></div>
	 </div> 
	</div>
  </div>
 
  <div id="footer">
   <h1>&copy; Wszelkie prawa zastrzeżone</h1>
  </div>
 </div>
</body>

</html>
