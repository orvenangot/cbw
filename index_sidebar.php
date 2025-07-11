<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

<li class="nav-item">
    <a class="nav-link " href="admin_dashboard.php">
    <i class="bi bi-speedometer2"></i>
    <span>ADMIN DASHBOARD</span>
    </a>
</li>


<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#users-nav" data-bs-toggle="collapse" href="#">
    <i class="bi bi-people"></i><span>User Management</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="users-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
    <li>
        <a href="users.php">
        <i class="bi bi-circle"></i><span>All Users</span>
        </a>
    </li>
    <!-- <li>
        <a href="add_user.php">
        <i class="bi bi-circle"></i><span>Add User</span>
        </a>
    </li> -->
    <!-- <li>
        <a href="#">
        <i class="bi bi-circle"></i><span>User Roles</span>
        </a>
    </li> -->
    
    </ul>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#partners-nav" data-bs-toggle="collapse" href="#">
    <i class="bi bi-building"></i><span>Partner Management</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="partners-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
            <a href="#">
            <i class="bi bi-circle"></i><span>All Partners</span>
            </a>
        </li>
        <li>
            <a href="#">
            <i class="bi bi-circle"></i><span>Add Partner</span>
            </a>
        </li>
        <li>
            <a href="#">
            <i class="bi bi-circle"></i><span>Partner Categories</span>
            </a>
        </li>
        
    </ul>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#reports-nav" data-bs-toggle="collapse" href="#">
    <i class="bi bi-graph-up"></i><span>Reports</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="reports-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
            <a href="#">
            <i class="bi bi-circle"></i><span>User Reports</span>
            </a>
        </li>
        <li>
            <a href="#">
            <i class="bi bi-circle"></i><span>Revenue Reports</span>
            </a>
        </li>
        <li>
            <a href="#">
            <i class="bi bi-circle"></i><span>Partner Reports</span>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#settings-nav" data-bs-toggle="collapse" href="#">
    <i class="bi bi-gear"></i><span>Settings</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="settings-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
    <li>
        <a href="#">
        <i class="bi bi-circle"></i><span>System Settings</span>
        </a>
    </li>
    <li>
        <a href="#">
        <i class="bi bi-circle"></i><span>Security</span>
        </a>
    </li>
    </ul>
</li>


<li class="nav-heading">Navigation</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="../index.php">
    <i class="bi bi-house"></i>
    <span>Public Site</span>
    </a>
</li><!-- End Public Site Nav -->
<li class="nav-item">
    <a class="nav-link collapsed" href="logout.php" 
       onclick="return confirm('Are you sure you want to logout?')">
    <i class="bi bi-box-arrow-right"></i>
    <span>Logout</span>
    </a>
</li><!-- End Logout Nav -->

</ul>

  </aside>