<?php
include('../../vigiaAjax.php');
include('../../libphp/config.inc.php');
include('../../libphp/mysql.php');
include('../clases/modulo_class.php');
$modulos = new modulo($conexion['local']);
$data = $modulos->getModulo($_POST['idmodulo']);
?>

<form id="frmModulo" class="formulario">
	<input type="hidden" name="idmodulo" id="idmodulo" value="<?=$data['idmodulo']?>" />
	<table class="responsive table">
		<thead>
			<tr>
				<th colspan="2"><div id="mensaje"></div></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><label>Nombres</label></td>
				<td><input type="text" name="descripcion" id="descripcion" class="validate[required,funcCall[_validarOnlyText]]" value="<?=$data['descripcion']?>" /></td>
			</tr>
			
			<tr>
				<td><label>Estado</label></td>
				<td>
					<span style="display:block;"><label>Activo</label><input type="radio" name="estado" id="estado1" value="1" class="validate[required]" <?=($data['estado']==1)?'checked="checked"':''?> /></span>
					<span style="display:block;"><label>Inactivo</label><input type="radio" name="estado" id="estado0" value="0" class="validate[required]" <?=($data['estado']==0)?'checked="checked"':''?> /></span>

				</td>
			</tr>
		</tbody>
	</table>
</form>