<?php
// MAILER
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* Confirm your web path of your phpmailer
   your php mailer might be loaded from a different path
   e.g.: /var/www/<your web directory>/vendor/autoload.php */

require 'phpmailer\vendor\autoload.php'; // WINDOWS
// require 'phpmailer/vendor/autoload.php';// LINUX

// Get the date of the selected booking
$date = isset($_GET['date']) ? $_GET['date'] : 'Date is not specified';
?>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/booking.css">
</head>

<body>
    <div class="container">
        <!-- Back Button -->
        <a href="./booking.php" role="button" class="btn btn-primary btn_back">← Back</a>
        <!-- Form -->
        <div class="form-container">
            <h2>Your Booking for: <?php echo htmlspecialchars($date); ?></h2>
            <form action="book_submit.php" method="POST">
                <div class="form-group">
                    <label for="firstname">* Firstname:</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" required>
                </div>
                <div class="form-group">
                    <label for="surname">* Surname:</label>
                    <input type="text" class="form-control" id="surname" name="surname" required>
                </div>
                <div class="form-group">
                    <label for="email">* Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">* Phone:</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="additional_info">Additional Information:</label>
                    <textarea class="form-control" id="additional_info" name="additional_info" rows="4"></textarea>
                </div>
                <input type="hidden" name="date" value="<?php echo htmlspecialchars($date); ?>">
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>

    <?php
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $firstname = htmlspecialchars($_POST['firstname']);
        $surname = htmlspecialchars($_POST['surname']);
        $email = htmlspecialchars($_POST['email']);
        $phone = htmlspecialchars($_POST['phone']);
        $additional_info = htmlspecialchars($_POST['additional_info']);
        $date = htmlspecialchars($_POST['date']);

        // DEBUG - Display the submitted data
        $message = "<div class='container'>";
        $message .= "<h3>Booking was Submitted Successfully!</h3>";
        $message .= "<p><strong>Firstname:</strong> $firstname</p>";
        $message .= "<p><strong>Surname:</strong> $surname</p>";
        $message .= "<p><strong>Email:</strong> $email</p>";
        $message .= "<p><strong>Phone:</strong> $phone</p>";
        $message .= "<p><strong>Additional Information:</strong> $additional_info</p>";
        $message .= "<p><strong>Date:</strong> $date</p>";
        $message .= "</div>";
        echo $message;

        // MAILER
        // Initialize debugging variables
        $debug = '';
        $sent = false;

        // Check if the form was submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($message)) {

            $to = 'your-testing-email@gmail.com'; // <<-Use an email address for testing.
            $subject = "Appointment Booking for Date: $date";

            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();  // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true; // Enable SMTP authentication
                $mail->Username = 'your-email@gmail.com';  // <<- // SMTP username e.g: google email address
                $mail->Password = 'xxxx xxxx xxxx xxxx';  // <<- // SMTP password or Gmail password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587; // TCP port to connect to. Port: 587 (TLS) or 465 (SSL)

                //Recipients
                $mail->setFrom('your-email@gmail.com', 'Your name'); // <<- Use your email an name
                $mail->addAddress($to);

                //Content
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $message;
                $mail->AltBody = strip_tags($message);

                $mail->send();
                $sent = true;
                $debug = 'Email sent successfully.';
            } catch (Exception $e) {
                $debug = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
    ?>
</body>

</html>