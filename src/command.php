<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $command = $_POST['command'] ?? '';

    switch ($command) {
        case 'help':
            echo "Available commands:<br>- about<br>- skills<br>- contact<br>- clear";
            break;

        case 'about':
            echo "I am a web developer passionate about creating interactive and user-friendly websites.";
            break;

        case 'skills':
            echo "Skills:<br>- PHP<br>- JavaScript<br>- React<br>- HTML/CSS<br>- SQL";
            break;

        case 'contact':
            echo "Email: example@domain.com<br>GitHub: github.com/username";
            break;

        case 'clear':
            echo '<script>document.getElementById("terminal").innerHTML = "";</script>';
            break;

        default:
            echo "Command not found. Type 'help' for a list of available commands.";
            break;
    }
}
?>
