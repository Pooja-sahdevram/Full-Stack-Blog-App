<?php
include "./connection.php";

// Check if postid is provided
if (!isset($_GET['postid'])) {
    die("Post ID not specified.");
}

$postId = $_GET['postid'];

// Prepare SQL query
$sql = "SELECT * FROM blogcreate WHERE postid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $postId);

// Execute the statement
if (!$stmt->execute()) {
    die("Error executing query: " . $stmt->error);
}

// Fetch the result
$result = $stmt->get_result();
$post = $result->fetch_assoc();

$stmt->close();
$conn->close();

// Check if post data exists
if (!$post) {
    die("Post not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <style>
        /* Internal CSS to be used in conjunction with Tailwind */
        .post-img {
            object-fit: cover; /* Ensures the image covers the post view */
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-4">
        <a href="index.php" class="bg-blue-500 px-5 py-2 text-white rounded-md inline-block text-center">Back</a>

        <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden">
            <div class="p-4">
                <p class="text-red-500 font-bold text-3xl"><?php echo htmlspecialchars($post['category']); ?></p>
                <h1 class="text-2xl text-blue-600 font-semibold mb-2"><?php echo htmlspecialchars($post['title']); ?></h1>
                <p class="text-gray-700 mb-4"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>

                <?php if (!empty($post['imgpath'])): ?>
                    <img src="<?php echo htmlspecialchars($post['imgpath']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" class="post-img">
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include "./footer.php"; ?>



 

</body>
</html>
