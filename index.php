<?php 

require 'main.php';

$Harvest_data = new Harvest_data;
$Harvest_data->clean_csv("csv_files/clean.csv");

//$Harvest_data->update_csv("csv_files/clean.csv", "csv_files/override.csv");



