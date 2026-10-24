
<?php
require_once __DIR__ . '/../includes/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $amount = $_POST['amount'] ?? '';
    $categoryId = $_POST['category_id'] ?? '';
    $date = $_POST['expense_date'] ?? '';

    if ($title === '' || !is_numeric($amount) || (float)$amount <= 0) {
        $message = 'يرجى إدخال اسم ومبلغ صحيح للمصروف.';
    } elseif (!filter_var($categoryId, FILTER_VALIDATE_INT) || $categoryId < 1) {
        $message = 'يرجى اختيار فئة صحيحة.';
    } else {
        $check = $pdo->prepare('SELECT id FROM categories WHERE id = ?');
        $check->execute([$categoryId]);

        if (!$check->fetch()) {
            $message = 'الفئة المختارة غير موجودة.';
        } elseif (!DateTime::createFromFormat('!Y-m-d', $date) ||
            DateTime::createFromFormat('!Y-m-d', $date)->format('Y-m-d') !== $date) {
            $message = 'يرجى اختيار تاريخ صحيح.';
        } else {
            $stmt = $pdo->prepare(
                'INSERT INTO expenses (title, amount, category_id, expense_date)
                 VALUES (?, ?, ?, ?)'
            );
            $stmt->execute([$title, $amount, $categoryId, $date]);
            header('Location: summary.php');
            exit;
        }
    }
}

$categories = $pdo->query('SELECT id, name FROM categories ORDER BY name')
                  ->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>إضافة مصروف</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <main>
        <h1>إضافة مصروف جديد</h1>

        <?php if ($message !== ''): ?>
            <p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <form method="post">
            <label for="title">اسم المصروف:</label>
            <input id="title" name="title" type="text" required>

            <label for="amount">المبلغ:</label>
            <input id="amount" name="amount" type="number"
                   min="0.01" step="0.01" required>

            <label for="category_id">الفئة:</label>
            <select id="category_id" name="category_id" required>
                <option value="">اختاري الفئة</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= (int)$category['id'] ?>">
                        <?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="expense_date">التاريخ:</label>
            <input id="expense_date" name="expense_date"
                   type="date" required
                   value="<?= date('Y-m-d') ?>">

            <button type="submit">حفظ المصروف</button>
        </form>

        <p><a href="summary.php">عرض ملخص المصروفات</a></p>
        <script src="assets/js/main.js"></script>
    </main>

</body>
</html>
