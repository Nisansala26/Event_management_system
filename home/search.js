document.getElementById("searchInput").addEventListener("keyup", function () {
  const query = this.value.trim();

  // if the box is empty, clear results
  if (query === "") {
    document.getElementById("searchResults").innerHTML = "";
    return;
  }

  // send search request to PHP file
  fetch(`search_events.php?q=${encodeURIComponent(query)}`)
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("searchResults").innerHTML = data;
    })
    .catch((error) => console.error("Error:", error));
});
