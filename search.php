<?php

include "./connection.php";

// Assuming $_SESSION['matches'] is an array of search terms
$search_to = isset($_SESSION['matches']) ? $_SESSION['matches'] : [];

// Prepare search terms for SQL query
$search_terms = array_map(function($term) use ($conn) {
    return "%" . $conn->real_escape_string($term) . "%";
}, $search_to);

// Create the SQL query with multiple LIKE clauses
$like_clauses = array();
foreach ($search_terms as $term) {
    $like_clauses[] = "title LIKE ?";
}

// Join the LIKE clauses with OR
$where_clause = implode(' OR ', $like_clauses);

// Complete SQL query
$sql = "SELECT * FROM blogcreate WHERE $where_clause ";

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    // Output SQL error
    die("Failed to prepare statement: " . $conn->error);
}

// Bind parameters to the statement
$param_types = str_repeat('s', count($search_terms)); // 's' for string type
$stmt->bind_param($param_types, ...$search_terms);

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

// Fetch all posts
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
        .card-img {
            object-fit: cover; /* Ensures the image covers the card */
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach ($posts as $post): ?>
                <a href="singlepageview.php?postid=<?php echo urlencode($post['postid']); ?>" class="card bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden card-link">

                    <div class="card bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden">
                        <?php if (!empty($post['imgpath'])): ?>
                            <img src="<?php echo htmlspecialchars($post['imgpath']); ?>" 
                                 alt="<?php echo htmlspecialchars($post['title']); ?>" 
                                 class="w-full h-48 card-img">
                        <?php endif; ?>
                        <div class="p-4">
                            <h2 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($post['title']); ?></h2>
                            <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($post['category'])); ?></p>
                            <!-- Optional: Add a "Read more" link or additional details here -->
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
