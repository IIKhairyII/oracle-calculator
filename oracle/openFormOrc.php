<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose file</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="printStyle.css">
    <style>
        .openBtn{
            border: none;
            height: 4vh;
            width: 10vh;
            font-family: 'Lato', sans-serif;
            font-size: 1.75vh;
            background-color: #f3f3f3;
            border: 0.1vh solid;
        }
        .openBtn:hover{
      cursor: pointer;
      background-color: #158467;
      color: white;
      transition: 0.3s all ease-in-out;
  }
    </style>
</head>
<body><table class="content-table" id="filesTable">
  <thead>
    <tr>
      <th>File Name</th>
      <th colspan="1"></th>
    </tr>
  </thead>
  <tbody>
      <?php 
      session_start(); //you may need it
      include_once "oracle.php";
      $selectFiles = "SELECT * FROM FILENAMES";
      $parseFiles = oci_parse($orConn, $selectFiles);
      oci_execute($parseFiles);
      while($fetchData = oci_fetch_assoc($parseFiles)){
      ?>
    <tr>
      <td style="font-size: 2.25vh;"><?php echo $fetchData['TITLE'];?></td>
      <td><?php echo"<button name ='button' type= 'button' onclick='getVal(this)' value=".$fetchData['TITLE']." class ='openBtn'>Open</button>";?></td>
    </tr>
      <?php } ?>
  </tbody>
</table>
<p id="hi"></p>
<!--<button onclick="getVal()">Test</button>-->
 <!--<script src="ajax.js"></script>-->
 <script src="save.js"></script>
</body>
</html>