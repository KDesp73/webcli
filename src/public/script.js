const form = document.getElementById('command-form');
const commandInput = document.getElementById('command');
const terminal = document.getElementById('terminal');
const welcome = document.getElementById('welcome');

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
  const welcomeMessage = document.getElementById('welcome-message');

  if (welcomeMessage && config.welcome) {
    welcomeMessage.innerHTML += config.welcome;
  }
  if (prompt && config.prompt) {
    prompt.innerHTML += config.prompt;
  }
}

init();

function executeCommand(command) {
  const tokens = command.split(" ");
  switch(tokens[0]) {
    case "clear":
      terminal.innerHTML = "";
      break;
    case "welcome": {
      terminal.innerHTML = "";
      terminal.appendChild(welcome);
      break;
    }
    default:
      return false;
  }
  return true;
}

form.addEventListener('submit', async (e) => {
  e.preventDefault();
  const command = commandInput.value.trim();

  commandInput.disabled = true;

  terminal.removeChild(form);
  terminal.innerHTML += `<div class="output"><span id="prompt">${config.prompt}</span>  ${command}</div>`;
  commandInput.value = '';

  if(!executeCommand(command)){
    try {
      const response = await fetch('/php/commands.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `command=${encodeURIComponent(command)}`
      });
      const body = await response.json();
      const stdout = body.stdout || '';

      terminal.innerHTML += `<div class="output">${stdout}</div>`;
    } catch (_error) {
      terminal.innerHTML += `<div class="output">Error: Unable to process the command.</div>`;
    }
  }

  terminal.scrollTop = terminal.scrollHeight;
  terminal.appendChild(form);

  commandInput.disabled = false;
  commandInput.focus();
});
