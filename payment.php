
<!DOCTYPE html>
<html>
<head>
    <title>Event Finance Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; padding: 20px; }
        .chart-card {
            background: #fff;
            max-width: 900px;
            margin: auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
        h2 { color: #2d3436; margin-bottom: 20px; text-align: center; }
    </style>
</head>
<body>
<div style="text-align: right; margin-bottom: 10px;">
    <a href="admin_dashboard.php" style="text-decoration: none; color: #007bff;">← Back to Enquiries</a>
</div>

<div class="chart-card">
    <h2>Event Revenue: Paid vs. Unpaid</h2>
    <canvas id="financeChart"></canvas>
</div>


<script>
async function loadChart() {
    const response = await fetch('data.php');
    const dbData = await response.json();

    const labels = dbData.map(d => d.payment_date);
    const paidPoints = dbData.map(d => d.paid_total);
    const unpaidPoints = dbData.map(d => d.unpaid_total);

    const ctx = document.getElementById('financeChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar', 
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Paid Received',
                    data: paidPoints,
                    backgroundColor: '#2ecc71', // Green
                    borderRadius: 5
                },
                {
                    label: 'Unpaid/Pending',
                    data: unpaidPoints,
                    backgroundColor: '#e74c3c', // Red
                    borderRadius: 5
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                x: { stacked: true },
                y: { 
                    stacked: true,
                    beginAtZero: true,
                    title: { display: true, text: 'Amount ($)' }
                }
            },
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
}

loadChart();
</script>
</body>
</html>