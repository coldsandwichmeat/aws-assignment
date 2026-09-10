<?php
require_once 'database.php';
require_once 'functions.php';
include 'header.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $route_id = intval($_POST['route_id']);
    $passenger_name = sanitizeInput($conn, $_POST['passenger_name']);
    $passenger_email = sanitizeInput($conn, $_POST['passenger_email']);
    $tickets_booked = intval($_POST['tickets_booked']);

    if ($route_id > 0 && !empty($passenger_name) && !empty($passenger_email) && $tickets_booked > 0) {
        $stmt = $conn->prepare("SELECT price, available_seats FROM routes WHERE id = ?");
        $stmt->bind_param("i", $route_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($route = $result->fetch_assoc()) {
            if ($route['available_seats'] >= $tickets_booked) {
                $total_price = $route['price'] * $tickets_booked;
                $booking_ref = generateBookingReference();

                $conn->begin_transaction();
                try {
                    $ins = $conn->prepare("INSERT INTO bookings (booking_reference, route_id, passenger_name, passenger_email, tickets_booked, total_price) VALUES (?, ?, ?, ?, ?, ?)");
                    $ins->bind_param("sissid", $booking_ref, $route_id, $passenger_name, $passenger_email, $tickets_booked, $total_price);
                    $ins->execute();

                    $upd = $conn->prepare("UPDATE routes SET available_seats = available_seats - ? WHERE id = ?");
                    $upd->bind_param("ii", $tickets_booked, $route_id);
                    $upd->execute();

                    $conn->commit();
                    $message = "Booking Successful! Your Reference Code: <strong>{$booking_ref}</strong>";
                    $message_type = "success";
                } catch (Exception $e) {
                    $conn->rollback();
                    $message = "Transaction failed. Please try again.";
                    $message_type = "danger";
                }
            } else {
                $message = "Insufficient seats available for this route.";
                $message_type = "warning";
            }
        }
    } else {
        $message = "Please fill in all required fields accurately.";
        $message_type = "warning";
    }
}

$routes_result = $conn->query("SELECT * FROM routes ORDER BY departure_time ASC");
?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card p-4">
            <h4 class="mb-4 fw-bold">Reserve Your Shuttle Ticket</h4>
            <?php if(!empty($message)): ?>
                <div class="alert alert-<?php echo $message_type; ?>"><?php echo $message; ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Select Route</label>
                    <select name="route_id" class="form-select" required>
                        <option value="">-- Choose Route --</option>
                        <?php while($row = $routes_result->fetch_assoc()): ?>
                            <option value="<?php echo $row['id']; ?>">
                                <?php echo htmlspecialchars($row['route_name']); ?> (RM<?php echo number_format($row['price'], 2); ?>) [<?php echo $row['available_seats']; ?> seats left]
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Passenger Name</label>
                    <input type="text" name="passenger_name" class="form-control" placeholder="Full Name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Student Email</label>
                    <input type="email" name="passenger_email" class="form-control" placeholder="name@student.tarc.edu.my" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="tickets_booked" class="form-control" value="1" min="1" max="5" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">Confirm Booking</button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>