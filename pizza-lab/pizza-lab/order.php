<?php
declare(strict_types=1);

date_default_timezone_set('America/New_York');
header('Content-Type: text/html; charset=UTF-8');

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$errors = [];
$clean = [];
$practiceComplete = true; // TODO E: done, B-D are finished below.

// The menu lives here in PHP. Prices are never read from the form.
$menu = [
    'sizes'    => ['small' => 8, 'medium' => 10, 'large' => 12],
    'crusts'   => ['thin', 'thick'],
    'toppings' => ['mushroom', 'olive', 'pineapple'],
];
$size = null;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    $errors[] = 'Open order.html and submit the form using POST.';
} else {
    // customer: one string, 1-40 bytes after trimming
    $customer = $_POST['customer'] ?? null;
    if (!is_string($customer) || trim($customer) === ''
        || strlen(trim($customer)) > 40) {
        $errors[] = 'Enter one chef name of 1-40 bytes.';
    } else {
        $clean['customer'] = trim($customer);
    }

    // size: exactly one of the menu sizes
    $size = $_POST['size'] ?? null;
    if (!is_string($size) || !array_key_exists($size, $menu['sizes'])) {
        $errors[] = 'Choose small, medium, or large.';
        $size = null;
    } else {
        $clean['size'] = ucfirst($size);
    }

    // crust (extra slice): a missing key falls back to thin, an unknown crust is rejected
    $crust = $_POST['crust'] ?? 'thin';
    if (!is_string($crust) || !in_array($crust, $menu['crusts'], true)) {
        $errors[] = 'Choose a thin or thick crust.';
    } else {
        $clean['crust'] = ucfirst($crust);
    }

    // TODO B: quantity, one whole number from 1 to 5 (an array or 2.5 or 0 fails here)
    $quantity = $_POST['quantity'] ?? null;
    if (!is_string($quantity)) {
        $errors[] = 'Quantity must be one whole number from 1 to 5.';
    } else {
        $number = filter_var($quantity, FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1, 'max_range' => 5]]);
        if ($number === false) {
            $errors[] = 'Quantity must be one whole number from 1 to 5.';
        } else {
            $clean['quantity'] = $number;
        }
    }

    // TODO C: toppings, an optional list. Unchecked boxes never arrive, so a missing key means [].
    $toppings = $_POST['toppings'] ?? [];
    if (!is_array($toppings) || count($toppings) > count($menu['toppings'])) {
        $errors[] = 'Toppings must be a list of up to three menu choices.';
    } else {
        $cleanToppings = [];
        foreach ($toppings as $topping) {
            if (!is_string($topping) || !in_array($topping, $menu['toppings'], true)) {
                $errors[] = 'Choose only toppings offered on the menu.';
                break;
            }
            $cleanToppings[] = $topping;
        }
        if (count($cleanToppings) === count($toppings)) {
            $clean['toppings'] = array_values(array_unique($cleanToppings));
        }
    }

    // TODO D: notes, optional, one string of at most 200 bytes after trimming
    $notes = $_POST['notes'] ?? '';
    if (!is_string($notes) || strlen(trim($notes)) > 200) {
        $errors[] = 'Kitchen note must be one text value of at most 200 bytes.';
    } else {
        $clean['notes'] = trim($notes);
    }

    if (!$practiceComplete) {
        $errors[] = 'Learning checkpoint: finish TODOs B-D, then enable TODO E.';
    } elseif ($errors === []) {
        foreach (['customer', 'size', 'crust', 'quantity', 'toppings', 'notes'] as $key) {
            if (!array_key_exists($key, $clean)) {
                $errors[] = 'Finish the PHP processing block for: ' . $key;
            }
        }
    }
    if ($errors === [] && $size !== null) {
        // practice total: PHP price list x validated quantity
        $clean['total'] = $menu['sizes'][$size] * $clean['quantity'];
    }
    if ($errors !== []) {
        http_response_code(422);
    }
}

$receivedKeys = $_POST === [] ? 'none' : implode(', ', array_map('strval', array_keys($_POST)));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Campus Crust | Practice ticket</title>
  <style>
    body { font: 16px/1.6 system-ui, sans-serif; max-width: 650px; margin: 30px auto; padding: 20px; background: #faf5e9; color: #352b22; }
    main { background: white; padding: 24px; border: 1px solid #ddcfb5; border-radius: 12px; }
    li { margin: 10px 0; overflow-wrap: anywhere; }
    .errors { color: #932d22; }
    .meta { color: #65594a; font-size: 0.85em; border-top: 1px solid #ddcfb5; padding-top: 12px; margin-top: 20px; }
    a { color: #a53d23; }
    :focus-visible { outline: 3px solid #1d6fa5; outline-offset: 2px; }
  </style>
</head>
<body>
<main>
<?php if ($errors !== []): ?>
  <h1>Almost ready, Chef!</h1>
  <div role="alert">
    <ul class="errors">
      <?php foreach ($errors as $error): ?>
        <li><?= e($error) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php else: ?>
  <h1>Nice work, Chef <?= e($clean['customer']) ?>.</h1>
  <h2>Your practice ticket</h2>
  <ul>
  <?php
  $labels = [
      'customer' => 'Chef name',
      'size' => 'Pizza size',
      'crust' => 'Crust',
      'quantity' => 'Quantity',
      'toppings' => 'Toppings',
      'notes' => 'Kitchen note',
      'total' => 'Practice total'
  ];
  foreach ($labels as $key => $label):
      $value = $clean[$key];
      if ($key === 'toppings') {
          $value = $value === [] ? 'Plain cheese' : implode(', ', $value);
      } elseif ($key === 'notes' && $value === '') {
          $value = 'No special requests';
      } elseif ($key === 'total') {
          $value = sprintf('$%d (%d x $%d %s)', $value, $clean['quantity'], $menu['sizes'][$size], $size);
      }
  ?>
    <li><strong><?= e($label) ?>:</strong> <?= e((string) $value) ?></li>
  <?php endforeach; ?>
  </ul>
  <p>Practice complete. No order was saved, purchased, or sent to a kitchen.</p>
<?php endif; ?>
  <p><a href="order.html">Back to the pizza form</a></p>
  <p class="meta">Generated by order.php (PHP <?= e(PHP_VERSION) ?>) on <?= e($_SERVER['SERVER_NAME'] ?? 'this server') ?><?= e($_SERVER['SCRIPT_NAME'] ?? '') ?><br>
  <?= e(date('D, j M Y g:i A T')) ?> &middot; <?= e($_SERVER['REQUEST_METHOD']) ?> request &middot; fields received: <?= e($receivedKeys) ?></p>
</main>
</body>
</html>
