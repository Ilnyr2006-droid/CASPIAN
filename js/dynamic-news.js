(function () {
  const list = document.getElementById('news-list');
  const empty = document.getElementById('news-empty');
  if (!list) return;

  let cache = null;

  function formatDate(iso, lang) {
    if (!iso) return '';
    try {
      const d = new Date(iso);
      return d.toLocaleDateString(lang === 'ka' ? 'ka-GE' : lang === 'az' ? 'az-AZ' : lang === 'en' ? 'en-GB' : 'ru-RU', {
        year: 'numeric', month: 'long', day: 'numeric'
      });
    } catch { return iso; }
  }

  function render(items, lang) {
    list.innerHTML = '';
    if (!items.length) {
      if (empty) empty.style.display = '';
      return;
    }
    if (empty) empty.style.display = 'none';

    items
      .slice()
      .sort((a, b) => String(b.date || '').localeCompare(String(a.date || '')))
      .forEach(n => {
        const li = document.createElement('li');
        const title = Caspian.pick(n.title, lang, 'ru');
        const text = Caspian.pick(n.text, lang, 'ru');
        const date = formatDate(n.date, lang);
        li.innerHTML = `<strong>${title}</strong> — ${text}${date ? `<div class="news-date">${date}</div>` : ''}`;
        list.appendChild(li);
      });
  }

  async function loadAndRender() {
    try {
      const res = await fetch('data/news.json', { cache: 'no-store' });
      const data = await res.json();
      const items = Array.isArray(data) ? data : (data.news || data.items || []);
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
