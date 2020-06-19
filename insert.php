<?php
session_start();
$data = filter_input(INPUT_POST, 'data');
$user=$_SESSION["username"];
    echo $user;
    echo $data;

if (!empty($user)) {

        $host       = "";
        $dbusername = "";
        $dbpassword = "";
        $dbname     = "";
        // Create connection
        $conn       = new mysqli($host, $dbusername, $dbpassword, $dbname);
        if (mysqli_connect_error()) {
            die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
        } else {
            $sql = "UPDATE mathbglogin SET data = '$data' WHERE username = '$user'";
            if ($conn->query($sql)) {
                echo "New record is inserted sucessfully";
            } else {
                echo "Error: " . $sql . "" . $conn->error;
            }
            $conn->close();
        }

} else {
    echo "Username should not be empty";
    echo $user;
}
echo "<script>window.close()</script>"

?>
