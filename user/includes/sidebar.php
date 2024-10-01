<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="#" class="nav-link">

        <?php
        $uid = $_SESSION['sturecmsuid'];
        $sql = "SELECT * from tblstudent where ID=:uid";

        $query = $dbh->prepare($sql);
        $query->bindParam(':uid', $uid, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        $cnt = 1;
        if ($query->rowCount() > 0) {
          foreach ($results as $row) { ?>
            <div class="profile-image">
              <img class="img-xs rounded-circle" src="../<?php echo ($row->Image); ?>" alt="profile image">
              <div class="dot-indicator bg-success"></div>
            </div>
            <div class="text-wrapper">
              <p class="profile-name"><?php echo ($row->StudentName); ?></p>
              <p class="designation"><?php echo ($row->StudentEmail); ?></p><?php $cnt = $cnt + 1;
          }
        } ?>
        </div>

      </a>
    </li>
    <li class="nav-item nav-category">
      <span class="nav-link">Dashboard</span>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="dashboard.php">
        <span class="menu-title">Dashboard</span>
        <i class="icon-screen-desktop menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="view-notice.php">
        <span class="menu-title">View Notice</span>
        <i class="icon-book-open menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="handbook.php">
        <span class="menu-title">Display Handbook</span>
        <i class="icon-doc menu-icon"></i>
      </a>
    </li>
    <!-- <li class="nav-item">
      <a class="nav-link" href="handbook2.php">
        <span class="menu-title">Polices & Procedures</span>
        <i class="icon-docs menu-icon"></i>
      </a>
    </li> -->

    <li class="nav-item">
      <a class="nav-link" href="violations.php">
        <span class="menu-title">Violations</span>
        <i class="icon-lock menu-icon"></i>
      </a>
    </li>

  </ul>
</nav>