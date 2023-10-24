<?php

// Endereço do servidor
$servername = "10.0.0.50";
// Nome da base de dados
$dbname = "manutencao_preditiva";
// Usuário do banco de dados
$username = "root";
// Senha do banco de dados
$password = "paulvandyk11";

// Keep this API Key value to be compatible with the ESP32 code provided in the project page. 
// If you change this value, the ESP32 sketch needs to match
$api_key_value = "tPmAT5Ab3j7F9";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $api_key = test_input($_POST["api_key"]);
    
    if ($api_key == $api_key_value) {
        $i_compressor = test_input($_POST["i_compressor"]);
        $i_vent_int = test_input($_POST["i_vent_int"]);
        $i_vent_ext = test_input($_POST["i_vent_ext"]);
        $s1 = test_input($_POST["s1"]);
        $s2 = test_input($_POST["s2"]);
        $s3 = test_input($_POST["s3"]);
        $s4 = test_input($_POST["s4"]);

        $delta_s1s2 = $s2 - $s1;
        $delta_s3s4 = $s3 - $s4;
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $sql = "INSERT INTO sensores (i_compressor, i_vent_int, i_vent_ext, s1, s2, delta_s1s2, s3, s4, delta_s3s4) 
        VALUES ('{$i_compressor}', '{$i_vent_int}', '{$i_vent_ext}', '{$s1}', '{$s2}', '{$delta_s1s2}', '{$s3}', '{$s4}', '{$delta_s3s4}')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
        $conn->close();
    }
    else {
        echo "Wrong API Key provided.";
    }

}
else {
    echo "No data posted with HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}