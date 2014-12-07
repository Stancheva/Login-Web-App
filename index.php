<?php
$PageTitle = 'Index';
include 'includes/header.php';

error_reporting(E_ALL ^ E_NOTICE);
ini_set('memory_limit', '-1');
mb_internal_encoding('UTF-8');

if ($_POST) {
    $project = $_POST['project'];
    $entering_number=trim($_POST['number']);
    $er = array();
    if ($project==1) {
        $_SESSION['isLogged'] = true;
        $_SESSION['project'] = $project;
        header('Location:registration.php');
        exit();
    }
    else if ($project==2){
        $er[autors] = 'Ако имате съавтор, моля посочете дали е регистриран';
    }
    else if($project==3){
        
        $conn = mysqli_connect('localhost', 'developer', 'developer', 'technical_university');
        if (!$conn) {
            echo 'Няма връзка с базата от данни!';
        }
        
        mysqli_set_charset($conn, 'utf8');
        $sql="SELECT * FROM `project_information` WHERE entering_number='$entering_number'";
        $q = mysqli_query($conn, $sql);
        if(mysqli_num_rows($q)==0){
            $er[wrong_number]="Моля, проверете коректността на входящия номер, който сте въвели";
        }
        
        if(mysqli_num_rows($q)==3){
            $er[team_limit]="В този отбор вече има максимален брой съавтори!";
        }
        if (mysqli_num_rows($q)>0&&mysqli_num_rows($q)<3){
            $_SESSION['isLogged'] = true;
            $_SESSION['project'] = $project;
            $_SESSION['entering_number'] = $entering_number;
            header('Location:team_registration.php');
            exit();
        }
        else{//da napravq otdelni proverki za 0 ili poveche ot 3
            //echo 'Моля, проверете отново коректността на входящия номер, който сте въвели';
        }
    }
    else if($project==4){
        $_SESSION['isLogged'] = true;
        $_SESSION['project'] = $project;
        header('Location:registration.php');
        exit();
    }
    else {
        $er[unchecked]= "Моля, опитайте отново";
    }
}

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
        <div class="errors" style="color: red;margin-bottom:10px;">
            <small class="errorText"><?php echo $er[autors]; ?></small>
            <small class="errorText"><?php echo $er[wrong_number]; ?></small>
            <small class="errorText"><?php echo $er[team_limit]; ?></small>
            <small class="errorText"><?php echo $er[unchecked]; ?></small>
        </div>
        <h2 class="fs-title">Обща информация</h2>
        
        <label class="fs-subtitle">Учасвам в проекта</label>
        <br>
        <input type="radio" onclick="single_registration();" name="project" value="1" id="single">
        <label for="single">Сам</label>
        <br>
        <input type="radio" onclick="team_registration();" name="project" value="2" id="team">
        <label for="team">Отборно</label>
        <br>

        <div id="team_reg" style="display: none;">
            <input type="radio" onclick="show_number_field();" name="project" value="3" id="already_register">
            <label for="already_register">Участник от отбора вече е регистриран</label>
            <div id="enter_number" style="display:none;">
                <input type='text' name='number' placeholder="Въведете входящия номер"/>  
            </div>
            <br>
            <input type="radio" onclick="hide_number_field();" name="project" value="4" id="not_register">
            <label for="not_register">Отборът не е регистриран</label>
        </div>
        
        <input type="submit" name="submit" class="submit action-button" value="Next" />
        
    </fieldset>

</form>


<?php
include 'includes/footer.php';
?>
    
