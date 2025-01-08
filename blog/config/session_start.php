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
?>
