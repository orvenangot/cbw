<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav flex-column d-flex h-100" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link collapsed" href="index.php">
                    <i class="bi bi-grid"></i>
                    <span>ADMIN DASHBOARD</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#users-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-person-gear"></i><span>User Management</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="users-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="users.php" class="active">
                            <i class="bi bi-people-fill"></i><span>All Users</span>
                        </a>
                    </li>
                </ul>
            </li>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#members-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-person-vcard"></i><span>Membership</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="members-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="members.php" class="active">
                            <i class="bi bi-person-check"></i><span>Members</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#partners-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-buildings"></i><span>Partner Management</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="partners-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="all_partners.php" class="active">
                            <i class="bi bi-building-fill-check"></i><span>All Partners</span>
                        </a>
                    </li>
                    <li>
                        <a href="add_partner.php" class="active">
                            <i class="bi bi-building-fill-add"></i><span>Add Partner</span>
                        </a>
                    </li>
                </ul>
            </li>
       
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#articles-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-file-richtext"></i><span>Articles</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="articles-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                <li>
                    <a href="all_articles.php">
                        <i class="bi bi-files"></i><span>All Articles</span>
                    </a>
                </li>
                <li>
                    <a href="save_article.php">
                        <i class="bi bi-file-earmark-plus"></i><span>Add Article</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item mt-auto">
            <a class="nav-link collapsed" href="#" onclick="confirmLogout()">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
        </li>

        <script>
            function confirmLogout() {
                if (confirm('Are you sure you want to logout? This will end your current session.')) {
                    setTimeout(function() {
                        window.location.href = 'logout.php?redirect=loginpage.php';
                    }, 100);
                }
            }
        </script>

    </ul>

</aside>