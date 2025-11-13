<?php require_once __DIR__ . '/../../config/db.php'; require_admin(); if($_SERVER['REQUEST_METHOD']==='POST'){ $name=trim($_POST['name']); $desc=trim($_POST['description']); if(!empty($name)){ $pdo->prepare('INSERT INTO topics (name,description) VALUES (?,?)')->execute([$name,$desc]); header('Location: topics.php'); exit; } } if(isset($_GET['delete'])){ $pdo->prepare('DELETE FROM topics WHERE id=?')->execute([intval($_GET['delete'])]); header('Location: topics.php'); exit; } require_once __DIR__ . '/../../includes/header.php'; $rows=$pdo->query('SELECT * FROM topics ORDER BY created_at DESC')->fetchAll(PDO::FETCH_ASSOC); ?>
<div class="row"><div class="col-md-3">
  <div class="list-group">
    <a href="dashboard.php" class="list-group-item list-group-item-action">Dashboard</a>
    <a href="topics.php" class="list-group-item list-group-item-action active">Topics</a>
  </div>
</div>
<div class="col-md-9"><h3>Topics <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createModal">New</button></h3>
<table class="table"><thead><tr><th>Name</th><th>Description</th><th>Actions</th></tr></thead><tbody>
<?php foreach($rows as $r): ?>
<tr><td><?php echo e($r['name']); ?></td><td><?php echo e($r['description']); ?></td><td><a class="btn btn-sm btn-danger" href="?delete=<?php echo $r['id']; ?>" onclick="return confirm('Delete?')">Delete</a></td></tr>
<?php endforeach; ?>
</tbody></table>
<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document"><div class="modal-content"><form method="post"><div class="modal-header"><h5 class="modal-title">New Topic</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div><div class="modal-body"><div class="form-group"><label>Name</label><input name="name" class="form-control" required></div><div class="form-group"><label>Description</label><textarea name="description" class="form-control"></textarea></div></div><div class="modal-footer"><button class="btn btn-primary">Create</button></div></form></div></div></div>
</div></div><?php require_once __DIR__ . '/../../includes/footer.php'; ?>