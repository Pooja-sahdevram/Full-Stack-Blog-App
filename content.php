<?php
// Check if a session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['query'])) {
        include "./connection.php";

        $search = $_GET['query'];
        $matches = []; // Initialize $matches
        $arr = [];

        // Prepare and execute the SQL query
        $sql = 'SELECT title FROM blogcreate';
        if ($result = $conn->query($sql)) {

            if ($result->num_rows > 0) {
                while ($rows = $result->fetch_assoc()) {
                    $arr[] = $rows['title'];
                }

                foreach ($arr as $a) {
                    if (stripos($a, $search) !== false) {
                        $matches[] = $a;
                    }
                }

                if (!empty($matches)) {
                     implode(', ', $matches);
                } else {
                    echo "No matches found.";
                }

                // Optionally print the entire array
                // print_r($arr);
            }
        } else {
            echo "Error executing query: " . $conn->error;
        }

        // Close the database connection
        $conn->close();
    }
}




echo '<link href="https://cdn.jsdelivr.net/npm/tailwindcss@^3.0/dist/tailwind.min.css" rel="stylesheet">';

if (isset($_SESSION['login'])) {
    echo '<div class="p-4 bg-green-100 text-green-800 border border-green-300 rounded-md">';
    echo 'Your posts';
    echo '<br>'; // Add a line break for spacing
    echo '<div class="flex flex-col md:flex-row justify-between items-center mt-4 px-4">';
    echo '<div class="flex flex-wrap justify-center md:justify-start space-y-2 md:space-y-0 md:space-x-4">';
        echo '<a href="./createpost.php" class="inline-block px-4 py-2 text-white bg-blue-500 hover:bg-blue-700 rounded-md">Create Post</a>';
        echo '<a href="./allpost.php" class="inline-block px-4 py-2 text-white bg-blue-500 hover:bg-blue-700 rounded-md">See All Posts</a>';
    echo '</div>';
    echo '<div class="flex flex-col md:flex-row items-center mt-4 md:mt-0 space-y-2 md:space-y-0 md:space-x-2">';
        echo '<form action="./index.php" method="GET" class="flex items-center space-x-2">';
            echo '<input type="text" name="query" placeholder="Search..." class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">';
            echo '<button type="submit" class="inline-block px-4 py-2 text-white bg-blue-500 hover:bg-blue-700 rounded-md">Search</button>';
        echo '</form>';
    echo '</div>';
echo '</div>';

    echo '</div>';
    echo '</div>';

if(empty( $matches)){
    include './readmypost.php';
}
else{
    $_SESSION['matches']=$matches;
    include './search.php';

}


} else {
    echo '<div class="p-4 bg-red-100 text-red-800 border border-red-300 rounded-md">';
    
    echo 'Login to create post';
    echo '</div>';

    echo '<h1 class=" p-4 text-blue-600 font-bold text-5xl ">'."All Post".'</h1>';


    if(empty( $matches)){
        include './allpost.php';
    }
    else{
        $_SESSION['matches']=$matches;
        include './search.php';
    
    }
}
?>
