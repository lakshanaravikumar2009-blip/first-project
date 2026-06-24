let currentIndex = 0;
const images = document.querySelectorAll('.hero-bg');
const dots = document.querySelectorAll('.dot');
const totalImages = images.length;

function showNextImage() {
    // 1. Remove 'active' class from current image and dot
    images[currentIndex].classList.remove('active');
    dots[currentIndex].classList.remove('active-dot');

    // 2. Update index (loop back to 0 if at the end)
    currentIndex = (currentIndex + 1) % totalImages;

    // 3. Add 'active' class to the new image and dot
    images[currentIndex].classList.add('active');
    dots[currentIndex].classList.add('active-dot');
}

// 4. Change image every 5 seconds (5000ms)
setInterval(showNextImage, 5000);


