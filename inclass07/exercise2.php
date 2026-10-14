<?php
// mission 2: area calculator with exception handling

function calculateArea($length, $width) {
    if (!is_numeric($length) || !is_numeric($width)) {
        throw new InvalidArgumentException("Length and width must be numeric values.");
    }
    if ($length < 0 || $width < 0) {
        throw new InvalidArgumentException("Length and width cannot be negative.");
    }
    return (float)$length * (float)$width;
}

$tests = [
    ['call' => 'calculateArea(3, 4)',       'args' => [3, 4]],
    ['call' => 'calculateArea(7.4, 7.5)',   'args' => [7.4, 7.5]],
    ['call' => 'calculateArea("2.5", "4")', 'args' => ['2.5', '4']],
    ['call' => 'calculateArea(0, 4)',       'args' => [0, 4]],
    ['call' => 'calculateArea(-1, 4)',      'args' => [-1, 4]],
    ['call' => 'calculateArea("two", 4)',   'args' => ['two', 4]],
];

$results = [];
foreach ($tests as $t) {
    try {
        $val = calculateArea($t['args'][0], $t['args'][1]);
        $results[] = ['call' => $t['call'], 'ok' => true, 'value' => $val, 'msg' => ''];
    } catch (InvalidArgumentException $e) {
        $results[] = ['call' => $t['call'], 'ok' => false, 'value' => null, 'msg' => $e->getMessage()];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mission 2: Area Calculator</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Mission 2: calculateArea($length, $width)</h1>
    <p>rajan sharma - csc 4370 | <a href="index.php">back to index</a></p>
</header>

<main>
    <div class="card">
        <h2>Test Results</h2>
        <?php foreach ($results as $r): ?>
            <div class="result">
                <?= htmlspecialchars($r['call'], ENT_QUOTES, 'UTF-8') ?> :
                <?php if ($r['ok']): ?>
                    Area = <?= $r['value'] ?>
                <?php else: ?>
                    Caught InvalidArgumentException - <?= htmlspecialchars($r['msg'], ENT_QUOTES, 'UTF-8') ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</main>
</body>
</html>
