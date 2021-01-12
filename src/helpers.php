<?php

if (!function_exists('asQuestion')) {
    /**
     * Apply CLI question styles to text
     */
    function asQuestion($data)
    {
        return "<question>$data</question>";
    }
}

if (!function_exists('asComment')) {
    /**
     * Apply CLI comment styles to text
     */
    function asComment($data)
    {
        return "<comment>$data</comment>";
    }
}

if (!function_exists('asInfo')) {
    /**
     * Apply CLI info styles to text
     */
    function asInfo($data)
    {
        return "<info>$data</info>";
    }
}

if (!function_exists('asError')) {
    /**
     * Apply CLI error styles to text
     */
    function asError($data)
    {
        return "<error>$data</error>";
    }
}

if (!function_exists('asLink')) {
    /**
     * Output text as a link
     */
    function asLink($link, $display)
    {
        return "<href=$link>$display</>";
    }
}
