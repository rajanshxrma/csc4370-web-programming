<?php
// mission 3: charlie bit my finger and scope

function isBitten() {
    return rand(0, 1) === 1;
}

function winnerMessage($name) {
    return "The winner is: " . $name;
}

$bitten = isBitten();
$winner = "Charlie";
$msg = winnerMessage($winner);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mission 3: Charlie Bit My Finger</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Mission 3: isBitten() and winnerMessage($name)</h1>
    <p>rajan sharma - csc 4370 | <a href="index.php">back to index</a></p>
</header>

<main>
    <div class="card">
        <h2>isBitten() Result (refresh page to test rand)</h2>
        <div class="result">
            <?php if ($bitten): ?>
                Charlie bit your finger!
            <?php else: ?>
                Charlie did not bite your finger!
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <h2>winnerMessage($name) Scope Demo</h2>
        <div class="result">
            <?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?>
        </div>
        <p>
            $winner is set to "Charlie" in the outer script and passed into winnerMessage($winner) as a parameter instead of using global $winner inside the function.
        </p>
    </div>
</main>
</body>
</html>
