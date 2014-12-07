<?php
$PageTitle = 'Finish';
include 'includes/header.php';

error_reporting(E_ALL ^ E_NOTICE);
ini_set('memory_limit', '-1');
mb_internal_encoding('UTF-8');

?>

<link rel="stylesheet" type="text/css" href="style/index.css">

<form id="msform" method="POST" enctype="multipart/form-data">

    <div id="form_header">
        <img src="style/images/logo.png"/>
        <h2 class="fs-title">Технически университет Варна</h2>
        <h2 class="fs-title">Регистрационна карта</h2>
    </div>

    <ul id="progressbar">
        
    </ul>
    
    <!-- fieldsets -->
    <fieldset>
        <h2 class="fs-title">Регистрацията е успешна!</h2>
        <p style="margin-top:20px">Вашият входящ номер е: <?php echo $_SESSION[entering_number];?></p>
        <small> Същият е изпратен на посочения от Вас електронен адрес. </small>
        
    </fieldset>
    <?php
    include 'send-mail.php';
    
    ?>
</form>



<?php
include 'excel_data.php';
session_start();
session_destroy();
include 'includes/footer.php';
?>
    
