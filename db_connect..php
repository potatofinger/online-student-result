<?php 
    $driver = 'mysql';
    $host = 'localhost';
    $dbname = 'osrs_db';
    $charset = 'utf8';
    $username = 'root';
    $password = '';
    $dsn = "$driver:host=$host;port=3307;dbname=$dbname;charset=$charset";  

    $options = [
        PDO::ATTR_EMULATE_PREPARES => FALSE,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    try {
        $pdo = new PDO($dsn, $username, $password, $options);
        // if($pdo){
        //     echo 'success';
        // }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage(); 
    }
?>
