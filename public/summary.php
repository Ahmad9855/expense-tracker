
<?php
require_once __DIR__ . '/../includes/db.php';

try {
    $stmt = $pdo->query("
        SELECT
            categories.name AS category_name,
            COALESCE(SUM(expenses.amount), 0) AS total
        FROM categories
        LEFT JOIN expenses
            ON categories.id = expenses.category_id
        GROUP BY categories.id, categories.name
        ORDER BY categories.name
    ");

    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalStmt = $pdo->query(
        "SELECT COALESCE(SUM(amount), 0) FROM expenses"
    );
    $grandTotal = (float) $totalStmt->fetchColumn();

    $expensesStmt = $pdo->query("
        SELECT
            expenses.title,
            expenses.amount,
            expenses.expense_date,
            categories.name AS category_name
        FROM expenses
        JOIN categories
            ON expenses.category_id = categories.id
        ORDER BY expenses.expense_date DESC, expenses.id DESC
    ");

    $expenses = $expensesStmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("حدث خطأ أثناء تحميل المصروفات.");
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ملخص المصروفات</title>
   <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<main>
    <h1>ملخص المصروفات</h1>

    <h2>
        إجمالي المصروفات:
        <?= number_format($grandTotal, 2) ?>
    </h2>

    <h2>ملخص حسب الفئة</h2>

    <?php foreach ($categories as $category): ?>
        <?php
        $amount = (float) $category['total'];
        $percentage = $grandTotal > 0
            ? ($amount / $grandTotal) * 100
            : 0;
        ?>

        <section>
            <h3>
                <?= htmlspecialchars($category['category_name'], ENT_QUOTES, 'UTF-8') ?>
            </h3>

            <p>المبلغ: <?= number_format($amount, 2) ?></p>
            <p>النسبة: <?= number_format($percentage, 1) ?>%</p>

            <progress value="<?= $percentage ?>" max="100"></progress>
        </section>
    <?php endforeach; ?>

    <h2>تفاصيل جميع المصروفات</h2>

    <?php if (count($expenses) > 0): ?>
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>اسم المصروف</th>
                    <th>المبلغ</th>
                    <th>الفئة</th>
                    <th>التاريخ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($expenses as $expense): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($expense['title'], ENT_QUOTES, 'UTF-8') ?>
                        </td>
                        <td>
                            <?= number_format((float) $expense['amount'], 2) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($expense['category_name'], ENT_QUOTES, 'UTF-8') ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($expense['expense_date'], ENT_QUOTES, 'UTF-8') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>لا توجد مصروفات مسجلة حتى الآن.</p>
    <?php endif; ?>

    <p>
        <a href="index.php">إضافة مصروف جديد</a>
    </p>
</main>
</body>
</html>
