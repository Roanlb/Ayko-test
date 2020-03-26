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

 <script>
 function sortDatasets() {
   const selector = document.getElementById('selector');
   let datasetsArray = data;
   if (selector.value == 'modified') {
     datasetsArray = datasetsArray.sort((a, b) => {
       return new Date(a.modified) - new Date(b.modified);
     });
   }
   else if (selector.value == 'temporal') {
     datasetsArray = datasetsArray.sort((a, b) => {
       return new Date(a.temporal.toString().substring(0, 10)) - new Date(b.temporal.toString().substring(0, 10));
     }); 
   }
   if (selector.value != 'Sort by') {

     for (let i = 0; i < datasetsArray.length; i++) {
       let idNo = `dataset${i}`;
       let listItem = document.getElementById(idNo);
        let coordinatesText = '';

            if (Array.isArray(datasetsArray[i].spatial.coordinates[0])) {
             
              datasetsArray[i].spatial.coordinates[0].forEach(coordinatePair => {
                coordinatesText += '[ ';
                coordinatePair.forEach(coordinate => {
                  coordinatesText += `${coordinate} `;
                })
                coordinatesText += '] ';
              })
            }
            else {
              datasetsArray[i].spatial.coordinates.forEach(coordinate => {
                coordinatesText += `[${coordinate}] `;
              })
            }       

       listItem.innerHTML = `<h3>${datasetsArray[i].title}</h3>
        <h4><button id='description-button${i}' class='description-button' onClick='displayDescription(${i})'>Show description</button></h4>
         <p class='description' id=${i}>${datasetsArray[i].description}</p>
          <h5 class='identifier'>Identifier: ` + datasetsArray[i].identifier.toString().substr(-7) + ` </h5> 
          <h5>Date modified: ${datasetsArray[i].modified}</h5> 
          <h5>Publisher/Point of contact: ${datasetsArray[i].contactpoint_fn}</h5> 
          <h5>Temporal: ` + datasetsArray[i].temporal.toString().slice(0, 9) + datasetsArray[i].temporal.toString().slice(18, -9) + `</h5>
          <h5>Spatial coordinates: ${coordinatesText} </h5>`;
      }
     }
   }

</script>

<select onChange='sortDatasets()' id='selector'>
  <option>Sort by</option>
  <option value='modified'>Modified</option>
  <option value='temporal'>Temporal</option>
</select>

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