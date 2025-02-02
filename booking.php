<?php
require('./php_functions.php');
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
        <a href="./welcome.php" role="button" class="btn btn-primary">← Back</a>
        <div class="row">
            <div class="col-md-12">
                <?php
                $dateComponents = getdate();
                if (isset($_GET['month']) && isset($_GET['year'])) {
                    $month = $_GET['month'];
                    $year = $_GET['year'];
                } else {
                    $month = $dateComponents['mon'];
                    $year = $dateComponents['year'];
                }
                // Display the calendar
                build_calendar($month, $year);
                ?>
            </div>
        </div>
    </div>
</body>

</html>