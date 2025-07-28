

async function getAddressFromLatLng(latitude, longitude) {
    const apiUrl = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`;

    try {
        const response = await fetch(apiUrl);
        const data = await response.json();

        if (data.display_name) {
            // Extract the formatted address
            const address = data.display_name;
            return address;
        } else {
            throw new Error('Reverse geocoding failed');
        }
    } catch (error) {
        console.error('Error fetching address:', error.message);
        return null;
    }
}


async function updateRiderLocation(latitude, longitude) {
    const address = await getAddressFromLatLng(latitude, longitude);

    const element = document.getElementById('riderLocation');
    console.log(element)

    if (element) {
        element.textContent = address || '--';
    }
}