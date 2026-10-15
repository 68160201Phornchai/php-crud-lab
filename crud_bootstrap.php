<?php
require_once __DIR__ . '/config/db.php';
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
function h($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function csrf_field() { echo '<input type="hidden" name="csrf" value="'.h($_SESSION['csrf']).'">'; }
function verify_csrf() { if (!hash_equals($_SESSION['csrf'], (string)($_POST['csrf'] ?? ''))) { http_response_code(403); exit('Invalid CSRF'); } }
function valid_id($value) { $n = filter_var($value, FILTER_VALIDATE_INT, ['options'=>['min_range'=>1]]); return $n === false ? null : $n; }
function profile_id($conn) { $r=mysqli_query($conn,'SELECT id FROM profile ORDER BY id LIMIT 1'); $p=$r?mysqli_fetch_assoc($r):null; return $p?$p['id']:1; }
function page_start($title) { 
    echo '<!doctype html><html lang="th"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>'.h($title).'</title><style>body{font-family:sans-serif;margin:20px;background:#f8f9fa;}nav{margin-bottom:20px;}nav a{margin-right:15px;text-decoration:none;color:#0d6efd;}nav a:hover{text-decoration:underline;}.container{background:#fff;padding:20px;border-radius:8px;box-shadow:0 2px 4px rgba(0,0,0,0.1);}</style></head><body>';
    echo '<nav><a href="index.php">Resume</a> <a href="skills.php">Manage Skills</a> <a href="skill_create.php">+ Add Skill</a></nav>';
    echo '<main class="container">';
}
function page_end() { echo '</main></body></html>'; }