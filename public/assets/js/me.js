// Format Harga
document.getElementById('price-input').addEventListener('input', function (e) {
    let value = e.target.value.replace(/[^,\d]/g, '').toString();
    let split = value.split(',');
    let remainder = split[0].length % 3;
    let rupiah = split[0].substr(0, remainder);
    let thousand = split[0].substr(remainder).match(/\d{3}/gi);

    if (thousand) {
        let separator = remainder ? '.' : '';
        rupiah += separator + thousand.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    e.target.value = rupiah;
});


// Ambil Inventory Item
$(document).ready(function() {
    $('#division-item-select').on('change', function() {
        var divisionId = $(this).val();
        if (divisionId) {
            $.ajax({
                url: '/inventory-admin/get-division-items/' + divisionId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var $inventorySelect = $('#inventory-item-select2');
                    $inventorySelect.empty();
                    $inventorySelect.append('<option selected disabled>Pilih Barang</option>');
                    $.each(data, function(key, item) {
                        $inventorySelect.append('<option value="'+ item.inventory_item_id +'">'+ item.inventory_item.name +'</option>');
                    });
                }
            });
        }
    });

    $('#inventory-item-select').on('change', function() {
        var itemId = $(this).val();
        if (itemId) {
            $.ajax({
                url: '/get-inventory-item/' + itemId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#item-brand').val(data.brand);
                    $('#item-type').val(data.type);
                    $('#item-unit').val(data.unit);
                    $('#item-condition').val(data.condition);
                    $('#item-stock').val(data.stock);
                    $('#item-description').val(data.description);

                    if (data.photo) {
                      var photoUrl = '/storage/photos/inventory_item/' + data.photo;
                       $('#preview-photo').attr('src', photoUrl);
                   } else {
                      $('#preview-photo').attr('src', "/assets/img/me/empty-photo2.jpg");
                   }

                //    if (data.stock == 0) {
                //         $('#save-button').prop('disabled', true);
                //     } else {
                //         $('#save-button').prop('disabled', false);
                //     }
                }
            });
        }
    });
    
    $('#inventory-item-select2').on('change', function() {
        var itemId = $(this).val();
        if (itemId) {
            var divisionId = $('#division-item-select').val();
            $.ajax({
                url: '/inventory-admin/get-division-inventory-items/' + itemId + '/' + divisionId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#item-brand').val(data.brand);
                    $('#item-type').val(data.type);
                    $('#item-unit').val(data.unit);
                    $('#item-condition').val(data.condition);
                    $('#item-quantity').val(data.quantity);

                    if (data.photo) {
                      var photoUrl = '/storage/photos/inventory_item/' + data.photo;
                       $('#preview-photo').attr('src', photoUrl);
                   } else {
                      $('#preview-photo').attr('src', "/assets/img/me/empty-photo2.jpg");
                   }
                }
            });
        }
    });
});

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

function showApproveConfirmation(action, confirmationText, idForm) {
    Swal.fire({
        title: 'Konfirmasi',
        text: confirmationText,
        icon: 'question',
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
