<?php
include "pprint_r.php";
include "load_functions.php";
// Load Google Forms Spreadsheet info
$GS_KEY = $_GET['KEY'];

$Data = getSpreadSheetasArray($GS_KEY);
//preprint_r($Header);
$HeaderList = GetFieldInfo($Data['Header']);
//preprint_r($HeaderList );
$FeedBackTotals = getMultiSelectTotals($Data['Fields'], $HeaderList );
//preprint_r($FeedBackTotals);
?>

 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

      

      <script type="text/javascript">
        

google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawAxisTickColors);

function drawAxisTickColors() {


var data = [] ;


      <?php 
      $Keys = [
        'Poor' => 1,
        'Fair' => 2,
        'Average' => 3,
        'Good' => 4,
        'Excellent' => 5
    ];
      foreach ($FeedBackTotals['Teacher Feedback '] as $Person => $Details) {
        # code...
        foreach ($Details as $key => $value) {
          # code...
          $Scores[$Keys[$key]] = $value;
        }
        $DataRows[$Person]['DataRow'] = "['',$Scores[1],$Scores[2],$Scores[3],$Scores[4],$Scores[5]],";
      }
      $i = 0;
      foreach ($DataRows as $key => $value) {
        # code...
        
        echo "       data[$i] = new google.visualization.DataTable();
      data[$i].addColumn('string', 'SomeDay');
      data[$i].addColumn('number', 'Poor');
      data[$i].addColumn('number', 'Fair');
      data[$i].addColumn('number', 'Average');
      data[$i].addColumn('number', 'Good');
      data[$i].addColumn('number', 'Excellent');
      data[$i].addRows([
        $value[DataRow]


      ]);
      ";
      $i++;
      }
      ?>



      var options = {
        title: 'Teacher Feedback',
        focusTarget: 'category',
        chartArea: {width: '30%'},
        
        hAxis: {
          title: 'Feedback Selection',
          
          viewWindow: {
            min: [7, 30, 0],
            max: [17, 30, 0]
          },
          textStyle: {
            fontSize: 14,
            color: '#053061',
            bold: true,
            italic: false
          },
          titleTextStyle: {
            fontSize: 18,
            color: '#053061',
            bold: true,
            italic: false
          }
        },
        vAxis: {
          title: 'Number of Responses',
          textStyle: {
            fontSize: 18,
            color: '#67001f',
            bold: false,
            italic: false
          },
          titleTextStyle: {
            fontSize: 18,
            color: '#67001f',
            bold: true,
            italic: false
          }
        }
      };
      <?php
      $j = 0;
      foreach ($DataRows as $key => $value) {
        echo "      
        options['title'] = 'Teacher Feedback - $key';
        var chart$j = new google.visualization.ColumnChart(document.getElementById('chart_div$j'));
      chart$j.draw(data[$j], options);";
      $j++;
      }
      ?>

    


    }

      </script>

      <?php
      $k = 0;
      foreach ($DataRows as $key => $value) {
        echo "       <div id='chart_div$k'></div>\n<BR>";
      $k++;
      }
      ?>
       
        