  function toggleMenu() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }
         function toggleUserMenu() {
            const userMenu = document.getElementById('userMenu');
            userMenu.classList.toggle('active');
        }
        function closeMenu() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.remove('active');

            const userMenu = document.getElementById('userMenu');
            userMenu.classList.remove('active');
        }

 document.addEventListener("DOMContentLoaded", function () {
      const table = document.getElementById("myTable");
      const searchInput = document.getElementById("searchInput");
      const paginationContainer = document.getElementById("pagination");
      let rowsPerPage = 10;
      let currentPage = 1;
      let originalData = Array.from(table.querySelectorAll("tbody tr"));

      searchInput.addEventListener("input", function () {
        filterAndPaginate(this.value.toLowerCase());
      });

      function filterAndPaginate(searchTerm) {
        let filteredData = originalData;

        if (searchTerm.trim() !== "") {
          filteredData = originalData.filter(row => {
            const textContent = row.textContent.toLowerCase();
            return textContent.includes(searchTerm);
          });
        }

        renderTable(filteredData);
        renderPagination(filteredData);
      }

      function renderTable(filteredData) {
        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;

        const tbody = table.querySelector("tbody");
        tbody.innerHTML = "";

        if (filteredData.length === 0) {
          const noDataRow = document.createElement("tr");
          const noDataCell = document.createElement("td");
          noDataCell.colSpan = 3;
          noDataCell.className = "no-data";
          noDataCell.textContent = "Veri bulunamadı";
          noDataRow.appendChild(noDataCell);
          tbody.appendChild(noDataRow);
        } else {
          const visibleData = filteredData.slice(startIndex, endIndex);
          visibleData.forEach(row => {
            tbody.appendChild(row.cloneNode(true));
          });
        }
      }

      function renderPagination(filteredData) {
        paginationContainer.innerHTML = "";

        const totalPages = Math.ceil(filteredData.length / rowsPerPage);

        for (let i = 1; i <= totalPages; i++) {
          const pageButton = document.createElement("button");
          pageButton.textContent = i;
          pageButton.addEventListener("click", function () {
            currentPage = i;
            filterAndPaginate(searchInput.value.toLowerCase());
          });
          paginationContainer.appendChild(pageButton);
        }
      }

      // İlk render işlemi
      filterAndPaginate("");
    });