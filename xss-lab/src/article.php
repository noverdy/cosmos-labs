<?php
require_once 'config.php';

$article_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$article_query = "SELECT * FROM news_articles WHERE id = $article_id";
$article_result = $conn->query($article_query);
$article = $article_result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'])) {
    $username = $_POST['username'] ?? 'Anonymous';
    $comment_text = $_POST['comment_text'] ?? '';

    $insert_comment = "INSERT INTO comments (article_id, username, comment_text) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_comment);
    $stmt->bind_param("iss", $article_id, $username, $comment_text);
    $stmt->execute();

    header("Location: article.php?id=$article_id#comments");
    exit();
}

$comments_query = "SELECT * FROM comments WHERE article_id = $article_id ORDER BY created_at DESC";
$comments_result = $conn->query($comments_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['title'] ?? 'Article'); ?> - CosmosNews</title>
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

    <main class="container mx-auto px-4 py-8">
        <?php if ($article): ?>
            <!-- Article Header with Image -->
            <article class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                <?php if (!empty($article['header_image'])): ?>
                    <div class="relative h-80 md:h-96">
                        <img src="<?php echo htmlspecialchars($article['header_image']); ?>"
                             alt="<?php echo htmlspecialchars($article['title']); ?>"
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-8 text-white">
                            <div class="flex items-center space-x-3 mb-3">
                                <span class="bg-red-600 px-3 py-1 rounded text-xs font-bold uppercase tracking-wide">
                                    <?php echo htmlspecialchars($article['category'] ?? 'Technology'); ?>
                                </span>
                                <span class="text-sm opacity-90">
                                    <i class="far fa-clock mr-1"></i>
                                    <?php echo date('F j, Y', strtotime($article['created_at'])); ?>
                                </span>
                            </div>
                            <h1 class="text-3xl md:text-4xl font-bold leading-tight">
                                <?php echo htmlspecialchars($article['title']); ?>
                            </h1>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-8 text-white">
                        <span class="bg-white/20 px-3 py-1 rounded text-xs font-bold uppercase tracking-wide">
                            <?php echo htmlspecialchars($article['category'] ?? 'Technology'); ?>
                        </span>
                        <h1 class="text-3xl md:text-4xl font-bold mt-4">
                            <?php echo htmlspecialchars($article['title']); ?>
                        </h1>
                    </div>
                <?php endif; ?>

                <!-- Article Meta and Content -->
                <div class="p-8">
                    <!-- Article Meta -->
                    <div class="flex items-center justify-between border-b border-gray-200 pb-4 mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold">
                                        <?php echo strtoupper(substr($article['author'], 0, 1)); ?>
                                    </span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">
                                        <?php echo htmlspecialchars($article['author']); ?>
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        <?php echo date('F j, Y g:i A', strtotime($article['created_at'])); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <button class="text-gray-500 hover:text-blue-600 transition">
                                <i class="fas fa-share-alt text-xl"></i>
                            </button>
                            <button class="text-gray-500 hover:text-red-600 transition">
                                <i class="far fa-heart text-xl"></i>
                            </button>
                            <button class="text-gray-500 hover:text-blue-600 transition">
                                <i class="far fa-bookmark text-xl"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Article Content -->
                    <div class="prose prose-lg max-w-none text-gray-800">
                        <?php echo nl2br(htmlspecialchars($article['content'])); ?>
                    </div>

                    <!-- Article Tags and Share -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex flex-wrap items-center justify-between">
                            <div class="flex flex-wrap gap-2 mb-4 md:mb-0">
                                <span class="bg-gray-100 px-3 py-1 rounded-full text-sm text-gray-700">
                                    #technology
                                </span>
                                <span class="bg-gray-100 px-3 py-1 rounded-full text-sm text-gray-700">
                                    #<?php echo strtolower(str_replace(' ', '', $article['category'] ?? 'Technology')); ?>
                                </span>
                                <span class="bg-gray-100 px-3 py-1 rounded-full text-sm text-gray-700">
                                    #news
                                </span>
                            </div>
                            <div class="flex space-x-3">
                                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                    <i class="fab fa-twitter mr-2"></i>Share
                                </button>
                                <button class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition text-sm font-medium">
                                    <i class="fab fa-linkedin mr-2"></i>Share
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Comments Section -->
            <section id="comments" class="bg-white rounded-xl shadow-lg p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">
                        <i class="fas fa-comments text-blue-600 mr-2"></i>
                        Discussion
                    </h2>
                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                        <?php echo $comments_result->num_rows; ?> Comments
                    </span>
                </div>

                <!-- Comment Form -->
                <div class="mb-8 p-6 bg-gray-50 rounded-xl border border-gray-200">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-pen text-blue-600 mr-2"></i>
                        Join the Discussion
                    </h3>
                    <form method="POST" action="" class="space-y-4">
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                Your Name
                            </label>
                            <input type="text" id="username" name="username" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                   placeholder="Enter your name">
                        </div>
                        <div>
                            <label for="comment_text" class="block text-sm font-medium text-gray-700 mb-2">
                                Your Comment
                            </label>
                            <textarea id="comment_text" name="comment_text" rows="4" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                      placeholder="Share your thoughts about this article..."></textarea>
                        </div>
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Be respectful and constructive in your comments
                            </p>
                            <button type="submit" name="submit_comment"
                                    class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-medium">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Post Comment
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Comments List -->
                <div class="space-y-4">
                    <?php if ($comments_result->num_rows > 0): ?>
                        <?php while ($comment = $comments_result->fetch_assoc()): ?>
                            <div class="border-l-4 border-blue-500 pl-6 py-4 bg-gray-50 rounded-r-lg">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">
                                                <?php echo strtoupper(substr($comment['username'], 0, 1)); ?>
                                            </span>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900">
                                                <?php echo $comment['username']; ?>
                                            </h4>
                                            <span class="text-sm text-gray-500">
                                                <i class="far fa-clock mr-1"></i>
                                                <?php echo date('M j, Y g:i A', strtotime($comment['created_at'])); ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <button class="text-gray-400 hover:text-blue-600 transition text-sm">
                                            <i class="far fa-thumbs-up"></i>
                                        </button>
                                        <button class="text-gray-400 hover:text-red-600 transition text-sm">
                                            <i class="far fa-thumbs-down"></i>
                                        </button>
                                        <button class="text-gray-400 hover:text-gray-600 transition text-sm">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="text-gray-700 ml-13 leading-relaxed">
                                    <?php echo $comment['comment_text']; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <i class="fas fa-comments text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg font-medium mb-2">No comments yet</p>
                            <p class="text-gray-400">Be the first to share your thoughts on this article!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Related Articles -->
            <section class="mt-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Related Articles</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php
                    $related_query = "SELECT * FROM news_articles WHERE id != " . $article_id . " ORDER BY RAND() LIMIT 3";
                    $related_result = $conn->query($related_query);
                    while ($related = $related_result->fetch_assoc()): ?>
                        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                            <?php if (!empty($related['header_image'])): ?>
                                <div class="h-32 overflow-hidden">
                                    <img src="<?php echo htmlspecialchars($related['header_image']); ?>"
                                         alt="<?php echo htmlspecialchars($related['title']); ?>"
                                         class="w-full h-full object-cover">
                                </div>
                            <?php else: ?>
                                <div class="h-32 bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center">
                                    <i class="fas fa-newspaper text-white text-2xl"></i>
                                </div>
                            <?php endif; ?>
                            <div class="p-4">
                                <h4 class="font-semibold text-gray-900 mb-2 text-sm">
                                    <a href="article.php?id=<?php echo $related['id']; ?>" class="hover:text-blue-600 transition">
                                        <?php echo htmlspecialchars($related['title']); ?>
                                    </a>
                                </h4>
                                <p class="text-xs text-gray-500">
                                    <?php echo date('M j, Y', strtotime($related['created_at'])); ?>
                                </p>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
            </section>
        <?php else: ?>
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <i class="fas fa-exclamation-triangle text-4xl text-yellow-500 mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Article Not Found</h2>
                <p class="text-gray-600 mb-6">The article you're looking for doesn't exist or has been removed.</p>
                <a href="index.php" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-medium">
                    <i class="fas fa-home mr-2"></i>
                    Back to Home
                </a>
            </div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-16">
        <div class="container mx-auto px-4 py-8">
            <div class="text-center text-gray-400 text-sm">
                <p>&copy; 2024 CosmosNews. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>