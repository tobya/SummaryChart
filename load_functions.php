<?php


function getSpreadSheetasArray($KEY){

  if (file_exists($KEY . '.txt')){
    $CSVSpreadsheet = file_get_contents($KEY . '.txt');
  } else {
    $CSVSpreadsheet = file_get_contents("https://docs.google.com/spreadsheets/d/$KEY/export?format=csv");
    //file_put_contents($KEY . '.txt', $CSVSpreadsheet);
  }

  $CSVSpreadsheetLines = explode("\n", $CSVSpreadsheet);

  $IsHeader = true;
      $i = 0;
  foreach ($CSVSpreadsheetLines as $key => $Line) {

    $CSVFields = str_getcsv($Line);

    if ($IsHeader){
      foreach ($CSVFields as $key => $value) {
        $Header[($value)] = array('fieldname' =>  ($value));
        $HeaderList[] = ($value);
      }
    } else {
      foreach ($CSVFields as $key => $value) {

        $Data[$i][$HeaderList[$key]] = ($value);
        $Values[$HeaderList[$key]][$value] = $value;
      }
    }

    $i++;
    $IsHeader = false;
  }
  return ['Fields' => $Data, 'Header' => $Header , 'Values' => $Values];
}



function getMultiSelectTotals($Rows, $AllFieldInfo){
  $FieldInfo = $AllFieldInfo['allfields'];
  foreach ($Rows as $key => $Row) {

    foreach ($Row as $ColName => $ColValue) {

      // Check Data, or continue.
      if ($ColValue == '') {continue;}
      if ($FieldInfo[$ColName]['MultiSelect'] == ''){continue;}
   
      if (isset($SelectTotals[$FieldInfo[$ColName]['MultiSelect']][$FieldInfo[$ColName]['MultiSelectOption']][$ColValue])) {
          $SelectTotals[$FieldInfo[$ColName]['MultiSelect']][$FieldInfo[$ColName]['MultiSelectOption']][$ColValue]++;
      } else {  // First addition.
          $SelectTotals[$FieldInfo[$ColName]['MultiSelect']][$FieldInfo[$ColName]['MultiSelectOption']][$ColValue] = 1;
      }
    }
  }
  return $SelectTotals;
}

function GetFieldInfo($HeaderFields){
  foreach ($HeaderFields as $key => $Field) {
    
    // # (.*?) \[(.*?)\]
    if (preg_match('/(.*?) \[(.*?)\]/', $Field['fieldname'], $regs)) {
      $MultiSelectField = $regs[1];
      $MultiSelectOption = $regs[2];
    } else {
      $FieldName = $Field['fieldname'];
      $MultiSelectField = '';
      $MultiSelectOption = '';      
    }

    $HeaderFields[$key]['MultiSelect'] = $MultiSelectField;
    $HeaderFields[$key]['MultiSelectOption'] = $MultiSelectOption;

    $Options[$MultiSelectField][] = $MultiSelectOption;

  }

  return ['allfields' => $HeaderFields, 'options' => $Options];
}
