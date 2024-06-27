function showDeleteConfirmation(action, confirmationText, idForm) {
   Swal.fire({
       title: 'Konfirmasi',
       text: confirmationText,
       icon: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#5c6ef4',
       confirmButtonText: action,
       cancelButtonText: 'Batal',
       cancelButtonColor: '#f44336',
   }).then((result) => {
       if (result.isConfirmed) {
           document.getElementById(idForm).submit();
       }
   });
}

// Atur Gambar Preview
function previewImage(event) {
    var file = event.target.files[0];
    console.log(file)
    if (!file) {
        return; // No file selected
    }

    var fileType = file.type;
    var isValidFileType = fileType.includes('image');
    
    if (!isValidFileType) {
        // Show SweetAlert if file is not an image
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Harap pilih file berupa gambar',
            onClose: function() {
                resetFileInput();
            }
        });
        return;
    }

    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('preview-photo');
        output.src = reader.result;
    }
    reader.readAsDataURL(file);

    // Update file label with selected file name
    var fileName = file.name;
    var label = document.querySelector('.custom-file-label');
    label.textContent = fileName;
}

// Reset file input to clear previous selection
function resetFileInput() {
    var input = document.getElementById('profile-logo');
    input.value = ''; // Reset input value
    var label = input.nextElementSibling;
    label.textContent = 'Choose File'; // Reset label text
    var preview = document.getElementById('preview-photo');
    preview.src = "{{ asset('assets/img/news/img01.jpg') }}"; // Reset preview image
}

// Capture file input change
document.getElementById('profile-logo').addEventListener('change', function() {
    previewImage(event);
});
