document.addEventListener('DOMContentLoaded', () => {
    // 1. Sidebar Highlight Function
    const serviceItems = document.querySelectorAll('.services-list li');
    
    serviceItems.forEach(item => {
        item.addEventListener('click', function() {
            // Remove 'active' class from all items
            serviceItems.forEach(li => li.classList.remove('active'));
            // Add 'active' class to the clicked item
            this.classList.add('active');
        });
    });

    // 2. Form Reservation Function
    const reservationForm = document.querySelector('.event-form');
    
    if(reservationForm) {
        reservationForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevents page reload
            
            // Collect form data
            const formData = {
                name: this.querySelector('input[placeholder="Name"]').value,
                email: this.querySelector('input[placeholder="Email"]').value,
                location: this.querySelector('input[placeholder="Location"]').value,
                phone: this.querySelector('input[placeholder="Phone Number"]').value,
                eventType: this.querySelector('.event-dropdown').value,
                budget: this.querySelector('input[placeholder="Budget"]').value,
                message: this.querySelector('textarea').value
            };

            console.log("Reservation Request Sent:", formData);
            alert("Thank you! Our event organizing team will get back to you shortly.");
            this.reset(); // Clears form after submission
        });
    }
});