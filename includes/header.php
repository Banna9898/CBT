<?php
// Minimal Argon-like header partial
?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>CBT System</title>
  <link rel="stylesheet" href="/assets/vendor/bootstrap/4.6.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/argon-lite.css">
  <link rel="stylesheet" href="/assets/css/custom.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <a class="navbar-brand" href="/public/index.php">CBT</a>
  <div class="collapse navbar-collapse">
    <ul class="navbar-nav ml-auto">
<?php if(!empty($_SESSION['user'])): ?>
      <li class="nav-item"><a class="nav-link" href="/public/user/dashboard.php">Dashboard</a></li>
      <?php if(($_SESSION['user']['role'] ?? '') === 'admin'): ?>
      <li class="nav-item"><a class="nav-link" href="/public/admin/dashboard.php">Admin</a></li>
      <?php endif; ?>
      <li class="nav-item"><a class="nav-link" href="/public/logout.php">Logout</a></li>
<?php else: ?>
      <li class="nav-item"><a class="nav-link" href="/public/login.php">Login</a></li>
      <li class="nav-item"><a class="nav-link" href="/public/register.php">Register</a></li>
<?php endif; ?>
    </ul>
  </div>
</nav>
<div class="container mt-4">
