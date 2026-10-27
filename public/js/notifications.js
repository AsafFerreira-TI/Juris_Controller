document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.app-toast[data-autoclose]').forEach(function (toast) {
        const delay = Number(toast.dataset.autoclose || 5000);
        window.setTimeout(function () {
            if (!toast.isConnected) return;
            toast.style.transition = 'opacity .25s ease, transform .25s ease';
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(12px)';
            window.setTimeout(function () { toast.remove(); }, 260);
        }, delay);
    });
});
