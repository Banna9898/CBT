<?php require_once __DIR__ . '/../../config/db.php'; require_admin(); if(isset($_GET['action']) && isset($_GET['id'])){ $id=intval($_GET['id']); if($_GET['action']==='approve'){ $pdo->prepare('UPDATE users SET status=? WHERE id=?')->execute(['active',$id]); } if($_GET['action']==='disable'){ $pdo->prepare('UPDATE users SET status=? WHERE id=?')->execute(['disabled',$id]); } if($_GET['action']==='delete'){ $pdo->prepare('DELETE FROM users WHERE id=?')->execute([$id]); } header('Location: users.php'); exit; } require_once __DIR__ . '/../../includes/header.php'; $rows=$pdo->query('SELECT id,name,email,phone,role,status,created_at FROM users ORDER BY created_at DESC')->fetchAll(PDO::FETCH_ASSOC); ?>
<div class="row"><div class="col-md-3">
  <div class="list-group">
    <a href="dashboard.php" class="list-group-item list-group-item-action">Dashboard</a>
    <a href="users.php" class="list-group-item list-group-item-action active">Manage Users</a>
  </div>
</div>
<div class="col-md-9"><h3>Manage Users</h3>
<table class="table table-striped">
<thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Status</th><th>Actions</th></tr></thead>
<tbody>
<?php foreach($rows as $r): ?>
<tr><td><?php echo e($r['name']); ?></td><td><?php echo e($r['email']); ?></td><td><?php echo e($r['phone']); ?></td><td><?php echo e($r['role']); ?></td><td><?php echo e($r['status']); ?></td>
<td>
<?php if($r['status']==='pending'): ?>
  <a class="btn btn-sm btn-success" href="?action=approve&id=<?php echo $r['id']; ?>">Approve</a>
<?php endif; ?>
<?php if($r['status']!=='disabled'): ?>
  <a class="btn btn-sm btn-warning" href="?action=disable&id=<?php echo $r['id']; ?>">Disable</a>
<?php endif; ?>
  <a class="btn btn-sm btn-danger" href="?action=delete&id=<?php echo $r['id']; ?>" onclick="return confirm('Delete?')">Delete</a>
</td></tr>
<?php endforeach; ?>
</tbody>
</table></div></div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>