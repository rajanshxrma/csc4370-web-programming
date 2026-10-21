<?php
$matrix = array(
    array(1, 2, 3),
    array(4, 5, 6),
    array(7, 8, 9)
);
$original = $matrix;

// TODO 2: Save the three original coordinate values for the readout.
$topLeft = $matrix[0][0];
$center = $matrix[1][1];
$bottomRight = $matrix[2][2];

// TODO 3: Modify [1][2] and [2][1], then save $modified.
$matrix[1][2] = 10;
$matrix[2][1] = 15;
$modified = $matrix; // Move this snapshot below your two assignments.

// TODO 4: Append 11 to row 2, then append [10, 11, 12, 13].
$matrix[2][] = 11;
$matrix[] = array(10, 11, 12, 13);

// TODO 5: Calculate row count, each row length, and total numeric cells.
$rowCount = count($matrix);
$rowLengths = array();
$totalCells = 0;
$maxVal = $matrix[0][0];
foreach ($matrix as $rIdx => $row) {
    $len = count($row);
    $rowLengths[$rIdx] = $len;
    $totalCells += $len;
    foreach ($row as $cell) {
        if ($cell > $maxVal) {
            $maxVal = $cell;
        }
    }
}

function renderMatrix(array $rows, string $caption, array $compare = array()): void
{
    echo "<table><caption>" . htmlspecialchars($caption, ENT_QUOTES, 'UTF-8') . "</caption><tbody>";
    // TODO 6: Nested foreach loops; one tr per row, one td per integer.
    foreach ($rows as $r => $row) {
        echo "<tr>";
        foreach ($row as $c => $cell) {
            $changed = (!empty($compare) && (!isset($compare[$r][$c]) || $compare[$r][$c] !== $cell));
            $class = $changed ? ' class="changed"' : '';
            echo "<td$class>$cell</td>";
        }
        echo "</tr>";
    }
    echo "</tbody></table>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrix Mayhem | PHP Dashboard</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #eef3fa; color: #17243a; font: 16px/1.6 system-ui, sans-serif; }
        header, main { max-width: 1240px; margin: auto; padding: 28px; }
        header h1 { margin-bottom: 8px; }
        main { display: grid; grid-template-columns: minmax(0, 2fr) minmax(280px, 1fr); gap: 24px; align-items: start; }
        section, aside { background: #fff; border: 1px solid #cbd8ec; border-radius: 14px; padding: 24px; }
        .matrix-wrap { overflow-x: auto; }
        table { border-collapse: collapse; margin-bottom: 28px; }
        caption { text-align: left; font-weight: 700; padding: 10px 0; }
        td { padding: 14px 20px; border: 1px solid #b5c7e2; text-align: center; }
        td.changed { border: 3px double #2459d4; background: #eef4ff; font-weight: 700; }
        .stat { background: #e8eff9; border-left: 4px solid #2459d4; padding: 14px; margin: 12px 0; }
    </style>
</head>
<body>
    <header>
        <h1>Matrix Mayhem: control room</h1>
        <p>student: rajan sharma | csc 4370</p>
        <p>Due: <time datetime="2026-10-21T16:15:00-04:00">October 21, 2026 at 4:15 p.m. EDT</time></p>
    </header>
    <main>
        <section>
            <h2>Matrix evolution</h2>
            <div class="matrix-wrap">
                <?php
                renderMatrix($original, 'Original / 3 x 3');
                renderMatrix($modified, 'Modified / two values changed', $original);
                renderMatrix($matrix, 'Expanded / final state', $original);
                ?>
            </div>
        </section>
        <aside>
            <h2>Array telemetry</h2>
            <div class="stat">
                <strong>Coordinate readout:</strong><br>
                Element at [0][0]: <?= $topLeft ?><br>
                Element at [1][1]: <?= $center ?><br>
                Element at [2][2]: <?= $bottomRight ?>
            </div>
            <div class="stat">
                <strong>Dimensions &amp; Counts:</strong><br>
                Number of rows: <?= $rowCount ?><br>
                <?php foreach ($rowLengths as $idx => $len): ?>
                    Elements in row <?= $idx ?>: <?= $len ?><br>
                <?php endforeach; ?>
                Total numeric cells: <?= $totalCells ?><br>
                Maximum value: <?= $maxVal ?>
            </div>
            <p>
                why final rows have different lengths: we pushed a fourth number (11) onto the end of row index 2 using $matrix[2][] = 11, and then added a new fourth row with four numbers (10, 11, 12, 13). rows 0 and 1 were not changed so they stay at 3 items while rows 2 and 3 have 4 items. also count($matrix) gives 4 because it only counts how many row arrays are inside $matrix, not all 14 numbers.
            </p>
        </aside>
    </main>
</body>
</html>
