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

$ga = new GA();
$user = new User();

# Check if uses is logged in
if (!$user->isLoggedIn()) {
  Redirect::to('index.php');
}

# If POST has 'action' value
if(isset($_POST["action"])) {

    # Define action name
    $action = escape($_POST['action']);


    # =================================================
    #  USERS & SESSIONS DURING PAST 2 WEEKS
    # =================================================
    if ($action == "users_sessions_biweekly") {

      $start_date = escape($_POST['start_date']);
      $end_date = escape($_POST['end_date']);
      $result = $ga->getSessionsAndUsers($start_date, $end_date);

      # Return Ajax reponse as JSON
      json_output($result);

    }


    # =================================================
    #  USERS & SESSIONS DURING CURRENT AND PAST MONTHS
    # =================================================
    if ($action == "users_sessions_monthly") {

      $start_date = escape($_POST['start_month']);
      $end_date = escape($_POST['end_month']);
      $result = $ga->getSessionsAndUsers($start_date, $end_date);

      # Return Ajax reponse as JSON
      json_output($result);

    }


    # =================================================
    #  TOP BROWSERS USED DURING PAST 2 WEEKS
    # =================================================
    if ($action == "top_browsers") {

      $start_date = escape($_POST['start_date']);
      $end_date = escape($_POST['end_date']);
      $result = $ga->getTopBrowsers($start_date, $end_date);

      # Return Ajax reponse as JSON
      json_output($result);

    }


    # =================================================
    #  TOP DEVICES USED DURING PAST 2 WEEKS
    # =================================================
    if ($action == "top_devices") {

      $start_date = escape($_POST['start_date']);
      $end_date = escape($_POST['end_date']);
      $result = $ga->getTopDevices($start_date, $end_date);

      # Return Ajax reponse as JSON
      json_output($result);
      
    }


    # =================================================
    #  TOP TRAFFIC SOURCES DURING PAST 2 WEEKS
    # =================================================
    if ($action == "top_traffic") {

      $start_date = escape($_POST['start_date']);
      $end_date = escape($_POST['end_date']);
      $result = $ga->getTrafficSources($start_date, $end_date);

      # Return Ajax reponse as JSON
      json_output($result);
      
    }


    # =================================================
    #  TOP COUNTRIES DURING PAST 2 WEEKS
    # =================================================
    if ($action == "top_countries") {

      $start_date = escape($_POST['start_date']);
      $end_date = escape($_POST['end_date']);
      $result = $ga->getTopCountries($start_date, $end_date);

      # Return Ajax reponse as JSON
      json_output($result);
      
    }

}

# ==================================================================
#   JSON Output to XHE request
# ==================================================================
function json_output($data) {

    header('Content-Type: application/json');

    die(json_encode($data));

}

