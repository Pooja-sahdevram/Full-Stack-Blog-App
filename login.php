<!-- login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-sm p-8 bg-white rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>





        <?php
        include "./connection.php";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = ($_POST['password']);




            // echo $email.$password;


            
        //get data

        $sqlselect = "SELECT password FROM blogsignup WHERE email = '$email'";
        $result=$conn->query($sqlselect);
        if ($result->num_rows > 0) {



         while($row=$result->fetch_assoc()){
            // print_r($row);
         $sqlpass=$row['password'];
         $sqlpass=convert_uudecode($sqlpass);


         session_start();
         
         if ($sqlpass === $password) {
            $_SESSION['login'] = $_POST['email'];
            header('Location: index.php');
             exit();
         } else {
            echo '<div class="p-4 bg-red-100 text-red-800 border border-red-300 rounded-md">Invalid login credentials.</div>';

         }
         
         }

        }else{
            echo '<div class="p-4 bg-red-100 text-red-800 border border-red-300 rounded-md">Signup first</div>';

        }

          
        }


        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            </div>
            <button type="submit" name="login" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Login</button>
        </form>
        <p class="mt-4 text-center text-sm text-gray-600">Don't have an account? <a href="signup.php" class="text-blue-500 hover:text-blue-600">Sign up</a></p>
    </div>
</body>
</html>
