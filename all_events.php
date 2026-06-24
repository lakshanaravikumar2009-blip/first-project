<?php
$conn = new mysqli("localhost", "root", "", "event_manager");

// Update status logic
if(isset($_GET['update_id']) && isset($_GET['new_status'])) {
    $id = $_GET['update_id'];
    $stat = $_GET['new_status'];
    
    // 1. First, update the database
    $conn->query("UPDATE enquiries SET status='$stat' WHERE id=$id");
    
    // 2. PASTE THE EMAIL LOGIC HERE
    if($stat == 'Confirmed') {
        $res = $conn->query("SELECT email, customer_name, event_type, location, budget FROM enquiries WHERE id=$id");
        if($user = $res->fetch_assoc()){
            $to_email = $user['email'];
            $name = escapeshellarg($user['customer_name']);
            $type = escapeshellarg($user['event_type']);
            $loc = escapeshellarg($user['location']);
            $bud = escapeshellarg($user['budget']);

            // Added "2>&1" to capture errors and $output to store them
            $output = [];
            $cmd = "node \"C:\\xampp\\htdocs\\event_manager\\js\\send_email.js\" $to_email $name $type $loc $bud 2>&1";
            exec($cmd, $output);

            // This will print the error in your Browser Console (F12) if it fails
            if (!empty($output)) {
                // We use session or a temporary delay if we want to see this before redirect, 
                // but for debugging, let's log it.
                error_log(implode("\n", $output)); 
            }
        }
    }

    // 3. Finally, redirect
    header("Location: all_events.php");
    exit(); 
}

$sql = "SELECT * FROM enquiries WHERE status != 'Cancelled' ORDER BY event_type ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Events Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800"><i class="fa fa-calendar-check mr-2 text-blue-600"></i>Active Event Schedule</h1>
            <a href="admin_dashboard.php" class="text-blue-600 hover:underline">← Back to Enquiries</a>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <?php while($row = $result->fetch_assoc()): ?>
            <div class="bg-white p-5 rounded-lg shadow-sm border-l-4 <?php echo ($row['status'] == 'Confirmed') ? 'border-green-500' : 'border-blue-400'; ?> flex justify-between items-center">
                
                <div>
                    <span class="text-xs font-bold uppercase text-gray-400 tracking-wider"><?php echo $row['event_type']; ?></span>
                    <h3 class="text-xl font-bold text-gray-800"><?php echo $row['customer_name']; ?></h3>
                    <p class="text-gray-500 text-sm"><i class="fa fa-location-dot mr-1"></i> <?php echo $row['location']; ?></p>
                </div>

                <div class="text-center">
                    <p class="text-xs text-gray-400 uppercase font-bold">Budget</p>
                    <p class="text-lg font-mono font-bold text-gray-700">₹<?php echo $row['budget']; ?></p>
                </div>

                <div>
                    <p class="text-xs text-gray-400 uppercase font-bold mb-2 text-right">Current Status</p>
                    <div class="flex items-center space-x-2">
                        <span class="px-3 py-1 rounded text-xs font-bold 
                            <?php echo ($row['status'] == 'Confirmed') ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700'; ?>">
                            <?php echo $row['status']; ?>
                        </span>
                        
                        <div class="flex space-x-1 ml-4">
                            <a href="?update_id=<?php echo $row['id']; ?>&new_status=Confirmed" class="p-2 bg-green-500 text-white rounded hover:bg-green-600 title="Mark Confirmed"><i class="fa fa-check"></i></a>
                            <a href="?update_id=<?php echo $row['id']; ?>&new_status=Completed" class="p-2 bg-gray-800 text-white rounded hover:bg-black" title="Mark Completed"><i class="fa fa-flag-checkered"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>