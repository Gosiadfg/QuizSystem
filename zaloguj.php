<?php

  session_start();
  
  if((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
  {
	header('Location: logowanie.php');
	exit();
  }
  
  require_once "connect2.php";
  
  try
  {
	  $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	  
	  if($polaczenie->connect_errno!=0)
	  {
		throw new Exception(mysqli_connect_errno());
	  }
	  else
	  {
		$login = $_POST['login'];
		$haslo = $_POST['haslo'];
		
		$login = htmlspecialchars($login, ENT_QUOTES, "UTF-8");
		
		if($rezultat = @$polaczenie->query(sprintf("SELECT*FROM login WHERE Login='%s'",mysqli_real_escape_string($polaczenie,$login))))
		{		
			$ilu_userow = $rezultat->num_rows;
			if($ilu_userow>0)
			{
				$wiersz = $rezultat->fetch_assoc();						
				
				if(password_verify($haslo,$wiersz['Haslo']))
				{
					
					$_SESSION['zalogowany']=true;
					$_SESSION['id']=$wiersz['id'];
					$_SESSION['user'] = $wiersz['Login'];
					$_SESSION['email'] = $wiersz['Email'];
					
					unset($_SESSION['blad']);
					$rezultat->free_result();
					header('Location: profil.php');
				}
				else
				{
					$_SESSION['blad']='<span style="color:red">Nieprawidłowe hasło!</span>';
					header('Location: logowanie.php');
				}
				
			} else{
				
				$_SESSION['blad']='<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				header('Location: logowanie.php');
				
			}
		}
		else
		{
			throw new Exception($polaczenie->error);
		}
		
		$polaczenie->close();
	}
  }
  catch(Exception $e)
  {
	echo '<span style="color:red;">Błąd serwera!</span>';
  }
?>