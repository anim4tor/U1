function initDropdowns() {
  if (window._dropdownDelegationInit) return;
  window._dropdownDelegationInit = true;

  document.addEventListener('click', (e) => {
    // 1. Toggle button clicked
    const toggle = e.target.closest('.custom-dropdown .dropdown-toggle');
    if (toggle) {
      e.preventDefault();
      e.stopPropagation();
      const dropdown = toggle.closest('.custom-dropdown');
      const menu = dropdown?.querySelector('.dropdown-menu');
      if (!menu) return;

      const isCurrentlyOpen = menu.classList.contains('is-open');

      // Close all OTHER dropdowns
      document.querySelectorAll('.custom-dropdown .dropdown-menu.is-open').forEach(otherMenu => {
        if (otherMenu !== menu) {
          otherMenu.classList.remove('is-open');
          otherMenu.closest('.custom-dropdown')?.querySelector('.dropdown-toggle')?.setAttribute('aria-expanded', 'false');
        }
      });

      menu.classList.toggle('is-open', !isCurrentlyOpen);
      toggle.setAttribute('aria-expanded', !isCurrentlyOpen ? 'true' : 'false');
      return;
    }

    // 2. Click outside all dropdowns -> close them
    if (!e.target.closest('.custom-dropdown')) {
      document.querySelectorAll('.custom-dropdown .dropdown-menu.is-open').forEach(menu => {
        menu.classList.remove('is-open');
        menu.closest('.custom-dropdown')?.querySelector('.dropdown-toggle')?.setAttribute('aria-expanded', 'false');
      });
    }
  });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initDropdowns);
} else {
  initDropdowns();
}
