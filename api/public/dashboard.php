<?php
// Include database
include '../api/db_sqlite.php';

// Get total expenses
$totalStmt = $db->query("SELECT SUM(amount) as total FROM expenses");
$totalExpense = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

// Example target savings and remaining budget
$targetSaving = 50000;
$currentSaving = max(0, $targetSaving - $totalExpense);
$remainingBudget = 100000 - $totalExpense;

// Fetch recent expenses
$expenses = $db->query("SELECT * FROM expenses ORDER BY date DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | Personal Finance Manager</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

  <!-- Navbar -->
  <nav class="bg-orange-600 text-white p-4 shadow-lg">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-2xl font-semibold">💰 Personal Finance Manager</h1>
      <div>
        <a href="#" class="px-3 hover:underline">Dashboard</a>
        <a href="add_expense.html" class="px-3 hover:underline">Add Expense</a>
        <a href="reports.html" class="px-3 hover:underline">Reports</a>
      </div>
    </div>
  </nav>

  <!-- Dashboard Content -->
  <div class="container mx-auto p-6">

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

      <div class="bg-white rounded-2xl shadow-md p-6 text-center">
        <h2 class="text-lg font-semibold text-gray-600">Total Expenses</h2>
        <p class="text-3xl font-bold text-red-500 mt-2">Rs. <?= number_format($totalExpense, 2) ?></p>
      </div>

      <div class="bg-white rounded-2xl shadow-md p-6 text-center">
        <h2 class="text-lg font-semibold text-gray-600">Target Savings</h2>
        <p class="text-3xl font-bold text-orange-500 mt-2">Rs. <?= number_format($targetSaving, 2) ?></p>
      </div>

      <div class="bg-white rounded-2xl shadow-md p-6 text-center">
        <h2 class="text-lg font-semibold text-gray-600">Remaining Budget</h2>
        <p class="text-3xl font-bold text-green-600 mt-2">Rs. <?= number_format($remainingBudget, 2) ?></p>
      </div>

    </div>

    <!-- Recent Expenses Table -->
    <div class="bg-white rounded-2xl shadow-md p-6">
      <h2 class="text-xl font-semibold mb-4 text-gray-700">Recent Expenses</h2>

      <?php if (count($expenses) > 0): ?>
      <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border border-gray-200">
          <thead class="bg-orange-100">
            <tr>
              <th class="border border-gray-200 px-4 py-2 text-left">Category</th>
              <th class="border border-gray-200 px-4 py-2 text-left">Amount (Rs.)</th>
              <th class="border border-gray-200 px-4 py-2 text-left">Date</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($expenses as $row): ?>
              <tr class="hover:bg-gray-50">
                <td class="border border-gray-200 px-4 py-2"><?= htmlspecialchars($row['category']) ?></td>
                <td class="border border-gray-200 px-4 py-2 text-red-600 font-medium"><?= number_format($row['amount'], 2) ?></td>
                <td class="border border-gray-200 px-4 py-2"><?= htmlspecialchars($row['date']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
        <p class="text-gray-500 text-center py-4">No expenses recorded yet.</p>
      <?php endif; ?>
    </div>

  </div>

  <!-- Footer -->
  <footer class="bg-gray-800 text-gray-300 text-center py-4 mt-8">
    <p>© <?= date('Y') ?> Personal Finance Manager. All rights reserved.</p>
  </footer>

</body>
</html>
