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
require_once 'core/init.core.php';

# lOGOUT USER
$user = new User();
$user->logout();

# REDIRECT TO INDEX PAGE
Redirect::to('index.php');