<?php include 'MenuAdmin.php';
$nazwaO = '';
$pojemnoscO = '';
$poprawneO = true;
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
      <a class ="tytul" style="color: #007bff;">Opakowania</a>
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
    $result = $conn->query("SELECT * FROM opakowanie") or die($conn->error);

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
            <th scope="col">Typ opakowania</th>
            <th scope="col">Pojemność w mililitrach</th>
            <th colspan="2">Przyciski</th>
          </tr>
        </thead>
        <tbody>
        <?php
        while($row = $result->fetch_assoc()):
         ?>
         <tr>
           <td><?php echo $row['Typ'] ?></td>
           <td><?php echo $row['PojemnoscMl'] ?></td>
           <td>
             <form method="POST">
                <input type="submit" name="edytuj" class="btn btn-warning" value="Edytuj">
                <input type="submit" name="usun" class="btn btn-danger" value="Usuń">
                <input type="hidden" value="<?php echo $row['idOpakowanie']; ?>" name="id"/>
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
      $result = $conn->query("SELECT * FROM opakowanie WHERE idOpakowanie = $id") or die($conn->error);
        $guzikAktualizuj = true;
        $row = $result->fetch_array();
        $nazwaO = $row['Typ'];
        $pojemnoscO = $row['PojemnoscMl'];
    }
    if(isset($_POST['aktualizuj'])){
      $idDR = $_POST['idDR'];
      $nazwaO = $_POST['nazwa'];
      $pojemnoscO= $_POST['pojemnosc'];

      if(!is_numeric($pojemnoscO))
      {
       $poprawneO=false;
       $_SESSION['errorPojemnosc']="Pole pojemnosc może zawierać tylko cyfry!";
      }

      if($poprawneO == true){
      $conn->query("UPDATE opakowanie SET Typ = '$nazwaO', PojemnoscMl = '$pojemnoscO' WHERE idOpakowanie=$idDR") or die($conn->error);
      $_SESSION['message'] = "Opakowanie zaktualizowane!";
      $_SESSION['msg_type'] = "warning";
      echo("<meta http-equiv='refresh' content='0'>");
      }
    }

    if(isset($_POST['zapisz'])){
      $nazwaO = $_POST['nazwa'];
      $pojemnoscO = $_POST['pojemnosc'];

      if(!is_numeric($pojemnoscO))
      {
       $poprawneO=false;
       $_SESSION['errorPojemnosc']="Pole pojemnosc moze zawierac tylko cyfry!";
      }
      if($poprawneO == true){
       $conn->query("INSERT INTO opakowanie (Typ,PojemnoscMl) VALUES('$nazwaO','$pojemnoscO')") or die($conn->error);
       $_SESSION['message'] = "Dodano opakowanie!";
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
      <label>Nazwa opakowania</label>
      <input type="text" name="nazwa" value ="<?php echo $nazwaO; ?>" placeholder="Nazwa opakowania" class="form-control" required>
      </div>
      <div class="form-group">
      <label>Pojemność w mililitrach</label>
      <input type="number" name="pojemnosc" value ="<?php echo $pojemnoscO; ?>" placeholder="Pojemność" class="form-control" required>
      </div>
      <?php
        if(isset($_SESSION['errorPojemnosc']))
        {
          echo '<div class="error">'.$_SESSION['errorPojemnosc'].'</div><br>';
          unset($_SESSION['errorPojemnosc']);
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
      $conn->query("DELETE FROM opakowanie WHERE idOpakowanie = $id") or die($conn->error);
      echo("<meta http-equiv='refresh' content='0'>");
      $_SESSION['message'] = "Usunięto opakowanie!";
      $_SESSION['msg_type'] = "danger";
    }
    ?>


  </body>
</html>
