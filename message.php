<?php
// Connect to the same database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_manager";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch messages from the 'contacts' table
$sql = "SELECT * FROM contacts ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - messages</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .dashboard-container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { color: #333; border-bottom: 2px solid #27ae60; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #2c3e50; color: white; }
        tr:hover { background: #f9f9f9; }
        .btn { padding: 8px 12px; text-decoration: none; border-radius: 4px; color: white; font-size: 13px; }
        .btn-call { background: #27ae60; }
        .btn-email { background: #2980b9; }
        .budget-tag { background: #eee; padding: 2px 6px; border-radius: 4px; font-weight: bold; }
    </style>
</head>
<body>

<div class="dashboard-container">
<div style="text-align: right; margin-bottom: 10px;">
    <a href="admin_dashboard.php" style="text-decoration: none; color: #007bff;">← Back to Enquiries</a>
</div>
    <h2>📩 Customer's Messages</h2>

    
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Customer Name</th>
                <th>Location</th>
                <th>Message</th>
                <th>Contact Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . date('M d, Y', strtotime($row['created_at'])) . "</td>";
                    echo "<td><strong>" . $row['name'] . "</strong></td>";
                    echo "<td>" . $row['location'] . "</td>";
                    echo "<td>" . $row['message'] . "</td>";
                    echo "<td>
                            <a href='tel:" . $row['phone'] . "' class='btn btn-call'>📞 Call</a>
                            <a href='mailto:" . $row['email'] . "?subject=Inquiry Response from Radha Events' class='btn btn-email'>✉️ Email</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No messages found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>