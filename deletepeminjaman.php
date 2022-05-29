<?php
require_once('auth.php');
require 'config.php';
$id = $_GET['id'];
$sql = 'DELETE FROM peminjaman WHERE id=:id';
$statement = $db->prepare($sql);
if ($statement->execute([':id' => $id])) {
  header("Location: readpeminjaman.php");
}