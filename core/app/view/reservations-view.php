<?php
$opt = $_GET["opt"] ?? "all";
$projects = ProjectData::getAll();
$categories = CategoryData::getAll();
?>

<?php if($opt=="all"):
$events = EventData::getEvery();
?>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Eventos</h1>
                <p class="text-muted mb-0">Calendario y agenda de actividades</p>
            </div>
            <div class="ms-auto">
                <button class="btn btn-indigo shadow-sm fw-bold text-white px-4" data-coreui-toggle="modal" data-coreui-target="#newEventModal">
                    <i class="bi bi-calendar-plus me-1"></i> Nuevo Evento
                </button>
            </div>
        </div>

        <?php if(count($events)>0): ?>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 datatable">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-4">Título</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Proyecto</th>
                                <th>Categoría</th>
                                <th class="pe-4 text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($events as $e): 
                                $p = $e->getProject();
                                $c = $e->getCategory();
                            ?>
                            <tr>
                                <td class="ps-4 fw-bold text-indigo-900"><?php echo $e->title; ?></td>
                                <td class="small"><?php echo $e->date_at; ?></td>
                                <td class="small"><?php echo $e->time_at; ?></td>
                                <td><span class="badge bg-light text-dark fw-normal"><?php echo $p ? $p->name : "Ninguno"; ?></span></td>
                                <td><span class="badge bg-info text-dark fw-normal"><?php echo $c ? $c->name : "General"; ?></span></td>
                                <td class="pe-4 text-end">
                                    <a href="./?view=reservations&opt=edit&id=<?php echo $e->id; ?>" class="btn btn-light btn-sm"><i class="bi bi-pencil"></i></a>
                                    <button class="btn btn-light btn-sm text-danger" onclick="delEvent(<?php echo $e->id; ?>)"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php else: ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <div class="avatar avatar-xl bg-light text-muted mb-3 mx-auto d-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px;">
                        <i class="bi bi-calendar-x fs-1"></i>
                    </div>
                    <h4 class="fw-bold">No hay eventos</h4>
                    <p class="text-muted">Agenda tus próximas citas, reuniones o hitos importantes.</p>
                    <button class="btn btn-indigo fw-bold text-white px-4" data-coreui-toggle="modal" data-coreui-target="#newEventModal">
                        <i class="bi bi-plus-lg me-1"></i> Agregar Evento
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal: New Event -->
<div class="modal fade" id="newEventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Nuevo Evento</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-event-form">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold">Título *</label>
                            <input type="text" name="title" class="form-control" required placeholder="Título del evento">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Fecha *</label>
                            <input type="date" name="date_at" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Hora *</label>
                            <input type="time" name="time_at" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Proyecto</label>
                            <select name="project_id" class="form-select">
                                <option value="NULL">-- NINGUNO --</option>
                                <?php foreach($projects as $p): ?>
                                    <option value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Categoría</label>
                            <select name="category_id" class="form-select">
                                <option value="NULL">-- GENERAL --</option>
                                <?php foreach($categories as $c): ?>
                                    <option value="<?php echo $c->id; ?>"><?php echo $c->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Descripción</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Detalles..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light fw-bold" data-coreui-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-indigo text-white fw-bold px-4">Guardar Evento</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('add-event-form').onsubmit = function(e){
    e.preventDefault();
    const formData = new FormData(this);
    fetch('index.php?action=events&opt=add', { method: 'POST', body: formData })
    .then(res => res.text())
    .then(res => { if(res.trim() === "success"){ window.location.reload(); } });
}

function delEvent(id){
    if(confirm("¿Deseas eliminar este evento?")){
        fetch('index.php?action=events&opt=del&id='+id)
        .then(res => res.text())
        .then(res => { if(res.trim() === "success"){ window.location.reload(); } });
    }
}
</script>

<?php elseif($opt=="edit"): 
$e = EventData::getById($_GET["id"]);
?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Editar Evento</h1>
                <p class="text-muted mb-0">Actualiza la agenda</p>
            </div>
            <div class="ms-auto">
                <a href="./?view=reservations&opt=all" class="btn btn-light fw-bold px-4">
                    <i class="bi bi-arrow-left me-1"></i> Volver
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <form id="update-event-form">
                <input type="hidden" name="id" value="<?php echo $e->id; ?>">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold">Título *</label>
                            <input type="text" name="title" class="form-control" required value="<?php echo $e->title; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Fecha *</label>
                            <input type="date" name="date_at" class="form-control" required value="<?php echo $e->date_at; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Hora *</label>
                            <input type="time" name="time_at" class="form-control" required value="<?php echo $e->time_at; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Proyecto</label>
                            <select name="project_id" class="form-select">
                                <option value="NULL">-- NINGUNO --</option>
                                <?php foreach($projects as $p): ?>
                                    <option value="<?php echo $p->id; ?>" <?php if($p->id==$e->project_id){ echo "selected"; } ?>><?php echo $p->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Categoría</label>
                            <select name="category_id" class="form-select">
                                <option value="NULL">-- GENERAL --</option>
                                <?php foreach($categories as $c): ?>
                                    <option value="<?php echo $c->id; ?>" <?php if($c->id==$e->category_id){ echo "selected"; } ?>><?php echo $c->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Descripción</label>
                            <textarea name="description" class="form-control" rows="4"><?php echo $e->description; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-indigo text-white fw-bold px-4">Actualizar Evento</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('update-event-form').onsubmit = function(e){
    e.preventDefault();
    const formData = new FormData(this);
    fetch('index.php?action=events&opt=update', { method: 'POST', body: formData })
    .then(res => res.text())
    .then(res => {
        if(res.trim() === "success"){
            Swal.fire({ icon: 'success', title: '¡Actualizado!', timer: 1000, showConfirmButton: false })
            .then(() => { window.location.href = "./?view=reservations&opt=all"; });
        }
    });
}
</script>
<?php endif; ?>
