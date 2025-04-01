document.addEventListener('DOMContentLoaded', function() {
    const notificationBanner = document.getElementById('notificationBanner');
    const closeButton = document.getElementById('closeButton');

    // Remove alert from URL and show notification
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('alert')) {
        void notificationBanner.offsetWidth;

        notificationBanner.classList.add('show');
        history.replaceState({}, document.title, window.location.pathname);
    }

    // Close notification
    closeButton.addEventListener('click', function() {
        notificationBanner.classList.remove('show');
        notificationBanner.classList.add('hide');

        setTimeout(() => {
            notificationBanner.style.display = 'none';
        }, 400);
    });
});