<?php
require 'db_config.php';
$name = mysqli_real_escape_string($con, $_REQUEST['name']);
$type = mysqli_real_escape_string($con, $_REQUEST['answer']);

echo $name;

$sql = "SELECT name FROM empstat WHERE name='$name'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
    if ($type == "correct") {
       mysqli_query($con,"UPDATE empstat SET correct=correct+1 WHERE name='$name'");
    } else {
      mysqli_query($con,"UPDATE empstat SET wrong=wrong+1 WHERE name='$name'");
    }
    }
} else {
  if ($type == "correct") {
    mysqli_query($con,"INSERT INTO empstat (name, correct, wrong) VALUES ('$name',1,0)");
  } else {
      mysqli_query($con,"INSERT INTO empstat (name, correct, wrong) VALUES ('$name',0,1)");
  }
}

mysqli_close($con);
?>
