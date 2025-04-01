document.addEventListener('DOMContentLoaded', function() {
    const notificationBanner = document.getElementById('notificationBanner');
    const closeButton = document.getElementById('closeButton');

    // Remove the alert parameter from the URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('alert')) {
        notificationBanner.style.display = 'flex';
        history.replaceState({}, document.title, window.location.pathname);
    }

    // Close the notification banner
    closeButton.addEventListener('click', function() {
        notificationBanner.style.display = 'none';
    });
});