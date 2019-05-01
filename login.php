<?php

// Include message library
require('message.php');

// Include database and configuration
require('config/config.php');
require('config/db.php');

session_start();

// authorization
session_regenerate_id();
$_SESSION['session_id'] = session_id();
header('Location: ' . ROOT_URL . 'dashboard.php');