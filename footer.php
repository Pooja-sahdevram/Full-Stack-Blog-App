<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Footer</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Ensures the main content takes up the remaining space */
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        .content {
            flex: 1;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">

    <!-- Main content -->
    <div class="content">
        <!-- Existing content and navigation bar here -->
    </div>


    <?php
    // PHP code to output the quote
    $response = file_get_contents('https://zenquotes.io/api/random');
    $data = json_decode($response, true);
    $emoji=[
        '😊','😂','❤️','👍','🙌','🎉','🐱','🌟','🌍','🚀','🎨','🍕','🍎','🍔',
        '🏆','🏅','🌈','🕶️','⛺','🎸','🏖️','🚗','🏠','🌷','🎂','🐶','🌊',
        '🍦','🍹','🌟','🍿','🎬','💡','📚','🎓','🚴‍♂️','🌈','🐻','🍓','🍎',
        '🎵','🌺','🍋','🌞','🚲','💌','🎁','🥳','🎤','🏀','🍿','🎤','🌹',
        '📅','📸','🛒','🏄‍♀️','🏆','🚢','✈️','🛳️','🏋️‍♂️'
    ];
    
    $random=$emoji[rand(0,count($emoji))];
    echo '<h2 class="bg-purple-100  border border-gray-300 p-6 rounded-lg shadow-lg text-center text-xl">' ."Random Quote : -". htmlspecialchars($data[0]['q']) . '<span >' .$random .'</span>'.'</h2>';
    ?>



    <!-- Footer Section -->
    <footer class="bg-blue-500 text-white w-full">
        <div class="container mx-auto py-8 px-4">
            <div class="flex flex-wrap justify-between">
                <!-- Contact Information -->
                <div class="w-full md:w-1/3 mb-6 md:mb-0">
                    <h2 class="text-lg font-bold mb-2">Contact Us</h2>
                    <p class="text-gray-300">123 Blog Street, Blog City, BC 12345</p>
                    <p class="text-gray-300">Email: <a href="mailto:info@myblog.com" class="underline">info@myblog.com</a></p>
                    <p class="text-gray-300">Phone: (123) 456-7890</p>
                </div>

                <!-- Social Media Links -->
                <div class="w-full md:w-1/3 mb-6 md:mb-0">
                    <h2 class="text-lg font-bold mb-2">Follow Us</h2>
                    <div class="flex space-x-4">
                        <a href="https://facebook.com" target="_blank" class="text-gray-300 hover:text-gray-100">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22 12.07c0-5.52-4.48-10-10-10S2 6.55 2 12.07c0 5.12 3.87 9.34 8.86 9.93v-7h-2.68v-2.93h2.68v-2.2c0-2.63 1.6-4.06 3.98-4.06 1.15 0 2.13.09 2.42.13v2.82h-1.66c-1.3 0-1.56.63-1.56 1.56v2.04h2.86l-.37 2.93h-2.49v7c4.97-.59 8.83-4.81 8.83-9.93z"/>
                            </svg>
                        </a>
                        <a href="https://twitter.com" target="_blank" class="text-gray-300 hover:text-gray-100">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M23 3a10.9 10.9 0 0 1-3.14.86A5.48 5.48 0 0 0 22.4 2c-1.03.6-2.17 1.03-3.39 1.26A5.37 5.37 0 0 0 16.4 1c-2.97 0-5.38 2.42-5.38 5.38 0 .42.05.83.1 1.23-4.47-.22-8.44-2.37-11.11-5.64a5.37 5.37 0 0 0-.73 2.71c0 1.87.95 3.53 2.4 4.5A5.33 5.33 0 0 1 2 9.68v.07c0 2.62 1.87 4.79 4.36 5.28-.45.12-.93.19-1.42.19-.35 0-.69-.03-1.03-.1.69 2.14 2.7 3.7 5.07 3.74a10.82 10.82 0 0 1-6.68 2.31c-.43 0-.86-.02-1.28-.07 2.37 1.53 5.18 2.42 8.16 2.42 9.8 0 15.14-8.12 15.14-15.14 0-.23-.01-.46-.02-.69A10.8 10.8 0 0 0 23 3z"/>
                            </svg>
                        </a>
                        <a href="https://instagram.com" target="_blank" class="text-gray-300 hover:text-gray-100">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2.2c3.91 0 4.39.02 5.93.08 1.54.07 2.88.64 3.9 1.65 1.01 1.01 1.58 2.36 1.65 3.9.06 1.54.08 2.02.08 5.93 0 3.91-.02 4.39-.08 5.93-.07 1.54-.64 2.88-1.65 3.9-1.01 1.01-2.36 1.58-3.9 1.65-1.54.06-2.02.08-5.93.08-3.91 0-4.39-.02-5.93-.08-1.54-.07-2.88-.64-3.9-1.65-1.01-1.01-1.58-2.36-1.65-3.9-.06-1.54-.08-2.02-.08-5.93 0-3.91.02-4.39.08-5.93.07-1.54.64-2.88 1.65-3.9 1.01-1.01 2.36-1.58 3.9-1.65 1.54-.06 2.02-.08 5.93-.08zm0-2.2C8.68 0 7.19.03 6.01.09 4.89.15 3.78.53 2.86 1.45 1.94 2.37 1.56 3.48 1.5 4.6 1.44 5.78 1.42 6.76 1.42 12c0 5.24.02 6.22.08 7.4.06 1.12.44 2.23 1.35 3.14.93.92 2.04 1.3 3.16 1.35 1.18.06 2.16.08 7.4.08 5.24 0 6.5.02 7.52.08 1.3.07 2.57-.55 3.54-1.51.98-.97 1.5-2.26 1.59-3.56.07-1.2.09-2.04.09-7.4 0-5.24-.02-6.22-.08-7.4-.07-1.3-.56-2.59-1.59-3.56-.98-.96-2.26-1.58-3.54-1.51-1.18-.06-2.16-.08-7.52-.08zm0 5.8c-3.36 0-6.1 2.74-6.1 6.1 0 3.36 2.74 6.1 6.1 6.1 3.36 0 6.1-2.74 6.1-6.1 0-3.36-2.74-6.1-6.1-6.1zm0 10.4c-2.35 0-4.3-1.95-4.3-4.3 0-2.35 1.95-4.3 4.3-4.3 2.35 0 4.3 1.95 4.3 4.3 0 2.35-1.95 4.3-4.3 4.3z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Additional Links -->
                <div class="w-full md:w-1/3">
                    <h2 class="text-lg font-bold mb-2">Quick Links</h2>
                    <ul>
                        <li><a href="/" class="text-gray-300 hover:text-gray-100">Home</a></li>
                        <li><a href="/about.php" class="text-gray-300 hover:text-gray-100">About</a></li>
                        <li><a href="/services.php" class="text-gray-300 hover:text-gray-100">Services</a></li>
                        <li><a href="/contact.php" class="text-gray-300 hover:text-gray-100">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="bg-blue-700 text-center py-4">
            <p class="text-gray-300 text-sm">© 2024 POOJA. All rights reserved.</p>

        </div>
    </footer>




</div>
</html>
