<?php

  session_start();
    
  $kategorie=array();
	
	if(!isset($_SESSION['zalogowany']))
	  {
		header('Location: index.php');
		exit();
	  }
	  
	  require_once "connect2.php";
  
  $autor=$_SESSION['user'];
  $id = $_GET['id'];
	
     $check=true;
	 		
  if (isset($_SESSION['licznikpytan'])&&$_SESSION['licznikpytan']>1)
  {
	  $check=false;
	for($i=2;$i<=$_SESSION['licznikpytan'];$i++)
	{
		if(!isset($_POST["newanswer$i"])&& !isset($_POST["deleteanswer$i"])) $check=true;
		else
		{
			$check=false; 
			break;
		}
	}
  }
	
//if(!isset($_POST['newquestion']) && !isset($_POST['newanswer'])&& !isset($_POST['deleteanswer'])&& !isset($_POST['deletequestion']) && $check==true)
//{	
  if(isset($_POST['nazwaquizu']))
  {
	$nazwaquizu=$_POST['nazwaquizu'];
	$pytanie1=$_POST['pytanie1'];
	$odp1=$_POST['odp1'];
	$odp2=$_POST['odp2'];
	$answer1=$_POST['answer1'];
	
	if(isset($_POST['kategoria'])) $kategoria=$_POST['kategoria'];
	//if(isset($_POST['mySelect'])) 
	
	$_SESSION['mySelect']=$_POST['mySelect'];
				
	$_SESSION['listapytan'] = array();
	
	class pytania{
		public $tresc;
		public $licznikodpowiedzi=2;
		public $poprawnaodpowiedz;
		public $listaodpowiedzi=array();
		
		public function dodajodpowiedz($odp){
			array_push($this->listaodpowiedzi,$odp);
		}
		
		public function wypiszodpowiedzi(){
			print_r(array_values($this->listaodpowiedzi));
		}
		
		public function wypisz(){
			echo $this->tresc;
			echo $this->licznikodpowiedzi;
			echo $this->poprawnaodpowiedz;
		}
	}

	$_SESSION['listapytan']=array();
	
	$_SESSION['pyt1']=new pytania;
	$_SESSION['pyt1']->tresc=$_POST['pytanie1'];
	if(isset($_POST['licznikodpowiedzi1']))$_SESSION['pyt1']->licznikodpowiedzi=$_POST['licznikodpowiedzi1'];
	$_SESSION['pyt1']->poprawnaodpowiedz=$_POST['answer1'];
	$_SESSION['pyt1']->dodajodpowiedz($_POST['odp1']);
	$_SESSION['pyt1']->dodajodpowiedz($_POST['odp2']);
		
	$_SESSION['fr_nazwaquizu']=$nazwaquizu;
	$_SESSION['fr_kategoria']=$kategoria;
	$_SESSION['fr_pytanie1']=$pytanie1;
	$_SESSION['fr_odp1']=$odp1;
	$_SESSION['fr_odp2']=$odp2;
	$_SESSION['fr_answer1']=$answer1;
					
	if(isset($_SESSION['licznikodpowiedzi1']))
	{		
		for($i=3;$i<=$_SESSION['licznikodpowiedzi1'];$i++)
		{	
			if(isset($_SESSION['fr_odp'.$i]))
			{
				unset($_SESSION['fr_odp'.$i]);
			}
			$_SESSION['fr_odp'.$i]=$_POST['odp'.$i];
		}
	}
	
	if(isset($_SESSION['licznikpytan']))
	{	   
		for($i=2;$i<=$_SESSION['licznikpytan'];$i++)
		{
			if(isset($_SESSION['fr_pytanie'.$i]))
			{	
				unset($_SESSION['fr_pytanie'.$i]);
			}
			 $_SESSION['fr_pytanie'.$i]=$_POST['pytanie'.$i];
				 			 
		  if(isset($_SESSION['fr_answer'.$i]))
		  {
			 unset($_SESSION['fr_answer'.$i]);
		  }
	      $_SESSION['fr_answer'.$i]=$_POST['answer'.$i];
			
	
			for($j=1;$j<=$_SESSION['licznikodpowiedzi'.$i];$j++)
			{	
				if(isset($_SESSION['fr_odp'.$i.$j]))
				{
					unset($_SESSION['fr_odp'.$i.$j]);
				}
				$_SESSION['fr_odp'.$i.$j]=$_POST['odp'.$i.$j];
			}	
			
			$_SESSION['pyt'.$i]=new pytania;
			$_SESSION['pyt'.$i]->tresc=$_POST['pytanie'.$i];
			$_SESSION['pyt'.$i]->licznikodpowiedzi=$_SESSION['licznikodpowiedzi'.$i];
			$_SESSION['pyt'.$i]->poprawnaodpowiedz=$_POST['answer'.$i];
		
			for($j=1;$j<=$_SESSION['licznikodpowiedzi'.$i];$j++)
			{
				$_SESSION['pyt'.$i]->dodajodpowiedz($_POST['odp'.$i.$j]);
			}
		}
	}
	  
  if(!isset($_POST['newquestion']) && !isset($_POST['newanswer'])&& !isset($_POST['deleteanswer'])&& !isset($_POST['deletequestion'])&& $check==true)
  {
	//Walidacja
	$wszystko_OK=true;
	//$nazwaquizu=$_POST['nazwaquizu'];
	
	if ((strlen($nazwaquizu)<3) || (strlen($nazwaquizu)>100))
	{
		$wszystko_OK=false;
		$_SESSION['e_nazwaquizu']="Nazwa quizu musi posiadać od 3 do 100 znaków!";
	}
  
	if(isset($_POST['kategoria']) || isset($_POST['mySelect']))
	{	
		if ($kategoria=="" && $_POST['mySelect']==0)
		{
			$wszystko_OK=false;
			$_SESSION['e_kategoria']="Wybierz kategorię!";
		}

		if ($kategoria!="" && $_POST['mySelect']!=0)
		{
			$wszystko_OK=false;
			$_SESSION['e_kategoria']="Wybierz jedną kategorię!";
		}
	}
	
	if(isset($_SESSION['licznikodpowiedzi1']))
	{		
		for($i=1;$i<=$_SESSION['licznikodpowiedzi1'];$i++)
		{	
			 if (strlen($_SESSION['fr_odp'.$i])==0)
			{
				$wszystko_OK=false;
				$_SESSION['e_odp'.$i]="Odpowiedź nie może być pusta!";
			}
		}
	}
	
	if(isset($_SESSION['licznikpytan']))
	{	   
		for($i=1;$i<=$_SESSION['licznikpytan'];$i++)
		{  	
		    if ((strlen($_SESSION['fr_pytanie'.$i])<8) || (strlen($_SESSION['fr_pytanie'.$i])>100))
			{
				$wszystko_OK=false;
				$_SESSION['e_pytanie'.$i]="Pytanie musi posiadać od 8 do 100 znaków!";
			}
			if (is_numeric($_SESSION['fr_answer'.$i])==false || $_SESSION['fr_answer'.$i]==0 || $_SESSION['fr_answer'.$i]>$_SESSION['licznikodpowiedzi'.$i])
			{
				$wszystko_OK=false;
				$_SESSION['e_answer'.$i]="Prawidłowa odpowiedź może składać się tylko z cyfr większych od 0 i mniejszych od liczby odpowiedzi!";
			}
			
		}
		for($i=2;$i<=$_SESSION['licznikpytan'];$i++)
		{  
			for($j=1;$j<=$_SESSION['licznikodpowiedzi'.$i];$j++)
			{	
				 if (strlen($_SESSION['fr_odp'.$i.$j])==0)
				{
					$wszystko_OK=false;
					$_SESSION['e_odp'.$i.$j]="Odpowiedź nie może być pusta!";
				}
			}	
		}
	}
	
	//$autor=$_SESSION['user'];
	//require_once "connect2.php";

	try
	{
		$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
		 if($polaczenie->connect_errno!=0)
		 {
			throw new Exception (mysqli_connect_errno());
		 }
		 else
		 {	
			$nazwaquizu=htmlspecialchars($nazwaquizu, ENT_QUOTES, "UTF-8");
			$id=htmlspecialchars($id, ENT_QUOTES, "UTF-8");
			
			$rezultat=$polaczenie->query(sprintf("SELECT * FROM quiz WHERE nazwa='%s' AND id!='%s'",mysqli_real_escape_string($polaczenie,$nazwaquizu),mysqli_real_escape_string($polaczenie,$id)));
			
			$polaczenie->query("SET NAMES 'utf8'");
			
			if(!$rezultat) throw new Exception($polaczenie->error);
			
			$ile_takich_quizow=$rezultat->num_rows;
			
			if($ile_takich_quizow>0)
			{
				$wszystko_OK=false;
				$_SESSION['e_nazwaquizu']="Istnieje już quiz o takiej nazwie";	
			}
			
			if($wszystko_OK==true)
			{
				if($kategoria=="")
				{
					$result_1=$polaczenie->query("SELECT * FROM kategorie");
					
					if(!$result_1) throw new Exception($polaczenie->error);

					$idkategorii=0;
					$licznikkategorii=1;
					
					while($wiersz_1 = $result_1->fetch_assoc())
					{
						$idkat=$wiersz_1['id'];
						if($licznikkategorii==$_POST['mySelect'])
						{
							$idkategorii=$idkat;
						}
						$licznikkategorii++;
					}				
				}
				else
				{
					$kategoria=htmlspecialchars($kategoria, ENT_QUOTES, "UTF-8");
					
					$result=$polaczenie->query(sprintf("SELECT * FROM kategorie WHERE nazwa ='%s'",mysqli_real_escape_string($polaczenie,$kategoria)));
				
					if(!$result) throw new Exception($polaczenie->error);
						
					$ile_takich_kategorii=$result->num_rows;
					if($ile_takich_kategorii>0)
					{
						$idkategorii = $result->fetch_assoc()['id'];	
					}
					else
					{
						$result2=$polaczenie->query(sprintf("INSERT INTO kategorie VALUES (NULL, '%s')",mysqli_real_escape_string($polaczenie,$kategoria)));
				
						if(!$result2) throw new Exception($polaczenie->error);
						
						$result3=$polaczenie->query(sprintf("SELECT * FROM kategorie WHERE nazwa ='%s'",mysqli_real_escape_string($polaczenie,$kategoria)));
				
						if(!$result3) throw new Exception($polaczenie->error);
						
						$idkategorii = $result3->fetch_assoc()['id'];	
					}						
				}
				
				$result_3=$polaczenie->query(sprintf("SELECT * FROM quiz WHERE id='%s'",mysqli_real_escape_string($polaczenie,$id)));
				
				if(!$result_3) throw new Exception($polaczenie->error);
				
				$stareidkategorii = $result_3->fetch_assoc()['kategoriaID'];	
				
				if($stareidkategorii!=$idkategorii)
				{
					$result_4=$polaczenie->query(sprintf("UPDATE quiz SET kategoriaID='$idkategorii' WHERE id='%s'",mysqli_real_escape_string($polaczenie,$id)));
				
					if(!$result_4) throw new Exception($polaczenie->error);
				}
							
				$rezultat2=$polaczenie->query(sprintf("SELECT * FROM quiz WHERE nazwa='%s' AND id!='%s'",mysqli_real_escape_string($polaczenie,$nazwaquizu),mysqli_real_escape_string($polaczenie,$id)));
				
				if(!$rezultat2) throw new Exception($polaczenie->error);
				
				if($rezultat2->num_rows==1) if($polaczenie->query(sprintf("UPDATE quiz SET nazwa='%s' WHERE id='%s'",mysqli_real_escape_string($polaczenie,$nazwaquizu),mysqli_real_escape_string($polaczenie,$id))))
				{
				}
				else
				{
					throw new Exception($polaczenie->error);
				}
				
				for($i=1;$i<=$_SESSION['licznikpytan'];$i++)
				{ 
					$idpoprawnej="";
					$nowapoprawna="";
						
					$result=$polaczenie->query(sprintf("SELECT * FROM pytania WHERE quizID='%s'",mysqli_real_escape_string($polaczenie,$id)));
				
					if(!$result) throw new Exception($polaczenie->error);
					
					if($result->num_rows>$_SESSION['licznikpytan'])
					{
						$ileusunac=$result->num_rows-$_SESSION['licznikpytan'];
						
						$result1 = $polaczenie->query(sprintf("SELECT * FROM pytania WHERE quizID='%s' ORDER BY id DESC LIMIT $ileusunac",mysqli_real_escape_string($polaczenie,$id)));
						
						if(!$result1) throw new Exception($polaczenie->error);
						
						while($pytdousuniecia = $result1->fetch_assoc())
						{
							$idpytdousuniecia=$pytdousuniecia['id'];	
							if($polaczenie->query("DELETE FROM odpowiedzi WHERE pytanieID='$idpytdousuniecia'"))
							{
								if($polaczenie->query(sprintf("DELETE FROM pytania WHERE quizID='%s' ORDER BY id DESC LIMIT $ileusunac",mysqli_real_escape_string($polaczenie,$id))))
								{
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
					}
					
					$pytanie=$_SESSION['fr_pytanie'.$i];
					$pytanie=htmlspecialchars($pytanie, ENT_QUOTES, "UTF-8");
					  
					$starepytanie=$_SESSION['starepytanie'.$i];
					
					$rezultat5=$polaczenie->query(sprintf("SELECT * FROM pytania WHERE quizID='%s' AND tresc='$starepytanie'",mysqli_real_escape_string($polaczenie,$id)));
				
					if(!$rezultat5) throw new Exception($polaczenie->error);		
					
					$idpytania = $rezultat5->fetch_assoc()['id'];
					
					$result2=$polaczenie->query("SELECT * FROM odpowiedzi WHERE pytanieID='$idpytania'");
				
					if(!$result2) throw new Exception($polaczenie->error);
					
					if($result2->num_rows>$_SESSION['licznikodpowiedzi'.$i])
					{
						$ileusunac=$result2->num_rows-$_SESSION['licznikodpowiedzi'.$i];
						
						$result3 = $polaczenie->query("SELECT * FROM odpowiedzi WHERE pytanieID='$idpytania' ORDER BY id DESC LIMIT $ileusunac");
						if(!$result3) throw new Exception($polaczenie->error);
						
						while($odpdousuniecia = $result3->fetch_assoc())
						{
							$idodpdousuniecia=$odpdousuniecia['id'];	
							if($polaczenie->query("DELETE FROM odpowiedzi WHERE id='$idodpdousuniecia'"))
							{
							}
							else
							{
								throw new Exception($polaczenie->error);
							}
						}												
					}					
					
					$rezultat3=$polaczenie->query(sprintf("SELECT * FROM pytania WHERE id='$idpytania' AND quizID='%s' AND tresc!='%s'",mysqli_real_escape_string($polaczenie,$id),mysqli_real_escape_string($polaczenie,$pytanie)));
					
					if(!$rezultat3) throw new Exception($polaczenie->error);			
					
					if($rezultat3->num_rows==1)if($polaczenie->query(sprintf("UPDATE pytania SET tresc='%s' WHERE id='$idpytania'",mysqli_real_escape_string($polaczenie,$pytanie))))
					{	
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
					$rezultat7=$polaczenie->query(sprintf("SELECT * FROM pytania WHERE quizID='%s' AND tresc='%s'",mysqli_real_escape_string($polaczenie,$id),mysqli_real_escape_string($polaczenie,$pytanie)));
					
					if(!$rezultat7) throw new Exception($polaczenie->error);
					
					$starapoprodp=$_SESSION['starapoprawnaodp'.$i];
					
					$wiersz0 = $rezultat7->num_rows;
					if($wiersz0==0) if($rezultat1=$polaczenie->query(sprintf("INSERT INTO pytania VALUES(NULL, '%s', '%s')",mysqli_real_escape_string($polaczenie,$pytanie),mysqli_real_escape_string($polaczenie,$id))))
					{
						$rezultat12=$polaczenie->query(sprintf("SELECT * FROM pytania WHERE quizID='%s' AND tresc='%s'",mysqli_real_escape_string($polaczenie,$id),mysqli_real_escape_string($polaczenie,$pytanie)));
				
						if(!$rezultat12) throw new Exception($polaczenie->error);
						
						$idpytania = $rezultat12->fetch_assoc()['id'];
						
						$starapoprodp="";
					} 
					else throw new Exception($polaczenie->error);
								
					$rezultat8=$polaczenie->query("SELECT * FROM odpowiedzi WHERE pytanieID='$idpytania'");
			
					if(!$rezultat8) throw new Exception($polaczenie->error);
					

					for($j=1;$j<=$_SESSION['licznikodpowiedzi'.$i];$j++)
					{
						$wiersz = $rezultat8->fetch_assoc();
						$idodp=$wiersz['id'];
						
						
						if($i==1)
						{
							$odppopr=$_SESSION['fr_odp'.$_SESSION['fr_answer1']];
							$nowaodp=$_SESSION['fr_odp'.$j];
						}
						else 
						{
							$odppopr=$_SESSION['fr_odp'.$i.$_SESSION['fr_answer'.$i]];
							$nowaodp=$_SESSION['fr_odp'.$i.$j];
						}
						
						$nowaodp=htmlspecialchars($nowaodp, ENT_QUOTES, "UTF-8");
							
						$rezultat9=$polaczenie->query(sprintf("SELECT * FROM odpowiedzi WHERE pytanieID='$idpytania' AND id='$idodp' AND tresc!='%s'",mysqli_real_escape_string($polaczenie,$nowaodp)));
					
						if(!$rezultat9) throw new Exception($polaczenie->error);
						
						$zlicz = $rezultat9->num_rows;
						
						if($zlicz!=0)if($polaczenie->query(sprintf("UPDATE odpowiedzi SET tresc='%s' WHERE id='$idodp' AND pytanieID='$idpytania'",mysqli_real_escape_string($polaczenie,$nowaodp))))
						{							
							$rez=$polaczenie->query(sprintf("SELECT * FROM odpowiedzi WHERE pytanieID='$idpytania'"));
				
							if(!$rez) throw new Exception($polaczenie->error);
						
							$wiersz = $rez->fetch_assoc();
							$idodp=$wiersz['id'];
						}
						else
						{
							throw new Exception($polaczenie->error);
						}
						
						$rezultat4=$polaczenie->query(sprintf("SELECT * FROM odpowiedzi WHERE pytanieID='$idpytania' AND tresc='%s'",mysqli_real_escape_string($polaczenie,$nowaodp)));
					
						if(!$rezultat4) throw new Exception($polaczenie->error);
						$wiersz0 = $rezultat4->num_rows;
						if($wiersz0==0)
						{
							if($rezultat6=$polaczenie->query(sprintf("INSERT INTO odpowiedzi VALUES(NULL, '$idpytania', '%s', 0)",mysqli_real_escape_string($polaczenie,$nowaodp))))
							{
								$rezultat13=$polaczenie->query(sprintf("SELECT * FROM odpowiedzi WHERE pytanieID='$idpytania' AND tresc='%s'",mysqli_real_escape_string($polaczenie,$nowaodp)));
				
								if(!$rezultat13) throw new Exception($polaczenie->error);
						
								$wiersz=$rezultat13->fetch_assoc();
								$idodp = $wiersz['id'];
								//$starapoprodp="";
							} 
							else throw new Exception($polaczenie->error);
						}
									
						if($wiersz['czyprawidlowa']==1)
						{
							$idpoprawnej=$idodp;
						}
						else if($starapoprodp=="")
						{
							if($nowaodp==$odppopr) $nowapoprawna=$idodp;
						}
						else if($wiersz['tresc']==$odppopr)
						{							
							$nowapoprawna=$idodp;
						}
						//else $nowapoprawna=$idodp;
					}	
					 
					if($starapoprodp!=$_SESSION['fr_answer'.$i])
					{	
						if($starapoprodp!="")
						{
							$rezultat10=$polaczenie->query("UPDATE odpowiedzi SET czyprawidlowa=0 WHERE id='$idpoprawnej'");
							if(!$rezultat10) throw new Exception($polaczenie->error);			
						}
						
						$rezultat11=$polaczenie->query("UPDATE odpowiedzi SET czyprawidlowa=1 WHERE id='$nowapoprawna'");
							
						if(!$rezultat11) throw new Exception($polaczenie->error);		
					}	
				}
				$_SESSION['udanaedycja']=true;
				header('Location: poedycji.php');
			} 		
			$polaczenie->close();
		 }
	}
	catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera!</span>';
		//echo $e;
	}
  }
  }
  
  if(!isset($_POST['newquestion']) && !isset($_POST['newanswer'])&& !isset($_POST['deleteanswer'])&& !isset($_POST['deletequestion']) && $check==true)
  {
  unset($_SESSION['newquestion']);  
  unset($_SESSION['newanswer']);
  if (isset($_SESSION['licznikpytan'])&&$_SESSION['licznikpytan']>1)
  {
	for($i=2;$i<=$_SESSION['licznikpytan'];$i++)
	{
		unset($_SESSION["newanswer$i"]);
		unset($_SESSION["deleteanswer$i"]);
	}
  }
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
 <meta name="author" content="" />
 <link rel="stylesheet" href="style.css" type="text/css"/>
  <link rel="stylesheet" href="css/fontello.css" type="text/css"/>
  
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
   <a href="profil.php" title=""><h1>System quizów - stwórz quiz</h1></a> 
  </div>
	
   <div id="content">
   <?php
  if(!isset($_POST['nazwaquizu']))
  {
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
			
			$rezultat=$polaczenie->query(sprintf("SELECT * FROM quiz WHERE id='%s'",mysqli_real_escape_string($polaczenie,$id)));
			
			if(!$rezultat) throw new Exception($polaczenie->error);
			
			$wiersz = $rezultat->fetch_assoc();	
			
			$_SESSION['fr_nazwaquizu']=$wiersz['nazwa'];
			
			$idkat=$wiersz['kategoriaID'];
			
			$result_2=$polaczenie->query("SELECT * FROM kategorie WHERE id='$idkat'");
			
			if(!$result_2) throw new Exception($polaczenie->error);
			
			$nazwakat = $result_2->fetch_assoc()['nazwa'];	
			
			$result_1=$polaczenie->query("SELECT * FROM kategorie");
			
			if(!$result_1) throw new Exception($polaczenie->error);

			$mySelect=0;
			$licznikkategorii=1;
			
			while($wiersz_1 = $result_1->fetch_assoc())
			{
				$nazwakategorii=$wiersz_1['nazwa'];
				
				if($nazwakategorii==$nazwakat){
					$mySelect=$licznikkategorii;
				}
				else if($mySelect==0)$licznikkategorii++;
				array_push($kategorie,$nazwakategorii);
				$_SESSION['kategorie']=$kategorie;
			}
			$_SESSION['mySelect']=$mySelect;
			
			$rezultat2=$polaczenie->query(sprintf("SELECT * FROM pytania WHERE quizID='%s'",mysqli_real_escape_string($polaczenie,$id)));
			
			if(!$rezultat2) throw new Exception($polaczenie->error);
			
			$i=1;
			$j=1;
			$stop=0;
			while($wiersz2 = $rezultat2->fetch_assoc())
			{
				//if(!isset($_SESSION['fr_answer'.$i])) 
				$_SESSION['fr_answer'.$i]=1;
				$_SESSION['fr_pytanie'.$i]=$wiersz2['tresc'];
				$_SESSION['starepytanie'.$i]= $_SESSION['fr_pytanie'.$i];
				$_SESSION['starapoprawnaodp'.$i]=$_SESSION['fr_answer'.$i];
				
				$idpytania=$wiersz2['id'];
				$rezultat3=$polaczenie->query("SELECT * FROM odpowiedzi WHERE pytanieID='$idpytania'");
				if(!$rezultat3) throw new Exception($polaczenie->error);
				$_SESSION['licznikodpowiedzi'.$i]=$rezultat3->num_rows;
				
				$j=1;
				while($wiersz3 = $rezultat3->fetch_assoc())
				{
					if($wiersz3['czyprawidlowa']==1){$stop=1;}
					else if($stop!=1)
					{
						$_SESSION['fr_answer'.$i]++;
						$_SESSION['starapoprawnaodp'.$i]=$_SESSION['fr_answer'.$i];
					}
					
					if ($i==1)
					{
						$_SESSION['fr_odp'.$j]=$wiersz3['tresc'];
						$_SESSION['staraodp'.$j]=$_SESSION['fr_odp'.$j];
					}
					if ($i>1)
					{
						$_SESSION['fr_odp'.$i.$j]=$wiersz3['tresc'];
						$_SESSION['staraodp'.$i.$j]=$_SESSION['fr_odp'.$i.$j];
					}
					
					$j++;
				}
				$i++;
				$stop=0;
			}
			$_SESSION['licznikpytan']=$i-1;
			
			$polaczenie->close();
			}
			}
		 catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera!</span>';
	}
  }
	?>
   <form method="post" autocomplete="off">
   
    <div class="option3">Nazwa quizu: <br /> <input type="text" value="<?php
	  if(isset($_SESSION['fr_nazwaquizu']))
	  {
		echo $_SESSION['fr_nazwaquizu'];
		unset($_SESSION['fr_nazwaquizu']);
	  }
	?>" name="nazwaquizu" /></div><br /><br />
	
	<?php
	  if(isset($_SESSION['e_nazwaquizu']))
	  {
		echo '<div class="error">'.$_SESSION['e_nazwaquizu'].'</div>';
		unset($_SESSION['e_nazwaquizu']);
	  }
	?>

	<style>
	#mySelect{
	 width:520px;   
	 font-size:18px;
	 height:45px;
	}
	</style>
	
	<div class="option3">Kategoria - wybierz lub wpisz nową: <br /> 
	
	<select name="mySelect" id="mySelect" size="1">  
	<option value=0>+nowa kategoria</option>
	<?php 	
	$licznik=1;
	foreach($_SESSION['kategorie'] as $item)
	{
		$selected="";
		if($_SESSION['mySelect']==$licznik){ $selected='selected="selected"';}
		echo '<option value="'.$licznik.'"'.$selected.' >'.$item.'</option>';
		$licznik++;
	 }
	 ?>
	 
	</select>
	<input type="text" value="<?php
	  if(isset($_SESSION['fr_kategoria']))
	  {
		echo $_SESSION['fr_kategoria'];
		unset($_SESSION['fr_kategoria']);
	  }
	?>" name="kategoria" /></div><br /><br />
		
	<?php	
	  if(isset($_SESSION['e_kategoria']))
	  {
		echo '<br/><br/><div class="error">'.$_SESSION['e_kategoria'].'</div>';
		unset($_SESSION['e_kategoria']);
	  }
	?>
	
	<br /><br /><br /><div class="option3">Pytanie nr 1: <br /> <input type="text" value="<?php
	  if(isset($_SESSION['fr_pytanie1']))
	  {
		echo $_SESSION['fr_pytanie1'];
		//unset($_SESSION['fr_pytanie1']);
	  }
	?>" name="pytanie1" /></div><br /><br />
	
	<?php
	  if(isset($_SESSION['e_pytanie1']))
	  {
		echo '<div class="error">'.$_SESSION['e_pytanie1'].'</div>';
		unset($_SESSION['e_pytanie1']);
	  }
	?>
	
	<div class="option3">Nr prawidłowej odpowiedzi: <br /> <input type="text"  value="<?php
	  if(isset($_SESSION['fr_answer1']))
	  {
		echo $_SESSION['fr_answer1'];
		//unset($_SESSION['fr_answer1']);
	  }
	?>" name="answer1" /></div><br /><br />
	
	<?php
	  if(isset($_SESSION['e_answer1']))
	  {
		echo '<div class="error">'.$_SESSION['e_answer1'].'</div>';
		unset($_SESSION['e_answer1']);
	  }
	?>
	
	<div class="option3">Odpowiedź 1: <br /> <input type="text"  value="<?php
	if(isset($_SESSION['fr_odp1']))
	  {
		echo $_SESSION['fr_odp1'];
		//unset($_SESSION['fr_odp1']);
	  }
	?>" name="odp1" /></div><br /><br />
	
	<?php
	  if(isset($_SESSION['e_odp1']))
	  {
		echo '<div class="error">'.$_SESSION['e_odp1'].'</div>';
		unset($_SESSION['e_odp1']);
	  }
	?>
	
	<div class="option3">Odpowiedź 2: <br /> <input type="text"  value="<?php
	if(isset($_SESSION['fr_odp2']))
	  {
		echo $_SESSION['fr_odp2'];
		//unset($_SESSION['fr_odp2']);
	  }
	?>" name="odp2" /></div><br /><br />
	
	<?php
	  if(isset($_SESSION['e_odp2']))
	  {
		echo '<div class="error">'.$_SESSION['e_odp2'].'</div>';
		unset($_SESSION['e_odp2']);
	  }
	?>
	
	  <?php
	  if (!isset($_SESSION['licznikpytan'])){
		$_SESSION['licznikpytan']=1;
	  }
	   if (!isset($_SESSION['licznikodpowiedzi1'])){
		$_SESSION['licznikodpowiedzi1']=2;	
	  }
 
	if(isset($_POST['newanswer']))
	 {		 
		$_SESSION['licznikodpowiedzi1']++;
		$newanswer= $_POST['newanswer'];
	 }
	 
	 if(isset($_POST['deleteanswer']))
		{		 
			$ktoraodp=$_SESSION['licznikodpowiedzi1'];
			unset($_SESSION['fr_odp'.$ktoraodp]);
			$_SESSION['licznikodpowiedzi1']--;
			$deleteanswer= $_POST['deleteanswer'];
		}
		

	if($_SESSION['licznikodpowiedzi1']>2)
	{
     for($i=3;$i<=$_SESSION['licznikodpowiedzi1'];$i++)
	{
		//if ($_POST['newanswer']) {
		?> 
		<div class="option3">Odpowiedź <?php echo $i;?>: <br /> <input type="text"  value="<?php
	if(isset($_SESSION['fr_odp'.$i]))
	  {
		echo $_SESSION['fr_odp'.$i];
		//unset($_SESSION['fr_odp'.$i]);
	  }
	?>" name="odp<?php echo $i;?>" /></div><br /><br />
	 <?php
	  if(isset($_SESSION['e_odp'.$i]))
	  {
		echo '<div class="error">'.$_SESSION['e_odp'.$i].'</div>';
		unset($_SESSION['e_odp'.$i]);
	  }
	 }
}
	  ?>
	<input type="submit" value="&#xe801;Dodaj odpowiedź" name="newanswer" class="icon-search" style="color:white;width:300px;font-size:18px;font-family:fontello,Verdana"/>
	<br /><br /><br /><br />
	
     <?php
	 if($_SESSION['licznikodpowiedzi1']>2)
	{
	 ?>
	<input type="submit" value="&#xe802;Usuń odpowiedź" name="deleteanswer" class="icon-search" style= "color:white;width:300px;font-size:18px;font-family:fontello,Verdana"/>
	 <br /><br /><br /><br /> 
	<?php
	}
	
	if(isset($_POST['newquestion']))
	{		
		//unset($_SESSION['licznikodpowiedzi']);
		$_SESSION['licznikpytan']++;
		$ktorepyt=$_SESSION['licznikpytan'];
		$newquestion=$_POST['newquestion'];
		//if(!isset($_SESSION['licznikodpowiedzi'.$ktorepyt]))$_SESSION['licznikodpowiedzi'.$ktorepyt]=2;
	}
		if(isset($_POST['deletequestion']))
		{		 
			$licznik=$_SESSION['licznikpytan'];
			
			unset($_SESSION['fr_pytanie'.$licznik]);
			unset($_SESSION['fr_answer'.$licznik]);
			for($i=1;$i<=$_SESSION['licznikodpowiedzi'.$licznik];$i++)
			{
			  unset($_SESSION['fr_odp'.$licznik.$i]);
			}
			unset($_SESSION['licznikodpowiedzi'.$licznik]);
			$_SESSION['licznikpytan']--;
			$deletequestion= $_POST['deletequestion'];	
		}
		
	if($_SESSION['licznikpytan']>1)
	{
    for($i=2;$i<=$_SESSION['licznikpytan'];$i++)
	{
	//if ($_POST['newquestion']) {
		
		?>  <br /><br /><br /><br /><div class="option3">Pytanie nr <?php echo $i;?>: <br /> <input type="text"  value="<?php
	if(isset($_SESSION['fr_pytanie'.$i]))
	  {
		echo $_SESSION['fr_pytanie'.$i];
		//unset($_SESSION['fr_pytanie'.$i]);
	  }
	?>" name="pytanie<?php echo $i;?>" /></div><br /><br />
	 <?php
	  if(isset($_SESSION['e_pytanie'.$i]))
	  {
		echo '<div class="error">'.$_SESSION['e_pytanie'.$i].'</div>';
		unset($_SESSION['e_pytanie'.$i]);
	  }
	?>
	 
	 <div class="option3">Nr prawidłowej odpowiedzi: <br /> <input type="text"  value="<?php
	  if(isset($_SESSION['fr_answer'.$i]))
	  {
		echo $_SESSION['fr_answer'.$i];
		//unset($_SESSION['fr_answer'.$i]);
	  }
	?>" name="answer<?php echo $i;?>" /></div><br /><br />
	
	<?php
	  if(isset($_SESSION['e_answer'.$i]))
	  {
		echo '<div class="error">'.$_SESSION['e_answer'.$i].'</div>';
		unset($_SESSION['e_answer'.$i]);
	  }
	?>
	 
	 <div class="option3">Odpowiedź 1: <br /> <input type="text"  value="<?php
	if(isset($_SESSION['fr_odp'.$i.'1']))
	  {
		echo $_SESSION['fr_odp'.$i.'1'];
		//unset($_SESSION['fr_odp'.$i.'1']);
	  }
	?>" name="odp<?php echo $i;?>1" /></div><br /><br />
	
	<?php
	  if(isset($_SESSION['e_odp'.$i.'1']))
	  {
		echo '<div class="error">'.$_SESSION['e_odp'.$i.'1'].'</div>';
		unset($_SESSION['e_odp'.$i.'1']);
	  }
	?>
	
	<div class="option3">Odpowiedź 2: <br /> <input type="text"  value="<?php
	if(isset($_SESSION['fr_odp'.$i.'2']))
	  {
		echo $_SESSION['fr_odp'.$i.'2'];
		//unset($_SESSION['fr_odp'.$i.'2']);
	  }
	?>" name="odp<?php echo $i;?>2" /></div><br /><br />
	
	<?php
	  if(isset($_SESSION['e_odp'.$i.'2']))
	  {
		echo '<div class="error">'.$_SESSION['e_odp'.$i.'2'].'</div>';
		unset($_SESSION['e_odp'.$i.'2']);
	  }
	
	 if (!isset($_SESSION["licznikodpowiedzi$i"])){
		$_SESSION["licznikodpowiedzi$i"]=2;	
	  }
	  
	  if(isset($_POST["newanswer$i"]))
		{		 
			$_SESSION["licznikodpowiedzi$i"]++;
			$newanswer= $_POST["newanswer$i"];
		}
	 
		if(isset($_POST["deleteanswer$i"]))
		{		 
			$ktoraodp=$_SESSION["licznikodpowiedzi$i"];
			unset($_SESSION['fr_odp'.$i.$ktoraodp]);
			$_SESSION["licznikodpowiedzi$i"]--;
			$deleteanswer= $_POST["deleteanswer$i"];
		}
		
	if($_SESSION["licznikodpowiedzi$i"]>2)
	{
     for($j=3;$j<=$_SESSION["licznikodpowiedzi$i"];$j++)
	{
		//if ($_POST['newanswer']) {
		?> 
		<div class="option3">Odpowiedź <?php echo $j;?>: <br /> <input type="text"  value="<?php
	if(isset($_SESSION['fr_odp'.$i.$j]))
	  {
		echo $_SESSION['fr_odp'.$i.$j];
		//unset($_SESSION['fr_odp'.$i.$j]);
	  }
	?>" name="odp<?php echo $i.$j;?>" /></div><br /><br />
	<?php
	  if(isset($_SESSION['e_odp'.$i.$j]))
	  {
		echo '<div class="error">'.$_SESSION['e_odp'.$i.$j].'</div>';
		unset($_SESSION['e_odp'.$i.$j]);
	  }

	}}
	?>
	
	 <input type="submit" value="&#xe801;Dodaj odpowiedź" name="newanswer<?php echo $i ?>" class="icon-search" style="color:white;width:300px;font-size:18px;font-family:fontello,Verdana"/>
	 <br /><br /><br /><br />
	  <?php
	 if($_SESSION["licznikodpowiedzi$i"]>2)
	{
	 ?>
	 <input type="submit" value="&#xe802;Usuń odpowiedź" name="deleteanswer<?php echo $i ?>" class="icon-search" style= "color:white;width:300px;font-size:18px;font-family:fontello,Verdana"/>
	  <br /><br /><br /><br />
	   <?php
	}
	 } 
	}
	?>
	 <input type="submit" value="&#xe801;Dodaj pytanie" name="newquestion" class="icon-search" style="color:white;width:300px;font-size:18px;font-family:fontello,Verdana"/>
	 <br /><br /><br /><br />
	 
	   <?php
	   if($_SESSION['licznikpytan']>1)
	{
		?>
		<input type="submit" value="&#xe802;Usuń pytanie" name="deletequestion" class="icon-search" style="color:white;width:300px;font-size:18px;font-family:fontello,Verdana"/>
	 <br /><br /><br /><br />
	 
	<?php
	 } 
	
	?>
	
	<style>
	input[class="icon-search"]
    {
	   background-color: #999999;
	   border-radius:0px;
	   float:left;
	   font-family: Verdana,fontello;
	   text-align:left;
    }
	input[class="icon-search"]:hover
	{
		background-color: gray;
	}
	</style>
	
	<br /><br />
	<input type="submit" value="Zapisz quiz">
	 </form>
	 <br />
	<div class="wyloguj"><a href="profil.php" title=""><center>Wróć</center></a></div>
	<div style="clear:both"></div>
	 
  </div>
 
  <div id="footer">
   <h1>&copy; Wszelkie prawa zastrzeżone</h1>
  </div>
 </div>
</body>

</html>
