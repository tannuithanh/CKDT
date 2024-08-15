import lottie from 'lottie-web';

document.addEventListener("DOMContentLoaded", function() {
    var loadingContainer = document.getElementById('loadingContainer');
    var loadingOverlay = document.getElementById('loadingOverlay');

    if (loadingContainer) {
        var animation = lottie.loadAnimation({
            container: loadingContainer, // Container element ID
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '/assets/js/Animation - 1723176817324.json' // Đảm bảo đường dẫn đúng
        });

        function showLoading() {
            loadingOverlay.style.display = 'block';  // Hiển thị overlay làm mờ
            loadingContainer.style.display = 'block'; // Hiển thị loading animation
        }

        function hideLoading() {
            loadingOverlay.style.display = 'none';   // Ẩn overlay làm mờ
            loadingContainer.style.display = 'none'; // Ẩn loading animation
        }

        window.showLoading = showLoading;
        window.hideLoading = hideLoading;
    }
});
