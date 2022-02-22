<?php

// Create connection
$db = new mysqli("localhost", "yuvi", "hello123", "anime");

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
//echo "Connected successfully";
?>  