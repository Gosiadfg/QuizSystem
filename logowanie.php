<?php

  session_start();
  
  if((isset($_SESSION['zalogowany']))&&($_SESSION['zalogowany']==true))
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
 <meta name="keywords" content="quiz, system quizów, kreator quizów, stwórz quiz, rozwiąż quiz, test wiedzy" />
 <meta http-equiv="X-UA-Compatible" content=IE=edge,chrome=1" />
 <meta name="author" content="" />
 <link rel="stylesheet" href="style.css" type="text/css"/>
</head>

<body>
 <div id="container">
  <div id="logo">
   <a href="index.php" title=""><h1>System quizów - logowanie</h1></a> 
  </div>
 
  <div id="content">
   <form action="zaloguj.php" method="post">
	<input type="text2" name="login" placeholder="Podaj login">
    <br/> <br/>
    <input type="password" name="haslo" placeholder="Podaj hasło">
	<br/> <br/>
    <input type="submit" value="Zaloguj się">
   </form>
    <?php

    if(isset($_SESSION['blad'])) echo $_SESSION['blad'];
	unset($_SESSION['blad']);
  
	?>
	 <div class="wyloguj"><a href="index.php" title=""><center>Wróć</center></a></div>
 <br><br><br>
  </div>

  <div id="footer">
   <h1>&copy; Wszelkie prawa zastrzeżone</h1>
  </div>
 </div>
</body>

</html>
