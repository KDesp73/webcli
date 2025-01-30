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


function bold($str){
    return "<b>". $str ."</b>";
}
function italic($str){
    return "<i>". $str ."</i>";
}

function progressBar(int $progress, int $total, int $width = 20): string {
    if ($total <= 0) return "[ERROR: Invalid total value]";

    $percentage = $progress / $total;
    $fullBlocks = floor($width * $percentage);
    $remainder = ($width * $percentage) - $fullBlocks; // Fractional part
    $emptyBlocks = $width - $fullBlocks - 1; // Leave space for the partial block

    // Unicode fractional blocks from ▏(1/8) to █ (full)
    $blockChars = ["", "▏", "▎", "▍", "▌", "▋", "▊", "▉", "█"];
    $partialBlock = $blockChars[round($remainder * 8)]; // Get closest fractional block

    return sprintf("%s%s%s %3d%%", str_repeat("█", $fullBlocks), $partialBlock, str_repeat("░", $emptyBlocks), round($percentage * 100));
}

?>
