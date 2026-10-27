# Inclass 09 - PHP Forms (Pizza Lab)

Rajan Sharma, CSC 4370 Web Programming, Fall 2026.

The in-class Pizza Lab from the FormLab notes. `pizza-lab/order.html` is the form for a made up shop
(Campus Crust) and `pizza-lab/order.php` is the handler that checks everything and prints a practice
ticket. Nothing is saved or sent anywhere, it just shows you what PHP received.

live: https://codd.cs.gsu.edu/~rsharma30/web/pizza-lab/order.html

## what's in the form

- `customer` text, required, 1-40 bytes
- `size` select, small / medium / large
- `crust` select, thin / thick (extra slice from the lab)
- `quantity` number, whole number 1-5
- `toppings[]` three checkboxes, mushroom / olive / pineapple, any number including none
- `notes` textarea, optional, up to 200 bytes

The `name` attribute is what shows up as the key in `$_POST`. The `id` is only there so the label
can point at the control.

## what the php does

Everything goes through the same pattern: read the key with `??`, check it's the right shape
(`is_string` / `is_array`), check the meaning (range, allowed list, length), and only then put it in
`$clean`. Anything wrong goes into `$errors[]` and the page answers with a 422 and the list of
problems. Opening `order.php` directly (GET) gets a 405 that tells you to use the form.

Toppings that aren't checked never get sent at all, so a missing key just means `[]`. The checkboxes
are named `toppings[]` so PHP builds an array instead of keeping the last one only. An invented
topping, a plain string instead of a list, or a nested array all get rejected without a fatal error.

Output is escaped with `htmlspecialchars` through the `e()` helper, so a name like `<b>Alex</b>`
shows up literally. The practice total is worked out in PHP from a price list times the validated
quantity, a `price` field sent from the browser is ignored.

The footer of the ticket prints the server, time, request method and the field names that actually
arrived, which is handy for the "why is toppings missing" question.

## testing

`evidence/test-log.txt` is the run against the live CODD URL (31 checks, all passing), including
the lab's stretch tests. `evidence/w3c-validation.txt` is the W3C checker on the form page and on
three PHP outputs (ticket, 422 errors, 405). `evidence/*.html` are saved outputs from CODD.

To try it yourself: open the live link, make a pizza, then try 0 pizzas, no toppings, or the name
`<b>Chef</b>`. On CODD it lives in `~/public_html/web/pizza-lab/` (a `Web` symlink makes the lab's
example path work too).
