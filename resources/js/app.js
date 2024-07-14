import './bootstrap';
import 'preline';
import swal from 'sweetalert2';
window.Swal = swal;

document.addEventListener('livewire:navigated', () => {
    window.HSStaticMethods.autoInit();
});
