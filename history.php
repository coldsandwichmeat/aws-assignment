<?php
require_once 'database.php';
include 'header.php';

$recent_bookings = $conn->query("SELECT b.booking_reference, b.passenger_name, b.tickets_booked, b.total_price, b.booking_date, r.route_name FROM bookings b JOIN routes r ON b.route_id = r.id ORDER BY b.id DESC LIMIT 10");
?>

<div class="card p-4">
    <h4 class="mb-4 fw-bold">Recent Bookings History</h4>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr><th>Reference</th><th>Passenger</th><th>Route</th><th>Tickets</th><th>Total</th><th>Date</th></tr>
            </thead>
            <tbody>
                <?php if ($recent_bookings && $recent_bookings->num_rows > 0): ?>
                    <?php while($b = $recent_bookings->fetch_assoc()): ?>
                    <tr>
                        <td><code><?php echo htmlspecialchars($b['booking_reference']); ?></code></td>
                        <td class="fw-semibold"><?php echo htmlspecialchars($b['passenger_name']); ?></td>
                        <td><?php echo htmlspecialchars($b['route_name']); ?></td>
                        <td><?php echo htmlspecialchars($b['tickets_booked']); ?></td>
                        <td class="text-success fw-medium">RM<?php echo number_format($b['total_price'], 2); ?></td>
                        <td class="text-secondary small"><?php echo htmlspecialchars($b['booking_date']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center text-secondary py-4">No recent bookings found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>