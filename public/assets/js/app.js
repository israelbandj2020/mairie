// Menu mobile
document.addEventListener('DOMContentLoaded', function() {
    const body = document.body;
    const burger = document.getElementById('burger');
    const scrim = document.getElementById('scrim');
    const menu = document.getElementById('menu');

    if (burger && scrim) {
        burger.addEventListener('click', function() {
            body.classList.toggle('open');
        });

        scrim.addEventListener('click', function() {
            body.classList.remove('open');
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                body.classList.remove('open');
            }
        });
    }

    // Toast notifications
    window.showToast = function(message) {
        const toast = document.getElementById('toast');
        if (toast) {
            toast.textContent = message;
            toast.classList.add('show');
            setTimeout(function() {
                toast.classList.remove('show');
            }, 2600);
        }
    };

    // Dialogues
    window.openDialog = function(dialogId) {
        const dialog = document.getElementById(dialogId);
        if (dialog) {
            dialog.showModal();
            document.body.style.overflow = 'hidden';
        }
    };

    window.closeDialog = function(dialogId) {
        const dialog = document.getElementById(dialogId);
        if (dialog) {
            dialog.close();
            document.body.style.overflow = '';
        }
    };

    // Fermer les dialogues en cliquant sur le scrim
    document.querySelectorAll('dialog').forEach(dialog => {
        dialog.addEventListener('click', function(e) {
            if (e.target === dialog) {
                dialog.close();
                document.body.style.overflow = '';
            }
        });
    });

    // Onglets
    window.switchTab = function(tabId, contentId) {
        // Désactiver tous les onglets du groupe
        const tabGroup = document.querySelector(`[data-tab-group="${tabId}"]`);
        if (tabGroup) {
            tabGroup.querySelectorAll('[data-tab]').forEach(tab => {
                tab.classList.remove('active');
                tab.setAttribute('aria-selected', 'false');
            });
        }

        // Cacher tous les contenus du groupe
        const contentGroup = document.querySelector(`[data-content-group="${contentId}"]`);
        if (contentGroup) {
            contentGroup.querySelectorAll('[data-content]').forEach(content => {
                content.classList.add('hidden');
            });
        }

        // Activer l'onglet et le contenu sélectionnés
        const activeTab = document.querySelector(`[data-tab="${tabId}"]`);
        const activeContent = document.querySelector(`[data-content="${contentId}"]`);

        if (activeTab) {
            activeTab.classList.add('active');
            activeTab.setAttribute('aria-selected', 'true');
        }

        if (activeContent) {
            activeContent.classList.remove('hidden');
        }
    };
});
