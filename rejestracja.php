<?php

  session_start();
  
  if((isset($_SESSION['zalogowany']))&&($_SESSION['zalogowany']==true))
  {
	header('Location: profil.php');
	exit();	 
  }
  
  if(isset($_POST['email']))
  {
	//Walidacja
	$wszystko_OK=true;
	$nick=$_POST['nick'];
	
	if ((strlen($nick)<3) || (strlen($nick)>20))
	{
		$wszystko_OK=false;
		$_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków!";
	}
    if (ctype_alnum($nick)==false)
	{
		$wszystko_OK=false;
		$_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr bez polskich znaków!";
	}
	
	$email=$_POST['email'];
	$emailB=filter_var($email,FILTER_SANITIZE_EMAIL);

	if((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
	{
		$wszystko_OK=false;
		$_SESSION['e_email']="Podaj poprawny adres e-mail!";
	}
	
	$haslo1=$_POST['haslo1'];
	$haslo2=$_POST['haslo2'];
	
	if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
	{
		$wszystko_OK=false;
		$_SESSION['e_haslo']="Haslo musi posiadać od 8 do 20 znaków!";
	}
	
	if ($haslo1!=$haslo2)
	{
		$wszystko_OK=false;
		$_SESSION['e_haslo']="Podane hasla nie są identyczne!";
	}
	
	$haslo_hash=password_hash($haslo1,PASSWORD_DEFAULT);
	
	/*if(!isset($_POST['regulamin']))
	{
		$wszystko_OK=false;
		$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
	}*/
	
	$sekret = "";
	
	$sprawdz=file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
	
	$odpowiedz=json_decode($sprawdz);
	
	if($odpowiedz->success==false)
	{
		$wszystko_OK=false;
		$_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
	}
	
	$_SESSION['fr_nick']=$nick;
	$_SESSION['fr_email']=$email;
	$_SESSION['fr_haslo1']=$haslo1;
	$_SESSION['fr_haslo2']=$haslo2;
	//if(isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;
	
	require_once "connect2.php";
	//mysqli_report(MSQLI_REPORT_STRICT);
	
	try
	{
		$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
		 if($polaczenie->connect_errno!=0)
		 {
			throw new Exception (mysqli_connect_errno());
		 }
		 else
		 {
			$email=htmlspecialchars($email, ENT_QUOTES, "UTF-8");
				
			$rezultat=$polaczenie->query(sprintf("SELECT id FROM login WHERE email='%s'",mysqli_real_escape_string($polaczenie,$email)));
			
			if(!$rezultat) throw new Exception($polaczenie->error);
			
			$ile_takich_maili=$rezultat->num_rows;
			if($ile_takich_maili>0)
			{
				$wszystko_OK=false;
				$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";	
			}
			
			$nick=htmlspecialchars($nick, ENT_QUOTES, "UTF-8");
				
			$rezultat=$polaczenie->query(sprintf("SELECT id FROM login WHERE Login='%s'",mysqli_real_escape_string($polaczenie,$nick)));
			
			if(!$rezultat) throw new Exception($polaczenie->error);
			
			$ile_takich_nickow=$rezultat->num_rows;
			if($ile_takich_nickow>0)
			{
				$wszystko_OK=false;
				$_SESSION['e_nick']="Istnieje już gracz o takim nicku";	
			}
			
			if($wszystko_OK==true)
			{
				if($polaczenie->query(sprintf("INSERT INTO login VALUES(NULL, '%s', '$haslo_hash', '%s')",mysqli_real_escape_string($polaczenie,$nick),mysqli_real_escape_string($polaczenie,$email))))
				{
					$tytul = "Witaj w systemie quizów!";
					$wiadomosc = "Witaj ".$nick."! Dziękujemy za rejestrację w systemie quizów. Zapraszamy do logowania.";
					
					$headers = "Content-Type: text/html; charset=UTF-8";
					
					mail($email, $tytul, $wiadomosc, $headers);

					$_SESSION['udanarejestracja']=true;
					header('Location: witamy.php');
				}
				else
				{
					throw new Exception($polaczenie->error);
				}
			}
	
			$polaczenie->close();
		 }
	}
	catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera!</span>';
	}

  }
  
 ?>
 
 <!DOCTYPE HTML>
<html lang="pl">

<head>
 <meta charset="utf-8"/>
 <title>System quizów </title>
 <script src='https://www.google.com/recaptcha/api.js'></script>
 <meta name="description" content ="Stwórz swój własny quiz lub rozwiąż quiz, żeby sprawdzić swoją wiedzę! />
 <meta name="keywords" content="quiz, system quizów, kreator quizów, stwórz quiz, rozwiąż quiz, test wiedzy" />
 <meta http-equiv="X-UA-Compatible" content=IE=edge,chrome=1" />
 <meta name="author" content="" />
 <link rel="stylesheet" href="style.css" type="text/css"/>
 
 <style>
      .error
	  {
	      color:red;
	      margin-top: 10px;
	      margin-bottom: 10px;
      } 
  </style>
  
</head>

<body>
 
<div id="container">
  <div id="logo">
   <a href="index.php" title=""><h1>System quizów - rejestracja</h1></a> 
  </div>
 
  <div id="content">
  
   <!--<form>
	<input type="text" placeholder="Podaj login">
    <br/>    <br/>
	<input type="password" placeholder="Podaj hasło">
    <br/>    <br/>
    <input type="password" placeholder="Powtórz hasło">
	<br/>     <br/>
	<input type="text" placeholder="Podaj e-mail">
    <br/><br/>
    <input type="submit" value="Zarejestruj">
   </form>-->
  
  <form method="post">
   
    Nickname: <br /> <input type="text2" value="<?php
	  if(isset($_SESSION['fr_nick']))
	  {
		echo $_SESSION['fr_nick'];
		unset($_SESSION['fr_nick']);
	  }
	?>" name="nick" /><br />
	
	<?php
	  if(isset($_SESSION['e_nick']))
	  {
		echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
		unset($_SESSION['e_nick']);
	  }
	?>

	<br />E-mail: <br /> <input type="text2" value="<?php
	  if(isset($_SESSION['fr_email']))
	  {
		echo $_SESSION['fr_email'];
		unset($_SESSION['fr_email']);
	  }
	?>" name="email" /><br />
	
	<?php
	  if(isset($_SESSION['e_email']))
	  {
		echo '<div class="error">'.$_SESSION['e_email'].'</div>';
		unset($_SESSION['e_email']);
	  }
	?>
	<br />Hasło: <br /> <input type="password" value="<?php
	  if(isset($_SESSION['fr_haslo1']))
	  {
		echo $_SESSION['fr_haslo1'];
		unset($_SESSION['fr_haslo1']);
	  }
	?>" name="haslo1" /><br />
	
	<?php
	  if(isset($_SESSION['e_haslo']))
	  {
		echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
		unset($_SESSION['e_haslo']);
	  }
	?>
	
	<br />Powtórz hasło: <br /> <input type="password" value="<?php
	  if(isset($_SESSION['fr_haslo2']))
	  {
		echo $_SESSION['fr_haslo2'];
		unset($_SESSION['fr_haslo2']);
	  }
	?>" name="haslo2" /><br />
	
	<?php /* ?>
	<br />
	<p><label>
	  <input type="checkbox" name="regulamin" <?php
	  if(isset($_SESSION['fr_regulamin']))
	  {
		echo "checked";
		unset($_SESSION['fr_regulamin']);	
	  } 
	  ?> /> Akceptuję <a href="regulamin.php" title=""><u>regulamin</u></a>
	</label> 
	<?php> */ ?>
	
	<?php
	/*
	  if(isset($_SESSION['e_regulamin']))
	  {
		echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
		unset($_SESSION['e_regulamin']);
	  }
	  */
	?>
	<br /><br />
	<center><div class="g-recaptcha" data-sitekey=""></div></center>
	
	<?php
	  if(isset($_SESSION['e_bot']))
	  {
		echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
		unset($_SESSION['e_bot']);
	  }
	?>
	
	<br />
	
	<input type="submit" value="Zarejestruj się" />
    </form>
	<div class="wyloguj"><a href="index.php" title=""><center>Wróć</center></a></div>
	<br>	<br>	<br>
    </div>
    <div id="footer">
   <h1>&copy; Wszelkie prawa zastrzeżone</h1>
  </div>
 </div>
 
</body>

</html>
