<?php
require_once 'Auth/auth.php';
include('dbconnect.php');
$conn = $pdo;

// Delete article if requested (refactored to match save_article.php style)
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
        $msg = "Article deleted successfully!";
        $msgClass = "text-success";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } catch (Exception $e) {
        $conn->rollBack();
        $msg = "Error deleting article: " . $e->getMessage();
        $msgClass = "text-danger";
    }
}

// Update article if requested (optional, if you want to support inline update from this page)
if (isset($_POST['edit_article']) && isset($_POST['unique_id'])) {
    try {
        $conn->beginTransaction();
        $unique_id = $_POST['unique_id'];
        $author_id = $_POST['article_author'];
        $category = $_POST['newsCategory'];
        $headline = $_POST['headline'];
        $subtitle = $_POST['subtitle'];
        $body = $_POST['body'];
        $imagePath = isset($_POST['current_image']) ? $_POST['current_image'] : null;
        $name = isset($_FILES['articleImage']['name']) ? $_FILES['articleImage']['name'] : '';
        $tmp_name = isset($_FILES['articleImage']['tmp_name']) ? $_FILES['articleImage']['tmp_name'] : '';
        $filetype = $name ? strtolower(pathinfo($name, PATHINFO_EXTENSION)) : '';
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

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

        $stmt = $conn->prepare("UPDATE tbl_article SET article_author=?, article_category=?, article_image=?, article_headline=?, article_subtitle=?, article_body=? WHERE unique_id=?");
        $stmt->bindParam(1, $author_id);
        $stmt->bindParam(2, $category);
        $stmt->bindParam(3, $imagePath);
        $stmt->bindParam(4, $headline);
        $stmt->bindParam(5, $subtitle);
        $stmt->bindParam(6, $body);
        $stmt->bindParam(7, $unique_id, PDO::PARAM_STR, 12);
        $stmt->execute();
        $conn->commit();
        $msg = "Article updated successfully!";
        $msgClass = "text-success";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } catch (Exception $e) {
        $conn->rollBack();
        $msg = "Error updating article: " . $e->getMessage();
        $msgClass = "text-danger";
    }
}

// Handle Add Feedback
if (isset($_POST['add_feedback'])) {
    try {
        $fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);
        $feedback = trim($_POST['feedback']);
        $user_id = $_SESSION['user_id'];
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'assets/img/users/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = time() . basename($_FILES['image']['name']);
            $targetFile = $uploadDir . $fileName;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                throw new Exception("Failed to move uploaded file.");
            }
            $imagePath = $targetFile;
        }
        $stmt = $conn->prepare("INSERT INTO tbl_feedbacks (fname, lname, image, feedback, user_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$fname, $lname, $imagePath, $feedback, $user_id]);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } catch (Exception $e) {
        error_log("Add Feedback Error: " . $e->getMessage(), 3, __DIR__ . '/feedback_error.log');
        echo "<div class='alert alert-danger'>Add Feedback Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}
// Handle Edit Feedback
if (isset($_POST['edit_feedback']) && isset($_POST['feedback_id'])) {
    try {
        $feedback_id = $_POST['feedback_id'];
        $fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);
        $feedback = trim($_POST['feedback']);
        $imagePath = $_POST['existing_image'] ?? null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'assets/img/users/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = time() . basename($_FILES['image']['name']);
            $targetFile = $uploadDir . $fileName;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                throw new Exception("Failed to move uploaded file.");
            }
            $imagePath = $targetFile;
        }
        $stmt = $conn->prepare("UPDATE tbl_feedbacks SET fname=?, lname=?, image=?, feedback=? WHERE unique_id=?");
        $stmt->execute([$fname, $lname, $imagePath, $feedback, $feedback_id]);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } catch (Exception $e) {
        error_log("Edit Feedback Error: " . $e->getMessage(), 3, __DIR__ . '/feedback_error.log');
        echo "<div class='alert alert-danger'>Edit Feedback Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}
// Handle Delete Feedback
if (isset($_POST['delete_feedback']) && isset($_POST['feedback_id'])) {
    try {
        $stmt = $conn->prepare("SELECT image FROM tbl_feedbacks WHERE unique_id = ?");
        $stmt->execute([$_POST['feedback_id']]);
        $fb = $stmt->fetch();
        if ($fb && $fb['image'] && file_exists($fb['image'])) {
            if (!unlink($fb['image'])) {
                throw new Exception("Failed to delete feedback image file.");
            }
        }
        $stmt = $conn->prepare("DELETE FROM tbl_feedbacks WHERE unique_id = ?");
        $stmt->execute([$_POST['feedback_id']]);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } catch (Exception $e) {
        error_log("Delete Feedback Error: " . $e->getMessage(), 3, __DIR__ . '/feedback_error.log');
        echo "<div class='alert alert-danger'>Delete Feedback Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
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

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>All Articles</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Admin</a></li>
                    <li class="breadcrumb-item active">All Articles</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">Article Management</h5>
                                <a href="save_article.php" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Add New Article
                                </a>
                            </div>

                            <div class="table-responsive">
                                <table id="articlesTable" class="table datatable table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date Created</th>
                                            <th>Image</th>
                                            <th>Author</th>
                                            <th>Category</th>
                                            <th>Headline</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Refactored: Use bindColumn and FETCH_BOUND for articles
                                        if ($_SESSION['user_role'] === 'Admin') {
                                            $query = "SELECT unique_id, article_author, article_category, article_image, article_headline, article_subtitle, article_body, created_at FROM tbl_article ORDER BY created_at DESC";
                                            $stmt = $pdo->prepare($query);
                                            $stmt->execute();
                                        } else {
                                            $query = "SELECT unique_id, article_author, article_category, article_image, article_headline, article_subtitle, article_body, created_at FROM tbl_article WHERE article_author = ? ORDER BY created_at DESC";
                                            $stmt = $pdo->prepare($query);
                                            $stmt->execute([$_SESSION['user_fname'] . ' ' . $_SESSION['user_lname']]);
                                        }
                                        $stmt->bindColumn('unique_id', $unique_id);
                                        $stmt->bindColumn('article_author', $article_author);
                                        $stmt->bindColumn('article_category', $article_category);
                                        $stmt->bindColumn('article_image', $article_image);
                                        $stmt->bindColumn('article_headline', $article_headline);
                                        $stmt->bindColumn('article_subtitle', $article_subtitle);
                                        $stmt->bindColumn('article_body', $article_body);
                                        $stmt->bindColumn('created_at', $created_at);
                                        while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                                            $formatted_date = date_format(date_create($created_at), "M d, Y");
                                        ?>
                                            <tr>
                                                <td><?php echo $formatted_date; ?></td>
                                                <td>
                                                    <?php if ($article_image != "") { ?>
                                                        <img src="<?php echo $article_image; ?>" alt="Article Image" style="max-width: 100px; max-height: 100px;" class="img-thumbnail">
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($article_author); ?></td>
                                                <td>
                                                    <?php
                                                    $category_badges = [
                                                        'national' => 'primary',       
                                                        'regional' => 'secondary',      
                                                        'local' => 'success',          
                                                        'metro' => 'info',            
                                                        'bisaya' => 'warning',           
                                                        'opinion' => 'dark',            
                                                        'business' => 'secondary',     
                                                        'international' => 'danger',   
                                                        'entertainment' => 'primary',    
                                                        'sports' => 'warning',        
                                                        'faith' => 'info',            
                                                        'default' => 'dark',          
                                                    ];
                                                    $badge = isset($category_badges[$article_category]) ? $category_badges[$article_category] : 'secondary';
                                                    ?>
                                                    <span class="badge bg-<?php echo $badge; ?>"><?php echo htmlspecialchars(ucfirst($article_category)); ?></span>
                                                </td>
                                                <td><?php echo htmlspecialchars($article_headline); ?></td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="save_article.php?id=<?php echo $unique_id; ?>" class="btn btn-sm btn-primary" title="Edit">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('<?php echo $unique_id; ?>')" title="Delete">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mt-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Feedback Management</h5>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFeedbackModal">
                                <i class="bi bi-plus-circle"></i> Add Feedback
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table id="feedbackTable" class="table datatable table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Full Name</th>
                                        <th>Feedback</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Refactored: Use bindColumn and FETCH_BOUND for feedbacks
                                    $query = "SELECT unique_id, fname, lname, image, feedback, created_at FROM tbl_feedbacks ORDER BY created_at DESC";
                                    $stmt = $pdo->prepare($query);
                                    $stmt->execute();
                                    $stmt->bindColumn('unique_id', $fb_unique_id);
                                    $stmt->bindColumn('fname', $fb_fname);
                                    $stmt->bindColumn('lname', $fb_lname);
                                    $stmt->bindColumn('image', $fb_image);
                                    $stmt->bindColumn('feedback', $fb_feedback);
                                    $stmt->bindColumn('created_at', $fb_created_at);
                                    while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                                        $full_name = $fb_fname . ' ' . $fb_lname;
                                        $formatted_date = date('M d, Y h:i A', strtotime($fb_created_at));
                                    ?>
                                        <tr>
                                            <td>
                                                <?php if ($fb_image) : ?>
                                                    <img src="<?php echo $fb_image; ?>" alt="User Image" style="max-width: 100px; max-height: 100px;" class="img-thumbnail">
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($full_name); ?></td>
                                            <td><?php echo htmlspecialchars($fb_feedback); ?></td>
                                            <td><?php echo $formatted_date; ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-primary" onclick="editFeedback('<?php echo $fb_unique_id; ?>', '<?php echo htmlspecialchars(addslashes($fb_fname)); ?>', '<?php echo htmlspecialchars(addslashes($fb_lname)); ?>', '<?php echo htmlspecialchars(addslashes($fb_feedback)); ?>', '<?php echo $fb_image; ?>')" title="Edit"><i class="bi bi-pencil"></i></button>
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDeleteFeedback('<?php echo $fb_unique_id; ?>')" title="Delete"><i class="bi bi-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <!-- Delete Form (Hidden) -->
            <form id="deleteForm" method="POST" style="display: none;">
                <input type="hidden" name="unique_id" id="deleteArticleId">
                <input type="hidden" name="delete_article" value="1">
            </form>
            <!-- Add Feedback Modal -->
            <div class="modal fade" id="addFeedbackModal" tabindex="-1" aria-labelledby="addFeedbackModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="addFeedbackForm" method="POST" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addFeedbackModalLabel">Add Feedback</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="fname" class="form-label">First Name</label>
                                    <input type="text" class="form-control" name="fname" id="fname" required>
                                </div>
                                <div class="mb-3">
                                    <label for="lname" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" name="lname" id="lname" required>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control" name="image" id="image" accept="image/*" required>
                                </div>
                                <div class="mb-3">
                                    <label for="feedback" class="form-label">Feedback</label>
                                    <textarea class="form-control" name="feedback" id="feedback" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="add_feedback">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Edit Feedback Modal -->
            <div class="modal fade" id="editFeedbackModal" tabindex="-1" aria-labelledby="editFeedbackModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="feedback_id" id="edit_feedback_id">
                            <input type="hidden" name="existing_image" id="edit_existing_image">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editFeedbackModalLabel">Edit Feedback</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="edit_fname" class="form-label">First Name</label>
                                    <input type="text" class="form-control" name="fname" id="edit_fname" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_lname" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" name="lname" id="edit_lname" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_image" class="form-label">Image</label>
                                    <input type="file" class="form-control" name="image" id="edit_image" accept="image/*">
                                    <img id="edit_image_preview" src="" alt="Current Image" style="max-width: 100px; max-height: 100px; margin-top: 10px; display: none;" class="img-thumbnail">
                                </div>
                                <div class="mb-3">
                                    <label for="edit_feedback" class="form-label">Feedback</label>
                                    <textarea class="form-control" name="feedback" id="edit_feedback" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="edit_feedback">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Delete Feedback Form (Hidden) -->
            <form id="deleteFeedbackForm" method="POST" style="display: none;">
                <input type="hidden" name="feedback_id" id="deleteFeedbackId">
                <input type="hidden" name="delete_feedback" value="1">
            </form>

    </main>

    <?php include('footer.php'); ?>

    <script>
        $(document).ready(function() {
            // DataTables initialization
            $('#articlesTable').DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "order": [
                    [0, 'desc']
                ], // Sort by date descending
                "pageLength": 10,
                "buttons": ["copy", "csv", "excel", "pdf", "print"],
                "columnDefs": [{
                        "orderable": false,
                        "targets": [1, 5, 6]
                    }, // Disable sorting for image, details, and actions columns
                    {
                        "searchable": false,
                        "targets": [1, 5, 6]
                    } // Disable searching for image, details, and actions columns
                ]
            }).buttons().container().appendTo('#articlesTable_wrapper .col-md-6:eq(0)');

            // Show toast if there's a message
            <?php if (isset($msg)) : ?>
                var toast = new bootstrap.Toast(document.getElementById('notificationToast'));
                toast.show();
            <?php endif; ?>

            // Clear Add Feedback modal fields when opened (plain JS, robust)
            document.addEventListener('DOMContentLoaded', function() {
                var addFeedbackModal = document.getElementById('addFeedbackModal');
                if (addFeedbackModal) {
                    addFeedbackModal.addEventListener('show.bs.modal', function(event) {
                        var form = document.getElementById('addFeedbackForm');
                        if (form) {
                            form.reset();
                            var fileInput = form.querySelector('input[type="file"]');
                            if (fileInput) fileInput.value = '';
                        }
                    });
                }
            });
        });

        function showArticleDetails(headline, subtitle, body) {
            document.getElementById('modalHeadline').textContent = headline;
            document.getElementById('modalSubtitle').textContent = subtitle;
            document.getElementById('modalBody').textContent = body.replace(/\\n/g, '\n');
            new bootstrap.Modal(document.getElementById('articleDetailsModal')).show();
        }

        function confirmDelete(articleId) {
            if (confirm('Are you sure you want to delete this article? This action cannot be undone.')) {
                document.getElementById('deleteArticleId').value = articleId;
                document.getElementById('deleteForm').submit();
            }
        }

        function confirmDeleteFeedback(feedbackId) {
            if (confirm('Are you sure you want to delete this feedback? This action cannot be undone.')) {
                document.getElementById('deleteFeedbackId').value = feedbackId;
                document.getElementById('deleteFeedbackForm').submit();
            }
        }

        function editFeedback(id, fname, lname, feedback, image) {
            document.getElementById('edit_feedback_id').value = id;
            document.getElementById('edit_fname').value = fname;
            document.getElementById('edit_lname').value = lname;
            document.getElementById('edit_feedback').value = feedback;
            document.getElementById('edit_existing_image').value = image;
            if (image) {
                document.getElementById('edit_image_preview').src = image;
                document.getElementById('edit_image_preview').style.display = 'block';
            } else {
                document.getElementById('edit_image_preview').style.display = 'none';
            }
            new bootstrap.Modal(document.getElementById('editFeedbackModal')).show();
        }
    </script>
</body>

</html>