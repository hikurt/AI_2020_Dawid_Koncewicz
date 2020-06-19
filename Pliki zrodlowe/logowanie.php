<?php
$correctReg = true;

require_once "polaczenie.php";
$conn = new mysqli($adres, $login, $haslo, $baza);

if($conn->connect_error)
die("Bład połaczenia".$conn->connect_error());

if(isset($_POST['login']) && isset($_POST['haslo']))
{

$login = $_POST['login'];
$haslo = $_POST['haslo'];

	$sql = "SELECT * FROM uzytkownicy WHERE permisja = 'admin';";
	$results = $conn->query($sql);

	if($results->num_rows>0){
		while($row = $results->fetch_assoc())
		{
			if(($login==$row['login']) && ($haslo==$row['haslo']))
			{
				$_SESSION['sesja']="admin";
				header("Location: index.php?page=admin");
				exit();
			}
		}
    $_SESSION['errorLogin']="Login lub haslo jest bledne!";
	}
	else{
    $_SESSION['errorLogin']="Login lub haslo jest bledne!";
	}

	$sql1 = "SELECT * FROM uzytkownicy WHERE permisja = 'klient';";
	$results1 = $conn->query($sql1);

	if($results1->num_rows>0){
			while($row = $results1->fetch_assoc())
			{
				if(($login==$row['login']) && ($haslo==$row['haslo']))
				{
					$_SESSION['sesja']="klient";
					$_SESSION['idUzytkownicy'] = $row['idUzytkownicy'];
					header("Location: index.php?page=klient");
					exit();
				}
			}
			$_SESSION['errorLogin']="Login lub haslo jest bledne!";
		}
	else{
			$_SESSION['errorLogin']="Login lub haslo jest bledne!";
		}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Firma sokowa</title>
	<link rel="stylesheet" type="text/css" href="styleS.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="logowanie">

<div class="container" id="container">
<div class="form-container sign-up-container">

<form id = "register" class="input-group"  method="post">
	<h1>Stwórz konto</h1>
	<input type="text" name="loginR" placeholder="Login" required>
	<input type="email" name="emailR" placeholder="E-mail" required>
	<input type="password" name="hasloR" placeholder="Hasło" required>
	<button>Zarejestruj sie</button>
</form>
</div>
<div class="form-container sign-in-container">
	<form id = "login" class="input-group" method="post">
		<h1>Zaloguj</h1>
    <?php
						if(isset($_SESSION['errorLogin']))
						{
							echo '<div class="error">'.$_SESSION['errorLogin'].'</div><br>';
							unset($_SESSION['errorLogin']);
						} ?>
	<input type="text" name="login" placeholder="Login" required>
	<input type="password" name="haslo" placeholder="Hasło" required>
	<button>Zaloguj się</button>
	</form>
</div>
<div class="overlay-container">
	<div class="overlay">
		<div class="overlay-panel overlay-left">
			<h1>Witaj!</h1>
			<p>Jezeli masz juz konto, zaloguj sie!</p>
			<button class="ghost" id="Zaloguj">Zaloguj</button>
		</div>
		<div class="overlay-panel overlay-right">
			<h1>Witaj!</h1>
			<p>Zarejestruj sie i poznaj nasze przepyszne soki!</p>
			<button class="ghost" id="Zarejestruj">Zarejestruj</button>
		</div>
	</div>
</div>
</div>

<?php
	if(isset($_POST['loginR']) && isset($_POST['emailR']) && isset($_POST['hasloR']))
	{
		$loginR = $_POST['loginR'];
		$emailR = $_POST['emailR'];
		$hasloR = $_POST['hasloR'];

		$rezultat1 = $conn->query("SELECT login FROM uzytkownicy WHERE login='$loginR'");
		if(!$rezultat1) throw new Exception($conn->error); //błąd

		$ile_loginow = $rezultat1->num_rows;
		if($ile_loginow>0)
		{
			$correctReg=false;
		}

		 if($correctReg == true)
		 {
			 $conn->query("INSERT INTO uzytkownicy (login,email,haslo,permisja) VALUES ('$loginR','$emailR','$hasloR','klient')");
    echo "<script>alert('Rejestracja udana!')</script>";

		 }
		 else{
			 echo "<script>alert('Taki login juz istnieje!')</script>";
		 }
	 }
	 ?>


<script type="text/javascript">
	const zarejestrujGuzik = document.getElementById('Zarejestruj');
	const zalogujGuzik = document.getElementById('Zaloguj');
	const container = document.getElementById('container');

	zarejestrujGuzik.addEventListener('click', () => {
		container.classList.add("right-panel-active");
	});
	zalogujGuzik.addEventListener('click', () => {
		container.classList.remove("right-panel-active");
	});
</script>
</div>
</body>
</html>
