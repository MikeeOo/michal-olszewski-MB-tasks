<?php
declare(strict_types=1);

require_once '../../partials/head.php';
require_once '../../partials/body.php';

class ExcelConverter
{
    private const MAX_ROW = 1048576; // Excel maksymalna liczba wierszy
    private const MAX_COLUMN_LENGTH = 3; // Excel maksymalna długość kolumny

    public function convertCellToNumeric(string $cell): string
    {
        try {
            $this->validateCell($cell);
            [$column, $row] = $this->parseCell($cell);
            $columnNumber = $this->convertColumnToNumber($column);

            return sprintf('%d.%d', $columnNumber, $row);
        } catch (Exception $e) {
            return 'Błąd: ' . $e->getMessage();
        }
    }

    private function validateCell(string $cell): void
    {
        if (!preg_match('/^([A-Z]+)(\d+)$/', $cell)) {
            throw new Exception('Nieprawidłowy format komórki');
        }
    }

    private function parseCell(string $cell): array
    {
        preg_match('/^([A-Z]+)(\d+)$/', $cell, $matches);
        [, $column, $row] = $matches;

        if (strlen($column) > self::MAX_COLUMN_LENGTH) {
            throw new Exception('Przekroczono maksymalną długość kolumny');
        }

        if ((int) $row > self::MAX_ROW || (int) $row < 1) {
            throw new Exception('Numer wiersza poza zakresem');
        }

        return [$column, (int) $row];
    }

    private function convertColumnToNumber(string $column): int
    {
        $columnNumber = 0;
        $length = strlen($column);

        for ($i = 0; $i < $length; $i++) {
            $columnNumber = $columnNumber * 26 + (ord($column[$i]) - ord('A') + 1);
        }

        return $columnNumber;
    }
}

$converter = new ExcelConverter();
?>

    <main class="container mt-4">
        <h1>Konwerter komórek Excel</h1>
        <div>
            <p>Test AA22: <?= $converter->convertCellToNumeric('AA23') ?></p>
        </div>
    </main>

<?php require_once '../../partials/footer.php'; ?>
