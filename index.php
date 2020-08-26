<?php

  session_start();
  
  if(isset($_SESSION['zalogowany']))
  {
	header('Location: profil.php');
	exit();
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
</head>

<body>
 <div id="container">
  <div id="logo">
   <a href="index.php" title=""><h1>System quizów</h1></a> 
  </div>

  <div id="content">
   <div id="menu">
   <div class="option"><a href="logowanie.php" title="">Logowanie</a> 
   <br/></div>
   <div class="option"><a href="rejestracja.php" title="">Rejestracja</a> 
   </div>
   <div style="clear:both"></div></div>
  </div>
 
  <div id="footer">
   <h1>&copy; Wszelkie prawa zastrzeżone</h1>
  </div>
 </div>
</body>

</html>