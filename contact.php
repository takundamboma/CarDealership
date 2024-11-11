<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Initialize an array to hold error messages
    $errors = [];

    // Validate inputs
    if (empty($name)) {
        $errors[] = 'Name is required.';
    }

    if (empty($email)) {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format.';
    }

    if (empty($message)) {
        $errors[] = 'Message is required.';
    }

    // Check for errors
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    } else {
        // Proceed to send the email if there are no errors
        $to = "takundamboma@gmail.com"; // Your email address
        $subject = "Contact Form Submission from $name";
        $body = "Name: $name\nEmail: $email\nMessage:\n$message";
        $headers = "From: $email";

        if (mail($to, $subject, $body, $headers)) {
            echo 'Message sent successfully.';
        } else {
            echo 'Failed to send message.';
        }
    }
} else {
    echo "Invalid request.";
}
