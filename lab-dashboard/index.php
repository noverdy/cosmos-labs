<?php
$labs = [
    [
        'name' => 'LFI Lab',
        'port' => 8081,
        'description' => 'Local File Inclusion exercises',
        'icon' => '📁',
        'color' => 'blue'
    ],
    [
        'name' => 'XSS Lab',
        'port' => 8082,
        'description' => 'Cross-Site Scripting challenges',
        'icon' => '🌐',
        'color' => 'green'
    ],
    [
        'name' => 'SQLI Lab',
        'port' => 8083,
        'description' => 'SQL Injection practice',
        'icon' => '🗄️',
        'color' => 'purple'
    ],
    [
        'name' => 'JWT Lab',
        'port' => 8084,
        'description' => 'JSON Web Token security',
        'icon' => '🔑',
        'color' => 'orange'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COSMOS Security Labs Dashboard</title>
    <link rel="icon" type="image/png" href="favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .lab-card {
            transition: all 0.3s ease;
        }
        .lab-card:hover {
            transform: translateY(-4px);
        }
      </style>
</head>
<body class="bg-gray-900 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="text-center mb-12">
            <h1 class="text-5xl font-bold text-white mb-4">
                COSMOS<span class="text-blue-400">Labs</span>
            </h1>
            <p class="text-xl text-gray-300">Security Learning Environment</p>
            <div class="mt-6 inline-flex items-center px-4 py-2 bg-gray-800 rounded-lg border border-gray-700">
                <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                <span class="text-sm text-gray-300">Dashboard Active</span>
            </div>
        </header>

        <!-- Lab Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <?php foreach ($labs as $lab): ?>
                <div class="lab-card bg-gray-800 rounded-xl shadow-lg border border-gray-700 overflow-hidden">
                    <div class="p-6">
                        <!-- Lab Icon -->
                        <div class="flex items-center justify-center mb-4">
                            <div class="text-4xl"><?php echo $lab['icon']; ?></div>
                        </div>

                        <!-- Lab Info -->
                        <h3 class="text-xl font-bold text-white mb-2"><?php echo htmlspecialchars($lab['name']); ?></h3>
                        <p class="text-gray-300 text-sm mb-4"><?php echo htmlspecialchars($lab['description']); ?></p>

                        <!-- Port Info -->
                        <div class="text-xs text-gray-400 mb-4">
                            Port: <?php echo $lab['port']; ?>
                        </div>

                        <!-- Access Button -->
                        <a href="http://localhost:<?php echo $lab['port']; ?>"
                           target="_blank"
                           class="w-full block text-center bg-<?php echo $lab['color']; ?>-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-<?php echo $lab['color']; ?>-700 transition">
                            Access Lab
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Info Section -->
        <div class="bg-gray-800 rounded-xl shadow-lg border border-gray-700 p-8">
            <h2 class="text-2xl font-bold text-white mb-4">Welcome to COSMOS Security Labs</h2>
            <p class="text-gray-300 mb-4">
                This dashboard provides access to various security laboratories designed for educational purposes.
                Each lab focuses on different security concepts and provides hands-on learning experiences.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                <div class="bg-gray-700 rounded-lg p-4">
                    <h3 class="font-semibold text-white mb-2">Getting Started</h3>
                    <ul class="text-sm text-gray-300 space-y-1">
                        <li>• Ensure all lab services are running</li>
                        <li>• Click "Access Lab" to open each environment</li>
                        <li>• Follow the instructions within each lab</li>
                    </ul>
                </div>
                <div class="bg-gray-700 rounded-lg p-4">
                    <h3 class="font-semibold text-white mb-2">Lab Access</h3>
                    <ul class="text-sm text-gray-300 space-y-1">
                        <li>• Click "Access Lab" to open each environment</li>
                        <li>• Each lab runs on its designated port</li>
                        <li>• All labs are accessible from this dashboard</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="text-center mt-12 text-gray-400 text-sm">
            <p>COSMOS Security Learning Environment</p>
            <p class="mt-1">For educational purposes only</p>
        </footer>
    </div>

    <script>
        // Add keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if (e.key >= '1' && e.key <= '4') {
                const labIndex = parseInt(e.key) - 1;
                const labCards = document.querySelectorAll('.lab-card');
                if (labCards[labIndex]) {
                    const link = labCards[labIndex].querySelector('a');
                    if (link) {
                        window.open(link.href, '_blank');
                    }
                }
            }
        });
    </script>
</body>
</html>