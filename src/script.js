const form = document.getElementById('command-form');
const commandInput = document.getElementById('command');
const terminal = document.getElementById('terminal');

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const command = commandInput.value.trim();
    
    // Disable the input field to prevent further input
    commandInput.disabled = true;
    
    terminal.removeChild(form);
    terminal.innerHTML += `<div class="output">&gt; ${command}</div>`;
    commandInput.value = '';
    
    try {
        const response = await fetch('command.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `command=${encodeURIComponent(command)}`
        });
        const result = await response.text();
        terminal.innerHTML += `<div class="output">${result}</div>`;
    } catch (_error) {
        terminal.innerHTML += `<div class="output">Error: Unable to process the command.</div>`;
    }
    
    terminal.scrollTop = terminal.scrollHeight;
    terminal.appendChild(form);
    
    commandInput.disabled = false;
    commandInput.focus();
});
