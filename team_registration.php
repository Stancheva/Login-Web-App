<?php
$PageTitle = 'Team_registration';
include 'includes/header.php';
require_once 'PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php';
error_reporting(E_ALL ^ E_NOTICE);
ini_set('memory_limit', '-1');

$educational_degrees = array(1 => 'Бакалавър', 2 => 'Магистър', 3 => 'Докторант');

mb_internal_encoding('UTF-8');


if ($_POST) {

    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $family = trim($_POST['family']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $student_address = trim($_POST['student_address']);
    $lodging = $_POST['lodging'];

    $faculty_number = trim($_POST['faculty_number']);
    $educational_key = (int) $_POST['educational_degree'];
    $university = trim($_POST['university']);
    $university_address = trim($_POST['university_address']);

    $today = date("Y-m-d H:i:s");
    $entering_number = $_SESSION['entering_number'];
    $er = array();

 if (mb_strlen($name) < 2) {
        $er[name] = 'Полето е задължително';
    }
    elseif (!preg_match("/^([а-яА-Я '-]+)$/u", $name)) {
        $er[name] = 'Моля пишете на кирилица';
    }
    if (mb_strlen($surname) < 2) {
        $er[surname] = 'Полето е задължително';
    }
    elseif (!preg_match("/^([а-яА-Я '-]+)$/u", $surname)) {
        $er[surname] = 'Моля пишете на кирилица';
    }
    if (mb_strlen($family) < 2) {
        $er[family] = 'Полето е задължително';
    }
    elseif (!preg_match("/^([а-яА-Я '-]+)$/u", $family)) {
        $er[family] = 'Моля пишете на кирилица';
    }
    
    
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $er[email] = 'Вашият имейл е невалиден.';
    }
    
    if (mb_strlen($phone) < 2) {
        $er[phone] = 'Полето е задължително';
    }
    elseif (!preg_match("/^[0-9+\/-]+$/", $phone)) {

        $er[phone] = 'Некоректен телефонен номер';
    }

    if (mb_strlen($student_address) < 2) {
        $er[student_address] = 'Въведете адресната си регистрация';
    }
    
    elseif (!preg_match('/^([а-яА-Я0-9""№., -]+)$/u', $student_address)) {
        $er[student_address] = 'Моля пишете на кирилица';
    }
    
    if ($lodging < 1 || $lodging > 3) {
        $er[lodging] = '<br><p>Моля, изберете една от посочените опции относно настаняване</p><br>';
    }

    if (mb_strlen($faculty_number)<2){
        $er[faculty_number] = 'Полето е задължително';
    }
    elseif (!is_numeric($faculty_number)) {
        $er[faculty_number] = 'Факултетният номер трябва да съдържа само числа.';
    }

    if ($educational_key < 1 || $educational_key > 3) {
        $er[educational_key] = 'Изберете образователна квалификация';
    }

    if (mb_strlen($university) < 2) {
        $er[university] = 'Въведете името на учебното заведение';
    }
    elseif (!preg_match('/^([а-яА-Я ""-]+)$/u', $university)) {
        $er[university] = 'Моля пишете на кирилица';
    }

    if (mb_strlen($university_address) < 2) {
        $er[university_address] = '<p>Въведете адреса на учебното заведение</p>';
    }
    elseif (!preg_match('/^([а-яА-Я0-9""№., -]+)$/u', $university_address)) {
        $er[university_address] = 'Моля пишете на кирилица';
    }


    if (count($er) > 0) {
        
    } else {

        $conn = mysqli_connect('localhost', 'developer', 'developer', 'technical_university');

        if (!$conn) {
            echo 'Няма връзка с базата от данни!';
        }
        //else moje bi
        else {
            mysqli_set_charset($conn, 'utf8');

            $sql_take_info = "SELECT topic,scientific_trend,mentor,technical_means FROM `project_information` WHERE entering_number='$entering_number'";

            $result = mysqli_query($conn, $sql_take_info);
            echo $entering_number;

            if (mysqli_num_rows($result) > 2) {
                echo "В този отбор вече има максимален брой съавтори!";
            }
            if (mysqli_num_rows($result) == 0) {
                echo "Нещо не е наред!";
            }
            if (mysqli_num_rows($result) > 0 && mysqli_num_rows($result) < 3) {
                //mysqli_data_seek($result, 0);
                //mysqli_data_seek($result, 0);
                //$row1 = mysqli_fetch_assoc($result);

                $row1 = mysqli_fetch_assoc($result);
                //$row1 = $row[0];
                
                $topic = $row1["topic"];
                $scientific_trend = $row1["scientific_trend"];
                $mentor = $row1["mentor"];
                $technical_means = $row1["technical_means"];

                $sql_1 = 'INSERT INTO personal_information VALUES(NULL,
            "' . mysqli_real_escape_string($conn, $faculty_number) . '",
            "' . mysqli_real_escape_string($conn, $name) . '",
            "' . mysqli_real_escape_string($conn, $surname) . '",
            "' . mysqli_real_escape_string($conn, $family) . '",
            "' . $educational_degrees[$educational_key] . '",
            "' . mysqli_real_escape_string($conn, $university) . '",
            "' . mysqli_real_escape_string($conn, $university_address) . '",
            "' . mysqli_real_escape_string($conn, $phone) . '",
            "' . mysqli_real_escape_string($conn, $email) . '",
            "' . mysqli_real_escape_string($conn, $student_address) . '",
            "' . mysqli_real_escape_string($conn, $lodging-1) . '",
                "'.$entering_number.'")';

//                $sql_2 = 'INSERT INTO project_information VALUES(NULL,
//            "' . mysqli_real_escape_string($conn, $faculty_number) . '",
//            "' . mysqli_real_escape_string($conn, $topic) . '",
//            "' . $scientific_trend. '",
//            "' . mysqli_real_escape_string($conn, $mentor) . '",
//            "' . mysqli_real_escape_string($conn, $technical_means) . '",
//            "' . mysqli_real_escape_string($conn, $today) . '",
//                "'.$entering_number.'")';


                $q1 = mysqli_query($conn, $sql_1);
                //$q2 = mysqli_query($conn, $sql_2);

//                if (!$q2) {
//                    echo mysqli_error($conn);
//                }

                if ($q1) {
                    //include 'excel_data.php';
                    $_SESSION['project'] = $project;
                    $_SESSION['entering_number'] = $entering_number;
                    $_SESSION['email'] = $email;
                    $_SESSION['name'] = $name;
                    header('Location:success_reg.php');
                    exit();
                    
                }
                

                //printf ($row1["topic"], $row1["scientific_trend"],$row1["mentor"],$row1["technical_means"]);
            }
//        if (mysqli_num_rows($q_take_info)>2){
//            $er[team_limit]= 'В този отбор вече има максимален брой съавтори!';
//        }
//        $arr=array();
//        $rows = mysql_fetch_array($query_take_info); 
//        foreach ($rows as $row){
//            array_push($arr, $row['keyword']);
//        }
//        print_r($arr);
        }
    }
}
?>
<link rel="stylesheet" type="text/css" href="style/style.css">
<form id="msform" method="POST" enctype="multipart/form-data">

    <div id="form_header">
        <img src="style/images/logo.png"/>
        <h2 class="fs-title">Технически университет Варна</h2>
        <h2 class="fs-title">Регистрационна карта</h2>
    </div>

    <!-- progressbar -->
    <div id="progressbar">
        <ul>
            <li class="active">Лични данни</li>
            <li>Образование</li>
        </ul>
    </div>
    <!-- fieldsets -->
    <fieldset>
        <h2 class="fs-title">Лични данни</h2>
        <h3 class="fs-subtitle">Стъпка 1</h3>

        <input type='text' name='name' placeholder="Име" value="<?php
        if (isset($name)) {
            echo $name;
        }
        ?>"/>
        <small class="errorText"><?php echo $er[name]; ?></small>
        <input type='text' name='surname' placeholder="Презиме"  value="<?php
        if (isset($surname)) {
            echo $surname;
        }
        ?>"/>
        <small class="errorText"><?php echo $er[surname]; ?></small>
        <input type = 'text' name='family' placeholder="Фамилия"  value="<?php
        if (isset($family)) {
            echo $family;
        }
        ?>"/>
        <small class="errorText"><?php echo $er[family]; ?></small>
        <input type='text' name='email' placeholder="Електронна поща"  value="<?php
        if (isset($email)) {
            echo $email;
        }
        ?>"/>
        <small class="errorText"><?php echo $er[email]; ?></small>
        <input type='text' name='phone' placeholder="Телефон за връзка"  value="<?php
        if (isset($phone)) {
            echo $phone;
        }
        ?>"/>
        <small class="errorText"><?php echo $er[phone]; ?></small>
        <input type='text' name='student_address' placeholder="Адрес на участника"  value="<?php
        if (isset($student_address)) {
            echo $student_address;
        }
        ?>"/>
        <small class="errorText"><?php echo $er[student_address]; ?></small>
        </br>
        <label>Настаняване</label></br>
        <input type="radio" name="lodging" value="1" id="radio_1">
        <label for="radio_1">Не</label>
        <input type="radio" name="lodging" value="2" id="radio_2">
        <label for="radio_2">Една нощувка</label>
        <input type="radio" name="lodging" value="3" id="radio_3">
        <label for="radio_3">Две нощувки</label>
        <small class="errorText"><?php echo $er[lodging]; ?></small>
        </br>

        <input type="button" name="next" class="next action-button" value="Next" />

    </fieldset>
    <fieldset>
        <h2 class="fs-title">Образование</h2>
        <h3 class="fs-subtitle">Стъпка 2</h3>

        <input type='text' name='faculty_number' placeholder="Факултетен номер"  value="<?php
               if (isset($faculty_number)) {
                   echo $faculty_number;
               }
        ?>"/>
        <small class="errorText"><?php echo $er[faculty_number]; ?></small>
        <select name="educational_degree">
            <option selected="selected" class="select_placeholder">Образователна степен</option>
<?php
foreach ($educational_degrees as $key => $educational_degree) {
    echo '<option value="' . $key . '">' . $educational_degree . '</option>';
}
?>
        </select>
        <small class="errorText"><?php echo $er[educational_degree]; ?></small>
        <input type='text' name='university' placeholder="Университет"  value="<?php
if (isset($university)) {
    echo $university;
}
?>"/>
        <small class="errorText"><?php echo $er[university]; ?></small>
        <input type='text' name='university_address' placeholder="Адрес на университета"  value="<?php
if (isset($university_address)) {
    echo $university_address;
}
?>"/>
        <small class="errorText"><?php echo $er[university_address]; ?></small>
        <br/>
        <input type="button" name="previous" class="previous action-button" value="Previous" />
        <input type="submit" name="submit" class="submit action-button" value="Регистрирай се" />
    </fieldset>

</form>

<!-- jQuery -->
<script src="js/jquery-2.1.1.js" type="text/javascript"></script>
<!-- jQuery easing plugin -->
<script src="js/jquery.easing-1.3.min.js" type="text/javascript"></script>

<script src="js/style_javascript.js"></script>

<?php
include 'includes/footer.php';
?>
    
