
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html"/>
        <title>.:: Menu ::.</title>
        <script src="../jquery/jquery-1.7.1.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $.ajaxSetup({cache: false});

                $("body").on("click", "#btnBackUp", function () {
                    window.location.href = "backUp.php";

                });
            });
        </script>


    </head><body>
        <?php
        include('../include/header.php');
        aud($_SESSION['i'], '', 'Ingreso al sistema', 1);
        ?>

        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
    </body>
<?php include('../include/pie.php'); ?>
</html>



<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html"/>
<title>.:: Menu ::.</title>
</head>
<?php include('../include/header.php'); 
aud($_SESSION['i'],'','Ingreso al sistema',1);?>
<body>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
</body>
<?php include('../include/pie.php'); ?>
</html>-->