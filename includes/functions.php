<?php
function e($s){ return htmlspecialchars($s ?? '', ENT_QUOTES); }
function current_user(){ return $_SESSION['user'] ?? null; }
