<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CosmosCorp - Enterprise Technology Solutions</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Professional Header -->
    <header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <nav class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-8">
                    <h1 class="text-2xl font-bold text-gray-900">
                        Cosmos<span class="text-blue-600">Corp</span>
                    </h1>
                    <ul class="hidden md:flex space-x-8">
                        <li><a href="?page=home" class="text-gray-700 hover:text-blue-600 font-medium transition">Home</a></li>
                        <li><a href="?page=about" class="text-gray-700 hover:text-blue-600 font-medium transition">About</a></li>
                        <li><a href="?page=services" class="text-gray-700 hover:text-blue-600 font-medium transition">Services</a></li>
                        <li><a href="?page=contact" class="text-gray-700 hover:text-blue-600 font-medium transition">Contact</a></li>
                    </ul>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                        Get Quote
                    </button>
                    <button class="md:hidden text-gray-700">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mx-auto px-4 py-8">
        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            include('pages/' . $page);
        } else {
            include('pages/home');
        }
        ?>
    </main>

    <!-- Professional Footer -->
    <footer class="bg-gray-900 text-white mt-16">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4">Cosmos<span class="text-blue-400">Corp</span></h3>
                    <p class="text-gray-400 text-sm">
                        Leading enterprise technology solutions provider for modern businesses.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Services</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="?page=services" class="hover:text-white">Cloud Solutions</a></li>
                        <li><a href="?page=services" class="hover:text-white">Enterprise Software</a></li>
                        <li><a href="?page=services" class="hover:text-white">IT Consulting</a></li>
                        <li><a href="?page=services" class="hover:text-white">Security Services</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="?page=about" class="hover:text-white">About Us</a></li>
                        <li><a href="?page=contact" class="hover:text-white">Contact</a></li>
                        <li><a href="#" class="hover:text-white">Careers</a></li>
                        <li><a href="#" class="hover:text-white">Partners</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Connect</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-github text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fas fa-envelope text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; 2024 CosmosCorp. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>