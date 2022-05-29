<?php
require_once('auth.php');
require 'config.php';
$id = $_GET['id'];
$sql = 'SELECT * FROM buku WHERE id=:id';
$statement = $db->prepare($sql);
$statement->execute([':id' => $id ]);
$book = $statement->fetch(PDO::FETCH_OBJ);
if (isset ($_POST['nama'])  && isset($_POST['stock']) ) {
  $nama = $_POST['nama'];
  $stock = $_POST['stock'];
  $sql = 'UPDATE buku SET nama=:nama, stock=:stock WHERE id=:id';
  $statement = $db->prepare($sql);
  if ($statement->execute([':nama' => $nama, ':stock' => $stock, ':id' => $id])) {
    header("Location: bukuadmn.php");
  }
}


 ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="icon" type="image/x-icon" href="assets/logo.png" />
        <!-- Bootstrap Icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
        <!-- SimpleLightbox plugin CSS-->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
        <title>Manage Buku</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/bar2.css" rel="stylesheet" />
    </head>
    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end bg-white" id="sidebar-wrapper">
                
                <div class="sidebar-heading border-bottom bg-light"><i><img src="assets/img/book.png"  width="35" height="35" alt=""></i> <a href="admin.php" style="color: black;text-decoration:none;">MOCO</a> </div>
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="user.php">Data Anggota Perpustakaan</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="createbuku.php">Manage Buku</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="bukuadmn.php">Data Buku</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="creatpinjam.php">Manage Peminjaman</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="readpeminjaman.php">Peminjaman</a>

                </div>
            </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper">
                <!-- Top navigation-->
                <nav class="navbar navbar-expand-lg  border-bottom" style="background-color: #195681; border-color:#195681;">
                    <div class="container-fluid">
                        <button class="btn btn-primary" id="sidebarToggle"><i class="bi bi-justify"></i></button>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;">Other</a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown"   >
                                        <a class="dropdown-item" href="logout.php">Log Out <i class="bi bi-box-arrow-right" style="margin-left: 40%;"></i></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- Page content-->
                
                
                <header class="masthead">
           
                    <div class="container px-4 px-lg-5 h-100">
                  
                    
                        <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                            
                            <form action="#" method="POST" enctype="multipart/form-data">
                            <h2 style='color:white;'>Ubah Data Buku</h2>
                                <div class="form-group" style="margin-top: 2%;">
                                <label for="stock" style="color: white;">-Jumlah Stock-</label>
                                    <input type="text" class="form-control" placeholder="Stock" required name="stock" value="<?= $book->stock; ?>"/>
                                </div>
                                <div class="form-group" style="margin-top: 2%;">
                                <label for="judul" style="color: white;">-Nama Buku-</label>
                                    <input type="text" class="form-control" placeholder="Judul" required name="nama" value="<?= $book->nama; ?>"/>
                                </div>
                                
                                <button type="submit" name="ubah" style="margin-top: 2%; background-color:#195681;" class="btn btn-primary">Ubah</button>
                            </form>
   
                        </div>
      
                    </div>
                
                </header>
                
                ?>
            </div>  
        </div>
        
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/bar.js"></script>
    </body>
</html>
