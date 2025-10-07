<?php
// api/db_oracle.php
$conn = oci_connect('finance_app', 'mypassword', 'localhost/XEPDB1');

if (!$conn) {
  $e = oci_error();
  die("❌ Connection failed: " . $e['message']);
}
?>
