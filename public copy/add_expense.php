<?php
require_once __DIR__ . '/../includes/db.php';

$categories = $pdo->query('SELECT id, name FROM categories ORDER BY id')->fetchAll();
$validIds   = array_column($categories, 'id');

$error       = '';
$description = '';
$amount      = '';
$categoryId  = '';
$date        = date('Y-m-d');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = trim($_POST['description'] ?? '');
    $amount      = trim($_POST['amount'] ?? '');
    $categoryId  = $_POST['category_id'] ?? '';
    $date        = trim($_POST['expense_date'] ?? '');

    $d = DateTime::createFromFormat('Y-m-d', $date);

    if ($description === '') {
        $error = 'Description cannot be empty.';
    } elseif (!is_numeric($amount) || (float)$amount <= 0) {
        $error = 'Amount must be a number greater than zero.';
    } elseif (!in_array((int)$categoryId, array_map('intval', $validIds), true)) {
        $error = 'Please select a category.';
    } elseif (!$d || $d->format('Y-m-d') !== $date) {
        $error = 'Please enter a valid date (yyyy-mm-dd).';
    } else {
        $stmt = $pdo->prepare(
            'INSERT INTO expenses (description, amount, category_id, expense_date)
             VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([$description, $amount, (int)$categoryId, $date]);
        header('Location: index.php');
        exit;
    }
}

$pageTitle = 'Add Expense';
include __DIR__ . '/../includes/header.php';
?>
<h1 class="mb-4">Add Expense</h1>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post" id="expense-form" novalidate class="form-narrow">
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <input type="text" class="form-control" id="description" name="description"
               placeholder="e.g. Lunch" value="<?= htmlspecialchars($description) ?>">
    </div>
    <div class="mb-3">
        <label for="amount" class="form-label">Amount</label>
        <input type="text" inputmode="decimal" class="form-control" id="amount" name="amount"
               placeholder="0.00" value="<?= htmlspecialchars($amount) ?>">
    </div>
    <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <select class="form-select" id="category_id" name="category_id">
            <option value="">Select a category</option>
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['id'] ?>" <?= (string)$c['id'] === (string)$categoryId ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="expense_date" class="form-label">Date</label>
        <input type="text" class="form-control" id="expense_date" name="expense_date"
               placeholder="yyyy-mm-dd" value="<?= htmlspecialchars($date) ?>">
    </div>
    <button type="submit" class="btn btn-primary">Save Expense</button>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>
