<?php

include "pprint_r.php";
include "load_functions.php";
// Load Google Forms Spreadsheet info
$GS_KEY = $_GET['KEY'];
$Title = $_GET['Title'];

$Data = getSpreadSheetasArray($GS_KEY);
//preprint_r($Header);
$HeaderList = GetFieldInfo($Data['Header']);
//preprint_r($HeaderList );
$FeedbackScores = getMultiSelectTotals($Data['Fields'], $HeaderList );
//preprint_r($Data);

foreach ($FeedbackScores as $MultiSelect => $value) {
  # code...
  $MultiSelect = urlencode($MultiSelect);
 echo "<a href='charts.php?KEY=$GS_KEY&feedbackfield=$MultiSelect&Title=$Title'>$MultiSelect</a><br>";



}
