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
  $csvlink = "https://docs.google.com/spreadsheets/d/$GS_KEY/export?format=csv";
  echo "Unable to download Results in Spreadsheet. Spreadsheet key may be incorrect.

  <P> <h2> Things to Check </h2>
  <ul>
  <li> Alternatively, you may need to correctly set Sharing options on Sheet.
  <li> Check Here <a href='$KEY'>$KEY</a>
  <li> In addition ensure that the spreadsheet does not have multiple pages.  The first tab is what will be returned by the <a href='$csvlink'> csv link (click to check)</a>
  </ul>
  ";
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


