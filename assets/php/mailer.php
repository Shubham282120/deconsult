<?php

// Only process POST reqeusts.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // Get the form fields and remove whitespace.
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r", "\n"), array(" ", " "), $name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $url = trim($_POST["url"]);
    // $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    // Check that data was sent to the mailer.
    if (empty($name) or empty($message) or !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Set a 400 (bad request) response code and exit.
        http_response_code(400);
        // echo "Oops! There was a problem with your submission. Please complete the form and try again.";
        echo `<script>alert("Oops! There was a problem with your submission. Please complete the form and try again."); window.location.href = location.origin+$url;</script>`;

    }

    // Set the recipient email address.
    // FIXME: Update this to your desired email address.
    $recipient = "info@execuler.com";
    $service_details = isset($_POST["serviceDetails"]) ? $_POST["serviceDetails"] : "Execuler Contact Form";
    // Set the email subject.
    $subject = `New contact from $service_details`;

    // Build the email content.
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Subject: $subject\n\n";
    $email_content .= "Message:\n$message\n";

    // Build the email headers.
    $email_headers = "From: $name <$email>";

    // Additional headers
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $recipient\r\n";
    $headers .= "Cc: visshubham82@gmail.com\r\n";
    // $headers .= "Bcc: bcc_recipient@example.com\r\n";
    // $headers .= "X-Mailer: PHP/" . phpversion();

    // Send the email.
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // // Set a 200 (okay) response code.
        // http_response_code(200);
        // echo "Thank You! Your message has been sent.";
        echo `<script>alert("Thank You! Your message has been sent."); window.location.href = location.origin+$url;</script>`;
    } else {
        // Set a 500 (internal server error) response code.
        // http_response_code(500);
        // echo "Oops! Something went wrong and we couldn't send your message.";
        echo `<script>alert("There was an error and we could not send your message."); window.location.href = location.origin+$url;</script>`;

    }

} else {
    // Not a POST request, set a 403 (forbidden) response code.
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}

?>