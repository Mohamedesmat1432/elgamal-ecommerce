import './bootstrap';
import 'preline';


document.addEventListener('livewire:navigated', () => {
    window.HSStaticMethods.autoInit();
});

import swal from 'sweetalert2';
window.Swal = swal;
