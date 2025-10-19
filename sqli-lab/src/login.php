<?php
require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            $ip = $_SERVER['REMOTE_ADDR'];
            $log_query = "INSERT INTO audit_log (user_id, action, description, ip_address) VALUES
                         ({$user['id']}, 'LOGIN', 'User logged in successfully', '$ip')";
            $conn->query($log_query);

            redirect('dashboard.php');
        } else {
            $error = 'Invalid username or password';

            $ip = $_SERVER['REMOTE_ADDR'];
            $log_query = "INSERT INTO audit_log (user_id, action, description, ip_address) VALUES
                         (NULL, 'LOGIN_FAILED', 'Failed login attempt for username: $username', '$ip')";
            $conn->query($log_query);
        }
    } else {
        $error = 'Please enter both username and password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - COSMOS Apps</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-md mx-auto">
            <!-- Logo and Title -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-2">
                    COSMOS<span class="text-blue-600">Apps</span>
                </h1>
                <p class="text-gray-600">Classroom Management System</p>
            </div>

            <!-- Login Form -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200">
                <div class="bg-gray-50 border-b border-gray-200 p-6">
                    <h2 class="text-2xl font-bold text-gray-800 text-center">Login to Your Account</h2>
                    <p class="text-gray-600 text-center mt-2">Enter your credentials to access the classroom</p>
                </div>

                <div class="p-8">
                    <?php if ($error): ?>
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700"><?php echo htmlspecialchars($error); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="" class="space-y-6">
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                Username
                            </label>
                            <input type="text" id="username" name="username" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                                   placeholder="Enter your username"
                                   value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password
                            </label>
                            <input type="password" id="password" name="password" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                                   placeholder="Enter your password">
                        </div>

                        <button type="submit" name="login"
                                class="w-full bg-blue-600 text-white font-semibold py-3 px-4 rounded-lg hover:bg-blue-700 transition">
                            Login
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-gray-600">
                            Don't have an account?
                            <a href="register.php" class="text-blue-600 hover:text-blue-800 font-medium">
                                Register here
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Help Section -->
            <div class="mt-8 bg-gray-100 rounded-lg p-6 border border-gray-200">
                <h3 class="font-semibold mb-2 text-gray-700">Need Help?</h3>
                <ul class="text-sm space-y-1 text-gray-600">
                    <li>• Use your university credentials to login</li>
                    <li>• Contact IT support if you have login issues</li>
                    <li>• First-time users should check their email for login instructions</li>
                </ul>
                <p class="text-xs mt-3 text-gray-500">
                    Having trouble? Visit the <a href="#" class="text-blue-600 hover:text-blue-800 underline">IT Support Portal</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>