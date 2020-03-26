<!doctype html>

<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>NOAA Datasets</title>
    <meta name="description" content="Descriptions of NOAA datasets">
    <meta name="keywords" content="NOAA, oceanography, environment, temperature">
    <meta name="author" content="Roan Lill-Bovill">

<style><?php include 'css/styles.css';?></style>
</head>

<?php

$data_json = file_get_contents("data.json");
$data = json_decode($data_json);

?>

<body>
<img class='icon' src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/79/NOAA_logo.svg/1200px-NOAA_logo.svg.png" alt="The logo for the National Oceanic and Atmospheric Administration" height="60px" width="60px"><h1>National Oceanic and Atmospheric Administration Datasets</h1>
<p class="universals">All contacts can be reached by email at NODC.Services@noaa.gov. All accrual periodicities are irregular.</p>

  <script>
 const data = <?php echo $data_json ?>

 function displayDescription(id) {
   const description = document.getElementById(id);
   description.style.display === 'inline' ? description.style.display = 'none' :  description.style.display = 'inline';
 }
 </script>

 <!-- 33 to 94 -->

 <ul id="initialDatasets">

<?php

$id = 0; 
foreach ($data as $dataset) { 
  echo "<li class='dataset-card' id='dataset$id'> 
  <h3>$dataset->title</h3> 
  <h4><button id='description-button$id' class='description-button' onClick='displayDescription($id)'>Show description</button></h4>
   <p class='description' id=$id>$dataset->description</p>
    <h5 class='identifier'>Identifier: " . substr($dataset->identifier, -7) . " </h5> 
    <h5>Date modified: $dataset->modified</h5>
    <h5>Publisher/Point of contact: $dataset->contactpoint_fn</h5>";
}

?>

 </ul>

</body>
</html>