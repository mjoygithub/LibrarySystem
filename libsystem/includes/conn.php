<?php
// PostgreSQL connection settings for Render
$host = "dpg-d3s8k39r0fns73aag4sg-a.singapore-postgres.render.com";
$port = "5432";
$dbname = "libystem_db_6clw";
$user = "libystem_db";
$password = "8NFTIb4Pc7SbFZ4Gbt8N4DqwQtXUWwDv";

// Build connection string
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password options='--client_encoding=UTF8'";

// Connect to PostgreSQL
$conn = pg_connect($conn_string);

// Check connection
if (!$conn) {
    // Use pg_last_error() for PostgreSQL-specific error
    die("Connection failed: " . pg_last_error());
}

// Optional: set error reporting for queries
pg_query($conn, "SET CLIENT_ENCODING TO 'UTF8';");
?>
