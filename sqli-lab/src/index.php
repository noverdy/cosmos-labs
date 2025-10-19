<?php
require_once 'config.php';

// Redirect to dashboard if already logged in
if (isLoggedIn()) {
    redirect('dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COSMOS Apps - Classroom Management System</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-4xl mx-auto text-center">
            <!-- Main Content -->
            <div class="mb-16">
                <h1 class="text-6xl font-bold text-gray-800 mb-4">
                    COSMOS<span class="text-blue-600">Apps</span>
                </h1>
                <p class="text-2xl text-gray-600 mb-8">Classroom Management System</p>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Welcome to the COSMOS Classroom Management System. Join our learning community
                    where teachers and students collaborate in a secure educational environment.
                </p>
            </div>

            <!-- Action Cards -->
            <div class="grid md:grid-cols-2 gap-8 mb-16">
                <div class="bg-white rounded-xl shadow-2xl p-8 transform hover:scale-105 transition">
                    <div class="bg-gradient-to-r from-purple-600 to-blue-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Login to Your Account</h2>
                    <p class="text-gray-600 mb-6">
                        Access your classroom dashboard, view course materials, and connect with fellow students.
                    </p>
                    <a href="login.php" class="inline-flex items-center bg-gradient-to-r from-purple-600 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:from-purple-700 hover:to-blue-700 transition">
                        Login Now
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-2xl p-8 transform hover:scale-105 transition">
                    <div class="bg-gradient-to-r from-green-600 to-teal-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Create Student Account</h2>
                    <p class="text-gray-600 mb-6">
                        New to COSMOS? Register as a student and join our learning community today.
                    </p>
                    <a href="register.php" class="inline-flex items-center bg-gradient-to-r from-green-600 to-teal-600 text-white font-semibold py-3 px-6 rounded-lg hover:from-green-700 hover:to-teal-700 transition">
                        Register Now
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Features Section -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 text-white">
                <h3 class="text-2xl font-bold mb-6">Classroom Features</h3>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="bg-white/20 rounded-lg p-4 mb-4">
                            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                        </div>
                        <h4 class="font-semibold mb-2">User Management</h4>
                        <p class="text-purple-100 text-sm">View all classroom members and their roles</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-white/20 rounded-lg p-4 mb-4">
                            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h4 class="font-semibold mb-2">Secure Environment</h4>
                        <p class="text-purple-100 text-sm">Protected learning space for students and teachers</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-white/20 rounded-lg p-4 mb-4">
                            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <h4 class="font-semibold mb-2">Activity Tracking</h4>
                        <p class="text-purple-100 text-sm">Monitor classroom activities and user engagement</p>
                    </div>
                </div>
            </div>

            <!-- System Status -->
            <div class="mt-8 bg-white/10 backdrop-blur-sm rounded-lg p-6 text-white text-sm">
                <p class="italic">
                    📚 <strong>Academic Portal:</strong> COSMOS Apps is the official learning management system for our educational institution.
                    Access your courses, submit assignments, and track your academic progress.
                </p>
            </div>
        </div>
    </div>
</body>
</html>