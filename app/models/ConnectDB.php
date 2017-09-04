<html>
<head>
  <title>Connection to local DataBase</title>
</head>
<body>

<?php
$dbServer = "localhost";
$user = "root";
$pswd = "";
$db="Vokuro" ; 

try {
    $conn = new PDO("mysql:host=$dbServer", $user, $pswd,$db);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
    
    $conn = null;
    
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>
</body>
</html>
