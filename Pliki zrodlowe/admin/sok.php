<?php include 'MenuAdmin.php';
$nazwaS = '';
$warzywaS = '';
$owoceS = '';
$poprawneS = true;
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
      <a class ="tytul" style="color: #007bff;">Sok</a>
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
    $result = $conn->query("SELECT * FROM sok") or die($conn->error);

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
            <th scope="col">Nazwa soku</th>
            <th scope="col">Zawartość owoców (%)</th>
            <th scope="col">Zawartość warzyw (%)</th>
            <th colspan="2">Przyciski</th>
          </tr>
        </thead>
        <tbody>
        <?php
        while($row = $result->fetch_assoc()):
         ?>
         <tr>
           <td><?php echo $row['Nazwa'] ?></td>
           <td><?php echo $row['ZawartoscOwocow'] ?></td>
           <td><?php echo $row['ZawartoscWarzyw'] ?></td>
           <td>
             <form method="POST">
                <input type="submit" name="edytuj" class="btn btn-warning" value="Edytuj">
                <input type="submit" name="usun" class="btn btn-danger" value="Usuń">
                <input type="hidden" value="<?php echo $row['idSok']; ?>" name="id"/>
            </form>
           </td>
         <?php endwhile; ?>
         </tr>
         </tbody>
      </table>
    </div>
    <?php
    // edytuj uzytkownika z bazy


    if(isset($_POST['edytuj'])){
      $id = $_POST['id'];
      $result = $conn->query("SELECT * FROM sok WHERE idSok = $id") or die($conn->error);
        $guzikAktualizuj = true;
        $row = $result->fetch_array();
        $nazwaS = $row['Nazwa'];
        $owoceS = $row['ZawartoscOwocow'];
        $warzywaS = $row['ZawartoscWarzyw'];
    }
    if(isset($_POST['aktualizuj'])){
      $idDR = $_POST['idDR'];
      $nazwaS = $_POST['nazwa'];
      $owoceS = $_POST['owoce'];
      $warzywaS= $_POST['warzywa'];

      if(!is_numeric($owoceS))
      {
       $poprawneS=false;
       $_SESSION['errorOwoce']="Pole zawartosc owocow może zawierać tylko cyfry!";
      }

      if(!is_numeric($warzywaS))
      {
       $poprawneS=false;
       $_SESSION['errorWarzywa']="Pole zawartosc warzyw może zawierać tylko cyfry!";
      }

      if($poprawneS == true){
      $conn->query("UPDATE sok SET Nazwa = '$nazwaS', ZawartoscOwocow = '$owoceS',ZawartoscWarzyw = '$warzywaS' WHERE idSok=$idDR") or die($conn->error);
      $_SESSION['message'] = "Sok zaktualizowany!";
      $_SESSION['msg_type'] = "warning";
      echo("<meta http-equiv='refresh' content='0'>");
      }
    }

    if(isset($_POST['zapisz'])){
      $nazwaS = $_POST['nazwa'];
      $owoceS = $_POST['owoce'];
      $warzywaS= $_POST['warzywa'];

      if(!is_numeric($owoceS))
      {
       $poprawneS=false;
       $_SESSION['errorOwoce']="Pole zawartosc owocow może zawierać tylko cyfry!";
      }

      if(!is_numeric($warzywaS))
      {
       $poprawneS=false;
       $_SESSION['errorWarzywa']="Pole zawartosc warzyw może zawierać tylko cyfry!";
      }

      if($poprawneS == true){
       $conn->query("INSERT INTO sok (Nazwa,ZawartoscOwocow,ZawartoscWarzyw) VALUES('$nazwaS','$owoceS','$warzywaS')") or die($conn->error);
       $_SESSION['message'] = "Dodano sok!";
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
      <label>Nazwa soku</label>
      <input type="text" name="nazwa" value ="<?php echo $nazwaS; ?>" placeholder="Nazwa opakowania" class="form-control" required>
      </div>
      <div class="form-group">
      <label>Zawartość owoców (%)</label>
      <input type="text" name="owoce" value ="<?php echo $owoceS; ?>" placeholder="Zawartość owoców" class="form-control" required>
      </div>
      <?php
        if(isset($_SESSION['errorOwoce']))
        {
          echo '<div class="error">'.$_SESSION['errorOwoce'].'</div><br>';
          unset($_SESSION['errorOwoce']);
        }
      ?>
      <div class="form-group">
      <label>Zawartość warzyw (%)</label>
      <input type="text" name="warzywa" value ="<?php echo $warzywaS; ?>" placeholder="Zawartość warzyw" class="form-control" required>
      </div>
      <?php
        if(isset($_SESSION['errorWarzywa']))
        {
          echo '<div class="error">'.$_SESSION['errorWarzywa'].'</div><br>';
          unset($_SESSION['errorWarzywa']);
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
      $id = $_POST['id'];
      $conn->query("DELETE FROM sok WHERE idSok = $id") or die($conn->error);
      echo("<meta http-equiv='refresh' content='0'>");
      $_SESSION['message'] = "Usunięto sok!";
      $_SESSION['msg_type'] = "danger";
    }
    ?>


  </body>
</html>
