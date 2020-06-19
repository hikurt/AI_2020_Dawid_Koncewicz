<?php include 'MenuKlient.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <style>
    </style>
  </head>
  <body>
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
    <div class = "divout">
      <a class ="tytul" style="color: #007bff;">Wybierz Sok</a>
    </div>
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

    <?php
    if(isset($_POST['wybierzSok'])){
      $_SESSION['idSok'] = $_POST['idSok'];
      $_SESSION['message'] = "Wybrano sok!";
      $_SESSION['msg_type'] = "success";
      echo("<meta http-equiv='refresh' content='0'>");
    }
     ?>
    <div>
      <table class="table table-striped table-dark">
        <thead>
          <tr>
            <th scope="col">Nazwa</th>
            <th scope="col">Zawartość owoców (%)</th>
            <th scope="col">Zawartość warzyw (%)</th>
            <th colspan="2">Wybierz sok</th>
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
               <input type="submit" name="wybierzSok" class="btn btn-info" value="Wybierz">
                <input type="hidden" value="<?php echo $row['idSok']; ?>" name="idSok"/>
            </form>
           </td>
         <?php endwhile; ?>
         </tr>
         </tbody>
      </table>
    </div>

    <div class = "row justify-content-center">
    <form class="" action="" method="post">
      <input type="hidden" name="idDR" value="<?php echo $id; ?>">
    </div>
    </div>
    </form>


    <!--DRUGA TABELA-->

    <div class = "divout">
      <a class ="tytul" style="color: #007bff;">Wybierz smak</a>
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

    <?php
    if(isset($_POST['wybierzSmak'])){
      $_SESSION['idSkladniki'] = $_POST['idSkladniki'];
      $_SESSION['message'] = "Wybrano smak!";
      $_SESSION['msg_type'] = "success";
      echo("<meta http-equiv='refresh' content='0'>");
    }
     ?>

    <div>
      <table class="table table-striped table-dark">
        <thead>
          <tr>
            <th scope="col">Smak</th>
            <th scope="col">Organiczny</th>
            <th colspan="2">Wybierz smak</th>
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
                <input type="submit" name="wybierzSmak" class="btn btn-info" value="Wybierz">
                <input type="hidden" value="<?php echo $row['idSkladniki']; ?>" name="idSkladniki"/>
            </form>
           </td>
         <?php endwhile; ?>
         </tr>
         </tbody>
      </table>
    </div>

    <!--TRZECIA TABELA-->

    <div class = "divout">
      <a class ="tytul" style="color: #007bff;">Wybierz opakowanie</a>
    </div>
     </div>
    <?php
    require_once "polaczenie.php";
    $conn = new mysqli($adres, $login, $haslo, $baza);

    if($conn->connect_error)
    die("Bład połaczenia".$conn->connect_error());
    // uzupelnij tabele rekordami
    $result = $conn->query("SELECT * FROM Opakowanie") or die($conn->error);

    ?>

    <?php
    if(isset($_POST['wybierzOpakowanie'])){
      $_SESSION['idOpakowanie'] = $_POST['idOpakowanie'];
      $_SESSION['message'] = "Wybrano opakowanie!";
      $_SESSION['msg_type'] = "success";
      echo("<meta http-equiv='refresh' content='0'>");
    }
     ?>

    <div>
      <table class="table table-striped table-dark">
        <thead>
          <tr>
            <th scope="col">Typ opakowania</th>
            <th scope="col">Pojemność w mililitrach</th>
            <th colspan="2">Wybierz opakowanie</th>
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
                <input type="submit" name="wybierzOpakowanie" class="btn btn-info" value="Wybierz">
                <input type="hidden" value="<?php echo $row['idOpakowanie']; ?>" name="idOpakowanie"/>
            </form>
           </td>
         <?php endwhile; ?>
         </tr>
         </tbody>
      </table>

      <form class="" action="" method="post">
        <div class="test">
          <div class="form-group">
          <label>Ilość</label>
          <input type="number" name="ilosc" placeholder="Ilość" class="form-control" required>
          </div>
        <div class="form-group">
          <button type="submit" class="btn btn-success"name="zlozZamowienie">Złóż zamówienie</button>
        </div>
        </div>
      </div>
      </div>
      </form>
    </div>

    <?php
    if(isset($_POST['zlozZamowienie'])){

      if(isset($_SESSION['idSok']) or isset($_SESSION['idSmak']) or isset($_SESSION['idOpakowanie']))
      {
      $date = date('Y-m-d');
      $date = date('Y-m-d',strtotime($date. ' + 3 days'));
      $idKlient=$_SESSION['idUzytkownicy'];
      $idOpakowanie=$_SESSION['idOpakowanie'];
      $idSkladniki=$_SESSION['idSkladniki'];
      $idSok=$_SESSION['idSok'];
      $ilosc=$_POST['ilosc'];
      $cena = 0;
      $result4 = $conn->query("SELECT PojemnoscMl FROM opakowanie WHERE idOpakowanie = '$idOpakowanie'") or die($conn->error);
      $row=$result4->fetch_assoc();
      $cena = $cena + $row['PojemnoscMl']/250 * $ilosc;
      $result5 = $conn->query("SELECT Organiczny FROM skladniki WHERE idSkladniki = '$idSkladniki'") or die($conn->error);
      $row=$result5->fetch_assoc();
      if($row['Organiczny'] == 'Tak'){
        $cena = $cena + 2;
      }


      $conn->query("INSERT INTO zamowienia (idKlient,idOpakowanie,idSkladniki,idSok,cena,dataDostarczenia,ilosc) VALUES('$idKlient','$idOpakowanie','$idSkladniki','$idSok',$cena,'$date','$ilosc')") or die($conn->error);
      $_SESSION['message'] = "Dodano!";
      $_SESSION['msg_type'] = "success";
      unset($_SESSION['idOpakowanie']);
      unset($_SESSION['idSkladniki']);
      unset($_SESSION['idSok']);
      echo("<meta http-equiv='refresh' content='0'>");

    }
    else{
      $_SESSION['message'] = "Nie wybrano wszystkich rzeczy potrzebnych do zamówienia!";
      $_SESSION['msg_type'] = "danger";
     echo("<meta http-equiv='refresh' content='0'>");
    }
    }
     ?>


  </body>
</html>
