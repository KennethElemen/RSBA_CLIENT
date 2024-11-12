document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll('.checkbox-wrapper input[type="checkbox"]');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const specifyInput = this.closest('.checkbox-wrapper').querySelector('.specify-input');
            if (this.checked) {
                specifyInput.style.display = 'block'; // Show input if checked
            } else {
                specifyInput.style.display = 'none'; // Hide input if unchecked
            }
        });
    });
});

const regionUrl = 'https://psgc.cloud/api/regions';
const provinceSelect = document.getElementById('province');
const regionSelect = document.getElementById('region');
const citySelect = document.getElementById('city');
const barangaySelect = document.getElementById('barangay');

// Function to show loading indicator
function showLoadingIndicator() {
    const loadingIndicator = document.createElement('div');
    loadingIndicator.textContent = 'Loading...';
    loadingIndicator.id = 'loadingIndicator';
    document.body.appendChild(loadingIndicator);
}

// Function to hide loading indicator
function hideLoadingIndicator() {
    const loadingIndicator = document.getElementById('loadingIndicator');
    if (loadingIndicator) loadingIndicator.remove();
}

// Fetch regions on page load
fetch(regionUrl)
    .then(response => {
        showLoadingIndicator();
        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
        return response.json();
    })
    .then(data => {
        hideLoadingIndicator();
        data.forEach(region => {
            const option = document.createElement('option');
            option.value = region.name; // Set the value to the region name
            option.textContent = region.name; // Display the region name
            regionSelect.appendChild(option);
        });
    })
    .catch(error => {
        hideLoadingIndicator();
        console.error('Error fetching regions:', error);
    });

// Fetch provinces when a region is selected
regionSelect.addEventListener('change', function() {
    const selectedRegion = this.value;
    provinceSelect.innerHTML = '<option value="">PROVINCE</option>';
    citySelect.innerHTML = '<option value="">CITY/MUNICIPALITY</option>';
    barangaySelect.innerHTML = '<option value="">BARANGAY</option>'; // Clear barangay dropdown

    if (selectedRegion) {
        const provinceUrl = `https://psgc.cloud/api/regions/${selectedRegion}/provinces`;

        fetch(provinceUrl)
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                data.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.name; // Set the value to the province name
                    option.textContent = province.name; // Display the province name
                    provinceSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching provinces:', error));
    }
});

// Fetch cities and municipalities when a province is selected
provinceSelect.addEventListener('change', function() {
    const selectedProvince = this.value;
    citySelect.innerHTML = '<option value="">CITY/MUNICIPALITY</option>';
    barangaySelect.innerHTML = '<option value="">BARANGAY</option>'; // Clear barangay dropdown

    if (selectedProvince) {
        const citiesUrl = `https://psgc.cloud/api/provinces/${selectedProvince}/cities-municipalities`;

        fetch(citiesUrl)
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                data.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.name; // Set the value to the city name
                    option.textContent = city.name; // Display the city name
                    citySelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching cities:', error));
    }
});

// Fetch barangays when a city/municipality is selected
citySelect.addEventListener('change', function() {
    const selectedCity = this.value;
    barangaySelect.innerHTML = '<option value="">BARANGAY</option>'; // Clear barangay dropdown

    if (selectedCity) {
        const barangayUrl = `https://psgc.cloud/api/cities-municipalities/${selectedCity}/barangays`;

        fetch(barangayUrl)
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                data.forEach(barangay => {
                    const option = document.createElement('option');
                    option.value = barangay.name; // Set the value to the barangay name
                    option.textContent = barangay.name; // Display the barangay name
                    barangaySelect.appendChild(option);
                });

                // If no barangays are found, display a message
                if (data.length === 0) {
                    const option = document.createElement('option');
                    option.textContent = "No barangays available";
                    barangaySelect.appendChild(option);
                }
            })
            .catch(error => console.error('Error fetching barangays:', error));
    }
});

