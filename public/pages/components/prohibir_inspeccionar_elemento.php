<script>
  $(document).ready(function() {
    // Bloquear clic derecho
    $(document).on("contextmenu", function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Acceso bloqueado',
        text: 'No se permite inspeccionar el contenido.',
        icon: 'warning',
        confirmButtonText: 'Entendido'
      });
    });

    // Bloquear teclas F12, Ctrl+Shift+I, Ctrl+U
    $(document).on("keydown", function(e) {
      if (
        e.keyCode === 123 || // F12
        (e.ctrlKey && e.shiftKey && e.keyCode === 73) || // Ctrl+Shift+I
        (e.ctrlKey && e.keyCode === 85) // Ctrl+U
      ) {
        e.preventDefault();
        Swal.fire({
          title: 'Acceso bloqueado',
          text: 'No se permite inspeccionar el contenido.',
          icon: 'warning',
          confirmButtonText: 'Entendido'
        });
      }
    });
  });
</script>