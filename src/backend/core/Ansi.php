<?php 
namespace app\core;

class Ansi {
    /**
     * @param mixed $str
     */
    function black($str): string 
    {
        return "<span class=\"black\">" . $str . "</span>";
    }
    /**
     * @param mixed $str
     */
    function red($str): string 
    {
        return "<span class=\"red\">" . $str . "</span>";
    }
    /**
     * @param mixed $str
     */
    function green($str): string 
    {
        return "<span class=\"green\">" . $str . "</span>";
    }
    /**
     * @param mixed $str
     */
    function yellow($str): string 
    {
        return "<span class=\"yellow\">" . $str . "</span>";
    }
    /**
     * @param mixed $str
     */
    function blue($str): string 
    {
        return "<span class=\"blue\">" . $str . "</span>";
    }
    /**
     * @param mixed $str
     */
    function magenta($str): string 
    {
        return "<span class=\"magenta\">" . $str . "</span>";
    }
    /**
     * @param mixed $str
     */
    function cyan($str): string 
    {
        return "<span class=\"cyan\">" . $str . "</span>";
    }
    /**
     * @param mixed $str
     */
    function white($str): string 
    {
        return "<span class=\"white\">" . $str . "</span>";
    }
    /**
     * @param mixed $str
     */
    function bold($str): string 
    {
        return "<span class=\"bold\">" . $str . "</span>";
    }
    /**
     * @param mixed $str
     */
    function italic($str): string 
    {
        return "<span class=\"italic\">" . $str . "</span>";
    }
    /**
     * @param mixed $str
     */
    function underline($str): string 
    {
        return "<span class=\"underline\">" . $str . "</span>";
    }
    /**
     * @param mixed $str
     */
    function strikethrough($str): string 
    {
        return "<span class=\"strikethrough\">" . $str . "</span>";
    }
    /**
     * @param mixed $str
     */
    function bgBlack($str): string 
    {
        return "<span class=\"bg-black\">" . $str . "</span>";
    }
    /**
     * @param mixed $str
     */
    function bgRed($str): string 
    {
        return "<span class=\"bg-red\">" . $str . "</span>";
    }
    /**
     * @param mixed $str
     */
    function bgGreen($str): string 
    {
        return "<span class=\"bg-green\">" . $str . "</span>";
    }
    /**
     * @param mixed $str
     */
    function bgYellow($str): string 
    {
        return "<span class=\"bg-yellow\">" . $str . "</span>";
    }
    /**
     * @param mixed $str
     */
    function bgBlue($str): string 
    {
        return "<span class=\"bg-blue\">" . $str . "</span>";
    }
    /**
     * @param mixed $str
     */
    function bgMagenta($str): string 
    {
        return "<span class=\"bg-magenta\">" . $str . "</span>";
    }
    /**
     * @param mixed $str
     */
    function bgCyan($str): string 
    {
        return "<span class=\"bg-cyan\">" . $str . "</span>";
    }
    /**
     * @param mixed $str
     */
    function bgWhite($str): string 
    {
        return "<span class=\"bg-white\">" . $str . "</span>";
    }
}
