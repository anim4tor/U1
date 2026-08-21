document.addEventListener('DOMContentLoaded', () => {
  const dropdowns = document.querySelectorAll('.custom-dropdown');

  dropdowns.forEach(dropdown => {
    const toggle = dropdown.querySelector('.dropdown-toggle');
    const menu = dropdown.querySelector('.dropdown-menu');
    const selectedText = dropdown.querySelector('.dropdown-selected-text');
    const items = dropdown.querySelectorAll('.dropdown-menu li');

    // Toggle dropdown visibility
    toggle.addEventListener('click', () => {
      const expanded = toggle.getAttribute('aria-expanded') === 'true';
      toggle.setAttribute('aria-expanded', !expanded);
      menu.classList.toggle('is-open');
    });

    // Handle option selection
    items.forEach(item => {
      item.addEventListener('click', () => {
        selectedText.textContent = item.textContent;
        toggle.setAttribute('aria-expanded', 'false');
        menu.classList.remove('is-open');

        // Access the custom data value
        const value = item.dataset.value;
        console.log('Selected value:', value);
      });
    });

    // Close dropdown when clicking outside
    window.addEventListener('click', e => {
      if (!dropdown.contains(e.target)) {
        toggle.setAttribute('aria-expanded', 'false');
        menu.classList.remove('is-open');
      }
    });
  });
});