document.addEventListener('DOMContentLoaded', () => {
    const contactForm = document.getElementById('contactForm');

    if (contactForm) {
        contactForm.addEventListener('submit', function(event) {
            // Prevent the default form submission (page reload)
            event.preventDefault();

            // Simple data collection
            const formData = {
                firstName: this.elements.firstName.value,
                lastName: this.elements.lastName.value,
                email: this.elements.email.value,
                phoneNumber: this.elements.phoneNumber.value,
                subject: this.elements.subject.value,
                message: this.elements.message.value
            };

            // Log data to console for demonstration
            console.log('Form Submitted!', formData);

            // You would typically send this data to a server here (e.g., using fetch or XMLHttpRequest)
            // Example of a successful feedback (you'd replace this with real server feedback)
            const submitButton = this.querySelector('.send-message-btn');
            submitButton.textContent = 'Message Sent! ✅';
            submitButton.style.backgroundColor = '#4CAF50'; // Green color
            
            // Optionally, reset the form after a short delay
            setTimeout(() => {
                contactForm.reset();
                submitButton.textContent = 'Send Message';
                submitButton.style.backgroundColor = 'var(--light-pink)';
            }, 3000);
        });
    }

    // Optional: Add focus class to input groups for subtle styling (not strictly in the image)
    document.querySelectorAll('.input-group input, .message-area textarea').forEach(input => {
        input.addEventListener('focus', () => {
            input.closest('.input-group, .message-area').classList.add('focused');
        });
        input.addEventListener('blur', () => {
            input.closest('.input-group, .message-area').classList.remove('focused');
        });
    });
});