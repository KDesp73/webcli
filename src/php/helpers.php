<?php

function println($str) {
    echo $str . "<br>";
}

function parseJson($file) {
    $jsonData = file_get_contents($file);
    $data = json_decode($jsonData, true); 
    return $data;
}

function mailto($email){
    return "<a tabindex=\"-1\" href=\"mailto:" . $email . "\">" . $email . "</a>";
}

function anchor(string $url, string $name = null): string {
    $name = $name ?? $url;
    return "<a tabindex=\"-1\" target=\"_blank\" href=\"" . $url . "\">" . $name . "</a>";
}

function img(string $src, string $alias = null): string {
    $alias = $alias ?? "image";
    return '<img class="image" src="' . htmlspecialchars($src, ENT_QUOTES) . '" alt="' . htmlspecialchars($alias, ENT_QUOTES) . '">';
}

function strpad($str, $size): string {
    return str_replace(" ", "&nbsp;", str_pad($str, $size));
}

function bold($str){
    return "<b>". $str ."</b>";
}
function italic($str){
    return "<i>". $str ."</i>";
}

function wrap(string $str, int $maxLength): string {
    $words = explode(' ', $str);
    $line = '';
    $result = '';

    foreach ($words as $word) {
        if (strlen($line . ' ' . $word) <= $maxLength) {
            $line .= (empty($line) ? '' : ' ') . $word;
        } else {
            $result .= $line . '<br>';
            $line = $word;
        }
    }

    if (!empty($line)) {
        $result .= $line;
    }

    return $result;
}
function wrapLines(string $str, int $maxLength): array {
    $words = explode(' ', $str);  // Split the string into words
    $line = '';
    $result = [];

    foreach ($words as $word) {
        // Check if adding the word exceeds the maxLength
        if (strlen($line . ' ' . $word) <= $maxLength) {
            // If it fits, add it to the current line
            $line .= (empty($line) ? '' : ' ') . $word;
        } else {
            // Otherwise, push the current line to the result and start a new line
            $result[] = $line;
            $line = $word;
        }
    }

    // Add the last line to the result
    if (!empty($line)) {
        $result[] = $line;
    }

    return $result;
}


function progressBar(int $progress, int $total, int $width = 20): string {
    if ($total <= 0) return "[ERROR: Invalid total value]";

    $percentage = $progress / $total;
    $fullBlocks = floor($width * $percentage);
    $remainder = ($width * $percentage) - $fullBlocks;
    $emptyBlocks = $width - $fullBlocks - 1;

    // Unicode fractional blocks from ▏(1/8) to █ (full)
    $blockChars = ["", "▏", "▎", "▍", "▌", "▋", "▊", "▉", "█"];
    $partialBlock = $blockChars[round($remainder * 8)];

    return sprintf("%s%s%s %3d%%", str_repeat("█", $fullBlocks), $partialBlock, str_repeat("░", $emptyBlocks), round($percentage * 100));
}

?>
