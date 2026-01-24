import Vue from 'vue';
import VueI18n from 'vue-i18n';
import api from './api';
import en from './translations/en.json';
import ja from './translations/ja.json';
import vi from './translations/vi.json';

Vue.use(VueI18n);

// Get default locale from server-side config, fallback to 'en'
const defaultLocale = (typeof app !== 'undefined' && app.locale) ? app.locale : 'en';

export const i18n = new VueI18n({
    locale: defaultLocale,
    fallbackLocale: 'en',
    messages: {
        en,
        ja,
        vi,
    },
});

export const availableLanguages = app.languages;

export const loadedLanguages = [defaultLocale];  // Start with configured locale loaded

function setI18nLanguage(lang) {
    i18n.locale = lang;
    api.defaults.headers.common['Accept-Language'] = lang;
    api.defaults.params = {};
    api.defaults.params['lang'] = lang;
    document.querySelector('html').setAttribute('lang', lang);
    return lang;
}

export const loadLanguage = (lang) => {
    if (!loadedLanguages.includes(lang)) {
        return import(/* webpackChunkName: "lang-[request]" */ `./translations/${lang}`).then((msgs) => {
            i18n.setLocaleMessage(lang, msgs);
            loadedLanguages.push(lang);
            return Promise.resolve(setI18nLanguage(lang));
        });
    }
    return Promise.resolve(setI18nLanguage(lang));
};
