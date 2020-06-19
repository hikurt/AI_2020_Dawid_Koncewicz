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
      <a class ="tytul" style="color: #007bff;">Moje zamówienia</a>
    </div>
    <?php
    require_once "polaczenie.php";
    $conn = new mysqli($adres, $login, $haslo, $baza);

    if($conn->connect_error)
    die("Bład połaczenia".$conn->connect_error());
    // uzupelnij tabele rekordami
    $idKlient=$_SESSION['idUzytkownicy'];
    $result = $conn->query("SELECT S.*, SK.*, O.*, SM.*,Z.* FROM sok S, skladniki SK, opakowanie O, smak SM, zamowienia Z WHERE SK.idSmak=SM.idSmak AND Z.idOpakowanie = O.idOpakowanie AND Z.idSkladniki = SK.idSkladniki AND Z.idSok=S.idSok AND Z.idKlient = '$idKlient'") or die($conn->error);

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
            <th scope="col">Nazwa Soku</th>
            <th scope="col">Zawartość owoców (%)</th>
            <th scope="col">Zawartość warzyw (%)</th>
            <th scope="col">Smak</th>
            <th scope="col">Organiczny</th>
            <th scope="col">Typ opakowania</th>
            <th scope="col">Pojemność w mililitrach</th>
            <th scope="col">Ilość</th>
            <th scope="col">Cena</th>
            <th scope="col">Data dostarczenia</th>
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
           <td><?php echo $row['Smak'] ?></td>
           <td><?php echo $row['Organiczny'] ?></td>
           <td><?php echo $row['Typ'] ?></td>
           <td><?php echo $row['PojemnoscMl'] ?></td>
           <td><?php echo $row['ilosc'] ?></td>
           <td><?php echo $row['cena'] ?></td>
           <td><?php echo $row['dataDostarczenia'] ?></td>
         <?php endwhile; ?>
         </tr>
         </tbody>
      </table>
    </div>

    <div class = "row justify-content-center">
    <form class="" action="" method="post">
    </div>
    </div>
    </form>
