<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_manager";

$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM enquiries WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to dashboard after deleting
        header("Location: admin_dashboard.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>