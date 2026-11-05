(function () {
    'use strict';
    if (window.fabPluginLoaded) return;
    window.fabPluginLoaded = true;
    function mount() {
        var config = document.querySelector('.floatingactionbutton-config');
        if (!config) return;
        var data;
        try { data = JSON.parse(config.textContent); } catch (e) { return; }
        if (!data.text || !data.href) return;
        function path(url) {
            var p = url.pathname;
            try { p = decodeURI(p); } catch (e) {}
            return p.replace(/\/+$/, '') || '/';
        }
        try {
            var target = new URL(data.href, document.baseURI);
            var current = new URL(window.location.href);
            if (/^https?:$/.test(target.protocol) && target.origin === current.origin && path(target) === path(current)) return;
        } catch (e) { return; }
        var root = document.createElement('div');
        root.id = 'floatingactionbutton-root';
        root.className = 'fab-plugin-wrap';
        root.hidden = true;
        root.setAttribute('role', 'complementary');
        root.setAttribute('aria-label', 'Call to action');
        var button = document.createElement('a');
        button.className = 'fab-plugin-button';
        button.href = data.href;
        // Decorative local vectors; no external icon or font dependency.
        var mouse = '<rect x="7" y="2" width="14" height="23" rx="7"/><path d="M14 2v8m0-4v2M3 5l-2-2m2 9H0m23-7 2-2"/>';
        var finger = '<path d="M10 17V5a2 2 0 0 1 4 0v9-3a2 2 0 0 1 4 0v3-1a2 2 0 0 1 4 0v2a2 2 0 0 1 4 0v5c0 5-3 8-7 8h-2c-3 0-4-2-6-4l-5-6a2 2 0 0 1 3-3l3 3M2 8h5M4 5 1 8l3 3"/>';
        function icon(kind, drawing) {
            var span = document.createElement('span');
            span.className = 'fab-icon fab-icon-' + kind;
            span.setAttribute('aria-hidden', 'true');
            span.innerHTML = '<svg viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' + drawing + '</svg>';
            return span;
        }
        button.appendChild(icon('mouse', mouse));
        button.appendChild(icon('finger', finger));
        var label = document.createElement('span');
        label.className = 'fab-label';
        label.textContent = data.text;
        button.appendChild(label);
        root.appendChild(button);
        document.body.appendChild(root);
        var media = window.matchMedia('(max-width:700px)');
        function update() {
            var threshold = Number(media.matches ? data.mobileScroll : data.desktopScroll);
            if (!Number.isFinite(threshold)) threshold = media.matches ? 40 : 30;
            threshold = Math.max(0, Math.min(100, threshold));
            var available = Math.max(0, document.documentElement.scrollHeight - window.innerHeight);
            var progress = available > 0 ? Math.max(0, window.scrollY) / available * 100 : 0;
            root.hidden = progress + 0.01 < threshold;
        }
        var queued = false;
        function schedule() {
            if (queued) return;
            queued = true;
            window.requestAnimationFrame(function () { queued = false; update(); });
        }
        window.addEventListener('scroll', schedule, {passive:true});
        window.addEventListener('resize', schedule);
        window.addEventListener('load', schedule);
        if (window.ResizeObserver) new ResizeObserver(schedule).observe(document.body);
        update();
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', mount, {once:true});
    else mount();
}());
