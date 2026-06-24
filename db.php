<?php
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = "";     // Default XAMPP password is empty
$dbname = "event_manager";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully!";
?>

<?php
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM attendees");
$data = mysqli_fetch_assoc($result);
$total_attendees = $data['total'];
?>
<h3 class="text-2xl font-bold">
  <?php echo $total_attendees; ?>
</h3>