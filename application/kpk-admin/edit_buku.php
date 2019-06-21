<?php

require "../config/connection.php";
if(!isset($_SESSION['login'])) {

    header("Location: ./login");
    exit;

}

if(!isset($_GET['id'])) {
    header("Location: ./home");
    exit;
}

$id = mysqli_real_escape_string( $conn, stripslashes( htmlspecialchars($_GET['id']) ));

$buku = mysqli_query($conn, "SELECT * FROM pdf WHERE id='$id'");
if(!$buku) {
    header("Location: ./home");
    exit;
}

$buku_obj = mysqli_fetch_object($buku);

$kategori = mysqli_query($conn, "SELECT * FROM kategori");
$sub = mysqli_query($conn, "SELECT * FROM sub_kategori");

if (isset($_POST["edit"])) {
  if(edit_pdf($_POST)>0){
    echo "
      <script>
        alert('Data berhasil diubah');
        document.location.href='home';
      </script>
    ";
  } else{
    echo "
      <script>
        alert('Data gagal diubah');
      </script>
    ";
  }
}

$emails = mysqli_query($conn, "SELECT * FROM contact WHERE status = 0");
$jumlah = mysqli_num_rows($emails);

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Buku Antikorupsi | Edit Buku</title>
  <!-- favicon  -->
  <link rel="shortcut icon" href="../images/Logo KPK/favicon.png">


  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home">
        <div class="sidebar-brand-icon rotate-n-15">
          <img src="../images/Logo KPK/favicon.png" alt="Logo" width="50">
        </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Admin Panel
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item active">
        <a class="nav-link collapsed " href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-book"></i>
          <span>Buku Antikorupsi</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Buku Antikorupsi</h6>
            <a class="collapse-item bg-danger text-white" href="home">Daftar Buku</a>
            <a class="collapse-item" href="tambah_buku">Tambah Buku</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link" href="email">
          <i class="fas fa-fw fa-envelope-open-text"></i>
          <span>Email Masuk</span> <span class="badge badge-light"><?= $jumlah; ?></span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-fw fa-sign-out-alt"></i>
          <span>Logout</span>
        </a>
      </li>

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin KPK</span>
                <img class="img-profile rounded-circle" src="img/user.png">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="ubah_password">
                  <i class="fas fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>
                  Ubah Password
                </a>
                <hr class="px-2">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Nav -->
            <div class="card mb-3">
              <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link text-danger" href="home"><i class="fas fa-arrow-left"></i></a>
                </li>
              </ul>
            </div>
          <!-- End Nav -->

          <!-- View Pdf -->
          <div class="card p-5">
            <form class="" method="post">
              <!-- Hidden Input -->
              <input type="hidden" name="id" value="<?= $buku_obj->id; ?>">
              <input type="hidden" name="pdf_thumb" value="<?= $buku_obj->pdf_thumb; ?>">
              <input type="hidden" name="pdf_url" value="<?= $buku_obj->pdf_url; ?>">
              <input type="hidden" name="pdf_size" value="<?= $buku_obj->pdf_size; ?>">
              <input type="hidden" name="pdf_url" value="<?= $buku_obj->pdf_url; ?>">
              <input type="hidden" name="pdf_modal" value="<?= $buku_obj->pdf_modal; ?>">

              <div class="form-group">
                <label for="title">Judul Buku</label>
                <input type="text" class="form-control" id="title" value="<?= $buku_obj->pdf_title; ?>" required name="pdf_title">
              </div>

              <div class="form-group">
                <label for="kategori">Kategori Buku</label>
                <select class="form-control" id="kategori" name="kategori_id" required>
                  <?php if ($buku_obj->kategori_id == 1): ?>
                    <option selected class="active active_kategori" value="<?= $buku_obj->kategori_id; ?>" data-id="<?= $buku_obj->kategori_id ?>">Anak</option>
                  <?php endif; ?>
                  <?php if ($buku_obj->kategori_id == 2): ?>
                    <option selected class="active active_kategori" value="<?= $buku_obj->kategori_id; ?>" data-id="<?= $buku_obj->kategori_id ?>">Dunia Usaha</option>
                  <?php endif; ?>
                  <?php if ($buku_obj->kategori_id == 3): ?>
                    <option selected class="active active_kategori" value="<?= $buku_obj->kategori_id; ?>" data-id="<?= $buku_obj->kategori_id ?>">Panduan Pendidikan AntiKorupsi</option>
                  <?php endif; ?>
                  <?php if ($buku_obj->kategori_id == 4): ?>
                    <option selected class="active active_kategori" value="<?= $buku_obj->kategori_id; ?>" data-id="<?= $buku_obj->kategori_id ?>">Politik</option>
                  <?php endif; ?>
                  <?php if ($buku_obj->kategori_id == 5): ?>
                    <option selected class="active active_kategori" value="<?= $buku_obj->kategori_id; ?>" data-id="<?= $buku_obj->kategori_id ?>">Umum</option>
                  <?php endif; ?>
                  <?php foreach ($kategori as $row): ?>
                    <?php if ($buku_obj->kategori_id != $row['id']): ?>
                      <option class="pil_kategori-<?=$row['id'] ?>" value="<?= $row['id']; ?>" data-id="<?= $row['id'] ?>"><?= $row['name']; ?></option>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group sub_kategori">
                <label for="sub_kategori">Sub Kategori</label>
                <select class="form-control" id="sub_kategori" name="sub_kategori_id">
                  <option selected disabled>-- Sub Kategori Buku --</option>
                  <?php foreach ($sub as $row): ?>
                    <?php if ($row['id'] != 1): ?>
                      <?php if ($row['name'] == $buku_obj->sub_kategori): ?>
                        <option class="bg-danger text-white">
                        <?php else: ?>
                        <option>
                      <?php endif; ?>
                        <?= $row['name'] ?></option>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="baca">Jumlah Baca Buku</label>
                <input type="text" class="form-control" id="baca" name="pdf_read_count" value="<?= $buku_obj->pdf_read_count; ?>" required>
              </div>
              <div class="form-group">
                <label for="unduh">Jumlah Unduh Buku</label>
                <input type="text" class="form-control" id="unduh" name="pdf_download_count" value="<?= $buku_obj->pdf_download_count; ?>" required>
              </div>
              <div class="form-group">
                <label for="deskripsi" required>Deskripsi Buku</label>
                <textarea class="form-control" id="deskripsi" rows="10" name="pdf_desc" value="<?= $buku_obj->pdf_desc; ?>"><?= $buku_obj->pdf_desc; ?></textarea>
              </div>
              <button type="submit" name="edit" class="btn btn-danger w-100">Ubah Data Buku</button>
            </form>
          </div>
          <!-- End View Pdf -->

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Hak Cipta © 2019 Komisi Pemberantasan Korupsi. Semua Hak Dilindungi.</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="logout">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      if($('.active_kategori').val() != 3){
        $('.sub_kategori').hide();
      } else {
        $('.sub_kategori').show();
      }
      $("#kategori").change(function(){
        if ( $(this).val() == 3 ) {
    			$('.sub_kategori').show();
        } else {
          $('.sub_kategori').hide();
        }
      });
    });
  </script>
</body>

</html>
