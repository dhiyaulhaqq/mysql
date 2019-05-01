<?php

// Include message library
require('message.php');

// Include database and configuration
require('config/config.php');
require('config/db.php');

session_start();

// release authorization
session_unset();
session_destroy();

header('Location: ' . ROOT_URL . '');