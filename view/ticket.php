<?php
    require_once('../php/libreriaPdo.php');
    require_once('../php/daoUser.php');
    require_once('../php/daoOrder.php');
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <!--Css propio-->
        <link rel="stylesheet" type="text/css" href="../css/style_ticket.css"></link>
        <link rel="stylesheet" type="text/css" href="../css/style_registro.css"></link>
        <link rel="stylesheet" type="text/css" href="../css/style_main.css"></link>

        <?php
            session_start();
        ?>

        <title>EShopGroceries - Ticket</title>
        <link rel="icon" type="image/x-icon" href="../img/logo/logo.png">
    </head>

    <body>
        <div class="row">
            <div class="col-12 padding-Logo ">
                <img class="logo" src="../img/logo/logo.png"></img>
            </div>
        </div>

        <div class="ticketTitle">
            <?php    
                $daoUser = new DaoUser();
                $daoUser->userLoggedInTicket($_GET['ticketId']);    
                $daoOrder = new DaoOrder();
                $daoOrder->createTable($_GET['ticketId']);
            ?>
        </div>

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="../js/jquery-3.2.1.min.js"></script>
        <script type="module" src="../js/main.js"></script>
    </body>
</html>