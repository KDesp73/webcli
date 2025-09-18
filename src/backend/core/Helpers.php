<?php
declare(strict_types=1);

namespace app\core;

class Helpers
{
    public static function println(string $str): void
    {
        echo $str . "<br>";
    }

    public static function parseJson(string $file): array
    {
        $jsonData = file_get_contents($file);
        return json_decode($jsonData, true) ?? [];
    }

    public static function mailto(string $email): string
    {
        return '<a tabindex="-1" href="mailto:' . htmlspecialchars($email, ENT_QUOTES) . '">' . htmlspecialchars($email, ENT_QUOTES) . '</a>';
    }

    public static function anchor(string $url, ?string $name = null): string
    {
        $name = $name ?? $url;
        return '<a tabindex="-1" target="_blank" href="' . htmlspecialchars($url, ENT_QUOTES) . '">' . htmlspecialchars($name, ENT_QUOTES) . '</a>';
    }

    public static function img(string $src, ?string $alias = null): string
    {
        $alias = $alias ?? 'image';
        return '<img class="image" src="' . htmlspecialchars($src, ENT_QUOTES) . '" alt="' . htmlspecialchars($alias, ENT_QUOTES) . '">';
    }

    public static function strpad(string $str, int $size): string
    {
        return str_replace(" ", "&nbsp;", str_pad($str, $size));
    }

    public static function bold(string $str): string
    {
        return "<b>{$str}</b>";
    }

    public static function italic(string $str): string
    {
        return "<i>{$str}</i>";
    }

    public static function wrap(string $str, int $maxLength): string
    {
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

    /**
     * @return string[]|<missing>|string[]
     */
    public static function wrapLines(string $str, int $maxLength): array
    {
        $words = explode(' ', $str);
        $line = '';
        $result = [];

        foreach ($words as $word) {
            if (strlen($line . ' ' . $word) <= $maxLength) {
                $line .= (empty($line) ? '' : ' ') . $word;
            } else {
                $result[] = $line;
                $line = $word;
            }
        }

        if (!empty($line)) {
            $result[] = $line;
        }

        return $result;
    }

    public static function progressBar(int $progress, int $total, int $width = 20): string
    {
        if ($total <= 0) {
            return "[ERROR: Invalid total value]";
        }

        $percentage = $progress / $total;
        $fullBlocks = (int) floor($width * $percentage);
        $remainder = ($width * $percentage) - $fullBlocks;
        $emptyBlocks = $width - $fullBlocks - 1;

        $blockChars = ["", "▏", "▎", "▍", "▌", "▋", "▊", "▉", "█"];
        $partialBlock = $blockChars[(int) round($remainder * 8)];

        return sprintf(
            "%s%s%s %3d%%",
            str_repeat("█", $fullBlocks),
            $partialBlock,
            str_repeat("░", $emptyBlocks),
            (int) round($percentage * 100)
        );
    }
}
