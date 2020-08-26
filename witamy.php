<?php

  session_start();
  
  if(!isset($_SESSION['udanarejestracja']))
  {
	header('Location: index.php');
	exit();	 
  }
  else
  {
	  unset($_SESSION['udanarejestracja']);
  }
  
  if(isset($_SESSION['fr_nick']))unset($_SESSION['fr_nick']);
  if(isset($_SESSION['fr_email']))unset($_SESSION['fr_email']);
  if(isset($_SESSION['fr_haslo1']))unset($_SESSION['fr_haslo1']);
  if(isset($_SESSION['fr_haslo2']))unset($_SESSION['fr_haslo2']);
  if(isset($_SESSION['fr_regulamin']))unset($_SESSION['fr_regulamin']);
  
  if(isset($_SESSION['e_nick']))unset($_SESSION['e_nick']);
  if(isset($_SESSION['e_email']))unset($_SESSION['e_email']);
  if(isset($_SESSION['e_haslo1']))unset($_SESSION['e_haslo1']);
  if(isset($_SESSION['e_haslo2']))unset($_SESSION['e_haslo2']);
  if(isset($_SESSION['e_regulamin']))unset($_SESSION['e_regulamin'])
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
</head>

<body>

<div id="container">
  <div id="logo">
   <a href="index.php" title=""><h1>System quizów - rejestracja</h1></a> 
  </div>
  <div id="content">
	Dziękujemy za rejestrację w systemie quizów. Zapraszamy do logowania. <br /><br />

	<div class="option"><a href="logowanie.php">Zaloguj się na swoje konto!</a></div><br /><br />
  </div>
</div>
</body>
</html>