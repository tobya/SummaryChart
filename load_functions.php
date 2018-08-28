<?php


function getSpreadSheetasArray($KEY){


if (file_exists($KEY . '.txt')){
$CSVSpreadsheet = file_get_contents($KEY . '.txt');
} else {

$CSVSpreadsheet = file_get_contents("https://docs.google.com/spreadsheets/d/$KEY/export?format=csv");
file_put_contents($KEY . '.txt', $CSVSpreadsheet);
}

$CSVSpreadsheetLines = explode("\n", $CSVSpreadsheet);

$IsHeader = true;
    $i = 0;
foreach ($CSVSpreadsheetLines as $key => $Line) {
  # code...

  $CSVFields = str_getcsv($Line);

  if ($IsHeader){
    foreach ($CSVFields as $key => $value) {
      # code...
    $Header[trim($value)] = array('fieldname' =>  trim($value));
    $HeaderList[] = trim($value);
    }
  } else {
    foreach ($CSVFields as $key => $value) {
      # code...
      $Data[$i][$HeaderList[$key]] = trim($value);
    }
  }

  $i++;
  $IsHeader = false;
}
return ['Fields' => $Data, 'Header' => $Header];
}



function getMultiSelectTotals($Rows, $FieldInfo){
  foreach ($Rows as $key => $Row) {
    # code...
    foreach ($Row as $ColName => $ColValue) {
      # code...
   // echo $ColName;
   // echo "<BR>";
   // echo $ColValue;
    if ($ColValue == '') {continue;}
   // print_r($FieldInfo[$ColName]);
   // exit;
     // echo '$FieldInfo[$ColName][\'MultiSelectOption\']' . " " . $FieldInfo[$ColName]['MultiSelectOption'] . "<BR>";
    //  echo '$SelectTotals[$FieldInfo[$ColName][\'MultiSelect\']][$FieldInfo[$ColName][\'MultiSelectOption\']]' . " " . $SelectTotals[$FieldInfo[$ColName]['MultiSelect']][$FieldInfo[$ColName]['MultiSelectOption']] . "<BR>";
   
    if (isset($SelectTotals[$FieldInfo[$ColName]['MultiSelect']][$FieldInfo[$ColName]['MultiSelectOption']][$ColValue])) {
        $SelectTotals[$FieldInfo[$ColName]['MultiSelect']][$FieldInfo[$ColName]['MultiSelectOption']][$ColValue]++;// = $SelectTotals[$FieldInfo[$ColName]['MultiSelect']][$FieldInfo[$ColName]['MultiSelectOption']] +1;
    } else {
        $SelectTotals[$FieldInfo[$ColName]['MultiSelect']][$FieldInfo[$ColName]['MultiSelectOption']][$ColValue] = 1;
    }
  }
  }
  return $SelectTotals;
}

function GetFieldInfo($HeaderFields){
  foreach ($HeaderFields as $key => $Field) {
    # code...
    // # (.*?)\[(.*?)\]
    if (preg_match('/(.*?)\[(.*?)\]/', $Field['fieldname'], $regs)) {
      $MultiSelectField = $regs[1];
      $MultiSelectOption = $regs[2];
    } else {
      $FieldName = $Field['fieldname'];
      $MultiSelectField = '';
      $MultiSelectOption = '';      
    }

    $HeaderFields[$key]['MultiSelect'] = $MultiSelectField;
    $HeaderFields[$key]['MultiSelectOption'] = $MultiSelectOption;

  }

  return $HeaderFields;
}
