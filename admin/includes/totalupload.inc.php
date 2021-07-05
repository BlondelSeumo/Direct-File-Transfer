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

# Get total bucket size current month
$data_dashboard = $db->get('data_dashboard', array('id', '=', 1))->first();
$total_bucket_size = intval($data_dashboard->total_bucket_size);


function formatBytes($bytes, $precision = 2) { 
	    
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 
    $bytes /= pow(1024, $pow);

    return round($bytes, $precision) . ' ' . $units[$pow];
	     
} 


echo json_encode(formatBytes($total_bucket_size), true);