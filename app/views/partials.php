<?php
// Public views helper for standalone partial rendering
function standalonePartial(string $view, array $data = []): string {
    extract($data);
    $viewPath = __DIR__ . '/partials/' . $view . '.php';
    if (!file_exists($viewPath)) return '';
    ob_start();
    require $viewPath;
    return ob_get_clean();
}
?>
