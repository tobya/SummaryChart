<?php

#include "pprint_r.php";
include "load_functions.php";
// Load Google Forms Spreadsheet info
$KEY = $_GET['KEY'];

$GS_KEY = urltokey($KEY);

// sanitise title so no script.
$Title = htmlspecialchars( $_GET['Title']);

$Data = getSpreadSheetasArray($GS_KEY);
//preprint_r($Header);
$HeaderList = GetFieldInfo($Data['Header']);
//preprint_r($HeaderList );
$FeedbackScores = getMultiSelectTotals($Data['Fields'], $HeaderList );
//preprint_r($Data);

// If not Grids found
if ($FeedbackScores == []){
  echo "Unable to  find any MultiSelect Results in Spreadsheet.  Try another spreadsheet.";
  die();
}

echo "
<h2>$Title</h2>
<ul>";
foreach ($FeedbackScores as $MultiSelect => $value) {
  # code...
  $MultiSelectURL = urlencode($MultiSelect);

 echo "<li><a href='charts.php?KEY=$GS_KEY&feedbackfield=$MultiSelectURL&Title=$Title'>$MultiSelect</a><br>";



}


