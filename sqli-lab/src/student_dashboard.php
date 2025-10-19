<?php
require_once 'config.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$current_user = getCurrentUser();

if ($current_user['role'] === 'admin') {
    redirect('admin_dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - COSMOS Apps</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">
    <!-- Simple Header -->
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <h1 class="text-xl font-bold text-gray-800">COSMOS<span class="text-blue-600">Apps</span></h1>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600 text-sm">
                        Welcome, <?php echo htmlspecialchars($current_user['full_name']); ?>
                        <span class="ml-2 px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">Student</span>
                    </span>
                    <a href="logout.php" class="bg-gray-800 hover:bg-gray-900 text-white px-3 py-1 rounded text-sm">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="flex">
        <!-- Simple Sidebar -->
        <aside class="w-64 bg-white shadow-lg min-h-screen p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Classroom</h3>
            <div class="space-y-2">
                <div class="p-3 bg-gray-100 rounded">
                    <span class="text-sm text-gray-600">🏠 Dashboard</span>
                </div>
                <div class="p-3 hover:bg-gray-50 rounded cursor-not-allowed">
                    <span class="text-sm text-gray-400">📚 Assignments</span>
                </div>
                <div class="p-3 hover:bg-gray-50 rounded cursor-not-allowed">
                    <span class="text-sm text-gray-400">📝 Grades</span>
                </div>
                <div class="p-3 hover:bg-gray-50 rounded cursor-not-allowed">
                    <span class="text-sm text-gray-400">📅 Schedule</span>
                </div>
            </div>

            <!-- User Directory -->
            <div class="mt-8">
                <h4 class="font-semibold text-gray-700 mb-3">User Directory</h4>
                <div class="space-y-2 max-h-80 overflow-y-auto">
                    <?php
                    // Re-execute the query to get fresh results
                    $classmates_query = "SELECT * FROM users WHERE id != " . $current_user['id'] . " ORDER BY role DESC, full_name ASC";
                    $classmates_result = $conn->query($classmates_query);

                    if ($classmates_result && $classmates_result->num_rows > 0):
                        while ($classmate = $classmates_result->fetch_assoc()): ?>
                            <div class="p-3 bg-gray-50 rounded hover:bg-gray-100 transition">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center space-x-2">
                                        <?php if ($classmate['role'] === 'admin'): ?>
                                            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-semibold">
                                                👑 Professor
                                            </span>
                                        <?php else: ?>
                                            <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold">
                                                🎓 Student
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($classmate['id'] === $current_user['id']): ?>
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">You</span>
                                    <?php endif; ?>
                                </div>
                                <div class="mt-1">
                                    <p class="font-medium text-gray-800 text-sm">
                                        <?php echo htmlspecialchars($classmate['full_name']); ?>
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        <?php echo htmlspecialchars($classmate['email']); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endwhile;
                    else: ?>
                        <div class="p-4 bg-gray-50 rounded text-center">
                            <span class="text-gray-400">No other users enrolled yet</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-6 p-3 bg-yellow-50 border border-yellow-200 rounded">
                <p class="text-xs text-yellow-700">
                    <strong>Notice:</strong> Limited access features are available.
                </p>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="max-w-4xl mx-auto">
                <!-- Waiting Message -->
                <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                    <div class="mb-8">
                        <svg class="w-24 h-24 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-400 mb-4">Class hasn't started yet</h2>
                    <p class="text-gray-500 text-lg mb-8">
                        Please wait for your instructor to begin the session.
                    </p>

                    <div class="bg-gray-50 rounded-lg p-6 max-w-md mx-auto">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Your Status:</span>
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full">Waiting</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Session:</span>
                                <span class="text-gray-500">Not Started</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Instructor:</span>
                                <span class="text-gray-500">Not Available</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 p-4 bg-blue-50 rounded-lg max-w-md mx-auto">
                        <p class="text-sm text-blue-700">
                            <strong>📋 What you can do:</strong><br>
                            View classmates list<br>
                            Wait for instructor to start class<br>
                            Access will be granted when session begins
                        </p>
                    </div>

                    <!-- Disabled Actions -->
                    <div class="mt-8">
                        <p class="text-sm text-gray-400 mb-4">Available when class starts:</p>
                        <div class="flex justify-center space-x-4">
                            <button disabled class="px-4 py-2 bg-gray-200 text-gray-400 rounded cursor-not-allowed">
                                View Assignments
                            </button>
                            <button disabled class="px-4 py-2 bg-gray-200 text-gray-400 rounded cursor-not-allowed">
                                Check Grades
                            </button>
                            <button disabled class="px-4 py-2 bg-gray-200 text-gray-400 rounded cursor-not-allowed">
                                Join Session
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Limited Features Notice -->
                <div class="mt-8 bg-yellow-50 border-l-4 border-yellow-500 p-6 rounded-lg">
                    <div class="flex items-start">
                        <svg class="h-6 w-6 text-yellow-400 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h3 class="text-lg font-semibold text-yellow-800 mb-2">Student Access</h3>
                            <p class="text-yellow-700 text-sm">
                                As a student, you have limited access to the COSMOS system. Full features will be available
                                once your instructor starts the class session. Please be patient while we prepare the learning environment.
                            </p>
                            <p class="text-yellow-600 text-xs mt-2">
                                Current permissions: View only | No administrative access | Limited functionality
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Quick Info -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-lg p-6 text-center shadow">
                        <div class="text-2xl font-bold text-blue-600 mb-2">0</div>
                        <div class="text-sm text-gray-600">Active Assignments</div>
                    </div>
                    <div class="bg-white rounded-lg p-6 text-center shadow">
                        <div class="text-2xl font-bold text-green-600 mb-2">0</div>
                        <div class="text-sm text-gray-600">Completed Tasks</div>
                    </div>
                    <div class="bg-white rounded-lg p-6 text-center shadow">
                        <div class="text-2xl font-bold text-purple-600 mb-2">--</div>
                        <div class="text-sm text-gray-600">Current Grade</div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>