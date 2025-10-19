<?php
require_once 'config.php';

$articles_query = "SELECT * FROM news_articles ORDER BY created_at DESC";
$articles_result = $conn->query($articles_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CosmosNews - Your Source for Technology News & Security Updates</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Top Navigation Bar -->
    <header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <div class="flex items-center justify-between w-full">
                    <h1 class="text-3xl font-bold text-gray-900">
                        Cosmos<span class="text-blue-600">News</span>
                    </h1>
                    <nav class="hidden md:flex space-x-6">
                        <a href="index.php" class="text-gray-700 hover:text-blue-600 font-medium transition">Home</a>
                        <a href="#cybersecurity" class="text-gray-700 hover:text-blue-600 font-medium transition">Cybersecurity</a>
                        <a href="#development" class="text-gray-700 hover:text-blue-600 font-medium transition">Development</a>
                        <a href="#business" class="text-gray-700 hover:text-blue-600 font-medium transition">Business</a>
                    </nav>
                </div>
            </div>
        </div>
        </div>
    </header>

    <!-- Breaking News Ticker -->
    <div class="bg-red-600 text-white py-2">
        <div class="container mx-auto px-4 flex items-center">
            <span class="bg-red-800 px-3 py-1 rounded text-sm font-bold mr-4">BREAKING</span>
            <div class="flex-1 overflow-hidden">
                <div class="animate-pulse">
                    Major cybersecurity conference announced for next month • New JavaScript framework gains popularity • Local companies enhance security measures
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Featured Article -->
            <div class="lg:col-span-2">
                <?php
                $featured_query = "SELECT * FROM news_articles ORDER BY created_at DESC LIMIT 1";
                $featured_result = $conn->query($featured_query);

                if ($featured_result && $featured_result->num_rows > 0) {
                    $featured = $featured_result->fetch_assoc();
                } else {
                    // Create a default featured article if database is empty
                    $featured = [
                        'id' => 1,
                        'title' => 'Welcome to CosmosNews',
                        'content' => 'Your trusted source for the latest technology news, cybersecurity updates, and development trends. Stay informed with our comprehensive coverage of the tech world.',
                        'author' => 'Editorial Team',
                        'created_at' => date('Y-m-d H:i:s'),
                        'category' => 'Technology',
                        'header_image' => 'https://picsum.photos/seed/welcome-cosmosnews/1200/800'
                    ];
                }
                ?>
                <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
                    <?php if (!empty($featured['header_image'])): ?>
                        <div class="relative h-96">
                            <img src="<?php echo htmlspecialchars($featured['header_image']); ?>"
                                 alt="<?php echo htmlspecialchars($featured['title']); ?>"
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 p-8 text-white">
                                <span class="bg-red-600 px-3 py-1 rounded text-xs font-bold uppercase tracking-wide">
                                    <?php echo htmlspecialchars($featured['category'] ?? 'Technology'); ?>
                                </span>
                                <h2 class="text-3xl font-bold mt-3 mb-2">
                                    <?php if (isset($featured['id']) && $featured['id'] != 1): ?>
                                    <a href="article.php?id=<?php echo $featured['id']; ?>" class="hover:text-blue-300 transition">
                                        <?php echo htmlspecialchars($featured['title']); ?>
                                    </a>
                                    <?php else: ?>
                                        <?php echo htmlspecialchars($featured['title']); ?>
                                    <?php endif; ?>
                                </h2>
                                <p class="text-gray-200 mb-3">
                                    <?php echo substr(strip_tags($featured['content']), 0, 150) . '...'; ?>
                                </p>
                                <div class="flex items-center space-x-4 text-sm">
                                    <span>By <?php echo htmlspecialchars($featured['author']); ?></span>
                                    <span><?php echo date('M j, Y', strtotime($featured['created_at'])); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-12 text-white">
                            <span class="bg-white/20 px-3 py-1 rounded text-xs font-bold uppercase tracking-wide">
                                <?php echo htmlspecialchars($featured['category'] ?? 'Technology'); ?>
                            </span>
                            <h2 class="text-3xl font-bold mt-4 mb-3">
                                <?php if (isset($featured['id']) && $featured['id'] != 1): ?>
                                <a href="article.php?id=<?php echo $featured['id']; ?>" class="hover:text-blue-200 transition">
                                    <?php echo htmlspecialchars($featured['title']); ?>
                                </a>
                                <?php else: ?>
                                    <?php echo htmlspecialchars($featured['title']); ?>
                                <?php endif; ?>
                            </h2>
                            <p class="text-blue-100 mb-4">
                                <?php echo substr(strip_tags($featured['content']), 0, 200) . '...'; ?>
                            </p>
                            <div class="flex items-center space-x-4 text-sm">
                                <span>By <?php echo htmlspecialchars($featured['author']); ?></span>
                                <span><?php echo date('M j, Y', strtotime($featured['created_at'])); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                </article>
            </div>

            <!-- Trending Sidebar -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-fire text-orange-500 mr-2"></i>
                        Trending Now
                    </h3>
                    <div class="space-y-3">
                        <?php
                        $trending_query = "SELECT * FROM news_articles ORDER BY created_at DESC LIMIT 1, 3";
                        $trending_result = $conn->query($trending_query);

                        if ($trending_result && $trending_result->num_rows > 0) {
                            while ($trending = $trending_result->fetch_assoc()): ?>
                                <div class="border-b border-gray-100 pb-3 last:border-0">
                                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">
                                        <?php echo htmlspecialchars($trending['category'] ?? 'Technology'); ?>
                                    </span>
                                    <h4 class="font-semibold text-gray-800 mt-1">
                                        <a href="article.php?id=<?php echo $trending['id']; ?>" class="hover:text-blue-600 transition text-sm">
                                            <?php echo htmlspecialchars($trending['title']); ?>
                                        </a>
                                    </h4>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <?php echo date('M j', strtotime($trending['created_at'])); ?>
                                    </p>
                                </div>
                            <?php endwhile;
                        } else {
                            // Show default trending items if database is empty
                            $default_trending = [
                                ['title' => 'Cybersecurity Best Practices for 2024', 'category' => 'Security'],
                                ['title' => 'AI Development Trends to Watch', 'category' => 'AI'],
                                ['title' => 'Cloud Computing Innovations', 'category' => 'Cloud']
                            ];
                            foreach ($default_trending as $index => $item): ?>
                                <div class="border-b border-gray-100 pb-3 last:border-0">
                                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">
                                        <?php echo htmlspecialchars($item['category']); ?>
                                    </span>
                                    <h4 class="font-semibold text-gray-800 mt-1 text-sm">
                                        <?php echo htmlspecialchars($item['title']); ?>
                                    </h4>
                                    <p class="text-xs text-gray-500 mt-1">Coming soon</p>
                                </div>
                            <?php endforeach;
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Articles Grid -->
    <section class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Latest Articles</h2>
            <div class="flex space-x-2">
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">All</button>
                <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300">Popular</button>
                <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300">Recent</button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $articles_query = "SELECT * FROM news_articles ORDER BY created_at DESC";
            $articles_result = $conn->query($articles_query);

            if ($articles_result && $articles_result->num_rows > 0):
                $skip_first = true; // Skip the first one as it's featured
                while ($article = $articles_result->fetch_assoc()):
                    if ($skip_first) {
                        $skip_first = false;
                        continue;
                    }
            ?>
                <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1">
                    <?php if (!empty($article['header_image'])): ?>
                        <div class="h-48 overflow-hidden">
                            <img src="<?php echo htmlspecialchars($article['header_image']); ?>"
                                 alt="<?php echo htmlspecialchars($article['title']); ?>"
                                 class="w-full h-full object-cover hover:scale-105 transition duration-300">
                        </div>
                    <?php else: ?>
                        <div class="h-48 bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center">
                            <i class="fas fa-newspaper text-white text-3xl"></i>
                        </div>
                    <?php endif; ?>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded font-medium">
                                <?php echo htmlspecialchars($article['category'] ?? 'Technology'); ?>
                            </span>
                            <span class="text-xs text-gray-500">
                                <?php echo date('M j, Y', strtotime($article['created_at'])); ?>
                            </span>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2 line-clamp-2">
                            <a href="article.php?id=<?php echo $article['id']; ?>" class="hover:text-blue-600 transition">
                                <?php echo htmlspecialchars($article['title']); ?>
                            </a>
                        </h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                            <?php echo substr(strip_tags($article['content']), 0, 120) . '...'; ?>
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">
                                        <?php echo strtoupper(substr($article['author'], 0, 1)); ?>
                                    </span>
                                </div>
                                <span class="text-sm text-gray-700"><?php echo htmlspecialchars($article['author']); ?></span>
                            </div>
                            <div class="flex items-center space-x-3 text-gray-500 text-sm">
                                <span class="flex items-center">
                                    <i class="fas fa-comment mr-1"></i>
                                    <?php
                                    $comment_count_query = "SELECT COUNT(*) as count FROM comments WHERE article_id = " . $article['id'];
                                    $comment_count_result = $conn->query($comment_count_query);
                                    if ($comment_count_result) {
                                        $comment_count = $comment_count_result->fetch_assoc()['count'];
                                        echo $comment_count;
                                    } else {
                                        echo '0';
                                    }
                                    ?>
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-share mr-1"></i>
                                    Share
                                </span>
                            </div>
                        </div>
                    </div>
                </article>
            <?php
                endwhile;
            else:
                // Show sample articles if database is empty
                $sample_articles = [
                    [
                        'title' => 'Getting Started with Cybersecurity',
                        'content' => 'Learn the fundamentals of cybersecurity and how to protect yourself online.',
                        'author' => 'Security Team',
                        'category' => 'Cybersecurity',
                        'header_image' => 'https://picsum.photos/seed/cybersecurity-basics/800/600'
                    ],
                    [
                        'title' => 'Web Development Best Practices',
                        'content' => 'Discover the latest trends and best practices in modern web development.',
                        'author' => 'Dev Team',
                        'category' => 'Development',
                        'header_image' => 'https://picsum.photos/seed/web-development/800/600'
                    ],
                    [
                        'title' => 'Tech Industry News Roundup',
                        'content' => 'Weekly roundup of the most important news in the technology industry.',
                        'author' => 'News Desk',
                        'category' => 'Technology',
                        'header_image' => 'https://picsum.photos/seed/tech-news/800/600'
                    ]
                ];

                foreach ($sample_articles as $article): ?>
                    <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1">
                        <div class="h-48 overflow-hidden">
                            <img src="<?php echo htmlspecialchars($article['header_image']); ?>"
                                 alt="<?php echo htmlspecialchars($article['title']); ?>"
                                 class="w-full h-full object-cover hover:scale-105 transition duration-300">
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded font-medium">
                                    <?php echo htmlspecialchars($article['category']); ?>
                                </span>
                                <span class="text-xs text-gray-500">
                                    <?php echo date('M j, Y'); ?>
                                </span>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-2 line-clamp-2">
                                <span class="text-gray-400">
                                    <?php echo htmlspecialchars($article['title']); ?>
                                </span>
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                <?php echo htmlspecialchars($article['content']); ?>
                            </p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                        <span class="text-white text-xs font-bold">
                                            <?php echo strtoupper(substr($article['author'], 0, 1)); ?>
                                        </span>
                                    </div>
                                    <span class="text-sm text-gray-700"><?php echo htmlspecialchars($article['author']); ?></span>
                                </div>
                                <div class="flex items-center space-x-3 text-gray-500 text-sm">
                                    <span class="flex items-center">
                                        <i class="fas fa-comment mr-1"></i>
                                        0
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-share mr-1"></i>
                                        Share
                                    </span>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach;
            endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-16">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4">Cosmos<span class="text-blue-400">News</span></h3>
                    <p class="text-gray-400 text-sm">
                        Your trusted source for the latest technology news, cybersecurity updates, and development trends.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Categories</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-white">Cybersecurity</a></li>
                        <li><a href="#" class="hover:text-white">Development</a></li>
                        <li><a href="#" class="hover:text-white">Business</a></li>
                        <li><a href="#" class="hover:text-white">Innovation</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-white">About Us</a></li>
                        <li><a href="#" class="hover:text-white">Contact</a></li>
                        <li><a href="#" class="hover:text-white">Careers</a></li>
                        <li><a href="#" class="hover:text-white">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; 2024 CosmosNews. All rights reserved. | This is a training environment for security testing</p>
            </div>
        </div>
    </footer>
</body>
</html>