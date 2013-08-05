<?php
include('../../vigiaAjax.php');
include('../../libphp/config.inc.php');
include('../../libphp/mysql.php');
include('../clases/perfiles_class.php');
$perfiles = new perfil($conexion['local']);
$data = $perfiles->getPerfil($_POST['idperfil']);
?>

<form id="frmPerfil" class="formulario">
    <input type="hidden" name="idperfil" id="idperfil" value="<?= $data['idperfil'] ?>" />
    <table class="responsive table">
        <thead>
            <tr>
                <th colspan="2">
        <div id="mensaje"></div>
        </th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td><label>Nombres</label></td>
                <td><input type="text" name="descripcion" id="descripcion" class="validate[required,funcCall[_validarOnlyText]]" value="<?= $data['descripcion'] ?>" data-prompt-position="bottomRight:1,-5"/></td>
            </tr>
            <tr>
                <td colspan="2"><label>Estado</label>
                    <input type="radio" name="estado" id="estado1" value="1" class="validate[required]" data-prompt-position="centerRight:1,-5" <?= ($data['estado'] == 1) ? 'checked="checked"' : '' ?> /> <span class="text-title">Activo</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="estado" id="estado0" value="0" class="validate[required]" data-prompt-position="centerRight:1,-5" <?= ($data['estado'] == 0) ? 'checked="checked"' : '' ?> /> <span class="text-title">Inactivo</span>
                </td>
            </tr>
        </tbody>
    </table>
</form>


<input type="hidden" id="nombre_archivo" value="/perfiles/index_perfil.php" />


<script>
    $('.guardar-formulario').submit(function(e) {
        $.preventDefault(e);

    })
    $('.guardar-formulario').click(function(e) {

        if ($('#frmPerfil').validationEngine('validate') == true) {
            $.post(init.XNG_WEBSITE_URL + 'perfiles/ajax/save.php?type=editPerfil', $('#frmPerfil').serialize(), function(data) {
                console.log('entra: ' + data);
                switch (data) {
                    case '1':
                        alert("Perfil Editado con Éxito!!");
                        _loadContenido($('#nombre_archivo').val());
                        $('.modal').modal('hide')
                        break;
                    default:
                        _msgerror(data, "#mensaje");
                        break;
                }
            })
        }

    })
</script>