<?php require_once __DIR__ . '/../../config/db.php'; require_admin(); $exam_id = intval($_GET['exam_id'] ?? 0); if($exam_id<=0){ header('Location: exams.php'); exit; } if($_SERVER['REQUEST_METHOD']==='POST'){ $q = trim($_POST['question_text']); $opts = [ trim($_POST['o1']), trim($_POST['o2']), trim($_POST['o3']), trim($_POST['o4']) ]; $ci = intval($_POST['correct_index']); if(!empty($q)){ $pdo->prepare('INSERT INTO questions (exam_id,question_text,options,correct_index) VALUES (?,?,?::jsonb,?)')->execute([$exam_id,json_encode($q),json_encode($opts),$ci]); header('Location: questions.php?exam_id='.$exam_id); exit; } } if(isset($_GET['delete'])){ $pdo->prepare('DELETE FROM questions WHERE id=?')->execute([intval($_GET['delete'])]); header('Location: questions.php?exam_id='.$exam_id); exit; } require_once __DIR__ . '/../../includes/header.php'; $questions=$pdo->prepare('SELECT * FROM questions WHERE exam_id=? ORDER BY id'); $questions->execute([$exam_id]); $rows=$questions->fetchAll(PDO::FETCH_ASSOC); $exam = $pdo->prepare('SELECT * FROM exams WHERE id=?'); $exam->execute([$exam_id]); $exam = $exam->fetch(PDO::FETCH_ASSOC); ?>
<div class="row"><div class="col-md-3">
  <div class="list-group">
    <a href="dashboard.php" class="list-group-item">Dashboard</a>
    <a href="exams.php" class="list-group-item">Exams</a>
    <a href="questions.php?exam_id=<?php echo $exam_id; ?>" class="list-group-item active">Questions</a>
  </div>
</div>
<div class="col-md-9"><h3>Questions for: <?php echo e($exam['title']); ?> <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createModal">Add</button></h3>
<table class="table"><thead><tr><th>Question</th><th>Options</th><th>Actions</th></tr></thead><tbody>
<?php foreach($rows as $r): $opts=json_decode($r['options'], true); ?>
<tr><td><?php echo e($r['question_text']); ?></td><td><ol><?php foreach($opts as $o) echo '<li>'.e($o).'</li>'; ?></ol></td><td><a class="btn btn-sm btn-danger" href="?delete=<?php echo $r['id']; ?>&exam_id=<?php echo $exam_id; ?>" onclick="return confirm('Delete?')">Delete</a></td></tr>
<?php endforeach; ?></tbody></table>
<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document"><div class="modal-content"><form method="post"><div class="modal-header"><h5 class="modal-title">New Question</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div><div class="modal-body"><div class="form-group"><label>Question text</label><textarea name="question_text" class="form-control" required></textarea></div>
<div class="form-row"><div class="form-group col-md-6"><label>Option 1</label><input name="o1" class="form-control"></div><div class="form-group col-md-6"><label>Option 2</label><input name="o2" class="form-control"></div></div>
<div class="form-row"><div class="form-group col-md-6"><label>Option 3</label><input name="o3" class="form-control"></div><div class="form-group col-md-6"><label>Option 4</label><input name="o4" class="form-control"></div></div>
<div class="form-group"><label>Correct option index (0-3)</label><input name="correct_index" type="number" min="0" max="3" class="form-control" value="0"></div>
</div><div class="modal-footer"><button class="btn btn-primary">Create</button></div></form></div></div></div>
</div></div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>