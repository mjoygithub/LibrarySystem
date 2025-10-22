<?php
// PostgreSQL connection settings for Render
//$host = "dpg-d3s8k39r0fns73aag4sg-a.singapore-postgres.render.com";
//$port = "5432";
//$dbname = "libystem_db_6clw";
//$user = "libystem_db";
//$password = "8NFTIb4Pc7SbFZ4Gbt8N4DqwQtXUWwDv";

// Build connection string
//$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password options='--client_encoding=UTF8'";

// Connect to PostgreSQL
//$conn = pg_connect($conn_string);

// Check connection
//if (!$conn) {
    // Use pg_last_error() for PostgreSQL-specific error
  //  die("Connection failed: " . pg_last_error());


// ==============================
// Database Connection (Clever Cloud + Render Ready)
// ==============================

// Try to get credentials from Render environment variables first.
// If not found, it falls back to Clever Cloud defaults for local testing.
$host = getenv('MYSQL_ADDON_HOST') ?: 'bmrndqrsnpd4r1prk7ax-mysql.services.clever-cloud.com';
$username = getenv('MYSQL_ADDON_USER') ?: 'uqm5akn4krxj1h4n';
$password = getenv('MYSQL_ADDON_PASSWORD') ?: 'CQKiE6eKtts6QZXkEKlW';
$database = getenv('MYSQL_ADDON_DB') ?: 'bmrndqrsnpd4r1prk7ax';
$port = getenv('MYSQL_ADDON_PORT') ?: 3306;

// Create connection
$conn = new mysqli($host, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("❌ Database connection failed: " . $conn->connect_error);
}

// Set UTF-8 for compatibility
$conn->set_charset("utf8mb4");

// Optional — confirm connection (for testing only)
// echo "✅ Connected successfully to: " . $database;


// Optional: set error reporting for queries
pg_query($conn, "SET CLIENT_ENCODING TO 'UTF8';");
?>
