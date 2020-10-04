<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Calculations</title>
    <link href="PrintStyle2.css" rel="stylesheet" media="print">
    <link href="printStyle.css" rel="stylesheet">
</head>
<body>
    <div id="container">
<table id="tablePrint" class="content-table">
  <thead>
    <tr>
      <th>Value</th>
      <th>Result</th>
      <th>Operator</th>
    </tr>
  </thead>
  <tbody>
  <?php
    session_start();
    include_once "oracle.php";        
   /* $DeciInput = "SELECT * FROM calculations WHERE id = 5";
    $queryDeci = mysqli_query($conn, $DeciInput);
    $FetchDecimal = mysqli_fetch_assoc($queryDeci);
    $Decimal = $FetchDecimal['results'];*/
    $sessionId = $_SESSION['sessionId'];
    $SelectHistory = "SELECT * FROM calculations WHERE  SESSION_ID = '$sessionId' AND OPERATOR <> '0' ORDER BY ID ASC";
    $parseSelect = oci_parse($orConn, $SelectHistory);
    oci_execute($parseSelect);
    while($rows = oci_fetch_assoc($parseSelect)){
        if($rows['OPERATOR'] == "+"){
        echo "<tr style='color:black;'>";
        echo "<td>".$rows['VALUE']."</td>";
        echo "<td>".$rows['RESULT']."</td>";
       // echo "<td>".number_format($rows['RESULT'], $Decimal)."</td>";
        echo "<td>".$rows['OPERATOR']."</td>";
        echo "</tr>";
    } else{
        echo "<tr style='color:red;'>";
        echo "<td>".$rows['VALUE']."</td>";
        echo "<td>".$rows['RESULT']."</td>";
       // echo "<td>".number_format($rows['RESULT'], $Decimal)."</td>";
        echo "<td>".$rows['OPERATOR']."</td>";
        echo "</tr>";
    }
    }
    ?>

    
  </tbody>
</table>
<button onclick="window.print();" id="print">Print</button>
</div>
</body>
</html>