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
$s3 = new Wasabi();

# Check if uses is logged in
if (!$user->isLoggedIn()) {
  Redirect::to('index.php');
}

# Amazon IAM Parameters
$db = DB::getInstance();

# If POST has 'action' value
if(isset($_POST["action"])) {

    # Define action name
    $action = escape($_POST['action']);
    $id = escape($_POST['id']);


    # =================================================
    #  Get File Download Link
    # =================================================
    if ($action == "link") {

      $result = $s3->getFileLink($id);

      # Return Ajax reponse as JSON
      json_output($result);

    }


    # =================================================
    #  Download File
    # =================================================
    if ($action == "download") {


      $result = $s3->getFileLink($id);

      # Return Ajax reponse as JSON
      json_output($result);

    }

    # =================================================
    #  Download All Files
    # =================================================
    if ($action == "download-all") {

      $result = $s3->getAllFileLinks($id);

      # Return Ajax reponse as JSON
      json_output($result);

    }


    # =================================================
    #  Delete File
    # =================================================
    if ($action == "delete") {

      $result = $s3->deleteFile($id);

    }


    # =================================================
    #  Delete All Files
    # =================================================
    if ($action == "delete-all") {

      $result = $s3->deleteAllFiles($id);

    }


    # =================================================
    #  Send File Link via Email
    # =================================================
    if ($action == "email-link") {      

      $email = escape($_POST['email']);
      $subject = escape($_POST['subject']);
      $message = escape($_POST['message']);

      $result = $s3->emailDownloadLink($id, $email, $subject, $message);

      json_output($result);

    }


    # =================================================
    #  Send All Selected File Links via Email
    # =================================================
    if ($action == "email-all") {      

      $email = escape($_POST['email']);
      $subject = escape($_POST['subject']);
      $message = escape($_POST['message']);

      $result = $s3->emailAllDownloadLinks($id, $email, $subject, $message);

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

