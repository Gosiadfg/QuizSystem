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
		margin-top:10px;	
		margin-right:10px;
		width:160px;
		background-color:gray;
		color:white;
		border:none;
		border-radius:5px;
		cursor:pointer;
		letter-spacing:2px;
		outline:none;
		text-align:center;
		float:left;
	}

	.ranking:hover
	{
		background-color: #999999;
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
			$rezultat2=$polaczenie->query("SELECT * FROM kategorie");
			
			if(!$rezultat2) throw new Exception($polaczenie->error);

			while($wiersz = $rezultat2->fetch_assoc())
			{
				$nazwakategorii=$wiersz['nazwa'];		
				?>
				<div class="ranking"><a href="wyszukaj.php?kategoria=<?php echo $wiersz['id']; ?>" title=""><?php echo $nazwakategorii; ?></a></div>
				<?php
			}		
			$rezultat2->free_result();
		 }	
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
	<br/></br><br/></br></br></br>
	<div class="wyloguj"><a href="profil.php" title=""><center>Wróć</center></a></div>
	<div class="wszystkiequizy"><a href="wyszukaj.php?wyszukaj=" title="">Zobacz wszystkie quizy</a></div>
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
