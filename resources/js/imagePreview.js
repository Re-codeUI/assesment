// imagePreview.js
// Menampilkan preview gambar
function previewImage(event, previewId) {
    const file = event.target.files[0];
    const imgElement = document.getElementById(previewId);

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            imgElement.src = e.target.result;
            imgElement.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        imgElement.style.display = 'none';
    }
}
window.previewImage = previewImage;
