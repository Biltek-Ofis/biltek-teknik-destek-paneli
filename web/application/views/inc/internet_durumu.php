<script>
    $(document).ready(function () {
        function updateOnlineStatus() {
            if (navigator.onLine) {
                $('#internetYokModal').modal('hide');
            } else {
                document.querySelectorAll('.modal').forEach(function (modalElem) {
                    const myModal = bootstrap.Modal.getOrCreateInstance(modalElem);
                    myModal.hide();
                });
                $('#internetYokModal').modal('show');
            }
        }
        window.addEventListener('online', updateOnlineStatus);
        window.addEventListener('offline', updateOnlineStatus);
        updateOnlineStatus();
    });
</script>

<div class="modal fade" id="internetYokModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="internetYokModalLabel" aria-hidden="true" style="z-index: 9999999;">
    <div class="modal-dialog">
        <div class="modal-content modal-danger">
            <div class="modal-header">
                <h5 class="modal-title" id="internetYokModalLabel"><i class="fa fa-wifi"></i> İnternet Yok</h5>
            </div>
            <div class="modal-body">
                İnternet bağlantınız kesildi. Lütfen bağlantınızı kontrol edin. İnternete bağlandığınızda bu mesaj otomatik olarak kaybolacaktır.
            </div>
        </div>
    </div>
</div>