<!DOCTYPE HTML>
<html lang="pl">
    <head>
      <link rel="stylesheet" type="text/css" href="style.css">
    	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta charset="utf-8"/>
        <meta name="description" content="Firma Sokowa">
        <meta name="author" content="Dawid Koncewicz">
        <title>Firma Sokowa</title>



        <!--------------------------CSS--------------------->
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

      	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

      </head>
        <!--------------------------SCRIPTS------------------>
        <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="styleS.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    </head>
    <body>
        <?php
        session_start();

        $current_page = isset($_GET['page']) ? $_GET['page'] : null;



        switch ($current_page)
        {
            case 'logowanie':
            default;
                include 'logowanie.php';
                break;
            case 'admin':
                include 'admin/MenuAdmin.php';
                break;
            case 'opakowanie':
                include 'admin/opakowanie.php';
                break;
            case 'sok':
                include 'admin/sok.php';
                break;
            case 'skladniki':
                include 'admin/skladniki.php';
                break;
          case 'klient':
                include 'klient/MenuKlient.php';
                break;
         case 'zamowienie':
                include 'klient/zamowienie.php';
                break;
          case 'mojezamowienia':
                include 'klient/mojezamowienia.php';
                break;
        }

        ?>

    </body>
</html>
