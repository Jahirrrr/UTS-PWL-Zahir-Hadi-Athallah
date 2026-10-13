<?php

function h($text)
{
    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}

function redirect($page, $action = 'index')
{
    header('Location: index.php?page=' . $page . '&action=' . $action);
    exit;
}
