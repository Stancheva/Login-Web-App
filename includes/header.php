
<!DOCTYPE html>
<?php
session_start();
?>
<script>
    function team_registration(){
    if (document.getElementById('team').checked) {
        document.getElementById('team_reg').style.display = 'block';

    }
    
};
function single_registration(){
    if (document.getElementById('single').checked) {
        document.getElementById('team_reg').style.display = 'none';
        document.getElementById('enter_number').style.display = 'none';
    }
    
};
function show_number_field(){
    if (document.getElementById('already_register').checked) {
        document.getElementById('enter_number').style.display = 'block';
    }
};
function hide_number_field(){
    if (document.getElementById('not_register').checked) {
        document.getElementById('enter_number').style.display = 'none';
    }
};

</script>
<!-- jQuery -->
<script src="js/jquery-2.1.1.js" type="text/javascript"></script>
<!-- jQuery easing plugin -->
<script src="js/jquery.easing-1.3.min.js" type="text/javascript"></script>

<script src="js/style_javascript.js"></script>
<head>
    
    <title><?= $PageTitle; ?></title>
    <meta charset="utf-8">
    

</head>

<body>
