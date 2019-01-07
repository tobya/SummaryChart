<?php

#include "pprint_r.php";
include "load_functions.php";
// Load Google Forms Spreadsheet info
$KEY = $_GET['KEY'];
$Title = $_GET['Title'];
$GS_KEY = extractKey($KEY);

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

function ExtractKey($KEY){
  //Check if url sharing url
  //https://docs.google.com/spreadsheets/d/1yk-nGxD5kUeA_3vNCBJlX0yeEl7_edSABX-kEMyC3SA/edit?usp=sharing

  if (stripos($KEY,'https') !== false){
    $GS_KEY = str_replace('https://docs.google.com/spreadsheets/d/', '', $KEY);
    $index = strpos($GS_KEY,'/' );
    $GS_KEY = substr($GS_KEY, 0,$index);
  }
  else {
    $GS_KEY = $KEY;
  }
  return $GS_KEY;
}
