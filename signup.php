<!-- signup.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-sm p-8 bg-white rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Sign Up</h2>

        <?php
        include "./connection.php";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = convert_uuencode($_POST['password']);

            $sql = "INSERT INTO blogsignup (name, email, password) VALUES (?, ?, ?)";

            $smtp = $conn->prepare($sql);
            $smtp->bind_param('sss', $name, $email, $password);

            session_start();

            if ($smtp->execute()) {
                echo '<div class="text-green-600 font-bold mb-4">Inserted successfully</div>';
                
                $_SESSION['login'] = $_POST['email'];
            
                echo '<script>
                    setTimeout(function() {
                        window.location.href = "index.php";
                    }, 500);
                </script>';
                
                exit();
            } else {
                echo '<div class="text-red-600 font-bold mb-4">Email already exists</div>';
            }
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            </div>
            <button type="submit" name="signup" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Sign Up</button>
        </form>
        <p class="mt-4 text-center text-sm text-gray-600">Already have an account? <a href="login.php" class="text-blue-500 hover:text-blue-600">Login</a></p>
    </div>
</body>
</html>
