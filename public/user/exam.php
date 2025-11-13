<?php require_once __DIR__ . '/../../config/db.php'; require_login(); $exam_id=intval($_GET['exam_id'] ?? 0); if($exam_id<=0){ header('Location: dashboard.php'); exit; } $stmt=$pdo->prepare('SELECT * FROM exams WHERE id=?'); $stmt->execute([$exam_id]); $exam=$stmt->fetch(PDO::FETCH_ASSOC); if(!$exam){ header('Location: dashboard.php'); exit; } // fetch questions
$qstmt=$pdo->prepare('SELECT * FROM questions WHERE exam_id = ? ORDER BY id'); $qstmt->execute([$exam_id]); $questions=$qstmt->fetchAll(PDO::FETCH_ASSOC);
// shuffle questions and options server-side for each attempt
shuffle($questions);
foreach($questions as &$q){ $opts=json_decode($q['options'], true); $paired = []; foreach($opts as $i => $o) $paired[]=['idx'=>$i,'text'=>$o]; shuffle($paired); $newOpts = array_map(function($p){return $p['text'];}, $paired); $origIndexes = array_map(function($p){return $p['idx'];}, $paired); $correctIndex = array_search($q['correct_index'], $origIndexes); $q['options']=$newOpts; $q['shuffled_correct']=$correctIndex; }

require_once __DIR__ . '/../../includes/header.php'; ?>
<h3><?php echo e($exam['title']); ?> - Time: <?php echo e($exam['time_limit']); ?> mins</h3>
<form method="post" action="submit_exam.php">
  <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
  <?php foreach($questions as $i=>$q): ?>
    <div class="card p-3 mb-2">
      <h5>Q<?php echo $i+1; ?>. <?php echo e($q['question_text']); ?></h5>
      <?php foreach($q['options'] as $oi=>$opt): ?>
        <div class="form-check"><input class="form-check-input" type="radio" name="q_<?php echo $q['id']; ?>" value="<?php echo $oi; ?>" id="q_<?php echo $q['id'].'_'.$oi; ?>"><label class="form-check-label" for="q_<?php echo $q['id'].'_'.$oi; ?>"><?php echo e($opt); ?></label></div>
      <?php endforeach; ?>
      <!-- store correct index in hidden field per question to verify server-side -->
      <input type="hidden" name="correct_<?php echo $q['id']; ?>" value="<?php echo $q['shuffled_correct']; ?>">
    </div>
  <?php endforeach; ?>
  <button class="btn btn-success">Submit</button>
</form>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>