<?php
include 'classes/database.php'; // Database connection file

$con = new Database();

$transactions = $con->exportPayments();
if (empty($transactions)) {
    die("No transactions found to export");
}

$filename = "payments_" . date('YmdHis') . ".csv";

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$output = fopen('php://output', 'w'); // Open output stream

// Set column headers
fputcsv($output, ['#', 'First Name', 'Last Name', 'Service Name', 'Payment Method','Date', 'Time', 'Total Payment', 'username']);

$rowNum = 1;
foreach ($transactions as $transaction) {
    // Format the date in a more universally recognized format (ISO 8601)
    $formattedDate = date('Y-m-d', strtotime($transaction['date']));
    fputcsv($output, [
        $rowNum,
        ucwords($transaction['first_name']),
        ucwords($transaction['last_name']),
        ucwords($transaction['service_name']),
        ucwords($transaction['payment_method']),
        $formattedDate,
        ucwords($transaction['time']),
        'PHP ' . number_format($transaction['service_price'], 2),
        ucwords($transaction['username'])
    ]);
    $rowNum++;
}

fclose($output); // Close output stream
exit;