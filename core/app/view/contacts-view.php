<?php
$opt = $_GET["opt"] ?? "all";
?>

<?php if($opt=="all"):
$contacts = ContactData::getAll();
?>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Contactos</h1>
                <p class="text-muted mb-0">Directorio de personas y colaboradores</p>
            </div>
            <div class="ms-auto">
                <button class="btn btn-indigo shadow-sm fw-bold text-white px-4" data-coreui-toggle="modal" data-coreui-target="#newContactModal">
                    <i class="bi bi-person-plus me-1"></i> Nuevo Contacto
                </button>
            </div>
        </div>

        <?php if(count($contacts)>0): ?>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 datatable">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-4">Nombre Completo</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th class="pe-4 text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($contacts as $c): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-md bg-light text-indigo-600 me-3 rounded-circle d-flex align-items-center justify-content-center fw-bold">
                                            <?php echo substr($c->name,0,1).substr($c->lastname ?? '',0,1); ?>
                                        </div>
                                        <div class="fw-bold text-indigo-900"><?php echo $c->name." ".$c->lastname; ?></div>
                                    </div>
                                </td>
                                <td class="small"><?php echo $c->email; ?></td>
                                <td class="small"><?php echo $c->phone; ?></td>
                                <td class="small text-muted"><?php echo $c->address; ?></td>
                                <td class="pe-4 text-end">
                                    <a href="./?view=contacts&opt=edit&id=<?php echo $c->id; ?>" class="btn btn-light btn-sm"><i class="bi bi-pencil"></i></a>
                                    <button class="btn btn-light btn-sm text-danger" onclick="delContact(<?php echo $c->id; ?>)"><i class="bi bi-trash"></i></button>
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
                        <i class="bi bi-people fs-1"></i>
                    </div>
                    <h4 class="fw-bold">No hay contactos</h4>
                    <p class="text-muted">Crea un directorio de contactos para tener tu información a mano.</p>
                    <button class="btn btn-indigo fw-bold text-white px-4" data-coreui-toggle="modal" data-coreui-target="#newContactModal">
                        <i class="bi bi-person-plus me-1"></i> Agregar Contacto
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal: New Contact -->
<div class="modal fade" id="newContactModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Nuevo Contacto</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-contact-form">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nombre *</label>
                            <input type="text" name="name" class="form-control" required placeholder="Nombre">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Apellido</label>
                            <input type="text" name="lastname" class="form-control" placeholder="Apellido">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Email *</label>
                            <input type="email" name="email" class="form-control" required placeholder="correo@ejemplo.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Teléfono</label>
                            <input type="text" name="phone" class="form-control" placeholder="Teléfono">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Dirección</label>
                            <input type="text" name="address" class="form-control" placeholder="Dirección">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light fw-bold" data-coreui-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-indigo text-white fw-bold px-4">Guardar Contacto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('add-contact-form').onsubmit = function(e){
    e.preventDefault();
    const formData = new FormData(this);
    fetch('index.php?action=contacts&opt=add', { method: 'POST', body: formData })
    .then(res => res.text())
    .then(res => { if(res.trim() === "success"){ window.location.reload(); } });
}

function delContact(id){
    if(confirm("¿Deseas eliminar este contacto?")){
        fetch('index.php?action=contacts&opt=del&id='+id)
        .then(res => res.text())
        .then(res => { if(res.trim() === "success"){ window.location.reload(); } });
    }
}
</script>

<?php elseif($opt=="edit"): 
$c = ContactData::getById($_GET["id"]);
?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Editar Contacto</h1>
                <p class="text-muted mb-0">Actualiza los datos personales</p>
            </div>
            <div class="ms-auto">
                <a href="./?view=contacts&opt=all" class="btn btn-light fw-bold px-4">
                    <i class="bi bi-arrow-left me-1"></i> Volver
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <form id="update-contact-form">
                <input type="hidden" name="id" value="<?php echo $c->id; ?>">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nombre *</label>
                            <input type="text" name="name" class="form-control" required value="<?php echo $c->name; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Apellido</label>
                            <input type="text" name="lastname" class="form-control" value="<?php echo $c->lastname; ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Email *</label>
                            <input type="email" name="email" class="form-control" required value="<?php echo $c->email; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Teléfono</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo $c->phone; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Dirección</label>
                            <input type="text" name="address" class="form-control" value="<?php echo $c->address; ?>">
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-indigo text-white fw-bold px-4">Actualizar Contacto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('update-contact-form').onsubmit = function(e){
    e.preventDefault();
    const formData = new FormData(this);
    fetch('index.php?action=contacts&opt=update', { method: 'POST', body: formData })
    .then(res => res.text())
    .then(res => {
        if(res.trim() === "success"){
            Swal.fire({ icon: 'success', title: '¡Actualizado!', timer: 1000, showConfirmButton: false })
            .then(() => { window.location.href = "./?view=contacts&opt=all"; });
        }
    });
}
</script>
<?php endif; ?>
