<div class="modal fade" id="modal_horas">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Registrar Horas</h4>
            </div>
            <div class="modal-body">
                <form id="form_horas">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="name">Nº Horas:</label>
                            <input type="text" class="form-control" id="n_horas" name="n_horas" placeholder="Nº Horas">
                        </div>
                        <input type="hidden" id="modal_plan_id" value="{{$planId}}">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a class="btn btn-sm btn-primary" id="btn_save">Guardar</a>
                <a class="btn btn-sm btn-danger" data-dismiss="modal">Cancelar</a>
            </div>
        </div>
    </div>
</div>