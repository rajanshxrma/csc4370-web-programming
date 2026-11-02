<?php
$allowed_options = ['Chat', 'Email', 'File transfer', 'Directory', 'Shell', 'Remote control'];
$options_selected = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['options'])) {
        $raw_options = $_POST['options'];
        // T02 check 1: forged scalar instead of array
        if (!is_array($raw_options)) {
            http_response_code(400);
            exit('Error: Features must be submitted as an array. Please use the form.');
        }
        // T02 check 2: nested arrays or non-string elements
        foreach ($raw_options as $opt) {
            if (!is_string($opt)) {
                http_response_code(400);
                exit('Error: Invalid feature format received.');
            }
            // T02 check 3: unknown feature value
            if (!in_array($opt, $allowed_options, true)) {
                http_response_code(400);
                exit('Error: Unknown feature option selected: ' . htmlspecialchars($opt, ENT_QUOTES, 'UTF-8'));
            }
            $options_selected[] = $opt;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Form Data</title>
</head>
<body>

<h1>Raw Form Data</h1>
<pre>
<?php
   // Sanitized associative array for debugging: mask sensitive password
   $debug_post = $_POST;
   if (isset($debug_post['password'])) {
       $debug_post['password'] = '********';
   }
   print htmlspecialchars(print_r($debug_post, true), ENT_QUOTES, 'UTF-8');
?>
</pre>

<!-- Extract each form item from posted data -->

<h1>Form input values</h1>
<p>Your Name: <?php print htmlspecialchars($_POST["visitor_name"] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
<p>Password: <?php print isset($_POST["password"]) && $_POST["password"] !== '' ? '[hidden for security]' : '(none)'; ?></p>
<p>License accepted: <?php print isset($_POST["licenseOK"]) ? 'Yes' : 'No'; ?></p>
<p>Account type: <?php print htmlspecialchars($_POST["account_type"] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
<p>Options: <?php 
   if (empty($options_selected)) {
       print 'None';
   } else {
       print htmlspecialchars(implode(', ', $options_selected), ENT_QUOTES, 'UTF-8');
   }
?></p>
<p>Operating system: <?php print htmlspecialchars($_POST["system"] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
<p>Remarks: <?php print htmlspecialchars($_POST["remarks"] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>

<!-- Run thru all elements of the array of posted data -->

<h1>All Form Data</h1>

<?php
    foreach ($_POST as $key => $val) {
        $clean_key = htmlspecialchars((string)$key, ENT_QUOTES, 'UTF-8');
        if ($key === 'password') {
            $display_val = '[hidden for security]';
        } elseif (is_array($val)) {
            $cleaned_items = array_map(function($item) {
                return is_string($item) ? htmlspecialchars($item, ENT_QUOTES, 'UTF-8') : '[invalid]';
            }, $val);
            $display_val = implode(', ', $cleaned_items);
        } else {
            $display_val = htmlspecialchars((string)$val, ENT_QUOTES, 'UTF-8');
        }
        print "<p>" . $clean_key . " = " . $display_val . "</p>\n";
    }
?>

</body>
</html>
