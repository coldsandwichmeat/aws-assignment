<?php
require_once 'database.php';
include 'header.php';

$routes_result = $conn->query("SELECT * FROM routes ORDER BY departure_time ASC");
$instance_id = @file_get_contents('http://169.254.169.254/latest/meta-data/instance-id') ?: 'EC2-LocalHost';
?>

<div class="p-5 mb-4 bg-white rounded-4 shadow-sm">
    <div class="container-fluid py-3">
        <h1 class="display-5 fw-bold">Welcome to TAR UMT Shuttle</h1>
        <p class="col-md-8 fs-4 text-secondary">Seamlessly manage your campus transit, check real-time available schedules, and book your tickets instantly.</p>
        <a href="book.php" class="btn btn-primary btn-lg rounded-pill px-4">Book a Ticket Now</a>
        <div class="mt-3 text-muted small">Active Hosting Instance: <strong><?php echo htmlspecialchars($instance_id); ?></strong></div>
    </div>
</div>

<div class="row g-4">
    <div class="col-12">
        <div class="card p-4">
            <h4 class="mb-3 fw-bold">Quick Route Overview</h4>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr><th>Route Name</th><th>Origin</th><th>Destination</th><th>Departure</th><th>Price</th><th>Seats Available</th></tr>
                    </thead>
                    <tbody>
                        <?php while($r = $routes_result->fetch_assoc()): ?>
                        <tr>
                            <td class="fw-semibold"><?php echo htmlspecialchars($r['route_name']); ?></td>
                            <td><?php echo htmlspecialchars($r['origin']); ?></td>
                            <td><?php echo htmlspecialchars($r['destination']); ?></td>
                            <td class="text-secondary"><?php echo htmlspecialchars($r['departure_time']); ?></td>
                            <td class="text-success fw-medium">RM<?php echo number_format($r['price'], 2); ?></td>
                            <td><span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill"><?php echo $r['available_seats']; ?> seats left</span></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>