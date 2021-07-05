<?php

/*==========================================================================
 * Copyright (c) 2020
 * =========================================================================
 * 
 *
 * Project: Upload & Share
 * Author: Berkine 
 * Version: 1.0.0
 * 
 * 
 * =========================================================================
 */

# Core Initialization File
require_once __DIR__ . '/../core/init.core.php';

$user = new User();

# Check if uses is logged in
if (!$user->isLoggedIn()) {
  Redirect::to('index.php');
}

# Initiate DB Class
$db = DB::getInstance();

# Return all values from Files Table
$db->generalQuery("SELECT * FROM data_table_files");
$totalRecords = $db->count();


# Local variables and query builder
$data = array();
$output = array();
$query = '';
$query .= "SELECT * FROM data_table_files ";


# Add search fields 
if(isset($_POST["search"]["value"])) {
  $query .= 'WHERE filename LIKE "%'.$_POST["search"]["value"].'%" ';
  $query .= 'OR filetype LIKE "%'.$_POST["search"]["value"].'%" ';
  $query .= 'OR size LIKE "%'.$_POST["search"]["value"].'%" ';
  $query .= 'OR uploaddate LIKE "%'.$_POST["search"]["value"].'%" ';
}


# Add order format
if(isset($_POST["order"])) {
  $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
} else {
  $query .= 'ORDER BY id DESC ';
}


# Set the length
if($_POST["length"] != -1) {
  $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}   


# Get all resuts of custom query
$db->generalQuery($query);
$result = $db->results();
$filtered_rows = $db->count();


# Prepare results for output data
foreach($result as $row) {

  # Checkbox button
  $checkbox = '<label class="checkbox">                  
                  <input class="selectfile" type="checkbox" name="selectfile" value="'.$row["id"].'">
                  <span class="checkbox-inner"></span>
              </label>';
  # Action buttons
  $getLinkButton = '<button type="button" name="link" id="'.$row["id"].'" class="btn link" button-toggle="tooltip" button-placement="top" title="Copy Download Link"><i class="nav-icon fas fa-share-alt" ></i></button>';
  $downloadFileButton = '<button type="button" name="download" id="'.$row["id"].'" class="btn download" button-toggle="tooltip" button-placement="top" title="Download File"><i class="fas fa-cloud-download-alt"></i></button>';
  $sendEmailButton = '<button type="button" name="emaillink" data-file="'.$row['filename'].'" data-id="'.$row["id"].'" class="btn emaillink" button-toggle="tooltip" button-placement="top" title="Send Download Link" data-toggle="modal" data-target="#email-link"><i class="fas fa-envelope"></i></button>';
  $deleteFileButton = '<button type="button" name="delete" data-title="'.$row['filename'].'" data-id="'.$row["id"].'" class="btn delete" button-toggle="tooltip" button-placement="top" title="Delete Selected File" data-toggle="modal" data-target="#confirm-delete"><i class="fas fa-trash-alt"></i></button>';

  $actionButtons = $getLinkButton . " " . $downloadFileButton . " " . $sendEmailButton . " " . $deleteFileButton;

  # Formatted Size
  $formatted_size = formatBytes($row['size']);

  # DB table data 
  $sub_array = array();
  $sub_array[] = $checkbox;
  $sub_array[] = $row["filename"];
  $sub_array[] = $row["filetype"];
  $sub_array[] = $formatted_size;
  $sub_array[] = $row["sharetype"];
  $sub_array[] = $row["uploaddate"];
  $sub_array[] = $actionButtons;
  $data[] = $sub_array;
}

# Output for dataTable
$output = array(
  "draw"        =>  intval($_POST["draw"]),
  "recordsTotal"    =>  $filtered_rows,
  "recordsFiltered" =>  $totalRecords,
  "data"        =>  $data
);


function formatBytes($bytes, $precision = 2) { 
      
  $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
  $bytes = max($bytes, 0); 
  $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
  $pow = min($pow, count($units) - 1); 
  $bytes /= pow(1024, $pow);

  return round($bytes, $precision) . ' ' . $units[$pow];
       
} 


# Return JSON output
echo json_encode($output);