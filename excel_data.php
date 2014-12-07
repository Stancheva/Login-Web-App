<?php

/** Include PHPExcel */
require_once 'PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php';

mb_internal_encoding('UTF-8');

$conn = mysqli_connect('localhost', 'developer', 'developer', 'technical_university');
if (!$conn) {
    echo 'Няма връзка с базата от данни!';
}

mysqli_set_charset($conn, 'utf8');


$sql_excel1 = "SELECT DISTINCT per.faculty_number,per.name,per.surname,per.family,per.educational_degree,per.university,per.university_address, per.phone_number,per.email,per.student_address, per.lodging_days,per.entering_number,proj.topic,proj.scientific_trend,proj.mentor, proj.technical_means,proj.date_registered from personal_information per INNER JOIN project_information proj ON per.entering_number=proj.entering_number order by per.entering_number";

$result1 = mysqli_query($conn, $sql_excel1);

$objPHPExcel = new PHPExcel();
$F = $objPHPExcel->getActiveSheet();

$F->setCellValue('A' . 1, 'Входящ номер');
$F->setCellValue('B' . 1, 'Име');
$F->setCellValue('C' . 1, 'Презиме');
$F->setCellValue('D' . 1, 'Фамилия');
$F->setCellValue('E' . 1, 'Имейл');
$F->setCellValue('F' . 1, 'Телефонен номер');
$F->setCellValue('G' . 1, 'Адрес на студента');
$F->setCellValue('H' . 1, 'Настаняване(бр.дни)');
$F->setCellValue('I' . 1, 'Факултетен номер');
$F->setCellValue('J' . 1, 'Образователна степен');
$F->setCellValue('K' . 1, 'Университет');
$F->setCellValue('L' . 1, 'Адрес на университета');
$F->setCellValue('M' . 1, 'Тема на проекта');
$F->setCellValue('N' . 1, 'Научно направление');
$F->setCellValue('O' . 1, 'Ментор');
$F->setCellValue('P' . 1, 'Технически средства');
$F->setCellValue('Q' . 1, 'Дата на регистриране');

$Line = 2;
if (!$result1) {
    echo "Error with MySQL Query: " . mysqli_error();
}
while ($Trs = mysqli_fetch_assoc($result1)) {//extract each record
    $F->setCellValue('A' . $Line, $Trs['entering_number'])
            ->setCellValue('B' . $Line, $Trs['name'])
            ->setCellValue('C' . $Line, $Trs['surname'])
            ->setCellValue('D' . $Line, $Trs['family'])
            ->setCellValue('E' . $Line, $Trs['email'])
            ->setCellValue('F' . $Line, $Trs['phone_number'])
            ->setCellValue('G' . $Line, $Trs['student_address'])
            ->setCellValue('H' . $Line, $Trs['lodging_days'])
            ->setCellValue('I' . $Line, $Trs['faculty_number'])
            ->setCellValue('J' . $Line, $Trs['educational_degree'])
            ->setCellValue('K' . $Line, $Trs['university'])
            ->setCellValue('L' . $Line, $Trs['university_address'])
            ->setCellValue('M' . $Line, $Trs['topic'])
            ->setCellValue('N' . $Line, $Trs['scientific_trend'])
            ->setCellValue('O' . $Line, $Trs['mentor'])
            ->setCellValue('P' . $Line, $Trs['technical_means'])
            ->setCellValue('Q' . $Line, $Trs['date_registered']); //write in the sheet
    ++$Line;
}
// Redirect output to a client’s web browser (Excel5)

PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);

foreach (range('A', 'Q') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
            ->setAutoSize(true);
}
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

$objWriter->save('students.xls');
?>

