<?php
session_start();
include('dbconnect.php');
$conn = $pdo;

// Initialize variables
$msg = '';
$msgClass = '';
$isEdit = isset($_GET['id']);
$article = null;

// Fetch article if editing
if (isset($_POST['unique_id']) && $_POST['unique_id'] !== '') {
    $stmt = $conn->prepare("SELECT * FROM tbl_article WHERE unique_id = ?");
    $stmt->bindParam(1, $_POST['unique_id'], PDO::PARAM_STR, 12);
    $stmt->execute();
    $stmt->bindColumn('unique_id', $unique_id);
    $stmt->bindColumn('article_author', $article_author);
    $stmt->bindColumn('article_category', $article_category);
    $stmt->bindColumn('article_image', $article_image);
    $stmt->bindColumn('article_headline', $article_headline);
    $stmt->bindColumn('article_subtitle', $article_subtitle);
    $stmt->bindColumn('article_body', $article_body);
    $stmt->fetch(PDO::FETCH_BOUND);
    $article = [
        'unique_id' => $unique_id,
        'article_author' => $article_author,
        'article_category' => $article_category,
        'article_image' => $article_image,
        'article_headline' => $article_headline,
        'article_subtitle' => $article_subtitle,
        'article_body' => $article_body
    ];
} elseif (isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM tbl_article WHERE unique_id = ?");
    $stmt->bindParam(1, $_GET['id'], PDO::PARAM_STR, 12);
    $stmt->execute();
    $stmt->bindColumn('unique_id', $unique_id);
    $stmt->bindColumn('article_author', $article_author);
    $stmt->bindColumn('article_category', $article_category);
    $stmt->bindColumn('article_image', $article_image);
    $stmt->bindColumn('article_headline', $article_headline);
    $stmt->bindColumn('article_subtitle', $article_subtitle);
    $stmt->bindColumn('article_body', $article_body);
    $stmt->fetch(PDO::FETCH_BOUND);
    $article = [
        'unique_id' => $unique_id,
        'article_author' => $article_author,
        'article_category' => $article_category,
        'article_image' => $article_image,
        'article_headline' => $article_headline,
        'article_subtitle' => $article_subtitle,
        'article_body' => $article_body
    ];
}

// Handle Delete
if (isset($_POST['delete_article']) && isset($_POST['unique_id'])) {
    try {
        $conn->beginTransaction();
        $stmt = $conn->prepare("SELECT article_image FROM tbl_article WHERE unique_id = ?");
        $stmt->bindParam(1, $_POST['unique_id'], PDO::PARAM_STR, 12);
        $stmt->execute();
        $stmt->bindColumn('article_image', $del_image);
        $stmt->fetch(PDO::FETCH_BOUND);
        if ($del_image && file_exists($del_image)) {
            unlink($del_image);
        }
        $stmt = $conn->prepare("DELETE FROM tbl_article WHERE unique_id = ?");
        $stmt->bindParam(1, $_POST['unique_id'], PDO::PARAM_STR, 12);
        $stmt->execute();
        $conn->commit();
        header('Location: all_articles.php');
        exit();
    } catch (Exception $e) {
        $conn->rollBack();
        $msg = "Error deleting article: " . $e->getMessage();
        $msgClass = "alert-danger";
    }
}

// Handle Create/Update (refactored to match view_partner.php style)
if (isset($_POST['addsubmit'])) {
    try {
        $conn->beginTransaction();
        $unique_id = isset($_POST['unique_id']) ? $_POST['unique_id'] : '';
        if ($_SESSION['user_role'] === 'Admin') {
            $author_name = isset($_POST['author_name']) ? trim($_POST['author_name']) : '';
        } else {
            $author_name = $_SESSION['user_fname'] . ' ' . $_SESSION['user_lname'];
        }
        $category = $_POST['newsCategory'];
        $headline = $_POST['headline'];
        $subtitle = $_POST['subtitle'];
        $body = $_POST['body'];
        $imagePath = isset($_POST['current_image']) ? $_POST['current_image'] : null;
        $name = isset($_FILES['articleImage']['name']) ? $_FILES['articleImage']['name'] : '';
        $tmp_name = isset($_FILES['articleImage']['tmp_name']) ? $_FILES['articleImage']['tmp_name'] : '';
        $t = time();
        $filetype = $name ? strtolower(pathinfo($name, PATHINFO_EXTENSION)) : '';
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        
        // Check if article exists
        $checkquery = "SELECT unique_id FROM tbl_article WHERE unique_id = ?";
        $result = $conn->prepare($checkquery);
        $result->bindParam(1, $unique_id);
        $result->execute();
        $num = $result->rowCount();
        
        // Handle file upload if present
        if ($name && in_array($filetype, $allowed)) {
            $uploadDir = 'assets/img/articles/';
            is_dir($uploadDir) || mkdir($uploadDir, 0777, true);
            $newname = date('YmdHis') . '.' . $filetype;
            $target = $uploadDir . $newname;
            if (!move_uploaded_file($tmp_name, $target)) {
                throw new Exception("Error uploading file.");
            }
            if ($imagePath && file_exists($imagePath)) {
                unlink($imagePath);
            }
            $imagePath = $target;
        } elseif ($name && !in_array($filetype, $allowed)) {
            throw new Exception("Invalid file type. Allowed: " . implode(', ', $allowed));
        }
        
        if ($num > 0) {
            // Update
            $stmt = $conn->prepare("UPDATE tbl_article SET article_author=?, article_category=?, article_image=?, article_headline=?, article_subtitle=?, article_body=? WHERE unique_id=?");
            $stmt->bindParam(1, $author_name);
            $stmt->bindParam(2, $category);
            $stmt->bindParam(3, $imagePath);
            $stmt->bindParam(4, $headline);
            $stmt->bindParam(5, $subtitle);
            $stmt->bindParam(6, $body);
            $stmt->bindParam(7, $unique_id, PDO::PARAM_STR, 12);
            $stmt->execute();
            $msg = "Article updated successfully!";
        } else {
            // Insert
            $stmt = $conn->prepare("INSERT INTO tbl_article (article_author, article_category, article_image, article_headline, article_subtitle, article_body) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $author_name);
            $stmt->bindParam(2, $category);
            $stmt->bindParam(3, $imagePath);
            $stmt->bindParam(4, $headline);
            $stmt->bindParam(5, $subtitle);
            $stmt->bindParam(6, $body);
            $stmt->execute();
            $msg = "Article saved successfully!";
        }
        $conn->commit();
        $msgClass = "alert-success";
        header('Location: all_articles.php');
        exit();
    } catch (Exception $e) {
        $conn->rollBack();
        $msg = "Error: " . $e->getMessage();
        $msgClass = "alert-danger";
    }
}

// Handle redirect message
if (isset($_GET['msg']) && $_GET['msg'] == 'saved') {
    $msg = "Article saved successfully!";
    $msgClass = "alert-success";
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include('header.php'); ?>

<body>
    <!-- ======= Header ======= -->
    <?php include('index_header.php'); ?>

    <!-- ======= Sidebar ======= -->
    <?php include('index_sidebar.php'); ?>

    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="notificationToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="bi bi-info-circle me-2"></i>
                <strong class="me-auto">Notification</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <?php if ($msg): ?>
                    <div class="<?php echo $msgClass; ?>">
                        <?php echo $msg; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <main class="main" id="main">
        <div class="pagetitle">
            <h1><?php echo $isEdit ? 'Edit Article' : 'Add New Article'; ?></h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Admin</a></li>
                    <li class="breadcrumb-item"><a href="all_articles.php">Articles</a></li>
                    <li class="breadcrumb-item active"><?php echo $isEdit ? 'Edit Article' : 'Add New Article'; ?></li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Article Information</h5>

                            <!-- Article Form -->
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data" class="row g-3">
                                <!-- Hidden unique_id for edit -->
                                <?php if ($isEdit && $article && isset($article['unique_id'])): ?>
                                    <input type="hidden" name="unique_id" value="<?php echo htmlspecialchars($article['unique_id']); ?>">
                                <?php endif; ?>
                                <input type="hidden" name="addsubmit" value="1">
                                <!-- Article Image -->
                                <div class="col-12">
                                    <label for="articleImage" class="form-label">Article Image</label>
                                    <input type="file" class="form-control" id="articleImage" name="articleImage" accept="image/*" onchange="previewImage(this);">
                                    <?php if ($isEdit && $article['article_image']): ?>
                                        <input type="hidden" name="current_image" value="<?php echo $article['article_image']; ?>">
                                    <?php endif; ?>
                                    <!-- Image Preview -->
                                    <div class="mt-2">
                                        <img id="imagePreview"
                                            src="<?php echo $isEdit && $article['article_image'] ? $article['article_image'] : '#'; ?>"
                                            alt="Image Preview"
                                            style="max-width: 100%; max-height: 300px; <?php echo $isEdit && $article['article_image'] ? '' : 'display: none;'; ?>"
                                            class="mt-2 rounded">
                                    </div>
                                </div>

                                <!-- Author (Optional) -->
                                <?php if ($_SESSION['user_role'] === 'Admin'): ?>
                                    <div class="mb-3">
                                        <label for="author_name" class="form-label">Author Name</label>
                                        <input type="text" class="form-control" id="author_name" name="author_name" required value="<?php echo $isEdit ? htmlspecialchars($article['article_author']) : ''; ?>">
                                    </div>
                                <?php else: ?>
                                    <!-- Hidden input for non-admin users -->
                                    <input type="hidden" name="author_name" value="<?php echo $_SESSION['user_fname'] . ' ' . $_SESSION['user_lname']; ?>">
                                <?php endif; ?>
                                <!-- News Category -->
                                <div class="col-12">
                                    <label for="newsCategory" class="form-label">News Category</label>
                                    <select class="form-select" id="newsCategory" name="newsCategory" required>
                                        <option value="" disabled <?php echo !$isEdit ? 'selected' : ''; ?>>Select a category</option>
                                        <?php
                                        $categories = [
                                            'national' => 'NATIONAL NEWS',
                                            'regional' => 'REGIONAL NEWS',
                                            'local' => 'LOCAL NEWS IN  BRIEF',
                                            'metro' => 'METRO NEWS',
                                            'bisaya' => 'BISAYA NEWS',
                                            'opinion' => 'OPINION',
                                            'business' => 'BUSINESS UPDATES', 
                                            'international' => 'INTERNATIONAL NEWS', 
                                            'entertainment' => 'ENTERTAINMENT',
                                            'sports' => 'SPORTS',
                                            'faith' => 'FAITH',
                                        ];
                                        foreach ($categories as $value => $label): ?>
                                            <option value="<?php echo $value; ?>"
                                                <?php echo ($isEdit && $article['article_category'] == $value) ? 'selected' : ''; ?>>
                                                <?php echo $label; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Headline -->
                                <div class="col-12">
                                    <label for="headline" class="form-label">Headline</label>
                                    <input type="text" class="form-control" id="headline" name="headline"
                                        placeholder="Enter article headline" required
                                        value="<?php echo $isEdit ? htmlspecialchars($article['article_headline']) : ''; ?>">
                                </div>

                                <!-- Subtitle -->
                                <div class="col-12">
                                    <label for="subtitle" class="form-label">Subtitle</label>
                                    <input type="text" class="form-control" id="subtitle" name="subtitle"
                                        placeholder="Enter article subtitle"
                                        value="<?php echo $isEdit ? htmlspecialchars($article['article_subtitle']) : ''; ?>">
                                </div>

                                <!-- Body -->
                                <div class="col-12">
                                    <label for="body" class="form-label">Article Body</label>
                                    <textarea class="form-control" id="body" name="body" rows="10" required><?php echo $isEdit ? htmlspecialchars($article['article_body']) : ''; ?></textarea>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary"><?php echo $isEdit ? 'Update' : 'Save'; ?> Article</button>
                                    <a href="all_articles.php" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>

                            <!-- Add JavaScript for image preview -->
                            <script>
                                function previewImage(input) {
                                    const preview = document.getElementById('imagePreview');
                                    if (input.files && input.files[0]) {
                                        const reader = new FileReader();

                                        reader.onload = function(e) {
                                            preview.src = e.target.result;
                                            preview.style.display = 'block';
                                        }

                                        reader.readAsDataURL(input.files[0]);
                                    } else {
                                        preview.src = '#';
                                        preview.style.display = 'none';
                                    }
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            </div>
    </main>
    <?php include('footer.php'); ?>

    <!-- Toast Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($msg): ?>
                var toast = new bootstrap.Toast(document.getElementById('notificationToast'));
                toast.show();
            <?php endif; ?>
        });
    </script>
</body>

</html>