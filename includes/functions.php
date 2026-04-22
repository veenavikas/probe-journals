<?php
require_once __DIR__ . '/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
        'cookie_samesite' => 'Lax'
    ]);
}

/**
 * Journal related functions
 */
function getJournalBySlug(string $slug): ?array {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM journals WHERE slug = ? AND is_active = 1 LIMIT 1");
    $stmt->execute([$slug]);
    return $stmt->fetch() ?: null;
}

function getJournalById(int $id): ?array {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM journals WHERE id = ? LIMIT 1");
    $stmt->execute([$id]);
    return $stmt->fetch() ?: null;
}

function getAllJournals(): array {
    $db = getDB();
    $stmt = $db->query("SELECT * FROM journals WHERE is_active = 1 ORDER BY sort_order ASC");
    return $stmt->fetchAll();
}

function getJournalsByCategory(): array {
    $db = getDB();
    $stmt = $db->query("SELECT * FROM journals WHERE is_active = 1 ORDER BY subject_category, sort_order ASC");
    $journals = $stmt->fetchAll();
    
    $grouped = [];
    foreach ($journals as $journal) {
        $grouped[$journal['subject_category']][] = $journal;
    }
    return $grouped;
}

/**
 * Editor related functions
 */
function getEditorsByJournal(int $journalId): array {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM editors WHERE journal_id = ? AND is_active = 1 ORDER BY sort_order ASC");
    $stmt->execute([$journalId]);
    return $stmt->fetchAll();
}

/**
 * Article related functions
 */
function getArticlesByJournal(int $journalId, ?int $volume = null, ?int $issue = null): array {
    $db = getDB();
    $sql = "SELECT * FROM articles WHERE journal_id = ? AND is_published = 1";
    $params = [$journalId];
    
    if ($volume !== null) {
        $sql .= " AND volume = ?";
        $params[] = $volume;
    }
    if ($issue !== null) {
        $sql .= " AND issue = ?";
        $params[] = $issue;
    }
    
    $sql .= " ORDER BY volume DESC, issue DESC, sort_order ASC";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function getArticlesGroupedByVolume(int $journalId): array {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM articles WHERE journal_id = ? AND is_published = 1 ORDER BY volume DESC, issue DESC, sort_order ASC");
    $stmt->execute([$journalId]);
    $articles = $stmt->fetchAll();
    
    $grouped = [];
    foreach ($articles as $article) {
        $grouped[$article['volume']][$article['issue']][] = $article;
    }
    return $grouped;
}

function getLatestArticles(int $journalId, int $limit = 3): array {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM articles WHERE journal_id = ? AND is_published = 1 ORDER BY published_date DESC, id DESC LIMIT ?");
    $stmt->execute([$journalId, $limit]);
    return $stmt->fetchAll();
}

/**
 * Testimonials & Indexing
 */
function getTestimonialsByJournal(?int $journalId = null): array {
    $db = getDB();
    if ($journalId === null) {
        $stmt = $db->prepare("SELECT * FROM testimonials WHERE journal_id IS NULL AND is_active = 1 ORDER BY sort_order ASC");
        $stmt->execute();
    } else {
        $stmt = $db->prepare("SELECT * FROM testimonials WHERE journal_id = ? AND is_active = 1 ORDER BY sort_order ASC");
        $stmt->execute([$journalId]);
    }
    return $stmt->fetchAll();
}

function getAllIndexingPartners(): array {
    $db = getDB();
    $stmt = $db->query("SELECT * FROM indexing_partners WHERE is_active = 1 ORDER BY sort_order ASC");
    return $stmt->fetchAll();
}

/**
 * Site Settings & Content
 */
function getSiteSetting(string $key, string $default = ''): string {
    $db = getDB();
    $stmt = $db->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ? LIMIT 1");
    $stmt->execute([$key]);
    $result = $stmt->fetch();
    return $result ? $result['setting_value'] : $default;
}

function getAllSiteSettings(): array {
    $db = getDB();
    $stmt = $db->query("SELECT * FROM site_settings");
    $settings = $stmt->fetchAll();
    
    $keyed = [];
    foreach ($settings as $s) {
        $keyed[$s['setting_key']] = $s['setting_value'];
    }
    return $keyed;
}

function getPageContent(string $pageKey): string {
    $db = getDB();
    $stmt = $db->prepare("SELECT content FROM site_pages WHERE page_key = ? LIMIT 1");
    $stmt->execute([$pageKey]);
    $result = $stmt->fetch();
    return $result ? $result['content'] : '';
}

/**
 * Security & Utilities
 */
function sanitize(string $input): string {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function generateCSRFToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCSRFToken(string $token): bool {
    if (!isset($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

function uploadFile(array $file, string $type): string|false {
    if ($file['error'] !== UPLOAD_ERR_OK) return false;
    
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    
    $allowedMimes = ($type === 'pdf') ? ALLOWED_PDF : ALLOWED_IMG;
    $maxSize = ($type === 'pdf') ? MAX_PDF_SIZE : MAX_IMG_SIZE;
    $subDir = ($type === 'pdf') ? 'pdfs/' : ($type === 'editor' ? 'editors/' : 'indexing/');
    
    if (!in_array($mime, $allowedMimes)) return false;
    if ($file['size'] > $maxSize) return false;
    
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = bin2hex(random_bytes(16)) . '.' . $ext;
    $targetPath = UPLOAD_PATH . $subDir . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $subDir . $filename;
    }
    
    return false;
}

function deleteFile(string $filename, string $type): bool {
    // filename already includes subdir from uploadFile
    $filePath = UPLOAD_PATH . $filename;
    if (file_exists($filePath)) {
        return unlink($filePath);
    }
    return false;
}

function sendEmail(string $to, string $toName, string $subject, string $htmlBody): bool {
    // This requires PHPMailer via composer, which we'll set up.
    // For now, providing the placeholder structure.
    /*
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = MAIL_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = MAIL_USER;
        $mail->Password   = MAIL_PASS;
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = MAIL_PORT;

        $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
        $mail->addAddress($to, $toName);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $htmlBody;
        return $mail->send();
    } catch (Exception $e) {
        return false;
    }
    */
    return true; // Placeholder
}

function formatDate(string $date): string {
    return date("F j, Y", strtotime($date));
}

function slugify(string $text): string {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return empty($text) ? 'n-a' : $text;
}

function paginateResults(int $total, int $perPage, int $currentPage): array {
    $totalPages = ceil($total / $perPage);
    return [
        'total' => $total,
        'per_page' => $perPage,
        'current_page' => $currentPage,
        'total_pages' => $totalPages,
        'has_previous' => $currentPage > 1,
        'has_next' => $currentPage < $totalPages
    ];
}

function getUnreadMessageCount(): int {
    $db = getDB();
    $stmt = $db->query("SELECT COUNT(*) as count FROM contact_messages WHERE is_read = 0");
    return (int)$stmt->fetch()['count'];
}

function getNewSubmissionsCount(): int {
    $db = getDB();
    $stmt = $db->query("SELECT COUNT(*) as count FROM submissions WHERE status = 'new'");
    return (int)$stmt->fetch()['count'];
}
