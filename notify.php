<?php
/*
 * "Be first to know when we open" signup.
 *
 * Emails each signup to the cafe inbox and keeps a copy in a CSV that lives
 * one level ABOVE public_html, so it is never downloadable from the website.
 * Runs on Hostinger (PHP). The GitHub Pages copy cannot run PHP.
 */

const TO_ADDRESS   = 'info@yellowcapcafe.com';
const FROM_ADDRESS = 'info@yellowcapcafe.com';   // must be on our domain or it lands in spam
const MAX_PER_HOUR = 5;                           // per visitor IP, to stop bots flooding the inbox

$storeDir = dirname(__DIR__);                     // .../domains/yellowcapcafe.com (outside public_html)
$csvFile  = $storeDir . '/yellowcap-signups.csv';
$rateFile = $storeDir . '/yellowcap-signups-rate.json';

$wantsJson = stripos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false;

function respond(bool $ok, string $message, bool $wantsJson): void {
    if ($wantsJson) {
        http_response_code($ok ? 200 : 400);
        header('Content-Type: application/json');
        echo json_encode(['ok' => $ok, 'message' => $message]);
    } else {
        // Without JavaScript the browser posted the form directly: send it back to the page.
        header('Location: ./?notified=' . ($ok ? '1' : '0') . '#notify', true, 303);
    }
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit;
}

// Honeypot: a field hidden from people. Bots fill it in; pretend it worked.
if (!empty($_POST['website'])) {
    respond(true, 'Thanks!', $wantsJson);
}

$email = trim((string)($_POST['email'] ?? ''));
if ($email === '' || strlen($email) > 254 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond(false, 'Please enter a valid email address.', $wantsJson);
}

// Rate limit by hashed IP (the raw IP is never stored).
$ipKey = hash('sha256', ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . '|yellowcap');
$now   = time();
$rates = [];
if (is_readable($rateFile)) {
    $rates = json_decode((string)file_get_contents($rateFile), true) ?: [];
}
foreach ($rates as $k => $times) {
    $rates[$k] = array_values(array_filter($times, fn($t) => $t > $now - 3600));
    if (!$rates[$k]) unset($rates[$k]);
}
if (count($rates[$ipKey] ?? []) >= MAX_PER_HOUR) {
    respond(false, 'Too many tries. Please try again later.', $wantsJson);
}
$rates[$ipKey][] = $now;
@file_put_contents($rateFile, json_encode($rates), LOCK_EX);

// Keep a list for opening day, even if an email goes astray.
$isNewFile = !file_exists($csvFile);
if ($fh = @fopen($csvFile, 'a')) {
    if (flock($fh, LOCK_EX)) {
        if ($isNewFile) fputcsv($fh, ['date', 'email']);
        // Neutralise spreadsheet formulas in case the file is opened in Excel.
        $safe = preg_match('/^[=+\-@]/', $email) ? "'" . $email : $email;
        fputcsv($fh, [gmdate('Y-m-d H:i:s') . ' UTC', $safe]);
        flock($fh, LOCK_UN);
    }
    fclose($fh);
}

// FILTER_VALIDATE_EMAIL rejects line breaks, so the address is safe in a header.
$subject = 'New signup: notify me when Yellow Cap opens';
$body = "Someone wants to hear when Yellow Cap Cafe opens.\r\n\r\n"
      . "Email: {$email}\r\n"
      . 'Signed up: ' . gmdate('j M Y, H:i') . " UTC\r\n\r\n"
      . "Sent from the signup form on yellowcapcafe.com.\r\n";
$headers = implode("\r\n", [
    'From: Yellow Cap website <' . FROM_ADDRESS . '>',
    'Reply-To: ' . $email,
    'Content-Type: text/plain; charset=UTF-8',
]);

$sent = @mail(TO_ADDRESS, $subject, $body, $headers, '-f' . FROM_ADDRESS);

respond($sent, $sent ? "Thanks! We'll let you know when we open." : 'Something went wrong. Please try again later.', $wantsJson);
