<?php
require_once __DIR__ . '/../includes/db.php';

$expenses = $pdo->query(
    'SELECT e.expense_date, e.description, c.name AS category, e.amount
     FROM expenses e
     JOIN categories c ON c.id = e.category_id
     ORDER BY e.expense_date DESC, e.id DESC'
)->fetchAll();

$total = 0;
foreach ($expenses as $row) {
    $total += $row['amount'];
}

$pageTitle = 'Expenses';
include __DIR__ . '/../includes/header.php';
?>
<h1 class="mb-4">Expenses</h1>

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Date</th>
            <th>Description</th>
            <th>Category</th>
            <th class="text-end">Amount</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!$expenses): ?>
        <tr><td colspan="4" class="text-center text-muted">No expenses yet.</td></tr>
    <?php endif; ?>
    <?php foreach ($expenses as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['expense_date']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= htmlspecialchars($row['category']) ?></td>
            <td class="text-end"><?= number_format($row['amount'], 2) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<p class="fs-5 fw-bold text-end">Total: <?= number_format($total, 2) ?></p>
<?php include __DIR__ . '/../includes/footer.php'; ?>
