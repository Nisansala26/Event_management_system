const searchInput = document.getElementById("searchInput");
const resultsContainer = document.getElementById("searchResults");

searchInput.addEventListener("keyup", function () {
  const query = this.value.trim();

  if (query === "") {
    resultsContainer.innerHTML = "";
    return;
  }

  // Use relative path from home.html to PHP
  fetch(`../search_events.php?q=${encodeURIComponent(query)}`)
    .then(res => res.text())
    .then(data => {
      resultsContainer.innerHTML = data;
    })
    .catch(err => {
      console.error("Error fetching events:", err);
      resultsContainer.innerHTML = "<p>Error loading results</p>";
    });
});
