<?php
// --- DATABASE LOGIC START ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_manager"; // Ensure this matches your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_contact'])) {
    
    // Get data from form using 'name' attributes
    $name     = mysqli_real_escape_string($conn, $_POST['c_name']);
    $email    = mysqli_real_escape_string($conn, $_POST['c_email']);
    $location = mysqli_real_escape_string($conn, $_POST['c_location']);
    $phone    = mysqli_real_escape_string($conn, $_POST['c_phone']);
    $message  = mysqli_real_escape_string($conn, $_POST['c_message']);

    $sql = "INSERT INTO contacts (name, email, location, phone, message) 
            VALUES ('$name', '$email', '$location', '$phone', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Thank you! Your message has been sent.'); window.location.href='contact.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// --- DATABASE LOGIC END ---
?>

<?php include "header.php"?>
<link rel="stylesheet" href="css/contact.css">

<div class="contact-container">
    <div class="contact-image"></div>
    <div class="contact-visual">
        <img src="images/bulb.jpg" alt="Event Celebration">
    </div>
    <div class="contact-form-section">
        <h2>Get The Party Started</h2>
        <p>Radha Events Planning and decor is one of Coimbatore's best event management companies...</p>

        <form method="POST" action="contact.php">
            <div class="form-row">
                <div class="input-group">
                    <label>Your Name:*</label>
                    <input type="text" name="c_name" placeholder="Name" required>
                </div>
                <div class="input-group">
                    <label>Your email-id:*</label>
                    <input type="email" name="c_email" placeholder="Email" required>
                </div>
            </div>

            <div class="form-row">
                <div class="input-group">
                    <label>Location</label>
                    <input type="text" name="c_location" placeholder="Location">
                </div>
                <div class="input-group">
                    <label>Your Number:*</label>
                    <input type="tel" name="c_phone" placeholder="Phone Number" required>
                </div>
            </div>

            
            <div class="input-group full-width">
                <label>Your Message:*</label>
                <textarea name="c_message" rows="4" placeholder="Your Message" required></textarea>
            </div>

            <div class="captcha-box">
                <input type="checkbox" id="robot" required> <label for="robot">I'm not a robot</label>
            </div>

            <button type="submit" name="submit_contact" class="submit-btn">Make A Reservation</button>
        </form>
    </div>
</div>

<div class="laptop-container">
    <div class="laptop-frame">
        <div class="screen">
           <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3916.0154260908294!2d77.0122863750288!3d11.037469254324462!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba857004754429d%3A0xca960f172398b9c9!2sRadha%20selection!5e0!3m2!1sen!2sin!4v1771199717090!5m2!1sen!2sin"
             width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
    <div class="laptop-base"></div>
</div>
<?php include "footer.php"?>