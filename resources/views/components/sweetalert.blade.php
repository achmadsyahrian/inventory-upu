@if (session()->has('error'))
<script>
   Swal.fire({
      icon: 'error', 
      title: 'Gagal!', 
      text: "{{ session('error') }}", 
      showConfirmButton: true, 
      // timer: 3000
   });

</script>
@elseif (session()->has('success'))
<script>
   Swal.fire({
      icon: 'success', 
      title: 'Berhasil!', 
      text: "{{ session('success') }}", 
      showConfirmButton: true, 
      // timer: 3000
   });

</script>
@endif
