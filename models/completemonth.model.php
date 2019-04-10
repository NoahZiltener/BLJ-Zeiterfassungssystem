<?php
$user = 'root';
$pass = '';
$dbh = new PDO('mysql:host=localhost;dbname=timecounterdb', $user, $pass);

$stmt = $dbh->prepare('SELECT * FROM days');
$stmt->execute();
$days = $stmt->fetchAll();

foreach ($days as $day) {
 $parts  = explode("-", $day['DayDate']);
 $MonthDate = $parts[1] . "-" . $parts[0];

 $stmt = $dbh->prepare("INSERT INTO `months` (MonthDate, MonthCompleted) SELECT :MonthDate, :MonthCompletd WHERE NOT EXISTS (SELECT * FROM months WHERE MonthDate = :MonthDate2)");
 $stmt->execute([':MonthDate' => $MonthDate, ':MonthCompletd' => false, ':MonthDate2' => $MonthDate]);

}

$stmt = $dbh->prepare('SELECT * FROM months');
$stmt->execute();
$months = $stmt->fetchAll();

if(isset($_POST['completemonth_submit_button']) == true){

  $MonthID = $_POST['MonthID']  ??'';

  $stmt = $dbh->prepare("UPDATE `months` SET MonthCompleted  = :MonthCompleted WHERE MonthID = :MonthID");
  $stmt->execute([':MonthCompleted' => true, ':MonthID' => $MonthID]);

  $stmt = $dbh->prepare('SELECT * FROM months');
  $stmt->execute();
  $months = $stmt->fetchAll();
}
?>
