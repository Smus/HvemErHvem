<!doctype html>
<html lang="da-dk">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title>Quiz</title>
  <link rel="stylesheet" href="css/master.css" media="screen" title="no title" charset="utf-8">
  <link href="http://hjaltelinstahl.com/templates/lauritzz/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
</head>
<body>
<?php
require 'db/db_config.php';
$queryC = "SELECT * FROM empstat ORDER BY correct DESC LIMIT 1";
$queryW = "SELECT * FROM empstat ORDER BY wrong DESC LIMIT 1";
$numbC = "SELECT SUM(correct) as cValue_sum FROM empstat";
$numbW = "SELECT SUM(wrong) as wValue_sum FROM empstat";
$getall = "SELECT * FROM empstat ORDER BY correct DESC";

$rowc = mysqli_fetch_assoc(mysqli_query($con, $numbC));
$roww = mysqli_fetch_assoc(mysqli_query($con, $numbW));
$all = mysqli_query($con, $getall);
$sumC = $rowc['cValue_sum'];
$sumW = $roww['wValue_sum'];

$name_1;
$name_2;
$numbOfAnswers = $sumC + $sumW;




if ($result = mysqli_query($con, $queryC)) {
    /* fetch associative array */
    while ($row = mysqli_fetch_assoc($result)) {
      $name_1 = $row["name"];
    }
}
if ($result2 = mysqli_query($con, $queryW)) {
    /* fetch associative array */
    while ($row2 = mysqli_fetch_assoc($result2)) {
      $name_2 = $row2["name"];
    }
}

$arr = file_get_contents('json/employees.json');
$json =  json_decode($arr,true);

for ($i=0; $i < count($json); $i++) {
  if ($json[$i][Name] == $name_1) {
    $img1 = $json[$i][Image];
  }
}
for ($i=0; $i < count($json); $i++) {
  if ($json[$i][Name] == $name_2) {
    $img2 = $json[$i][Image];
  }
}

?>
<div class="dashboard boxer">
<div class="dash_right">
  <img src='crawl/<?php echo $img1 ?>' alt="" width="200" height="200" />
  <p>Mest kendte ansat:<br><span><?php echo $name_1; ?></span></p>
</div>
<div class="dash_wrong">
  <img src='crawl/<?php echo $img2 ?>' alt="" width="200" height="200" />
  <p>Mest ukendte ansat:<br><span><?php echo $name_2; ?></span></p>
</div>
<div>
  <p>Totale antal svar: <?php echo $numbOfAnswers; ?> </p>
</div>
  <div class="buttons tilbagetilquiz">Prøv igen</div>
</div>

<div class="dashboard boxer">
  <?php
  //find all names
  echo "<table id='scores'>";
  echo "<tr><td align='left'>Navn</td><td align='left'>Rigtige</td><td align='left'>Forkert</td></tr>";
  foreach($all as $row) {
      echo "<tr><td align='left'>" . $row['name'] . "</td><td>" .  $row['correct'] . "</td><td>" .  $row['wrong'] . "</td></tr>";
  }
    echo "</table>";
   ?>
</div>

<script src="lib/jquery-2.1.4.min.js" type="text/javascript"></script>
<script src="lib/jquery.transit.min.js" type="text/javascript"></script>
<script src="js/main.js" type="text/javascript"></script>
</body>
</html>
