<?php
require_once 'database.php';
include 'header.php';

$routes_result = $conn->query("SELECT * FROM routes ORDER BY departure_time ASC");
?>

<div class="card p-4">
    <h4 class="mb-4 fw-bold">Complete Route & Timetable Directory</h4>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr><th>#</th><th>Route Name</th><th>Origin</th><th>Destination</th><th>Departure Time</th><th>Price</th><th>Available Seats</th></tr>
            </thead>
            <tbody>
                <?php while($row = $routes_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td class="fw-semibold"><?php echo htmlspecialchars($row['route_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['origin']); ?></td>
                    <td><?php echo htmlspecialchars($row['destination']); ?></td>
                    <td><?php echo htmlspecialchars($row['departure_time']); ?></td>
                    <td class="text-success fw-medium">RM<?php echo number_format($row['price'], 2); ?></td>
                    <td><?php echo htmlspecialchars($row['available_seats']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>