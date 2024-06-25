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