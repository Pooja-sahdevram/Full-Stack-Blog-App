<?php
// Start the session
session_start();

// Initialize variables for displaying data
$submitted = false;
$postData = [];
$uploadError = '';
$message = ''; // Variable to hold the message
$messageType = ''; // Variable to hold the type of message (success or error)

// Default email from session if available
$defaultEmail = isset($_SESSION['login']) ? $_SESSION['login'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include "./connection.php";

    $submitted = true;

    // Collect and sanitize form data
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    $category = htmlspecialchars($_POST['category']);
    $email = htmlspecialchars($_POST['email']);

    // Generate unique identifier
    $uniqueValue = time() . '-' . md5($email);

    // Handle file upload
    if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] == 0) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['image_path']['name']);
        
        // Create uploads directory if not exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Check file size and type (optional)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['image_path']['type'], $allowedTypes) && $_FILES['image_path']['size'] < 5000000) {
            if (move_uploaded_file($_FILES['image_path']['tmp_name'], $uploadFile)) {
                $imagePath = htmlspecialchars($uploadFile);
            } else {
                $uploadError = 'Error uploading the file.';
                $imagePath = '';
            }
        } else {
            $uploadError = 'Invalid file type or size.';
            $imagePath = '';
        }
    } else {
        $imagePath = '';
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO blogcreate (email, category, content, imgpath, title, postid) VALUES (?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    // Bind parameters
    $stmt->bind_param('ssssss', $email, $category, $content, $imagePath, $title, $uniqueValue);

    // Execute the statement
    if ($stmt->execute()) {
        $message = 'Blog post submitted successfully!';
        $messageType = 'success'; // Set message type
    } else {
        $message = 'Error submitting blog post: ' . htmlspecialchars($stmt->error);
        $messageType = 'error'; // Set message type
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Display data
    $postData = [
        'title' => $title,
        'content' => $content,
        'category' => $category,
        'email' => $email,
        'image_path' => $imagePath,
        'unique_value' => $uniqueValue // Add the unique value here
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Blog Post</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">
<div class="bg-white p-4 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4 text-center">Posts</h1>
    <div class="flex justify-around">
        <a href="./allpost.php" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">All Posts</a>
        <?php if (isset($_SESSION['login'])): ?>
        <?php endif; ?>
    </div>
</div>

<main class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Create a New Blog Post</h1>
    
    <div class="flex flex-wrap gap-8">
        <!-- Form Section -->
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data" class="bg-white p-8 shadow-lg rounded-lg max-w-md flex-1">
            <div class="mb-6">
                <label for="title" class="block text-gray-700 font-semibold mb-2">Title:</label>
                <input type="text" id="title" name="title" class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-6">
                <label for="content" class="block text-gray-700 font-semibold mb-2">Content:</label>
                <textarea id="content" name="content" rows="6" class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
            </div>
            <div class="mb-6">
                <label for="category" class="block text-gray-700 font-semibold mb-2">Category:</label>
                <select id="category" name="category" class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="" disabled selected>Select a category</option>
                    <option value="Technology">Technology</option>
                    <option value="Lifestyle">Lifestyle</option>
                    <option value="Travel">Travel</option>
                    <option value="Food">Food</option>
                    <option value="Education">Education</option>
                    <option value="Health">Health</option>
                </select>
            </div>
            <div class="mb-6">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Your Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($defaultEmail); ?>" class="w-full p-4 border border-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" readonly>
            </div>
            <div class="mb-6">
                <label for="image_path" class="block text-gray-700 font-semibold mb-2">Image Upload:</label>
                <input type="file" id="image_path" name="image_path" class="w-full p-2 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <?php if ($uploadError): ?>
                    <p class="text-red-500 mt-2"><?php echo $uploadError; ?></p>
                <?php endif; ?>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">Submit</button>
        </form>

        <!-- Submitted Content Section -->
        <?php if ($submitted): ?>
            <div class="bg-white p-8 shadow-lg rounded-lg max-w-LG flex-1">
                <?php if ($message): ?>
                    <div id="message" class="p-4 rounded <?php echo $messageType === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <h2 class="text-2xl font-semibold mb-6 text-gray-800">Submitted Blog Post</h2>
                <div class="flex">
                    <!-- Left Side: Content -->
                    <div class="flex-1">
                        <?php if ($postData['image_path']): ?>
                            <p class="text-gray-700 mb-2"><strong>Image:</strong></p>
                            <img src="<?php echo $postData['image_path']; ?>" alt="Uploaded Image" class="w-full h-auto mt-2 border border-gray-300 rounded-lg shadow-md">
                        <?php endif; ?>

                        <p class="text-gray-700 mb-2"><strong>Title:</strong> <?php echo $postData['title']; ?></p>
                        <p class="text-gray-700 mb-2"><strong>Content:</strong> <br><?php echo nl2br($postData['content']); ?></p>
                        <p class="text-gray-700 mb-2"><strong>Category:</strong> <?php echo $postData['category']; ?></p>
                        <p class="text-gray-700 mb-2"><strong>Your Email:</strong> <?php echo $postData['email']; ?></p>
                    </div>
                    <!-- Right Side: Unique Value -->
                    <div class="ml-8">
                        <p class="text-gray-700 mb-2"><strong>Unique Value:</strong> <?php echo $postData['unique_value']; ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<script>
    // JavaScript to show the message and hide it after 3 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const messageElement = document.getElementById('message');

        if (messageElement) {
            setTimeout(() => {
                messageElement.classList.add('hidden');
            }, 3000); // 3 seconds
        }
    });
</script>

</body>
</html>
