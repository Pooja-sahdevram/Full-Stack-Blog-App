<?php
session_start();
if (isset($_SESSION['login'])) {
    $is_logged_in = $_SESSION['login'];
} else {
    $is_logged_in = false; // or whatever default value you prefer
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Optional: Add any custom styles here */
    </style>
</head>
<body>
    <header class="bg-blue-500 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-lg font-semibold">
                <a href="./index.php" class="block px-4 py-2 hover:bg-blue-700">Blog</a>
            </div>
            <nav class="hidden lg:flex space-x-4">
                <a href="./index.php" class="block px-4 py-2 hover:bg-blue-700">Home</a>
                <a href="./about.php" class="block px-4 py-2 hover:bg-blue-700">About</a>
                <?php if ($is_logged_in): ?>
                    <a href="./logout.php" class="block px-4 py-2 hover:bg-blue-700">Logout</a>
                <?php else: ?>
                    <a href="./login.php" class="block px-4 py-2 hover:bg-blue-700">Login</a>
                <?php endif; ?>
            </nav>
            <button id="menu-toggle" class="lg:hidden p-2 text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        <div id="mobile-menu" class="lg:hidden hidden bg-blue-600 text-white">
            <a href="./index.php" class="block px-4 py-2 hover:bg-blue-700">Home</a>
            <a href="./about.php" class="block px-4 py-2 hover:bg-blue-700">About</a>
            <?php if ($is_logged_in): ?>
                <a href="./logout.php" class="block px-4 py-2 hover:bg-blue-700">Logout</a>
            <?php else: ?>
                <a href="./login.php" class="block px-4 py-2 hover:bg-blue-700">Login</a>
            <?php endif; ?>
        </div>
    </header>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');

            menuToggle.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        });
    </script>
    
</body>
</html>
