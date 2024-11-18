<?php
require_once '../partials/head.php';
require_once '../partials/navbar.php';
function convertExcelCellToNumeric($cell)
{
    // FORMAT CHECK
    if (!preg_match('/^([A-Z]+)(\d+)$/', $cell, $matches)) {
        return 'Błąd: Nieprawidłowy format komórki';
    }

    $column = $matches[1];
    $row = $matches[2];

    // COLUMN TO NUMBER
    $columnNumber = 0;
    $length = strlen($column);

    for ($i = 0; $i < $length; $i++) {
        $columnNumber *= 26;
        $columnNumber += ord($column[$i]) - ord('A') + 1;
    }

    // RETURN
    return $columnNumber . '.' . $row;
}

echo convertExcelCellToNumeric('AA2234');
?>

<main> <?php echo convertExcelCellToNumeric('AA22'); ?> </main>

<?php require_once '../partials/footer.php'; ?>
