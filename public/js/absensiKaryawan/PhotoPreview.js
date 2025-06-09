document.getElementById('foto').addEventListener('change', function(event) {
    const previewContainer = document.getElementById('preview-container');
    previewContainer.innerHTML = '';
    const file = event.target.files[0];
    if (file && (file.type === 'image/jpeg' || file.type === 'image/jpg')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'Preview Foto';
            img.style.maxWidth = '100%';
            img.style.maxHeight = '200px';
            img.className = "img-thumbnail mt-2";
            previewContainer.appendChild(img);
        };
        reader.readAsDataURL(file);
    }
});