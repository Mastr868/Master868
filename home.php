<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['is_banned']) && $_SESSION['is_banned'] == 1) {
    echo "متأسفیم، شما بن شده‌اید.";
    exit();
}

require_once 'config.php';

$sql = "SELECT posts.*, users.username, users.is_verified FROM posts 
        JOIN users ON posts.user_id = users.id 
        ORDER BY created_at DESC";
$posts_result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>صفحه اصلی | شبکه اجتماعی</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --dark-color: #1a1a2e;
            --light-color: #f8f9fa;
            --success-color: #4cc9f0;
            --danger-color: #f72585;
            --warning-color: #f8961e;
            --info-color: #43aa8b;
            --text-color: #333;
            --text-light: #6c757d;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Vazirmatn', 'Segoe UI', Tahoma, sans-serif;
            background-color: #f5f7fa;
            color: var(--text-color);
            line-height: 1.6;
        }

        /* نوار ناوبری */
        .navbar {
            background: white;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo i {
            color: var(--accent-color);
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark-color);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
        }

        .nav-links a:hover {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }

        .nav-links a i {
            font-size: 1.1rem;
        }

        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            padding: 0.5rem;
        }

        .hamburger .bar {
            width: 25px;
            height: 3px;
            background-color: var(--dark-color);
            margin: 3px 0;
            transition: var(--transition);
        }

        /* محتوای اصلی */
        .container {
            width: 100%;
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .page-title {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--dark-color);
            position: relative;
            padding-bottom: 0.5rem;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
            border-radius: 3px;
        }

        /* کارت پست */
        .post-card {
            background: white;
            border-radius: 0.8rem;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
            overflow: hidden;
            transition: var(--transition);
        }

        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* هدر پست */
        .post-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .post-author {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .author-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            background-color: var(--light-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-weight: bold;
        }

        .author-info {
            display: flex;
            flex-direction: column;
        }

        .author-name {
            font-weight: 600;
            color: var(--text-color);
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .verified {
            color: var(--primary-color);
            font-size: 0.9rem;
        }

        .post-date {
            font-size: 0.8rem;
            color: var(--text-light);
        }

        /* محتوای پست */
        .post-content {
            padding: 1rem 1.5rem;
            color: var(--text-color);
            line-height: 1.7;
        }

        /* مدیای پست */
        .post-media {
            width: 100%;
            max-height: 600px;
            overflow: hidden;
        }

        .post-media img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        .post-media video {
            width: 100%;
            height: auto;
            display: block;
            background-color: #000;
        }

        /* اقدامات پست */
        .post-actions {
            padding: 0.8rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-light);
            transition: var(--transition);
            font-size: 0.9rem;
            padding: 0.5rem;
            border-radius: 0.5rem;
        }

        .action-btn:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .action-btn.like-btn {
            color: var(--danger-color);
        }

        .action-btn.like-btn.liked {
            color: var(--danger-color);
        }

        .action-btn i {
            font-size: 1.2rem;
        }

        .action-count {
            font-size: 0.9rem;
            color: var(--text-light);
        }

        /* رسپانسیو */
        @media (max-width: 768px) {
            .navbar {
                padding: 1rem;
            }
            
            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                right: 0;
                width: 100%;
                background: white;
                flex-direction: column;
                gap: 0;
                box-shadow: var(--shadow);
                border-radius: 0 0 0.8rem 0.8rem;
            }
            
            .nav-links.active {
                display: flex;
            }
            
            .nav-links a {
                padding: 1rem;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            }
            
            .hamburger {
                display: flex;
            }
            
            .container {
                padding: 0 0.5rem;
            }
        }

        /* انیمیشن‌ها */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .post-card {
            animation: fadeIn 0.5s ease forwards;
        }

        /* استایل برای اسکلت‌لودینگ */
        .skeleton {
            background-color: #e0e0e0;
            border-radius: 4px;
            animation: pulse 1.5s infinite ease-in-out;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
</head>
<body>
    <!-- نوار ناوبری -->
    <nav class="navbar">
        <div class="logo">
            <i class="fas fa-users"></i>
            <span>شبکه اجتماعی</span>
        </div>
        <div class="hamburger" onclick="toggleMenu()">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <div class="nav-links" id="navLinks">
            <a href="upload.php">
                <i class="fas fa-plus-circle"></i>
                <span>پست جدید</span>
            </a>
            <a href="profile.php">
                <i class="fas fa-user"></i>
                <span>پروفایل</span>
            </a>
            <a href="logout.php">
                <i class="fas fa-sign-out-alt"></i>
                <span>خروج</span>
            </a>
        </div>
    </nav>

    <!-- محتوای اصلی -->
    <div class="container">
        <h1 class="page-title">پست‌های اخیر</h1>
        
        <?php while ($post = $posts_result->fetch_assoc()): ?>
            <div class="post-card">
                <!-- هدر پست -->
                <div class="post-header">
                    <div class="post-author">
                        <div class="author-avatar">
                            <?php echo mb_substr($post['username'], 0, 1, 'UTF-8'); ?>
                        </div>
                        <div class="author-info">
                            <span class="author-name">
                                <?php echo htmlspecialchars($post['username']); ?>
                                <?php if ($post['is_verified'] == 1): ?>
                                    <i class="fas fa-check-circle verified"></i>
                                <?php endif; ?>
                            </span>
                            <span class="post-date"><?php echo $post['created_at']; ?></span>
                        </div>
                    </div>
                </div>

                <!-- محتوای پست -->
                <?php if (!empty($post['content'])): ?>
                    <div class="post-content">
                        <?php echo nl2br(htmlspecialchars($post['content'])); ?>
                    </div>
                <?php endif; ?>

                <!-- مدیای پست -->
                <div class="post-media">
                    <?php 
                    $ext = strtolower(pathinfo($post['media'], PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])):
                    ?>
                        <img src="<?php echo htmlspecialchars($post['media']); ?>" alt="پست" loading="lazy">
                    <?php elseif (in_array($ext, ['mp4', 'webm', 'ogg'])): ?>
                        <video autoplay muted loop playsinline>
                            <source src="<?php echo htmlspecialchars($post['media']); ?>" type="video/<?php echo $ext; ?>">
                            مرورگر شما از پخش ویدیو پشتیبانی نمی‌کند.
                        </video>
                    <?php endif; ?>
                </div>

                <!-- اقدامات پست -->
                <div class="post-actions">
                    <?php
                    $post_id = $post['id'];
                    // دریافت تعداد لایک‌ها
                    $likeStmt = $conn->prepare("SELECT COUNT(*) FROM likes WHERE post_id = ?");
                    $likeStmt->bind_param("i", $post_id);
                    $likeStmt->execute();
                    $likeStmt->bind_result($likeCount);
                    $likeStmt->fetch();
                    $likeStmt->close();
                    
                    // بررسی لایک کاربر
                    $checkLikeStmt = $conn->prepare("SELECT id FROM likes WHERE post_id = ? AND user_id = ?");
                    $checkLikeStmt->bind_param("ii", $post_id, $_SESSION['user_id']);
                    $checkLikeStmt->execute();
                    $checkLikeStmt->store_result();
                    $userLiked = $checkLikeStmt->num_rows > 0;
                    $checkLikeStmt->close();
                    
                    $likeClass = $userLiked ? 'liked' : '';
                    ?>
                    <button class="action-btn like-btn <?php echo $likeClass; ?>" onclick="toggleLike(<?php echo $post_id; ?>, this)">
                        <i class="fas fa-heart"></i>
                        <span class="action-count like-count"><?php echo $likeCount; ?></span>
                    </button>
                    <button class="action-btn">
                        <i class="fas fa-comment"></i>
                        <span class="action-count">0</span>
                    </button>
                    <button class="action-btn">
                        <i class="fas fa-share"></i>
                    </button>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- اسکریپت‌های جاوااسکریپت -->
    <script>
        // عملکرد منوی همبرگری
        function toggleMenu() {
            document.getElementById('navLinks').classList.toggle('active');
        }

        // پخش خودکار ویدیوها هنگام نمایش در صفحه
        document.addEventListener('DOMContentLoaded', function() {
            const videos = document.querySelectorAll('video');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.play();
                    } else {
                        entry.target.pause();
                    }
                });
            }, { threshold: 0.5 });
            
            videos.forEach(video => {
                observer.observe(video);
                
                // تنظیمات ویدیو
                video.autoplay = true;
                video.muted = true;
                video.loop = true;
                video.playsInline = true;
                
                // نمایش کنترل‌ها هنگام هاور
                video.addEventListener('mouseenter', () => {
                    video.controls = true;
                });
                
                video.addEventListener('mouseleave', () => {
                    video.controls = false;
                });
            });
        });

        // عملکرد لایک با استفاده از AJAX
        function toggleLike(postId, button) {
            const likeCount = button.querySelector('.like-count');
            const isLiked = button.classList.contains('liked');
            const action = isLiked ? 'unlike' : 'like';
            
            fetch(`ajax_like.php?post_id=${postId}&action=${action}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        likeCount.textContent = data.likeCount;
                        
                        if (action === 'like') {
                            button.classList.add('liked');
                            button.innerHTML = `<i class="fas fa-heart"></i> <span class="action-count like-count">${data.likeCount}</span>`;
                        } else {
                            button.classList.remove('liked');
                            button.innerHTML = `<i class="far fa-heart"></i> <span class="action-count like-count">${data.likeCount}</span>`;
                        }
                        
                        // انیمیشن لایک
                        button.style.transform = 'scale(1.2)';
                        setTimeout(() => {
                            button.style.transform = 'scale(1)';
                        }, 300);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
</body>
</html>