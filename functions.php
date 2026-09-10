<?php
function generateBookingReference() {
    return 'TKT-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
}

function sanitizeInput($conn, $data) {
    return mysqli_real_escape_string($conn, trim($data));
}
?>