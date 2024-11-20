<?php
declare(strict_types=1);

require_once '../../partials/head.php';
require_once '../../partials/body.php';

class Calendar
{
    private array $polishMonths = [
        'January' => 'Styczeń',
        'February' => 'Luty',
        'March' => 'Marzec',
        'April' => 'Kwiecień',
        'May' => 'Maj',
        'June' => 'Czerwiec',
        'July' => 'Lipiec',
        'August' => 'Sierpień',
        'September' => 'Wrzesień',
        'October' => 'Październik',
        'November' => 'Listopad',
        'December' => 'Grudzień',
    ];

    private array $monthsMap = [
        'styczeń' => 1,
        'luty' => 2,
        'marzec' => 3,
        'kwiecień' => 4,
        'maj' => 5,
        'czerwiec' => 6,
        'lipiec' => 7,
        'sierpień' => 8,
        'wrzesień' => 9,
        'październik' => 10,
        'listopad' => 11,
        'grudzień' => 12,
    ];

    private array $weekDays = ['Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'So', 'N'];

    private function validateDate(int $month, int $year): void
    {
        if (!checkdate($month, 1, $year)) {
            throw new InvalidArgumentException('Nieprawidłowa data');
        }
    }

    private function getMonthNumber(string|int $month): int
    {
        if (is_numeric($month)) {
            return (int) $month;
        }

        $monthLower = mb_strtolower($month);
        if (!isset($this->monthsMap[$monthLower])) {
            throw new InvalidArgumentException('Nieprawidłowa nazwa miesiąca');
        }

        return $this->monthsMap[$monthLower];
    }

    private function getMonthData(int $month, int $year): array
    {
        $timestamp = mktime(0, 0, 0, $month, 1, $year);
        return [
            'monthLength' => (int) date('t', $timestamp),
            'firstDayNumber' => (((int) date('N', $timestamp) + 6) % 7) + 1,
            'monthName' => $this->polishMonths[date('F', $timestamp)],
        ];
    }

    private function generateHeader(string $monthName, int $year): string
    {
        return sprintf('<h2 class="text-center mb-4">%s %d</h2>', htmlspecialchars($monthName), $year);
    }

    private function generateTableHeader(): string
    {
        $header = '<thead><tr>';
        foreach ($this->weekDays as $day) {
            $class = $day === 'N' ? 'text-red-600' : '';
            $header .= sprintf('<th class="p-4 %s">%s</th>', $class, htmlspecialchars($day));
        }
        return $header . '</tr></thead>';
    }

    private function generateCalendarBody(int $monthLength, int $firstDayNumber): string
    {
        $html = '<tbody><tr>';

        for ($i = 1; $i < $firstDayNumber; $i++) {
            $html .= '<td class="p-4">&nbsp;</td>';
        }

        $dayOfWeek = $firstDayNumber - 1;
        for ($day = 1; $day <= $monthLength; $day++) {
            if ($dayOfWeek === 7) {
                $html .= '</tr><tr>';
                $dayOfWeek = 0;
            }

            $class = $dayOfWeek === 6 ? 'text-red-600' : '';
            $html .= sprintf('<td class="p-4 %s">%d</td>', $class, $day);
            $dayOfWeek++;
        }

        while ($dayOfWeek < 7 && $dayOfWeek > 0) {
            $html .= '<td class="p-4">&nbsp;</td>';
            $dayOfWeek++;
        }

        return $html . '</tr></tbody>';
    }

    public function render(string|int $month, int $year): string
    {
        $monthNumber = $this->getMonthNumber($month);
        $this->validateDate($monthNumber, $year);
        $monthData = $this->getMonthData($monthNumber, $year);

        return sprintf(
            '<div>%s<table class="w-full border-collapse">%s%s</table></div>',
            $this->generateHeader(strval($monthData['monthName']), $year),
            $this->generateTableHeader(),
            $this->generateCalendarBody($monthData['monthLength'], $monthData['firstDayNumber']),
        );
    }
}

$calendar = new Calendar();
?>

    <main class="text-2xl h-screen flex items-center justify-center">
        <?php echo $calendar->render('grudzień', 2024); ?>
    </main>

<?php require_once '../../partials/footer.php'; ?>
