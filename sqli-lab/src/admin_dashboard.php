<?php
require_once 'config.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$current_user = getCurrentUser();

if ($current_user['role'] !== 'admin') {
    redirect('student_dashboard.php');
}

$users_query = "SELECT * FROM users ORDER BY role DESC, created_at ASC";
$users_result = $conn->query($users_query);

$total_users_query = "SELECT COUNT(*) as total FROM users";
$total_users_result = $conn->query($total_users_query);
$total_users = $total_users_result->fetch_assoc()['total'];

$admin_count_query = "SELECT COUNT(*) as count FROM users WHERE role = 'admin'";
$admin_count_result = $conn->query($admin_count_query);
$admin_count = $admin_count_result->fetch_assoc()['count'];

$student_count_query = "SELECT COUNT(*) as count FROM users WHERE role = 'student'";
$student_count_result = $conn->query($student_count_query);
$student_count = $student_count_result->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - COSMOS Apps</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation Header -->
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold text-gray-800">
                        COSMOS<span class="text-blue-600">Apps</span>
                    </h1>
                    <span class="text-gray-600 text-sm">Administrative Control Panel</span>
                </div>
                <div class="flex items-center space-x-6">
                    <span class="text-gray-700">
                        Welcome, <strong><?php echo htmlspecialchars($current_user['full_name']); ?></strong>
                        <span class="ml-2 px-3 py-1 bg-red-600 text-white rounded-full text-xs font-bold">
                            ADMINISTRATOR
                        </span>
                    </span>
                    <a href="logout.php" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg transition text-sm">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="flex">
        <!-- Sidebar Navigation -->
        <aside class="w-64 bg-gray-800 text-white min-h-screen">
            <div class="p-6">
                <h3 class="text-lg font-semibold mb-6 text-gray-100">Admin Controls</h3>
                <nav class="space-y-2">
                    <a href="#dashboard" class="flex items-center space-x-3 px-4 py-3 bg-gray-700 rounded-lg hover:bg-gray-600 transition">
                        <span>📊</span>
                        <span>Dashboard Overview</span>
                    </a>
                    <a href="#users" class="flex items-center space-x-3 px-4 py-3 hover:bg-gray-700 rounded-lg transition">
                        <span>👥</span>
                        <span>User Management</span>
                    </a>
                    <a href="#courses" class="flex items-center space-x-3 px-4 py-3 hover:bg-gray-700 rounded-lg transition">
                        <span>📚</span>
                        <span>Course Management</span>
                    </a>
                    <a href="#grades" class="flex items-center space-x-3 px-4 py-3 hover:bg-gray-700 rounded-lg transition">
                        <span>📝</span>
                        <span>Grade Center</span>
                    </a>
                    <a href="#analytics" class="flex items-center space-x-3 px-4 py-3 hover:bg-gray-700 rounded-lg transition">
                        <span>📈</span>
                        <span>Analytics & Reports</span>
                    </a>
                    <a href="#settings" class="flex items-center space-x-3 px-4 py-3 hover:bg-gray-700 rounded-lg transition">
                        <span>⚙️</span>
                        <span>System Settings</span>
                    </a>
                    <a href="#security" class="flex items-center space-x-3 px-4 py-3 hover:bg-gray-700 rounded-lg transition">
                        <span>🔐</span>
                        <span>Security Center</span>
                    </a>
                    <a href="#communication" class="flex items-center space-x-3 px-4 py-3 hover:bg-gray-700 rounded-lg transition">
                        <span>📢</span>
                        <span>Announcements</span>
                    </a>
                    <a href="#resources" class="flex items-center space-x-3 px-4 py-3 hover:bg-gray-700 rounded-lg transition">
                        <span>📦</span>
                        <span>Resource Library</span>
                    </a>
                    <a href="#logs" class="flex items-center space-x-3 px-4 py-3 hover:bg-gray-700 rounded-lg transition">
                        <span>📋</span>
                        <span>Audit Logs</span>
                    </a>
                    <a href="#backup" class="flex items-center space-x-3 px-4 py-3 hover:bg-gray-700 rounded-lg transition">
                        <span>💾</span>
                        <span>Backup & Restore</span>
                    </a>
                </nav>

                <div class="mt-8 p-4 bg-yellow-900/30 rounded-lg border border-yellow-600">
                    <p class="text-xs text-yellow-300 font-semibold">⚠️ System Status</p>
                    <p class="text-xs text-yellow-200 mt-1">All systems operational</p>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <!-- System Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total Users</p>
                            <p class="text-3xl font-bold text-gray-800"><?php echo $total_users; ?></p>
                        </div>
                        <div class="bg-red-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Administrators</p>
                            <p class="text-3xl font-bold text-gray-800"><?php echo $admin_count; ?></p>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Students</p>
                            <p class="text-3xl font-bold text-gray-800"><?php echo $student_count; ?></p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">System Health</p>
                            <p class="text-3xl font-bold text-green-600">98%</p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">🚀 Quick Actions</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <button class="p-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        <span class="text-sm">Add User</span>
                    </button>
                    <button class="p-4 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span class="text-sm">Create Course</span>
                    </button>
                    <button class="p-4 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                        <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <span class="text-sm">Grade Assignment</span>
                    </button>
                    <button class="p-4 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="text-sm">Send Alert</span>
                    </button>
                </div>
            </div>

            <!-- User Management Table -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gray-50 border-b border-gray-200 p-6">
                    <h2 class="text-2xl font-bold text-gray-800">👥 User Management</h2>
                    <p class="text-gray-600 mt-1">Complete control over all system users</p>
                </div>

                <div class="p-6">
                    <?php if ($users_result->num_rows > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b-2 border-gray-200">
                                        <th class="text-left py-3 px-4 font-semibold text-gray-700">ID</th>
                                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Username</th>
                                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Full Name</th>
                                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Email</th>
                                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Role</th>
                                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
                                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($user = $users_result->fetch_assoc()): ?>
                                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                            <td class="py-3 px-4 text-gray-600">#<?php echo $user['id']; ?></td>
                                            <td class="py-3 px-4">
                                                <span class="font-medium text-gray-800">
                                                    <?php echo htmlspecialchars($user['username']); ?>
                                                </span>
                                                <?php if ($user['username'] === $current_user['username']): ?>
                                                    <span class="ml-2 text-xs bg-green-100 text-green-800 px-2 py-1 rounded">You</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="py-3 px-4 text-gray-700"><?php echo htmlspecialchars($user['full_name']); ?></td>
                                            <td class="py-3 px-4">
                                                <a href="mailto:<?php echo htmlspecialchars($user['email']); ?>"
                                                   class="text-blue-600 hover:text-blue-800 text-sm">
                                                    <?php echo htmlspecialchars($user['email']); ?>
                                                </a>
                                            </td>
                                            <td class="py-3 px-4">
                                                <?php if ($user['role'] === 'admin'): ?>
                                                    <span class="px-3 py-1 bg-red-600 text-white rounded-full text-sm font-bold">
                                                        👑 Administrator
                                                    </span>
                                                <?php else: ?>
                                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                                        🎓 Student
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="py-3 px-4">
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Active</span>
                                            </td>
                                            <td class="py-3 px-4">
                                                <div class="flex space-x-2">
                                                    <button class="text-blue-600 hover:text-blue-800 text-sm">Edit</button>
                                                    <button class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                                                    <button class="text-purple-600 hover:text-purple-800 text-sm">Reset</button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                                <p class="text-sm text-red-700">
                                    <strong>Administrative Privilege:</strong> You have complete control over all user accounts and system settings.
                                    Exercise this power responsibly.
                                </p>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <p class="text-gray-500">No users found in the system.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- System Activity Log -->
            <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">📋 Recent System Activity</h3>
                <div class="space-y-2">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <span class="text-sm text-gray-600">User login detected</span>
                        <span class="text-xs text-gray-400">2 minutes ago</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <span class="text-sm text-gray-600">Database backup completed</span>
                        <span class="text-xs text-gray-400">1 hour ago</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <span class="text-sm text-gray-600">System health check passed</span>
                        <span class="text-xs text-gray-400">2 hours ago</span>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>