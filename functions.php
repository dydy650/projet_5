<?php
/**
 * @param mixed $args
 * @author Patxi
 * Custom var_dump/die
 */
function dd($args)
{
    $args = func_get_args();
    $from = debug_backtrace()[0];
    echo '<!DOCTYPE html><html><head><title>(' . count($args) . ') Var_dump</title><style>pre:last-child small{display:none}</style></head><body><pre>';
    foreach ($args as $arg) {
        $type = is_object($arg) ? 'object(' . get_class($arg) . ')' : gettype($arg);
        echo '<div style="color:#0a01f8;font-weight:bold">' . $from['file'] . ':' . $from['line'] . ' Type:' . $type . '</div>';
        var_dump($arg);
    }
    echo '</pre></body></html>';
    die;
}

