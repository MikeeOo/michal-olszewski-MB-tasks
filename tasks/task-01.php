<?php
require_once '../partials/head.php';
require_once '../partials/navbar.php';

function generateCalendarPage($month, $year): string
{
    // HTML INPUT
    $html = '';

    // GET MONTH DATA
    $timestamp = mktime(0, 0, 0, $month, 1, $year);
    $monthLength = intval(date('t', $timestamp));
    $firstDayNumber = intval(date('N', $timestamp)); //    $weekStart = date('w', $firstDay); // from 0 -> 6
    $monthName = date('F', $timestamp);
    $polishMonths = [
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

    // MONTH & YEAR [HEADERS]
    $html .= "<h2>{$polishMonths[$monthName]}</h2>";
    $html .= "<h3>{$year}</h3>";
    $html .= '<table>';

    // DAYS OF THE WEEK [TABLE HEAD]
    $html .= '<thead>';
    $html .= '<tr>';
    $weekDays = ['Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'So', 'N'];
    foreach ($weekDays as $day) {
        $html .= "<th class='p-4'>{$day}</th>";
    }
    $html .= '</tr>';
    $html .= '</thead>';

    $html .= '<tbody>';
    // FIRST WEEK W/EMPTY CELLS
    $html .= '<tr>';
    for ($i = 1; $i < $firstDayNumber; $i++) {
        $html .= "<td class='p-4'>&nbsp;</td>";
    }

    // ADD DAYS
    for ($day = 1; $day <= $monthLength; $day++) {
        $html .= "<td class='p-4'>{$day}</td>";

        // NEW ROW IF (LAST DAY OF THE WEEK === SUNDAY)
        if (($day + $firstDayNumber - 1) % 7 == 0) {
            $html .= '</tr>';
            // IF (MORE DAYS) -> NEW ROW
            if ($day < $monthLength) {
                $html .= '<tr>';
            }
        }
    }

    // ADD EMPTY CELLS
    $lastDayNumber = ($monthLength + $firstDayNumber - 1) % 7;
    if ($lastDayNumber > 0) {
        for ($i = $lastDayNumber; $i < 7; $i++) {
            $html .= "<td class='p-4'>&nbsp;</td>";
        }
        $html .= '</tr>';
    }

    $html .= '</tbody>';
    $html .= '</table>';

    // HTML RETURN
    return $html;
}
?>

<main class="pt-24 text-2xl">
    <?php echo generateCalendarPage(2, 2024); ?>
</main>

<?php require_once '../partials/footer.php'; ?>
