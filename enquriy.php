<?php
// --- DATABASE LOGIC START ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_manager"; // Make sure this matches your DB name in phpMyAdmin

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['make_reservation'])) {
    
    // Get data from form using the 'name' attributes
    $name     = mysqli_real_escape_string($conn, $_POST['u_name']);
    $email    = mysqli_real_escape_string($conn, $_POST['u_email']);
    $location = mysqli_real_escape_string($conn, $_POST['u_location']);
    $phone    = mysqli_real_escape_string($conn, $_POST['u_phone']);
    $event    = mysqli_real_escape_string($conn, $_POST['u_event']);
    $budget   = mysqli_real_escape_string($conn, $_POST['u_budget']);
    $message  = mysqli_real_escape_string($conn, $_POST['u_message']);

    $sql = "INSERT INTO enquiries (customer_name, email, location, phone, event_type, budget, message) 
            VALUES ('$name', '$email', '$location', '$phone', '$event', '$budget', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Reservation Request Sent Successfully!'); window.location.href='enquriy.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}


// --- DATABASE LOGIC END ---
?>

<?php include"header.php"?>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/enquriy.css">

<div class="page-wrapper">
    <div class="main-container">
        <section class="form-section">
            <div class="form-header">
                <h1>Hire An Expert Event Planner Company!</h1>
                <p>We ensure that you have an enjoyable, well-organized event free of hassle, and keeping it within budget.</p>
            </div>

            <form class="reservation-form" method="POST" action="enquriy.php">
                <div class="form-row">
                    <div class="input-group">
                        <label><i class="fa-regular fa-user"></i> Your Name:*</label>
                        <input type="text" name="u_name" placeholder="Name" required>
                    </div>
                    <div class="input-group">
                        <label><i class="fa-regular fa-envelope"></i> Your email-id:*</label>
                        <input type="email" name="u_email" placeholder="Email" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="input-group">
                        <label><i class="fa-solid fa-location-dot"></i> Location</label>
                        <input type="text" name="u_location" placeholder="Location">
                    </div>
                    <div class="input-group">
                        <label><i class="fa-solid fa-mobile-screen"></i> Your Number:*</label>
                        <input type="tel" name="u_phone" placeholder="Phone Number" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="input-group">
                        <select class="event-select" name="u_event" required>
                           <option value="" disabled selected>Select Your Event Here</option>
                           <option value="team-building">Team building Event</option>
                           <option value="wedding">Wedding Planner</option>
                           <option value="corporate">Corporate Events</option>
                           <option value="birthday">Birthday Party</option>
                           <option value="housewarming">Housewarming</option>
                           <option value="puberty">Puberty Function</option>
                           <option value="engagement">Engagement</option>
                           <option value="anniversary">Anniversary</option>
                           <option value="exhibition">Exhibition Stall</option>
                           <option value="alumni">College/School Alumni</option>
                           <option value="bangle">Bangle Ceremony</option>
                           <option value="sangeet">Sangeet & Mehendi</option>
                           <option value="naming">Baby Naming Ceremony</option>
                           <option value="corporate-anniversary">Corporate Anniversary Event Planner</option>
                           <option value="conferences">Conferences & Seminars</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label><i class="fa-solid fa-money-bill-wave"></i> Budget:*</label>
                        <input type="text" name="u_budget" placeholder="Budget">
                    </div>
                </div>

                <div class="input-group full-width">
                    <label><i class="fa-regular fa-comment"></i> Your Message:*</label>
                    <textarea name="u_message" rows="1" placeholder="Your Message" required></textarea>
                </div>

                <button type="submit" name="make_reservation" class="submit-btn">Make A Reservation</button>
            </form>
        </section>

        <aside class="sidebar">
            <h2 class="sidebar-title">Services of Radha Events</h2>
            <ul class="services-list">
                <li>Team building Event</li>
                <li>Wedding Planner</li>
                <li>Corporate Events</li>
                <li>Birthday Party</li>
                <li>Housewarming</li>
                <li>Puberty Function</li>
                <li>Engagement</li>
                <li class="active">Anniversary</li>
                <li>Exhibition Stall</li>
                <li>College/School Alumni</li>
                <li>Bangle Ceremony</li>
                <li>Sangeet & Mehendi</li>
                <li>Baby Naming Ceremony</li>
            </ul>
        </aside>
    </div>

    <footer class="footer-cta">
        <h2>We'll Make Your Next Event Celebration Very Special!</h2>
        <p>The Bamboo Events Planning and Decor is an exponentially evolving full-service Event Management and Party Planners in Coimbatore...</p>
        <p class="support-text">For all of your questions, we have a supportive helpdesk!</p>
        <div class="phone-box">
            <i class="fa-solid fa-phone"></i>
            <span>Call Us: +91 7402315731</span>
        </div>
    </footer>
</div>

<script src="js/enquriy.js"></script>
<?php include"footer.php"?>
  