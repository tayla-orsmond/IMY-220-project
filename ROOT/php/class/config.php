<?php
//Tayla Orsmond u21467456
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//allow file uploads
ini_set('file_uploads', 'On');
//set the max file size to 2MB
ini_set('upload_max_filesize', '2M');

try{
    session_start();
}
catch(Exception $e){
    echo 'Error: The server is currently down. Please try again later. <br/>' . $e->getMessage() . "<br/>";
}
//globals
$api_url = "http://imy.up.ac.za/IMY220/u21467456/api.php";
// $api_url = "http://localhost/api.php";
$api_headers = array(
    "Accept: application/json",
    "Content-Type: application/json",
);
$api_key = "u21467456" . ":" . "ejimskut";

class DBH
{
    /*
        Tayla Orsmond u21467456
        ---------------------------------------------------------
        This class is a singleton that handles the database connection
    */
    //connection info
    private $host = 'localhost';
    private $dbname = 'u21467456';
    private $username = 'u21467456';
    private $password = 'ejimskut';
    // private $host = 'localhost';
    // private $dbname = 'u21467456';
    // private $username = 'root';
    // private $password = '';
    private $charset = 'utf8mb4';
    private $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    private $conn; //connection
    private static $instance = null; //instance

    //private DB constructor
    private function __construct()
    {
        $this->conn = null;
        try {
            //return database connection
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=$this->charset", $this->username, $this->password, $this->options);
        } catch (PDOException $e) {
            echo "Error Connecting to Database: <br>" . $e->getMessage() . "<br/>";
            die();
        }
    }
    //prevent cloning
    private function __clone()
    {
    }

    //get instance and connection - singleton
    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    public function connect()
    {
        return $this->conn;
    }
}
