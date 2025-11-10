document.addEventListener('DOMContentLoaded', () => {
    // Simple handler for the Book Event button (if you need a quick action)
    const bookButton = document.querySelector('.book-btn');
    const learnButton = document.querySelector('.learn-btn');
    const searchButton = document.querySelector('.search-btn');

    if (bookButton) {
        bookButton.addEventListener('click', () => {
            
        });
    }

    if (learnButton) {
        learnButton.addEventListener('click', () => {
            // Smoothly scroll down to the "More Details" section
            const detailsSection = document.querySelector('.more-details-section');
            if (detailsSection) {
                detailsSection.scrollIntoView({ behavior: 'smooth' });
            }
        });
    }
    
    if (searchButton) {
        searchButton.addEventListener('click', () => {
            const query = document.querySelector('.search-input').value;
            if (query) {
                alert(`Searching for: ${query}`);
                // In a real application, you would send this to a search results page:
                // window.location.href = `/search?q=${encodeURIComponent(query)}`;
            }
        });
    }
});