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

# Amazon IAM Parameters
$db = DB::getInstance();

# Return all values from Shares Table
$db->generalQuery("SELECT * FROM data_table_shares");
$totalRecords = $db->count();


# Local variables and query builder
$data = array();
$output = array();
$query = '';
$query .= "SELECT * FROM data_table_shares ";


# Add search fields 
if(isset($_POST["search"]["value"])) {
  $query .= 'WHERE filenames LIKE "%'.$_POST["search"]["value"].'%" ';
  $query .= 'OR filequantity LIKE "%'.$_POST["search"]["value"].'%" ';
  $query .= 'OR senderemail LIKE "%'.$_POST["search"]["value"].'%" ';
  $query .= 'OR receiveremail LIKE "%'.$_POST["search"]["value"].'%" ';
  $query .= 'OR message LIKE "%'.$_POST["search"]["value"].'%" ';
  $query .= 'OR expirationtime LIKE "%'.$_POST["search"]["value"].'%" ';
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

  # DB table data 
  $sub_array = array();
  $sub_array[] = $row["sharetype"];
  $sub_array[] = $row["filequantity"];
  $sub_array[] = nl2br($row["filenames"]);
  $sub_array[] = $row["senderemail"];
  $sub_array[] = $row["receiveremail"];
  $sub_array[] = $row["message"];
  $sub_array[] = $row["privatelink"];
  $sub_array[] = $row["expirationtime"];
  $sub_array[] = $row["uploaddate"];
  $data[] = $sub_array;
}

# Output for dataTable
$output = array(
  "draw"        =>  intval($_POST["draw"]),
  "recordsTotal"    =>  $filtered_rows,
  "recordsFiltered" =>  $totalRecords,
  "data"        =>  $data
);

# Return JSON output
echo json_encode($output);