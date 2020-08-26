<?php

  session_start();
  
  if(!isset($_SESSION['udanaedycja']))
  {
	header('Location: index.php');
	exit();	 
  }
  else
  {
	  unset($_SESSION['udanaedycja']);
  }
  
  if(isset($_SESSION['fr_nazwaquizu']))unset($_SESSION['fr_nazwaquizu']);
    if(isset($_SESSION['fr_kategoria']))unset($_SESSION['fr_kategoria']);
  if(isset($_SESSION['fr_pytanie1']))unset($_SESSION['fr_pytanie1']);
  if(isset($_SESSION['fr_odp1']))unset($_SESSION['fr_odp1']);
  if(isset($_SESSION['fr_odp2']))unset($_SESSION['fr_odp2']);
  if(isset($_SESSION['fr_answer']))unset($_SESSION['fr_answer']);
   
  if(isset($_SESSION['e_nazwaquizu']))unset($_SESSION['e_nazwaquizu']);
    if(isset($_SESSION['e_kategoria']))unset($_SESSION['e_kategoria']);
  if(isset($_SESSION['e_pytanie1']))unset($_SESSION['e_pytanie1']);
  if(isset($_SESSION['e_odp1']))unset($_SESSION['e_odp1']);
  if(isset($_SESSION['e_odp2']))unset($_SESSION['e_odp2']);
  if(isset($_SESSION['e_answer']))unset($_SESSION['e_answer']);
  
		for($i=3;$i<=$_SESSION['licznikodpowiedzi1'];$i++)
		{	
			 if(isset($_SESSION['fr_odp'.$i]))unset($_SESSION['fr_odp'.$i]);
			 if(isset($_SESSION['e_odp'.$i]))unset($_SESSION['e_odp'.$i]);
		}

		for($i=2;$i<=$_SESSION['licznikpytan'];$i++)
		{		
		    if(isset($_SESSION['fr_pytanie'.$i]))unset($_SESSION['fr_pytanie'.$i]);
			if(isset($_SESSION['e_pytanie'.$i]))unset($_SESSION['e_pytanie'.$i]);
			if(isset($_SESSION['fr_answer'.$i]))unset($_SESSION['fr_answer'.$i]);
			if(isset($_SESSION['e_answer'.$i]))unset($_SESSION['e_answer'.$i]);
			 
			if(isset($_SESSION['licznikodpowiedzi'.$i]))
			{
				for($j=1 ; $j<=$_SESSION['licznikodpowiedzi'.$i] ; $j++)
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
 <meta name="author" content="" />
 <link rel="stylesheet" href="style.css" type="text/css"/>
</head>

<body>

<div id="container">
  <div id="logo">
   <a href="index.php" title=""><h1>System quizów - edycja</h1></a> 
  </div>
  <div id="content">
  Edytowano quiz! <br /><br />

   <div class="option"><a href="profil.php">Wróć na swoje konto!</a></div>
  <br /><br />
  </div>
</div>
</body>
</html>
