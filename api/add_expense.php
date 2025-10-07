<?php
header("Content-Type: application/json");
include 'db_oracle.php';

// Read JSON data from frontend
$data = json_decode(file_get_contents("php://input"), true);

$category_id = $data['category_id'];
$amount = $data['amount'];
$date_ = $data['date'];
$note = $data['note'];

// Insert to Oracle
$sql = "INSERT INTO expenses (category_id, amount, date_, note)
        VALUES (:cat, :amt, TO_DATE(:dt, 'YYYY-MM-DD'), :nt)";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':cat', $category_id);
oci_bind_by_name($stmt, ':amt', $amount);
oci_bind_by_name($stmt, ':dt', $date_);
oci_bind_by_name($stmt, ':nt', $note);

if (oci_execute($stmt, OCI_COMMIT_ON_SUCCESS)) {
  echo json_encode(["message" => "Expense added successfully"]);
} else {
  $e = oci_error($stmt);
  echo json_encode(["error" => $e['message']]);
}

oci_free_statement($stmt);
oci_close($conn);
?>
