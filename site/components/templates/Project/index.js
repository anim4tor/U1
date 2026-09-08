document.addEventListener('DOMContentLoaded', () => {
  const passwordForm = document.getElementById('password-form');
  if (!passwordForm) return; // Exit if already unlocked

  const passwordField = document.getElementById('password-field');

  // Trigger the browser password prompt and submit
  function triggerPrompt() {
    const password = prompt("Authorized access only. Enter credentials:");
    if (password) {
      passwordField.value = password;
      passwordForm.submit();
    }
  }

  // --- INTERACTION 1: The Silent Typist (Keyboard) ---
  // Users type 'secret' anywhere on the page to trigger the prompt
  const secretCode = 'secret'; // Change this to any word you want
  let inputBuffer = '';

  document.addEventListener('keydown', (e) => {
    // Only track single-character letters/numbers to avoid clutter
    if (e.key.length === 1) {
      inputBuffer += e.key.toLowerCase();
      // Keep buffer only as long as the secret code length
      inputBuffer = inputBuffer.slice(-secretCode.length);

      if (inputBuffer === secretCode) {
        inputBuffer = ''; // Reset
        triggerPrompt();
      }
    }
  });

  // --- INTERACTION 2: The Triple-Tap (Mobile/Desktop) ---
  // Triple-tapping/clicking the '.secret-door' element triggers the prompt
  const secretDoor = document.querySelector('.secret-door');
  if (secretDoor) {
    let clickCount = 0;
    let clickTimer;

    secretDoor.addEventListener('click', () => {
      clickCount++;
      
      // Reset count if they take too long between clicks (e.g., > 800ms)
      clearTimeout(clickTimer);
      clickTimer = setTimeout(() => {
        clickCount = 0;
      }, 800);

      if (clickCount === 3) {
        clickCount = 0;
        triggerPrompt();
      }
    });
    
    // Optional: Make sure it doesn't show a pointer cursor 
    // so it looks like entirely un-clickable flat text
    secretDoor.style.cursor = 'default';
  }
});