// Функция, которая обходит весь сайт и меняет слова
function updateText(lang) {
    // Проверяем, существует ли выбранный язык в словаре
    if (!translations[lang]) return;

    document.querySelectorAll("[data-i18n]").forEach(el => {
        const key = el.getAttribute("data-i18n");
        const translation = translations[lang][key];
        
        if (translation) {
            // Используем innerHTML, чтобы работали теги <strong> или 📍
            el.innerHTML = translation; 
        }
    });
}

// Функция, которая запускается при нажатии на кнопки RU, GE, AZ, EN
function changeLanguage(lang) {
    localStorage.setItem("caspian_lang", lang); // Запоминаем выбор
    updateText(lang); // Обновляем текст мгновенно

    // Сообщаем динамическим блокам (товары/новости/проекты), что язык поменялся
    document.dispatchEvent(new CustomEvent('caspian_lang_changed', { detail: { lang } }));
}

// При загрузке страницы проверяем, какой язык был выбран ранее
document.addEventListener("DOMContentLoaded", () => {
    const savedLang = localStorage.getItem("caspian_lang") || "ru";
    updateText(savedLang);
});