<?php
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

// Handle form submission for deleting the post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Delete the post
    $deleteSql = "DELETE FROM blogcreate WHERE postid = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("s", $postId);
    
    if ($deleteStmt->execute()) {
        echo "Post deleted successfully.";
        header("Location: index.php"); // Redirect to a list of posts or wherever you want
        exit();
    } else {
        echo "Error deleting post: " . $conn->error;
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
    <title>Delete Post</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
    <div class="container mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold mb-4">Delete Post</h1>
        <p class="mb-4">Are you sure you want to delete this post?</p>
        <div class="mb-4">
            <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($post['title']); ?></h2>
            <p class="mt-2"><?php echo htmlspecialchars($post['content']); ?></p>
            <?php if (!empty($post['image'])): ?>
                <p class="mt-2 text-gray-600">Current image:</p>
                <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image" class="mt-2 max-w-xs h-auto">
            <?php endif; ?>
        </div>
        <form method="post" action="delete.php?postid=<?php echo urlencode($postId); ?>">
            <div class="mb-4">
                <button type="submit" class="px-4 py-2 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600">Delete Post</button>
                <a href="singlepageview.php?postid=<?php echo urlencode($postId); ?>" class="ml-4 px-4 py-2 bg-gray-300 text-gray-800 font-semibold rounded-lg hover:bg-gray-400">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
