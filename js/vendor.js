// 1. Your List of Vendors (The "Attachment")
const vendorList = [
    { name: "Elite Catering", service: "Food & Drinks", phone: "+123456789", email: "info@elitecatering.com" },
    { name: "SoundBlast DJ", service: "Music/Audio", phone: "+198765432", email: "dj@soundblast.com" },
    { name: "Bloom Florals", service: "Decor", phone: "+112233445", email: "hello@bloom.com" },
    { name: "ProFocus Photo", service: "Photography", phone: "+155667788", email: "snap@profocus.com" }
];

// 2. Function to display vendors in the dashboard
function loadVendors() {
    const tableBody = document.getElementById('vendorBody');
    tableBody.innerHTML = vendorList.map(vendor => `
        <tr>
            <td><strong>${vendor.name}</strong></td>
            <td>${vendor.service}</td>
            <td>${vendor.phone}</td>
            <td>${vendor.email}</td>
            <td>
                <a href="tel:${vendor.phone}" class="btn call-btn">Call</a>
                <a href="mailto:${vendor.email}" class="btn email-btn">Email</a>
            </td>
        </tr>
    `).join('');
}

// 3. Search Filter Logic
function filterVendors() {
    let input = document.getElementById("vendorSearch").value.toLowerCase();
    let rows = document.querySelectorAll("#vendorBody tr");

    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(input) ? "" : "none";
    });
}

// Initialize on load
window.onload = loadVendors;