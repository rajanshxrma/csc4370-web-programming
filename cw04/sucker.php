<?php
// Reject any request method other than POST immediately with 405
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    exit('<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>405 Method Not Allowed</title>
    <link href="buyagrade.css" rel="stylesheet">
</head>
<body>
    <h1>Method Not Allowed</h1>
    <p>Please use the <a href="buyagrade.html">practice form</a> to submit data.</p>
</body>
</html>');
}

// Exercise 5: Server-side validation before writing to storage
$values = [];
foreach (['name', 'section', 'cardnumber', 'cardtype'] as $field) {
    $raw = $_POST[$field] ?? null;
    // Check presence, string type, non-empty after trim, and no delimiter injection
    if (!is_string($raw) || trim($raw) === '' || strpbrk($raw, ";\r\n") !== false) {
        http_response_code(400);
        exit('<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Incomplete Submission</title>
    <link href="buyagrade.css" rel="stylesheet">
</head>
<body>
    <h1>Sorry</h1>
    <p>You did not fill out the form completely. All fields are required and cannot contain semicolons or line breaks. <a href="buyagrade.html">Try again?</a></p>
</body>
</html>');
    }
    $values[$field] = trim($raw);
}

// Validate section code against allowed list, cardtype, and 16-digit card number rule
$allowed_sections = ['MA', 'MB', 'MC', 'MD', 'ME', 'MF', 'MG', 'MH'];
$allowed_cardtypes = ['visa', 'mastercard'];

if (!in_array($values['section'], $allowed_sections, true)
    || !in_array($values['cardtype'], $allowed_cardtypes, true)
    || preg_match('/\A[0-9]{16}\z/', $values['cardnumber']) !== 1) {
    http_response_code(400);
    exit('<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invalid Submission</title>
    <link href="buyagrade.css" rel="stylesheet">
</head>
<body>
    <h1>Sorry</h1>
    <p>You did not provide a valid section, card type, or 16-digit card number. Please choose a listed section and card type, and enter 16 practice digits. <a href="buyagrade.html">Try again?</a></p>
</body>
</html>');
}

// Exercise 4: Persistence with explicit error handling and locking
$path = __DIR__ . '/suckers.html';
$line = implode(';', [
    $values['name'],
    $values['section'],
    $values['cardnumber'],
    $values['cardtype']
]) . PHP_EOL;

$written = file_put_contents($path, $line, FILE_APPEND | LOCK_EX);
if ($written === false || $written !== strlen($line)) {
    error_log('Lab record append failed or was incomplete.');
    http_response_code(500);
    exit('<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Storage Error</title>
    <link href="buyagrade.css" rel="stylesheet">
</head>
<body>
    <h1>Server Error</h1>
    <p>The record could not be saved completely. Ask your instructor to check storage before retrying.</p>
</body>
</html>');
}

$all = file_get_contents($path);
if ($all === false) {
    error_log('Lab record read failed after a successful append.');
    http_response_code(500);
    exit('<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Read Error</title>
    <link href="buyagrade.css" rel="stylesheet">
</head>
<body>
    <h1>Server Error</h1>
    <p>Your record was saved, but the records could not be displayed. Do not resubmit.</p>
</body>
</html>');
}

// Exercise 3: HTML Rendering with escaping
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Your Way to a Better Education!</title>
    <link href="buyagrade.css" type="text/css" rel="stylesheet">
</head>
<body>
    <h1>Thanks, sucker!</h1>

    <p>Your information has been recorded.</p>

    <dl>
        <dt>Name</dt>
        <dd><?= htmlspecialchars($values['name'], ENT_QUOTES, 'UTF-8') ?></dd>

        <dt>Section</dt>
        <dd><?= htmlspecialchars($values['section'], ENT_QUOTES, 'UTF-8') ?></dd>

        <dt>Credit Card</dt>
        <dd><?= htmlspecialchars($values['cardnumber'], ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars($values['cardtype'], ENT_QUOTES, 'UTF-8') ?>)</dd>
    </dl>

    <h2>Here are all the suckers who have submitted here:</h2>
    <pre><?= htmlspecialchars($all, ENT_QUOTES, 'UTF-8') ?></pre>
</body>
</html>
