<?php require_once __DIR__ . '/../../config/db.php'; require_login(); require_once __DIR__ . '/../../includes/header.php'; $rows = $pdo->prepare('SELECT attempts.*, exams.title FROM attempts JOIN exams ON attempts.exam_id=exams.id WHERE attempts.user_id=? ORDER BY completed_at DESC'); $rows->execute([$_SESSION['user']['id']]); $rows = $rows->fetchAll(PDO::FETCH_ASSOC); ?>
<h3>Your Attempts</h3>
<table class="table"><thead><tr><th>Exam</th><th>Score</th><th>Date</th></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><td><?php echo e($r['title']); ?></td><td><?php echo e($r['score']); ?> / <?php echo e($r['total_questions']); ?></td><td><?php echo e($r['completed_at']); ?></td></tr><?php endforeach; ?>
</tbody></table>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>