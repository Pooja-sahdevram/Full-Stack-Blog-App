<?php
include "./connection.php";

// Check if the user is logged in
if (!isset($_SESSION['login'])) {
    die("User not logged in.");
}

$userEmail = $_SESSION['login'];

// Prepare and execute SQL query to fetch all posts
$sql = "SELECT * FROM blogcreate WHERE email = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    // Output SQL error
    die("Failed to prepare statement: " . $conn->error);
}

$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();

$posts = [];
while ($row = $result->fetch_assoc()) {
    $posts[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Posts</title>
    <!-- Include Tailwind CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        /* Internal CSS to be used in conjunction with Tailwind */
        .card {
            margin: 0.5rem; /* Adjust spacing if needed */
        }

        .card-title {
            color: #2d3748; /* Example custom color for card titles */
        }

        .card-content {
            color: #4a5568; /* Example custom color for card content */
        }

        .card-img {
            object-fit: cover; /* Ensures the image covers the card */
        }

        .card-link {
            display: block;
            height: 100%;
            width: 100%;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="p-5 mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php foreach ($posts as $post): ?>
                <a href="singlepageview.php?&postid=<?php echo urlencode($post['postid']); ?>" class="card bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden card-link">
                    <?php if (!empty($post['imgpath'])): ?>
                        <img src="<?php echo htmlspecialchars($post['imgpath']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" class="w-full h-48 card-img">
                    <?php endif; ?>
                    <div class="p-4">
                        <h2 class="card-title text-xl font-semibold mb-2"><?php echo htmlspecialchars($post['title']); ?></h2>
                        <p class="card-content"><?php echo nl2br(htmlspecialchars($post['category'])); ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
