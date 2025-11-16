<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/routing.php'; ?>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Inicializar tooltips de Bootstrap -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));
  });
</script>

<!-- Popper y Bootstrap desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>


<!-- jQuery desde tu carpeta pública -->
<script src="<?php echo PUBLIC_SCRIPTS_URL; ?>jquery.min.js"></script>

<script>
  // Vista previa de imagen
  function mostrarVistaPrevia(event) {
    const input = event.target;
    const vistaPrevia = document.getElementById('previewImagen');
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        vistaPrevia.src = e.target.result;
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  // Dark Mode Toggle
  $(document).ready(function() {
    $('#darkModeToggle').on('click', function() {
      $('body').toggleClass('dark-mode');
      const icon = $('#darkModeIcon');
      if ($('body').hasClass('dark-mode')) {
        icon.removeClass('bi-moon-fill').addClass('bi-sun-fill');
        $('body').attr('data-bs-theme', 'light');
      } else {
        icon.removeClass('bi-sun-fill').addClass('bi-moon-fill');
        $('body').attr('data-bs-theme', 'dark');
      }
    });
  });
</script>
