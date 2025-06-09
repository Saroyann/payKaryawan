window.onload = function() {
    var isSudahAbsenDatang = window.isSudahAbsenDatang || false;

    if (!isSudahAbsenDatang) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    document.getElementById('lokasi').value = position.coords.latitude + ', ' + position.coords.longitude;
                },
                function() {
                    document.getElementById('lokasi').value = 'Gagal mendapatkan lokasi';
                }
            );
        } else {
            document.getElementById('lokasi').value = 'Browser tidak mendukung geolocation';
        }
    }
};