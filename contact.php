<?php 
    define("TO_EMAIL", "kalilsn@gmail.com");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $errors = "";
        # Sanitize name to remove newlines to avoid email header injection
        $name = filter_var(preg_replace('/\s+/', ' ', trim($_POST["name"])), FILTER_SANITIZE_STRING);
        if ($name == "") {
            $errors .= "A valid name is required.<br>";
        }
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        if ($email == "" or !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors .= "A valid email is required.<br>";
        }
        $message = filter_var(trim($_POST["message"]), FILTER_SANITIZE_STRING);
        if ($message == "") {
            $errors .= "A valid message is required.<br>";
        }

        $to = TO_EMAIL;
        $subject = "Contact form message from $name <$email>";
        # Set reply-to rather than from to avoid being caught by spam/phishing filters
        $email_headers = "Reply-to: $name <$email>";

        if (!$errors) {
            if (mail($to, $subject, $message, $email_headers)) {
            http_response_code(200);
            echo "Thank you! We'll do our best to get back to you ASAP.";
            } else {
                http_response_code(500);
                echo 'We were unable to send your message. Please email us at <a href="mailto:' . TO_EMAIL . '">' . TO_EMAIL . '</a>."';
            }    
        } else {
            http_response_code(400);
            echo $errors;
        }

    } else {
        # For requests other than post
        http_response_code(403);
        echo "That's not what this is for.";
    }

?>