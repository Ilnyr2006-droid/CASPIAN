(function () {
  const grid = document.getElementById('products-grid');
  const empty = document.getElementById('products-empty');
  if (!grid) return;

  let productsCache = null;

  function getCategoryFromUrl() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('cat');
  }

  function render(products, lang) {
    const category = getCategoryFromUrl();
    const filtered = category ? products.filter(p => p.category === category) : products;
    const ordered = filtered.slice().sort((a, b) => (Number(a.sort ?? 9999) - Number(b.sort ?? 9999)));

    grid.innerHTML = '';

    if (!ordered.length) {
      if (empty) empty.style.display = '';
      return;
    }

    if (empty) empty.style.display = 'none';

    ordered.forEach(p => {
      const title = Caspian.pick(p.title, lang, 'ru');
      const short = Caspian.pick(p.short, lang, 'ru');
      const categoryLabel = p.category || '';
      const unit = p.unit || '';
      const priceText = (p.price && p.price !== 'по запросу') ? `${p.price} ${unit}` : Caspian.t('request_price', 'Запросить цену');

      const waMsg = `Здравствуйте! Интересует товар: ${title}. Категория: ${categoryLabel}.`;

      const card = document.createElement('article');
      card.className = 'product-card';
      card.innerHTML = `
        <div class="product-card__img">
          <img src="${p.image || ''}" alt="${title}">
        </div>
        <div class="product-card__body">
          <div class="product-card__meta">${categoryLabel}</div>
          <h3 class="product-card__title">${title}</h3>
          <p class="product-card__text">${short}</p>
          <div class="product-card__actions">
            <a class="btn-red" href="${Caspian.waLink(waMsg)}" target="_blank" rel="noopener">${priceText}</a>
          </div>
        </div>
      `;
      grid.appendChild(card);
    });
  }

  async function loadAndRender() {
    try {
      const res = await fetch('data/products.json', { cache: 'no-store' });
      const data = await res.json();
      const items = Array.isArray(data) ? data : (data.products || data.items || []);
      productsCache = Array.isArray(items) ? items : [];
      render(productsCache, Caspian.getLang());
    } catch (e) {
      console.error(e);
      if (empty) {
        empty.style.display = '';
        empty.querySelector('p') && (empty.querySelector('p').textContent = 'Не удалось загрузить товары.');
      }
    }
  }

  document.addEventListener('DOMContentLoaded', loadAndRender);

  Caspian.onLangChange((lang) => {
    if (productsCache) render(productsCache, lang);
  });
})();
