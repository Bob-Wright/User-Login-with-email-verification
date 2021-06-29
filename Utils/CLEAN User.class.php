<?php
/*
 * User Class
 * This class is used for user database related (connect, insert, read, update, and delete) operations
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);

class User {
	// Database configuration
    private $dbHost     = 'localhost'; //MySQL_Database_Host
    private $dbUsername = 'root'; //MySQL_Database_Username
    private $dbPassword = 'password'; //MySQL_Database_Password
    private $dbName     = 'users'; //MySQL_Database_Name
    private $userTbl    = 'users';

    function __construct(){
        if(!isset($this->db)){
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if($conn->connect_error){ // limit information displayed on error
                die("Failed to connect with database. "/* . $conn->connect_error*/);
            }else{
                $this->db = $conn;
            }
        }
    }

	/* --------------------
	create the users table
	*/
public function createTable(){
   // Check whether user data already exists in database
	$checkQuery = "SELECT * FROM ".$this->userTbl;
		// echo $prevQuery."<br>";
	$checkResult = $this->db->query($checkQuery);
	if($checkResult != NULL){
	$drop = "DROP TABLE `".$this->userTbl."`;";
		if ($this->db->query($drop) === TRUE) {
				echo "User Table dropped successfully<br>";
				} else {
				echo "Error dropping User Table: <br>"; // leave off $conn->error;
	}}
	$sql =
	"CREATE TABLE IF NOT EXISTS `users` (
	  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
	  `lastname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
	  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
	  `mobilenumber` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
	  `link` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
	  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
	  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
	  `is_active` enum('0','1') NOT NULL,
	  `date_time` date NOT NULL,
	  `created` datetime NOT NULL,
	  `modified` datetime NOT NULL,
	  `views` int(11) NOT NULL DEFAULT 0,
	  `posts` int(11) NOT NULL DEFAULT 0
	) COLLATE=utf8mb4_unicode_ci;
 	";
	if ($this->db->query($sql) === TRUE) {
		echo "User Table created successfully<br>";
		} else {
		echo "Error creating User Table: <br>"; // leave off $conn->error;
	}
}
}	
?>