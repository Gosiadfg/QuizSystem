<?php

  session_start();
  
  if(!isset($_SESSION['udaneusuniecie']))
  {
	header('Location: index.php');
	exit();	 
  }
  else
  {
	  unset($_SESSION['udaneusuniecie']);
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
 <meta name="author" content="Małgorzata Sierbin" />
 <link rel="stylesheet" href="style.css" type="text/css"/>
</head>

<body>

<div id="container">
  <div id="logo">
   <a href="index.php" title=""><h1>System quizów - usuwanie quizu</h1></a> 
  </div>
  <div id="content">
	Usunięto quiz! <br /><br />

   <div class="option"><a href="profil.php">Wróć na swoje konto!</a></div><br /><br />
  </div>
</div>
</body>
</html>