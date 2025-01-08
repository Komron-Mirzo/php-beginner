<?php
// Start the session with secure settings
session_start([
    'cookie_lifetime' => 86400, // Set the session cookie lifetime (optional)
    'cookie_secure' => true,    // Ensure the session cookie is sent over HTTPS
    'cookie_httponly' => true,  // Prevent JavaScript from accessing session cookie
    'use_strict_mode' => true,  // Enforce strict mode to prevent session fixation
]);

// Regenerate session ID to prevent session fixation attacks
if (session_id() === '') {
    session_regenerate_id(true);
}

// If a user is logging out, destroy the session
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    // Clear all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Optionally, unset the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 3600,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Redirect to the login page or another page
    header("Location: login.php");
    exit;
}
?>
