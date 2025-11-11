
console.log("UNI Events page loaded!");

document.addEventListener('DOMContentLoaded', (event) => {
   
    const searchInput = document.getElementById('searchInput');
    const searchIcon = document.getElementById('searchIcon');

    // Check if the elements exist before adding listeners
    if (searchInput && searchIcon) {

        // Function to handle the actual search logic
        function performSearch() {
            const query = searchInput.value.trim(); // Get the value and remove leading/trailing whitespace

            if (query !== '') {
                console.log("Search initiated for: " + query);

                
            } else {
                console.log("Search input is empty.");
            }
        }

        // Add event listener for clicking the search icon
        searchIcon.addEventListener('click', performSearch);

        // Add event listener for pressing the 'Enter' key within the input field
        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
    } else {
        console.error("Error: Search input or icon element not found. Check your HTML IDs.");
    }
});
