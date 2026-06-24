<?php
$conn = new mysqli("localhost", "root", "", "event_manager");

// Query to get unique customers and count their total bookings/spend
$sql = "SELECT 
            customer_name, 
            email, 
            phone, 
            COUNT(id) as total_bookings, 
            SUM(budget) as total_spent,
            MAX(id) as latest_id
        FROM enquiries 
        GROUP BY email 
        ORDER BY total_spent DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Directory</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="p-8">
        <div class=" mb-6">
            <h1 class="text-2xl font-bold text-gray-800"><i class="fa fa-calendar-check mr-2 text-blue-600"></i>Customer Database</h1>
            <p class="text-gray-500">View your most frequent clients and their lifetime value.</p>
			 <div style="text-align: right; margin-bottom: 10px;">
    <a href="admin_dashboard.php" style="text-decoration: none; color: #007bff;">← Back to Enquiries</a>
</div>
        </div>
		
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="p-4">Customer Name</th>
                        <th class="p-4">Contact Info</th>
                        <th class="p-4 text-center">Total Events</th>
                        <th class="p-4 text-center">Lifetime Revenue</th>
                        <th class="p-4">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr class="hover:bg-blue-50 transition">
                        <td class="p-4 font-bold text-gray-700"><?php echo $row['customer_name']; ?></td>
                        <td class="p-4 text-sm">
                            <div><i class="fa fa-envelope text-gray-400 mr-2"></i><?php echo $row['email']; ?></div>
                            <div><i class="fa fa-phone text-gray-400 mr-2"></i><?php echo $row['phone']; ?></div>
                        </td>
                        <td class="p-4 text-center">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-bold">
                                <?php echo $row['total_bookings']; ?> Events
                            </span>
                        </td>
                        <td class="p-4 text-center font-bold text-green-600">
                            ₹<?php echo number_format($row['total_spent']); ?>
                        </td>
                        <td class="p-4">
                            <a href="https://wa.me/<?php echo $row['phone']; ?>" target="_blank" class="bg-green-500 text-white p-2 rounded hover:bg-green-600 transition">
                                <i class="fa-brands fa-whatsapp"></i> Chat
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>