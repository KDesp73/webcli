<?php

require 'helpers.php';

function helpCommand() {
    $output = "Available commands:<br>";
    $output .= "&nbsp;&nbsp;help&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Prints this message<br>";
    $output .= "&nbsp;&nbsp;about&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Learn things about me<br>";
    $output .= "&nbsp;&nbsp;skills&nbsp;&nbsp;&nbsp;&nbsp;Check what I can do<br>";
    $output .= "&nbsp;&nbsp;contact&nbsp;&nbsp;&nbsp;Contact me!<br>";
    $output .= "&nbsp;&nbsp;clear&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clear the terminal<br>";
    echo $output;
    return $output;
}

function aboutCommand() {
    $output = "I am a web developer passionate about creating interactive and user-friendly websites.";
    echo $output;
    return $output;
}

function skillsCommand() {
    $output = "Skills:<br>- PHP<br>- JavaScript<br>- React<br>- HTML/CSS<br>- SQL";
    echo $output;
    return $output;
}

function contactCommand() {
    $config = parseJson("config.json");

    $output = "Reach me at<br>";
    if($config['email']){
        $output .= "- Email: " . mailto($config['email']) . "<br>";
    }
    if($config['github']) {
        $output .= "- Github: " . anchor($config['github']) . "<br>";
    }
    echo $output;
    return $output;
}

function clearCommand() {
    echo "<script>
        window.onload = function() {
            console.log('Clear');
            window.location.reload();
        }
    </script>";
}

function runCommand($command) {
    switch ($command) {
    case 'help':
        helpCommand();
        break;

    case 'about':
        aboutCommand();
        break;

    case 'skills':
        skillsCommand();
        break;

    case 'contact':
        contactCommand();
        break;

    case 'clear':
        clearCommand();
        break;

    default:
        echo "Command `" . $command . "` not found. Type 'help' for a list of available commands.";
        return false;
    }
    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $command = $_POST['command'] ?? '';

    runCommand($command);
}

?>
