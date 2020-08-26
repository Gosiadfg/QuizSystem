<?php

  session_start();
  
    if(!isset($_SESSION['zalogowany']))
	  {
		header('Location: index.php');
		exit();
	  }
	  
 	$autor=$_SESSION['user'];
	$id = $_GET['id'];
	
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
				$rezultat2=$polaczenie->query("SELECT * FROM login WHERE Login='$autor'");
			
				if(!$rezultat2) throw new Exception($polaczenie->error);
				
				$idautora = $rezultat2->fetch_assoc()['id'];	
				
				
				$id=htmlspecialchars($id, ENT_QUOTES, "UTF-8");
				
				$rezultat3=$polaczenie->query(sprintf("SELECT * FROM quiz WHERE id='%s' AND autorID='$idautora'",mysqli_real_escape_string($polaczenie,$id)));
			
				if(!$rezultat3) throw new Exception($polaczenie->error);
				
				$wiersz = $rezultat3->fetch_assoc();	
				
				if($wiersz==0)
				{
					header('Location: profil.php');
					exit();	 
				}
	
			$rezultat=$polaczenie->query(sprintf("SELECT * FROM pytania WHERE quizID='%s'",mysqli_real_escape_string($polaczenie,$id)));
			
			if(!$rezultat) throw new Exception($polaczenie->error);

				//$idpytania = $rezultat->fetch_assoc()['id'];	
				
				while($idpytania = $rezultat->fetch_assoc()['id']){
					if($polaczenie->query("DELETE FROM odpowiedzi WHERE pytanieID='$idpytania'"))
					{
						
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
			    }
				
					if($polaczenie->query(sprintf("DELETE FROM pytania WHERE quizID='%s'",mysqli_real_escape_string($polaczenie,$id))))
					{
						if($polaczenie->query(sprintf("DELETE FROM ranking WHERE quizID='%s'",mysqli_real_escape_string($polaczenie,$id))))
						{
							if($polaczenie->query(sprintf("DELETE FROM quiz WHERE id='%s'",mysqli_real_escape_string($polaczenie,$id))))
							{
								$_SESSION['udaneusuniecie']=true;
								header('Location: pousunieciu.php');
							}
							else
							{
								throw new Exception($polaczenie->error);
							}
						}
						else
						{
							throw new Exception($polaczenie->error);
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
		//echo $e;
	}
  
 ?>