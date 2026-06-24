<div class="admin-dashboard">
    <h2>Event Vendor Directory</h2>
  <div style="text-align: right; margin-bottom: 10px;">
    <a href="admin_dashboard.php" style="text-decoration: none; color: #007bff;">← Back to Enquiries</a>
  </div>
    
    <input type="text" id="vendorSearch" placeholder="Search by service (e.g. Catering)..." onkeyup="filterVendors()">

    <table id="vendorTable">
        <thead>
            <tr>
                <th>Vendor Name</th>
                <th>Service Type</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="vendorBody">
            </tbody>
    </table>
</div>
<link rel="stylesheet" href="css/vendor.css">
  <script src="js/vendor.js"></script>