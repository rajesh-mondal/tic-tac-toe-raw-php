<?php

// Database Configuration
const DB_HOST = 'localhost';
const DB_NAME = 'tic-tac-toe';
const DB_USER = 'root';
const DB_PASS = '';

// Creates and returns a PDO database connection.
function getDbConnection() {
    try {
        $conn = new PDO( "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS );
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        return $conn;
    } catch ( PDOException $e ) {
        die( "Database connection failed: " . $e->getMessage() );
    }
}