<?php
echo '<script>
$(document).ready(function(){
    $("#medyaSilModal").on("hidden.bs.modal", function (e) {
        $("#medyaSilOnayBtn").removeAttr("onclick");
    });
});
</script>';

echo '<div class="modal fade" id="medyaSilModal" tabindex="-1" role="dialog" aria-labelledby="medyaSilModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="medyaSilModalLabel">Medya Silme İşlemini Onaylayın</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body">
    Medyayı silmek istediğinize emin misiniz?
    </div>
    <div class="modal-footer">
    <a id="medyaSilOnayBtn" href="#" class="btn btn-success">Evet</a>
    <a class="btn btn-danger" data-dismiss="modal">Hayır</a>
    </div>
</div>
</div>
</div>';
?>