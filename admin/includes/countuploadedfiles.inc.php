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

# Check if user is logged in
if (!$user->isLoggedIn()) {
	Redirect::to('index.php');
}

# Initialize DB Class
$db = DB::getInstance();

# Get total seconds for current month
$db->generalQuery("SELECT upload_date, sum(total_files) AS total FROM data_upload_files WHERE (upload_date between  DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW()) GROUP BY upload_date");
		
$totalRecords = $db->results();

$dataset = [];

for($i = 1; $i <= 31; $i++) {
	$dataset[$i] = 0;
}

foreach ($totalRecords as $row) {				
	$day_tmp = explode('-', $row['upload_date']);
	$day = ltrim(end($day_tmp), '0');
	$dataset[$day] = intval($row['total']);
}

echo json_encode($dataset, true);