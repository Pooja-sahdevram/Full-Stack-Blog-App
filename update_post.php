<?php
// update_post.php

// Include the database connection file
include 'connection.php';

// Retrieve the post ID from the URL
if (!isset($_GET['postid']) || empty($_GET['postid'])) {
    die("Invalid post ID.");
}

$postId = $_GET['postid'];

// Fetch the post details from the database
$sql = "SELECT * FROM blogcreate WHERE postid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $postId);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    die("Post not found.");
}

// Handle form submission for updating the post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $category = $conn->real_escape_string($_POST['category']);
    $email = $conn->real_escape_string($_POST['email']);
    $imagePath = $post['image']; // Default to current image

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Check file extension
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($fileExtension, $allowedExtensions)) {
            // Directory where the image will be saved
            $uploadDir = 'uploads/';
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $destPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $imagePath = $destPath;
            } else {
                echo "There was an error uploading the image.";
            }
        } else {
            echo "Invalid file extension.";
        }
    }

    // Update post with new title, content, category, email, and image path
    $updateSql = "UPDATE blogcreate SET title = ?, content = ?, category = ?, email = ?, imgpath = ? WHERE postid = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ssssss", $title, $content, $category, $email, $imagePath, $postId);
    
    if ($updateStmt->execute()) {
        echo "Post updated successfully.";
        header("Location: singlepageview.php?&postid=" . urlencode($postId)); // Redirect to the updated post view
        exit();
    } else {
        echo "Error updating post: " . $conn->error;
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Post</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
    <div class="container mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold mb-4">Update Post</h1>
        <form method="post" action="update_post.php?postid=<?php echo urlencode($postId); ?>" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium mb-2">Title:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="content" class="block text-gray-700 font-medium mb-2">Content:</label>
                <textarea id="content" name="content" rows="10" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required><?php echo htmlspecialchars($post['content']); ?></textarea>
            </div>
            <div class="mb-4">
                <label for="category" class="block text-gray-700 font-medium mb-2">Category:</label>
                <select id="category" name="category" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="" disabled>Select a category</option>
                    <option value="Technology" <?php echo ($post['category'] == 'Technology') ? 'selected' : ''; ?>>Technology</option>
                    <option value="Lifestyle" <?php echo ($post['category'] == 'Lifestyle') ? 'selected' : ''; ?>>Lifestyle</option>
                    <option value="Travel" <?php echo ($post['category'] == 'Travel') ? 'selected' : ''; ?>>Travel</option>
                    <option value="Food" <?php echo ($post['category'] == 'Food') ? 'selected' : ''; ?>>Food</option>
                    <option value="Education" <?php echo ($post['category'] == 'Education') ? 'selected' : ''; ?>>Education</option>
                    <option value="Health" <?php echo ($post['category'] == 'Health') ? 'selected' : ''; ?>>Health</option>
                </select>
            </div>
            <div class="mb-4">
    <label for="email" class="block text-gray-700 font-medium mb-2">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($post['email']); ?>" class="w-full p-2 border border-blue-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required readonly>
</div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-medium mb-2">Image:</label>
                <input type="file" id="image" name="image" class="w-full p-2 border border-gray-300 rounded-lg">
                <?php if (!empty($post['image'])): ?>
                    <p class="mt-2 text-gray-600">Current image:</p>
                    <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image" class="mt-2 max-w-xs h-auto">
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600">Update Post</button>
                <a href="singlepageview.php?postid=<?php echo urlencode($postId); ?>" class="ml-4 px-4 py-2 bg-gray-300 text-gray-800 font-semibold rounded-lg hover:bg-gray-400">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
