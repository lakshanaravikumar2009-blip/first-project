<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_manager";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all enquiries from the database
$sql = "SELECT * FROM enquiries ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="flex">
        <div class="w-64 bg-slate-900 min-h-screen text-white p-6 hidden md:block">
            <div class="logo mb-4">
                <img src="images/logo.png" width="200" height="100" alt="Radha Events Logo">
            </div> 
            <center><h2 class="text-3xl font-bold mb-8 text-blue-400">Radha Events</h2></center>

            <nav class="space-y-4">
                <a href="#" class="block py-2.5 px-4 rounded bg-blue-600 text-white"><i class="fa fa-home mr-2"></i> Dashboard</a>
                <a href="all_events.php" class="block py-2.5 px-4 rounded hover:bg-slate-800 transition"><i class="fa fa-calendar mr-2"></i> All Events</a>
                <a href="customers.php" class="block py-2.5 px-4 rounded hover:bg-slate-800 transition"><i class="fa fa-users mr-2"></i> Customers</a>
                <a href="vendor.php" class="block py-2.5 px-4 rounded hover:bg-slate-800 transition"><i class="fa fa-truck mr-2"></i> Vendors</a>
                <a href="message.php" class="block py-2.5 px-4 rounded hover:bg-slate-800 transition"><i class="fa fa-envelope mr-2"></i> Messages</a>
                <a href="payment.php" class="block py-2.5 px-4 rounded hover:bg-slate-800 transition"><i class="fa fa-credit-card mr-2"></i> Payment</a>
                <a href="logout.php" class="block py-2.5 px-4 rounded hover:bg-slate-900 transition"><i class="fa fa-sign-out mr-2"></i> Logout</a>
            </nav>
        </div>

        <div class="flex-1 p-8">
            <header class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Reservation Enquiries</h1>
                    <p class="text-gray-500">Manage your incoming leads and event bookings.</p>
                </div>
                <div class="bg-white p-3 rounded-lg shadow-sm border">
                    <span class="font-bold text-blue-600">Total Enquiries: <?php echo $result->num_rows; ?></span>
                </div>
            </header>

            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Customer Details</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Event Type</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Location</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Budget</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Message</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php 
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    // Clean the message for the popup
                                    $msg = addslashes($row['message']);
                                    $name = addslashes($row['customer_name']);

                                    echo "<tr id='row-".$row['id']."' class='hover:bg-gray-50 transition'>";
                                    echo "<td class='px-6 py-4'>";
                                    echo "<div class='font-bold text-gray-800'>" . $row['customer_name'] . "</div>";
                                    echo "<div class='text-sm text-gray-500'>" . $row['email'] . "</div>";
                                    echo "<div class='text-xs text-blue-500'>" . $row['phone'] . "</div>";
                                    echo "</td>";
                                    echo "<td class='px-6 py-4'><span class='px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium'>" . ucfirst($row['event_type']) . "</span></td>";
                                    echo "<td class='px-6 py-4 text-sm text-gray-600'>" . $row['location'] . "</td>";
                                    echo "<td class='px-6 py-4 font-semibold text-green-600'>" . $row['budget'] . "</td>";
                                    echo "<td class='px-6 py-4 text-sm text-gray-500 italic max-w-xs truncate'>" . $row['message'] . "</td>";
                                    
                                    // ACTION BUTTONS
                                    echo "<td class='px-6 py-4'>";
                                    echo "<button onclick=\"viewMessage('$name', '$msg')\" class='text-blue-600 hover:text-blue-800 mr-3'><i class='fa fa-eye'></i></button>";
                                    echo "<button onclick='deleteEnquiry(".$row['id'].")' class='text-red-600 hover:text-red-800'><i class='fa fa-trash'></i></button>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='p-10 text-center text-gray-400 italic'>No enquiries found yet.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="msgModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6 shadow-xl">
            <h2 id="modalName" class="text-xl font-bold mb-2"></h2>
            <p id="modalMsg" class="text-gray-600 italic border-t pt-2"></p>
            <button onclick="closeModal()" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Close</button>
        </div>
    </div>

    <script>
        // FUNCTION FOR EYE ICON
        function viewMessage(name, msg) {
            document.getElementById('modalName').innerText = "Message from " + name;
            document.getElementById('modalMsg').innerText = msg;
            document.getElementById('msgModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('msgModal').classList.add('hidden');
        }

        // FUNCTION FOR DELETE ICON
        function deleteEnquiry(id) {
            if(confirm("Are you sure you want to delete this enquiry?")) {
                window.location.href = "delete_enquiry.php?id=" + id;
            }
        }
    </script>
</body>
</html>