<?php require_once __DIR__ . '/../../config/db.php'; require_admin(); if($_SERVER['REQUEST_METHOD']==='POST'){ $title=trim($_POST['title']); $topic_id = empty($_POST['topic_id'])?null:intval($_POST['topic_id']); $time_limit=intval($_POST['time_limit']); if(!empty($title)){ $pdo->prepare('INSERT INTO exams (topic_id,title,description,time_limit) VALUES (?,?,?,?)')->execute([$topic_id,$title,trim($_POST['description']),$time_limit]); header('Location: exams.php'); exit; } } if(isset($_GET['delete'])){ $pdo->prepare('DELETE FROM exams WHERE id=?')->execute([intval($_GET['delete'])]); header('Location: exams.php'); exit; } require_once __DIR__ . '/../../includes/header.php'; $exams=$pdo->query('SELECT exams.*, topics.name as topic_name FROM exams LEFT JOIN topics ON exams.topic_id=topics.id ORDER BY created_at DESC')->fetchAll(PDO::FETCH_ASSOC); $topics=$pdo->query('SELECT id,name FROM topics ORDER BY name')->fetchAll(PDO::FETCH_ASSOC); ?>
<div class="row"><div class="col-md-3">
  <div class="list-group">
    <a href="dashboard.php" class="list-group-item list-group-item-action">Dashboard</a>
    <a href="exams.php" class="list-group-item list-group-item-action active">Exams</a>
  </div>
</div>
<div class="col-md-9"><h3>Exams <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createModal">New</button></h3>
<table class="table"><thead><tr><th>Title</th><th>Topic</th><th>Time (min)</th><th>Actions</th></tr></thead><tbody>
<?php foreach($exams as $e): ?>
<tr><td><?php echo e($e['title']); ?></td><td><?php echo e($e['topic_name']); ?></td><td><?php echo e($e['time_limit']); ?></td><td><a class="btn btn-sm btn-outline-secondary" href="questions.php?exam_id=<?php echo $e['id']; ?>">Questions</a> <a class="btn btn-sm btn-danger" href="?delete=<?php echo $e['id']; ?>" onclick="return confirm('Delete?')">Delete</a></td></tr>
<?php endforeach; ?>
</tbody></table>
<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document"><div class="modal-content"><form method="post"><div class="modal-header"><h5 class="modal-title">New Exam</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div><div class="modal-body"><div class="form-group"><label>Title</label><input name="title" class="form-control" required></div><div class="form-group"><label>Topic</label><select name="topic_id" class="form-control"><option value="">-- None --</option><?php foreach($topics as $t) echo "<option value='{$t['id']}'>".htmlspecialchars($t['name'])."</option>"; ?></select></div><div class="form-group"><label>Time limit (minutes)</label><input name="time_limit" type="number" value="30" class="form-control"></div><div class="form-group"><label>Description</label><textarea name="description" class="form-control"></textarea></div></div><div class="modal-footer"><button class="btn btn-primary">Create</button></div></form></div></div></div>
</div></div><?php require_once __DIR__ . '/../../includes/footer.php'; ?>