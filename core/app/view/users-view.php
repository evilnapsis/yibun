<?php
$opt = $_GET["opt"] ?? "all";
?>

<?php if($opt=="all"):
$users = UserData::getAll();
?>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Usuarios</h1>
                <p class="text-muted mb-0">Administración de acceso al sistema</p>
            </div>
            <div class="ms-auto">
                <button class="btn btn-indigo shadow-sm fw-bold text-white px-4" data-coreui-toggle="modal" data-coreui-target="#newUserModal">
                    <i class="bi bi-person-plus-fill me-1"></i> Nuevo Usuario
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 datatable">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-4">Nombre Completo</th>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th class="pe-4 text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($users as $u): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-indigo-900"><?php echo $u->name." ".$u->lastname; ?></td>
                                <td><?php echo $u->username; ?></td>
                                <td class="small"><?php echo $u->email; ?></td>
                                <td>
                                    <?php if($u->is_admin): ?>
                                        <span class="badge bg-primary rounded-pill px-3">Administrador</span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-dark border rounded-pill px-3">Usuario</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($u->is_active): ?>
                                        <span class="text-success fw-bold small"><i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i> Activo</span>
                                    <?php else: ?>
                                        <span class="text-danger fw-bold small"><i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i> Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="./?view=users&opt=edit&id=<?php echo $u->id; ?>" class="btn btn-light btn-sm"><i class="bi bi-pencil"></i></a>
                                    <button class="btn btn-light btn-sm text-danger" onclick="delUser(<?php echo $u->id; ?>)"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: New User -->
<div class="modal fade" id="newUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-user-form">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nombre *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Apellido</label>
                            <input type="text" name="lastname" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Email *</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nombre de Usuario *</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Contraseña *</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_admin" id="isAdminSwitch">
                                <label class="form-check-label fw-bold small" for="isAdminSwitch">¿Es Administrador?</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light fw-bold" data-coreui-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-indigo text-white fw-bold px-4">Crear Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('add-user-form').onsubmit = function(e){
    e.preventDefault();
    const formData = new FormData(this);
    fetch('index.php?action=users&opt=add', { method: 'POST', body: formData })
    .then(res => res.text())
    .then(res => { if(res.trim() === "success"){ window.location.reload(); } });
}

function delUser(id){
    if(confirm("¿Deseas eliminar este usuario?")){
        fetch('index.php?action=users&opt=del&id='+id)
        .then(res => res.text())
        .then(res => { if(res.trim() === "success"){ window.location.reload(); } });
    }
}
</script>

<?php elseif($opt=="edit"): 
$u = UserData::getById($_GET["id"]);
?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Editar Usuario</h1>
                <p class="text-muted mb-0">Actualiza el perfil y permisos</p>
            </div>
            <div class="ms-auto">
                <a href="./?view=users&opt=all" class="btn btn-light fw-bold px-4">
                    <i class="bi bi-arrow-left me-1"></i> Volver
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <form id="update-user-form">
                <input type="hidden" name="id" value="<?php echo $u->id; ?>">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nombre *</label>
                            <input type="text" name="name" class="form-control" required value="<?php echo $u->name; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Apellido</label>
                            <input type="text" name="lastname" class="form-control" value="<?php echo $u->lastname; ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Email *</label>
                            <input type="email" name="email" class="form-control" required value="<?php echo $u->email; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nombre de Usuario *</label>
                            <input type="text" name="username" class="form-control" required value="<?php echo $u->username; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nueva Contraseña (Opcional)</label>
                            <input type="password" name="password" class="form-control" placeholder="Dejar en blanco para no cambiar">
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_admin" id="isAdminSwitch" <?php if($u->is_admin){ echo "checked"; } ?>>
                                <label class="form-check-label fw-bold small" for="isAdminSwitch">¿Es Administrador?</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitch" <?php if($u->is_active){ echo "checked"; } ?>>
                                <label class="form-check-label fw-bold small" for="isActiveSwitch">¿Usuario Activo?</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-indigo text-white fw-bold px-4">Actualizar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('update-user-form').onsubmit = function(e){
    e.preventDefault();
    const formData = new FormData(this);
    fetch('index.php?action=users&opt=update', { method: 'POST', body: formData })
    .then(res => res.text())
    .then(res => {
        if(res.trim() === "success"){
            Swal.fire({ icon: 'success', title: '¡Actualizado!', timer: 1000, showConfirmButton: false })
            .then(() => { window.location.href = "./?view=users&opt=all"; });
        }
    });
}
</script>
<?php endif; ?>
