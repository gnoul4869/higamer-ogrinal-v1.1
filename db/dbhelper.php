<?php
require_once ('config.php');

function execute($sql) {
    // Save data into table
    // Open connection to database
    $con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    mysqli_set_charset($con, 'UTF8');
    // Insert, update, delete
    mysqli_query($con, $sql);

    // Close connection
    mysqli_close($con);
}

function executeResult($sql) {
    // Save data into table
    // Open connection to database
    $con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    mysqli_set_charset($con, 'UTF8');
    // Insert, update, delete
    $result = mysqli_query($con, $sql);
    $data = [];
    while ($row = mysqli_fetch_array($result, 1)) {
        $data[] = $row;
    }

    // Close connection
    mysqli_close($con);
    
    return $data;
}

function executeSingle($sql) {
    // Save data into table
    // Open connection to database
    $con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    mysqli_set_charset($con, 'UTF8');
    // Insert, update, delete
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result, 1);

    // Close connection
    mysqli_close($con);
    
    return $row;
}