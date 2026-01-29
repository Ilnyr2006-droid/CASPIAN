(function () {
  // Helpers shared across dynamic pages
  window.Caspian = window.Caspian || {};

  // Change this if you ever update WhatsApp number
  Caspian.WA_NUMBER = '995598918484';

  Caspian.getLang = function () {
    return localStorage.getItem('caspian_lang') || 'ru';
  };

  Caspian.pick = function (obj, lang, fallbackLang) {
    if (!obj || typeof obj !== 'object') return '';
    return obj[lang] || obj[fallbackLang || 'ru'] || '';
  };

  Caspian.t = function (key, fallback) {
    const lang = Caspian.getLang();
    const dict = window.translations;
    if (dict && dict[lang] && dict[lang][key]) return dict[lang][key];
    if (dict && dict.ru && dict.ru[key]) return dict.ru[key];
    return fallback || '';
  };

  Caspian.waLink = function (message) {
    const text = encodeURIComponent(message || '');
    return `https://wa.me/${Caspian.WA_NUMBER}?text=${text}`;
  };

  Caspian.onLangChange = function (handler) {
    document.addEventListener('caspian_lang_changed', (e) => {
      handler((e && e.detail && e.detail.lang) || Caspian.getLang());
    });
  };
})();
