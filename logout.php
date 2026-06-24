<?php
session_start();    // Access the current session
session_unset();    // Remove all session variables
session_destroy();  // Destroy the session entirely

// Redirect the user back to the home page or login page
header("Location: index.php");
exit();
?>
<a href="logout.php" class="logout-btn">Log Out</a>
<script src="js/login.js"></script>