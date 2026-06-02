<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$name    = trim(strip_tags($_POST['name'] ?? ''));
$email   = trim(strip_tags($_POST['email'] ?? ''));
$message = trim(strip_tags($_POST['message'] ?? ''));
$privacy = isset($_POST['privacy']);

// Validation
if (!$name || !$email || !$message || !$privacy) {
    header('Location: index.html?status=error#contact');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: index.html?status=error#contact');
    exit;
}

$to      = 'info@goldkueste-design.de';
$subject = 'Neue Nachricht von ' . $name;
$body    = "Name: $name\nE-Mail: $email\n\nNachricht:\n$message";
$headers = implode("\r\n", [
    'From: noreply@goldkueste-design.de',
    'Reply-To: ' . $email,
    'Content-Type: text/plain; charset=UTF-8',
]);

if (mail($to, $subject, $body, $headers)) {
    header('Location: index.html?status=success#contact');
} else {
    header('Location: index.html?status=error#contact');
}
exit;
