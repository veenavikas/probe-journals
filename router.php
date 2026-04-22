<?php
/**
 * ============================================================
 *  Probe Journals — PHP Built-in Server Router
 * ============================================================
 *  Usage (from project root):
 *    SITE_URL=http://localhost:8080 php -S localhost:8080 router.php
 *
 *  Then visit:
 *    Public site → http://localhost:8080/
 *    Admin panel → http://localhost:8080/admin/
 * ============================================================
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// ── Route /admin/ requests ────────────────────────────────────
if (str_starts_with($uri, '/admin')) {
    $adminUri = substr($uri, 6); // strip '/admin'
    if ($adminUri === '' || $adminUri === '/') {
        $adminUri = '/index.php';
    }

    // Static files inside admin dir (none currently, but safe)
    $adminFile = __DIR__ . '/admin' . $adminUri;
    if (is_file($adminFile) && !str_ends_with($adminFile, '.php')) {
        // Serve as static file with correct MIME
        serveStaticFile($adminFile);
        return true;
    }

    if (is_file($adminFile) && str_ends_with($adminFile, '.php')) {
        chdir(__DIR__ . '/admin');
        require $adminFile;
        return true;
    }

    // Default to admin index
    chdir(__DIR__ . '/admin');
    require __DIR__ . '/admin/index.php';
    return true;
}

// ── Route all static assets → public/ ────────────────────────
// Covers: /assets/css/, /assets/js/, /assets/img/, /assets/uploads/
$publicFile = __DIR__ . '/public' . $uri;
if ($uri !== '/' && is_file($publicFile)) {
    if (str_ends_with($publicFile, '.php')) {
        // PHP file in public
        chdir(__DIR__ . '/public');
        require $publicFile;
        return true;
    }
    // True static file — serve it correctly
    serveStaticFile($publicFile);
    return true;
}

// ── Route / → public/index.php ───────────────────────────────
if ($uri === '/' || $uri === '') {
    chdir(__DIR__ . '/public');
    require __DIR__ . '/public/index.php';
    return true;
}

// ── PHP files in public/ ──────────────────────────────────────
if (is_file($publicFile) && str_ends_with($publicFile, '.php')) {
    chdir(__DIR__ . '/public');
    require $publicFile;
    return true;
}

// ── Pretty URLs: /journals/{slug} → journal.php?slug={slug} ──
if (preg_match('#^/journals/([a-z0-9-]+)/?$#', $uri, $m)) {
    $_GET['slug'] = $m[1];
    $_REQUEST['slug'] = $m[1];
    chdir(__DIR__ . '/public');
    require __DIR__ . '/public/journal.php';
    return true;
}

// ── 404 fallback ──────────────────────────────────────────────
http_response_code(404);
echo '<html><body>';
echo '<h1>404 Not Found</h1>';
echo '<p>The path <code>' . htmlspecialchars($uri) . '</code> was not found.</p>';
echo '<p><a href="/">← Home</a> | <a href="/admin/">Admin</a></p>';
echo '</body></html>';
return true;

// ── Helper: serve static file with correct Content-Type ──────
function serveStaticFile(string $filePath): void {
    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    $mimeTypes = [
        'css'   => 'text/css',
        'js'    => 'application/javascript',
        'json'  => 'application/json',
        'png'   => 'image/png',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'gif'   => 'image/gif',
        'webp'  => 'image/webp',
        'svg'   => 'image/svg+xml',
        'ico'   => 'image/x-icon',
        'pdf'   => 'application/pdf',
        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf'   => 'font/ttf',
        'eot'   => 'application/vnd.ms-fontobject',
        'html'  => 'text/html; charset=utf-8',
        'txt'   => 'text/plain',
        'xml'   => 'application/xml',
    ];
    $mime = $mimeTypes[$ext] ?? 'application/octet-stream';
    header('Content-Type: ' . $mime);
    header('Content-Length: ' . filesize($filePath));
    readfile($filePath);
}
