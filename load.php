<?php

include "pprint_r.php";
include "load_functions.php";
// Load Google Forms Spreadsheet info
$GS_KEY = $_GET['KEY'];

$Data = getSpreadSheetasArray($GS_KEY);
//preprint_r($Header);
$HeaderList = GetFieldInfo($Header);
//preprint_r($HeaderList );
pprint_r(getMultiSelectTotals($Data, $HeaderList ));
//preprint_r($Data);