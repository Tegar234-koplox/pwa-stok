(() => {
    const body = document.body;

    document.querySelectorAll('[data-sidebar-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            body.classList.toggle('sidebar-open');
        });
    });

    const tanggalElement = document.getElementById('tanggalHari');
    if (tanggalElement) {
        const hariIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const now = new Date();
        tanggalElement.textContent = `${hariIndo[now.getDay()]}, ${String(now.getDate()).padStart(2, '0')} ${bulanIndo[now.getMonth()]} ${now.getFullYear()}`;
    }

    document.querySelectorAll('[data-stock-form]').forEach((form) => {
        const actionField = form.querySelector('[data-action-field]');
        const saveButton = form.querySelector('[data-save-button]');
        const buttons = form.querySelectorAll('[data-action]');

        buttons.forEach((button) => {
            button.addEventListener('click', () => {
                buttons.forEach((item) => item.classList.remove('selected'));
                button.classList.add('selected');
                actionField.value = button.dataset.action;
                saveButton.disabled = false;
            });
        });
    });

    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/service-worker.js').catch(() => {});
        });
    }
})();
