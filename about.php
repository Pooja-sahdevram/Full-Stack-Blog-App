<?php
// about.php
include "./header.php";


// Set the page title and other dynamic content
$title = "About Us";
$company_name = "Your Company";
$description = "We are a company dedicated to providing excellent services and products.";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="public/styles.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <header class="bg-blue-600 text-white py-4">
        <div class="container mx-auto text-center">
            <h1 class="text-3xl font-bold"><?php echo $company_name; ?></h1>
        </div>
    </header>

    <main class="container mx-auto mt-8 p-4 bg-white rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold mb-4"><?php echo $title; ?></h2>
        <p class="text-gray-700"><?php echo $description; ?></p>
    </main>
    <div class="mt-8 text-center">
            <?php
            // Set feedback email parameters
            $feedback_to = 'poojasahdevram@gmail.com'; // Your feedback recipient email
            $feedback_subject = 'Feedback for Your Company';
            $feedback_body = 'Please provide your feedback here.';
            
            // URL encode the parameters
            $feedback_subject_encoded = urlencode($feedback_subject);
            $feedback_body_encoded = urlencode($feedback_body);
            
            // Construct the Gmail URL
            $feedback_url = "https://mail.google.com/mail/?view=cm&fs=1&to=$feedback_to&su=$feedback_subject_encoded&body=$feedback_body_encoded";
            ?>
            <a href="<?php echo $feedback_url; ?>" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">Send Feedback</a>
        </div>

</body>
</html>

<?php
include "./footer.php";

?>