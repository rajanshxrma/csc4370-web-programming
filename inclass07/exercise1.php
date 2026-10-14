<?php
// mission 1: eligibility checker

function isEligible($age = 18) {
    return $age >= 18;
}

$tests = [
    ['label' => 'isEligible(17)', 'result' => isEligible(17)],
    ['label' => 'isEligible(18)', 'result' => isEligible(18)],
    ['label' => 'isEligible(21)', 'result' => isEligible(21)],
    ['label' => 'isEligible() [default 18]', 'result' => isEligible()],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mission 1: Eligibility Checker</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Mission 1: isEligible($age = 18)</h1>
    <p>rajan sharma - csc 4370 | <a href="index.php">back to index</a></p>
</header>

<main>
    <div class="card">
        <h2>Test Results</h2>
        <?php foreach ($tests as $test): ?>
            <div class="result">
                <?= htmlspecialchars($test['label'], ENT_QUOTES, 'UTF-8') ?> :
                <?php if ($test['result']): ?>
                    true (Eligible)
                <?php else: ?>
                    false (Not eligible)
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</main>
</body>
</html>
