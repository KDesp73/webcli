const form = document.getElementById('command-form');
const commandInput = document.getElementById('command');
const terminal = document.getElementById('terminal');

async function parseJson(url) {
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error reading JSON file:', error);
    }
}

let config = null;

async function init() {
    config = await parseJson("config.json");
    if (!config) {
        console.error("Failed to load config.json");
        return;
    }

    const prompt = document.getElementById('prompt');
    const welcome = document.getElementById('welcome');
    
    if (welcome && config.welcome) {
        welcome.innerHTML += config.welcome;
    }
    if (prompt && config.prompt) {
        prompt.innerHTML += config.prompt;
    }
}

init();

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const command = commandInput.value.trim();
    
    commandInput.disabled = true;
    
    terminal.removeChild(form);
    terminal.innerHTML += `<div class="output">${config.prompt}  ${command}</div>`;
    commandInput.value = '';
    
    try {
        const response = await fetch('/php/command.php', {
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

function clear() {
    console.log("Clear");
    window.location.reload();
}
