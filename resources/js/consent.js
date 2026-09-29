const STORAGE_KEY = 'certitest_consent_v1';

const banner = () => document.getElementById('certitest-consent');

const get = () => {
    try {
        const value = localStorage.getItem(STORAGE_KEY);

        return value === null ? null : JSON.parse(value);
    } catch {
        return null;
    }
};

const hideBanner = () => {
    banner()?.classList.add('hidden');
};

const showBanner = () => {
    banner()?.classList.remove('hidden');
};

const injectAnalytics = (gaId) => {
    if (document.getElementById('ga-gtag') !== null) {
        return;
    }

    const script = document.createElement('script');
    script.id = 'ga-gtag';
    script.async = true;
    script.src = `https://www.googletagmanager.com/gtag/js?id=${encodeURIComponent(gaId)}`;
    document.head.appendChild(script);

    window.dataLayer = window.dataLayer || [];
    window.gtag = function () {
        window.dataLayer.push(arguments);
    };
    window.gtag('js', new Date());
    window.gtag('config', gaId);
};

const injectAds = (client) => {
    if (document.getElementById('adsense-auto-ads') !== null) {
        return;
    }

    const script = document.createElement('script');
    script.id = 'adsense-auto-ads';
    script.async = true;
    script.crossOrigin = 'anonymous';
    script.src = `https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=${encodeURIComponent(client)}`;
    document.head.appendChild(script);
};

const apply = (consent) => {
    const el = banner();
    if (el === null) {
        return;
    }

    if (consent.analytics === true && el.dataset.gaId) {
        injectAnalytics(el.dataset.gaId);
    }

    if (consent.ads === true && el.dataset.adsenseClient) {
        injectAds(el.dataset.adsenseClient);
    }
};

const set = (consent) => {
    const value = {
        analytics: consent.analytics === true,
        ads: consent.ads === true,
        at: new Date().toISOString(),
    };

    localStorage.setItem(STORAGE_KEY, JSON.stringify(value));
    apply(value);
    hideBanner();
    window.dispatchEvent(new CustomEvent('certitest:consent-changed', { detail: value }));
};

const reset = () => {
    localStorage.removeItem(STORAGE_KEY);
    showBanner();
};

window.CertiConsent = { get, set, reset };

document.addEventListener('click', (event) => {
    const action = event.target.closest('[data-consent]');

    if (action !== null) {
        set({ analytics: action.dataset.consent === 'accept', ads: action.dataset.consent === 'accept' });

        return;
    }

    if (event.target.closest('[data-consent-reset]') !== null) {
        event.preventDefault();
        reset();
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const consent = get();

    if (consent === null) {
        showBanner();
    } else {
        apply(consent);
    }
});
