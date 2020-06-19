<?php include 'MenuAdmin.php';
$smakS = '';
$smakSK = '';
$organicznySK ='';

$poprawneS = true;
$poprawneSK = true;
$guzikAktualizuj = false;
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <style>
    </style>
  </head>
  <body>
    <div class = "divout">
      <a class ="tytul" style="color: #007bff;">Smak</a>
    </div>
    <?php
    if(isset($_SESSION['message'])):
     ?>
     <div class="alert alert-<?=$_SESSION['msg_type']?>">
       <?php
       echo $_SESSION['message'];
       unset($_SESSION['message']);
        ?>
     </div>
     <?php
   endif; ?>
    <?php
    require_once "polaczenie.php";
    $conn = new mysqli($adres, $login, $haslo, $baza);

    if($conn->connect_error)
    die("Bład połaczenia".$conn->connect_error());
    // uzupelnij tabele rekordami
    $result = $conn->query("SELECT * FROM smak") or die($conn->error);

    function pre_r($array)
    {
      echo '<pre>';
      print_r($array);
      echo '</pre>';
    }
    ?>

    <div>
      <table class="table table-striped table-dark">
        <thead>
          <tr>
            <th scope="col">Smak</th>
            <th colspan="2">Przyciski</th>
          </tr>
        </thead>
        <tbody>
        <?php
        while($row = $result->fetch_assoc()):
         ?>
         <tr>
           <td><?php echo $row['Smak'] ?></td>
           <td>
             <form method="POST">
                <input type="submit" name="edytuj" class="btn btn-warning" value="Edytuj">
                <input type="submit" name="usun" class="btn btn-danger" value="Usuń">
                <input type="submit" name="wybierz" class="btn btn-info" value="Wybierz">
                <input type="hidden" value="<?php echo $row['idSmak']; ?>" name="idSmak"/>
            </form>
           </td>
         <?php endwhile; ?>
         </tr>
         </tbody>
      </table>
    </div>
    <?php
    // edytuj uzytkownika z bazy
    if(isset($_POST['wybierz'])){
      $_SESSION['id'] = $_POST['idSmak'];
      $id = $_POST['idSmak'];
      $result = $conn->query("SELECT * FROM smak WHERE idSmak = $id") or die($conn->error);
      $row = $result->fetch_array();
      $smakSK = $row['Smak'];
    }

    if(isset($_POST['edytuj'])){
      $id = $_POST['idSmak'];
      $result = $conn->query("SELECT * FROM smak WHERE idSmak = $id") or die($conn->error);
        $guzikAktualizuj = true;
        $row = $result->fetch_array();
        $smakS = $row['Smak'];

    }
    if(isset($_POST['aktualizuj'])){
      $idDR = $_POST['idDR'];
      $smakS = $_POST['smak'];

      if ( !preg_match ("/^[a-zA-Z\s]+$/",$smakS)) {
          $poprawneS=false;
          $_SESSION['errorSmak']="Pole smak moze zawierac tylko litery!";
        }

      if($poprawneS == true){
      $conn->query("UPDATE smak SET Smak = '$smakS' WHERE idSmak=$idDR") or die($conn->error);
      $_SESSION['message'] = "Smak zaktualizowany!";
      $_SESSION['msg_type'] = "warning";
      echo("<meta http-equiv='refresh' content='0'>");
      }
    }

    if(isset($_POST['zapisz'])){
      $smakS = $_POST['smak'];
      if ( !preg_match ("/^[a-zA-Z\s]+$/",$smakS)) {
          $poprawneS=false;
          $_SESSION['errorSmak']="Pole smak moze zawierac tylko litery!";
        }

      if($poprawneS == true){
       $conn->query("INSERT INTO smak (Smak) VALUES('$smakS')") or die($conn->error);
       $_SESSION['message'] = "Dodano nowy smak!";
       $_SESSION['msg_type'] = "success";
       echo("<meta http-equiv='refresh' content='0'>");
     }
     }
     ?>
    <div class = "row justify-content-center">
    <form class="" action="" method="post">
      <input type="hidden" name="idDR" value="<?php echo $id; ?>">
      <div class="test">
      <div class="form-group">
      <label>Smak</label>
      <input type="text" name="smak" value ="<?php echo $smakS; ?>" placeholder="Smak" class="form-control" required>
      </div>
      <?php
        if(isset($_SESSION['errorSmak']))
        {
          echo '<div class="error">'.$_SESSION['errorSmak'].'</div><br>';
          unset($_SESSION['errorSmak']);
        }
      ?>
      <div class="form-group">
        <?php
        if($guzikAktualizuj==true):
         ?>
        <button type="submit" class="btn btn-warning"name="aktualizuj">Aktualizuj</button>
      <?php else: ?>
        <button type="submit" class="btn btn-success"name="zapisz">Dodaj</button>
      <?php endif; ?>
      </div>
      </div>
    </div>
    </div>
    </form>

    <?php
    // usun uzytkownika z bazy
    if(isset($_POST['usun'])){
      $id = $_POST['idSmak'];
      $conn->query("DELETE FROM smak WHERE idSmak = $id") or die($conn->error);
      echo("<meta http-equiv='refresh' content='0'>");
      $_SESSION['message'] = "Usunięto smak!";
      $_SESSION['msg_type'] = "danger";
    }
    ?>


    <!--DRUGA TABELA-->


    <div class = "divout">
      <a class ="tytul" style="color: #007bff;">Informacje</a>
    </div>
     </div>
    <?php
    require_once "polaczenie.php";
    $conn = new mysqli($adres, $login, $haslo, $baza);

    if($conn->connect_error)
    die("Bład połaczenia".$conn->connect_error());
    // uzupelnij tabele rekordami
    $result = $conn->query("SELECT S.*, SM.* FROM skladniki S, smak SM WHERE S.idSmak=SM.idSmak") or die($conn->error);

    ?>
    <div>
      <table class="table table-striped table-dark">
        <thead>
          <tr>
            <th scope="col">Smak</th>
            <th scope="col">Organiczny</th>
            <th colspan="2">Przyciski</th>
          </tr>
        </thead>
        <tbody>
        <?php
        while($row = $result->fetch_assoc()):
         ?>
         <tr>
           <td><?php echo $row['Smak'] ?></td>
           <td><?php echo $row['Organiczny'] ?></td>
           <td>
             <form method="POST">
                <input type="submit" name="usunn" class="btn btn-danger" value="Usuń">
                <input type="hidden" value="<?php echo $row['idSkladniki']; ?>" name="id"/>
            </form>
           </td>
         <?php endwhile; ?>
         </tr>
         </tbody>
      </table>
    </div>
    <?php
    // edytuj uzytkownika z bazy

    if(isset($_POST['zapiszD'])){
      $organicznySK = $_POST['organiczny'];
      if ( !preg_match ("/^[a-zA-Z\s]+$/",$organicznySK)) {
          $poprawneSK=false;
          $_SESSION['errorSmak']="Pole smak moze zawierac tylko litery!";
        }
      if ($_POST['smakSK']=='') {
          $poprawneSK=false;
          $_SESSION['errorWybierz']="Wybierz smak z tabeli powyzej!";
      }

      if($poprawneSK == true){
       $idSmak = $_SESSION['id'];
       $conn->query("INSERT INTO skladniki (idSmak,Organiczny) VALUES('$idSmak','$organicznySK')") or die($conn->error);
       $_SESSION['message'] = "Dodano!";
       $_SESSION['msg_type'] = "success";
       echo("<meta http-equiv='refresh' content='0'>");
     }
     }
     ?>
    <div class = "row justify-content-center">
    <form class="" action="" method="post">
      <input type="hidden" name="idDR" value="<?php echo $id; ?>">
      <div class="test">
      <div class="form-group">
        <?php
          if(isset($_SESSION['errorWybierz']))
          {
            echo '<div class="error">'.$_SESSION['errorWybierz'].'</div><br>';
            unset($_SESSION['errorWybierz']);
          }
        ?>
      <label>Smak</label>
      <input type="text" name="smakSK" value ="<?php echo $smakSK; ?>" placeholder="Smak" class="form-control" required readonly>
      </div>
      <div class="form-group">
      <label>Organiczny</label>
      <input type="text" name="organiczny" value ="<?php echo $organicznySK; ?>" placeholder="Organiczny" class="form-control" required>
      </div>
      <?php
        if(isset($_SESSION['errorSmak']))
        {
          echo '<div class="error">'.$_SESSION['errorSmak'].'</div><br>';
          unset($_SESSION['errorSmak']);
        }
      ?>
      <div class="form-group">
        <button type="submit" class="btn btn-success"name="zapiszD">Dodaj</button>
      </div>
      </div>
    </div>
    </div>
    </form>

    <?php
    // usun uzytkownika z bazy
    if(isset($_POST['usunn'])){
      $id = $_POST['id'];
      $conn->query("DELETE FROM Skladniki WHERE idSkladniki = $id") or die($conn->error);
      echo("<meta http-equiv='refresh' content='0'>");
      $_SESSION['message'] = "Usunięto!";
      $_SESSION['msg_type'] = "danger";
    }
    ?>

  </body>
</html>
