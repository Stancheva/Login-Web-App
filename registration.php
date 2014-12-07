<?php
$PageTitle = 'Registration';
include 'includes/header.php';
require_once 'PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php';
error_reporting(E_ALL ^ E_NOTICE);
ini_set('memory_limit', '-1');

$educational_degrees = array(1 => 'Бакалавър', 2 => 'Магистър', 3 => 'Докторант');
$scientific_trends = array(1 => 'Автоматика', 2 => 'Агрономство', 3 => 'Електроника', 4 => 'Екология', 5 => 'Електроснабдяване и електрообзавеждане',
    6 => 'Електроенергетика', 7 => 'Електротехника и електротехнологии', 8 => 'Възобновяеми енергийни източници', 9 => 'Земеделска техника и технологии',
    10 => 'Икономика и мениджмънт', 11 => 'Инженерен дизайн', 12 => 'Компютърни системи и технологии', 13 => 'Комуникации',
    14 => 'Корабни машини и механизми', 15 => 'Корабостроене', 16 => 'Математика', 17 => 'Машиностроене', 18 => 'Механика', 19 => 'Морски науки',
    20 => 'Проблеми на висшето образование', 21 => 'Социални и правни науки', 22 => 'Технологии', 23 => 'Топлотехника', 24 => 'Транспорт',
    25 => 'Физика', 26 => 'Физическо възпитание и спорт', 27 => 'Химия', 28 => 'Проблеми на чуждоезиковото обучение');

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

    $topic = trim($_POST['topic']);
    $scientific_trend_key = (int) $_POST['scientific_trend'];
    $mentor = trim($_POST['mentor']);
    $technical_means = trim($_POST['technical_means']);

    $today = date("Y-m-d H:i:s");
    $random_number = mt_rand();
    //echo $random_number.'<br>';
    $entering_number = $faculty_number + $random_number;
    //echo $entering_number;
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


    if (mb_strlen($topic) < 2) {
        $er[topic] = 'Полето е задължително';
    }
    elseif (!preg_match('/^([а-яА-Яa-zA-Z ""-#]+)$/u', $topic)) {
        $er[topic] = 'Моля пишете на кирилица';
    }

    if ($scientific_trend_key < 1 || $scientific_trend_key > 28) {
        $er[scientific_trend_key] = 'Моля, посочете направление';
    }
    
    if(mb_strlen($mentor)>1){
        if (!preg_match("/^([а-яА-Я '-,]+)$/u", $mentor)) {
            $er[mentor] = 'Моля пишете на кирилица';
        }
    }
    
    if(mb_strlen($technical_means)>1){
        if (!preg_match("/^([а-яА-Я '-,]+)$/u", $technical_means)) {
            $er[technical_means] = 'Моля пишете на кирилица';
        }
    }

    if (!file_exists($_FILES['upload']['tmp_name'][0]) || !is_uploaded_file($_FILES['upload']['tmp_name'][0])) {
        $er[file] = '<p>Моля прикачете поне един файл.</p>';
    }


    if (count($er) > 0) {
        
    } else {


        for ($i = 0; $i < count($_FILES['upload']['name']); $i++) {
            //Get the temp file path
            $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
            //$file_name = "$entering_number#" . $_FILES['upload_file']['name'][$i];
            //Make sure we have a filepath
            if ($tmpFilePath != "") {
                //Setup our new file path
                $newFilePath = "files" . DIRECTORY_SEPARATOR . "$entering_number#" . $_FILES['upload']['name'][$i];

                //Upload the file into the temp dir
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {

                    //Handle other code here
                }
            }
        }
        $conn = mysqli_connect('localhost', 'developer', 'developer', 'technical_university');

        if (!$conn) {
            echo 'Няма връзка с базата от данни!';
        }

        mysqli_set_charset($conn, 'utf8');

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

        $sql_2 = 'INSERT INTO project_information VALUES(NULL,
            "' . mysqli_real_escape_string($conn, $topic) . '",
            "' . $scientific_trends[$scientific_trend_key] . '",
            "' . mysqli_real_escape_string($conn, $mentor) . '",
            "' . mysqli_real_escape_string($conn, $technical_means) . '",
            "' . mysqli_real_escape_string($conn, $today) . '",
                "' . $entering_number . '")';


        $q1 = mysqli_query($conn, $sql_1);
        $q2 = mysqli_query($conn, $sql_2);

        if (!$q2) {
            echo mysqli_error($conn);
        }

        if ($q1 && $q2) {
            //include 'excel_data.php';
            $_SESSION['project'] = $project;
            $_SESSION['entering_number'] = $entering_number;
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $name;
            header('Location:success_reg.php');
            exit();
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
            <li>Данни за проекта</li>
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
        <select name="educational_degree" >
            <option selected="selected" class="select_placeholder">Образователна степен</option>
            <?php
            foreach ($educational_degrees as $key => $educational_degree) {
                echo '<option value="' . $key . '">' . $educational_degree . '</option>';
            }
            ?>
        </select>
        <small class="errorText"><?php echo $er[educational_key]; ?></small>
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
        <input type="button" name="next" class="next action-button" value="Next" />
    </fieldset>
    <fieldset>
        <h2 class="fs-title">Данни за проекта</h2>
        <h3 class="fs-subtitle">Стъпка 3</h3>

        <input type='text' name='topic' placeholder="Тема на доклада" value="<?php
        if (isset($topic)) {
            echo $topic;
        }
        ?>"/>
        <small class="errorText"><?php echo $er[topic]; ?></small>
        <select name="scientific_trend">
            <option selected="selected" class="select_placeholder">Научно направление</option>
            <?php
            foreach ($scientific_trends as $key => $scientific_trend) {
                echo '<option value="' . $key . '">' . $scientific_trend . '</option>';
            }
            ?>
        </select>
        <small class="errorText"><?php echo $er[scientific_trend_key]; ?></small>
        <input type='text' name='mentor' placeholder="Научен ръководител"  value="<?php
        if (isset($mentor)) {
            echo $mentor;
        }
        ?>"/>
        <small class="errorText"><?php echo $er[mentor]; ?></small>
        <input type='text' name='technical_means' placeholder="Необходими технически средства" value="<?php
        if (isset($technical_means)) {
            echo $technical_means;
        }
        ?>"/>
        <small class="errorText"><?php echo $er[technical_means]; ?></small>
        
        <input type='file' name="upload[]" multiple="multiple"/><br/>
        <input type='file' name="upload[]" multiple="multiple"/><br/>
        <input type='file' name="upload[]" multiple="multiple"/>

        <small class="errorText"><?php echo $er[file]; ?></small>

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
    
