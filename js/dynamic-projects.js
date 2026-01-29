(function () {
  const grid = document.getElementById('projects-grid');
  const empty = document.getElementById('projects-empty');
  if (!grid) return;

  let cache = null;

  function render(items, lang) {
    grid.innerHTML = '';

    if (!items.length) {
      if (empty) empty.style.display = '';
      return;
    }

    if (empty) empty.style.display = 'none';

    items
      .slice()
      .sort((a, b) => String(b.date || '').localeCompare(String(a.date || '')))
      .forEach(p => {
        const title = Caspian.pick(p.title, lang, 'ru');
        const desc = Caspian.pick(p.description || p.short, lang, 'ru');
        const card = document.createElement('article');
        card.className = 'project-card';
        card.innerHTML = `
          <div class="project-card__img">
            ${p.image ? `<img src="${p.image}" alt="${title}">` : ''}
          </div>
          <div class="project-card__body">
            <h3 class="project-card__title">${title}</h3>
            <p class="project-card__text">${desc}</p>
          </div>
        `;
        grid.appendChild(card);
      });
  }

  async function loadAndRender() {
    try {
      const res = await fetch('data/projects.json', { cache: 'no-store' });
      const data = await res.json();
      const items = Array.isArray(data) ? data : (data.projects || data.items || []);
      cache = Array.isArray(items) ? items : [];
      render(cache, Caspian.getLang());
    } catch (e) {
      console.error(e);
      if (empty) empty.style.display = '';
    }
  }

  document.addEventListener('DOMContentLoaded', loadAndRender);

  Caspian.onLangChange((lang) => {
    if (cache) render(cache, lang);
  });
})();
