<?php
include("../vigiaAjax.php");
include("../libphp/config.inc.php");
include("../libphp/mysql.php");
include("../radicacion/clases/facturas_class.php");
include("clases/auMedica_class.php");
$facturas = new facturas($conexion['local']);
$campos = "*, UPPER(CONCAT_WS(' ',pa.nombre, pa.apellidos)) AS  paciente_nombre, UPPER(pro.nombre) AS proveedor_nombre, f.estado AS estado_factura, 
    IFNULL(COUNT(auf.idauditoria_financiera), 0) AS audFinanciera, f.idFactura as idFactura";
$where = "f.idFactura IN (SELECT idFactura FROM auditoria_financiera WHERE id_auditor = " . $_SESSION['usrid'] . ")";
$dataFacturas = $facturas->getall($campos, $where);
//var_dump($dataFacturas);
$auMedica = new auMedica($conexion['local']);
include '../requestFunctionsJavascript.php';
?>
<div class="collapse in" id="content_">
    <div class="table-option clearfix">

        <span class="pull-left keywords">
            <form action="#" class="form-inline">
                <input name="q" class="table-form" type="text"  placeholder="Keywords: Ruby, Rails, Django" >
                <button type="submit" class="btn btn-primary"> <i class="icon-search icon-white"></i></button>
            </form>
        </span>

        <div class="clear"></div>


    </div>
    <input type="hidden" id="nombre_archivo" value="/auditoria_medica/index_factura.php" />


    <div id="contenido">

        <table  id="reporte" class="responsive table table-hover">
            <thead>

                <tr>
                    <th title="No. Radicado">RAD</th>
                    <th title="Fecha Radicación">FECHA RAD.</th>
                    <th>NO. FACTURA</th>
                    <th>VALOR</th>
                    <th>PROVEEDOR</th>
                    <th>PACIENTE</th>
                    <th>ESTADO</th>
                    <th>AUD. FINANCIERA</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="lista">
                <?
                $i = 1;
                foreach ($dataFacturas as $fac) {

                    //  echo '<pre>'; var_dump($fac); echo '</pre>';
                    $rs_au = $auMedica->getOne(0, $fac['idFactura']);
                    //var_dump($rs_au);
                    $isGlosa = ($rs_au['estado_factura'] == '2') ? true : false;
                    ?>
                    <tr class="elemetoBusqueda">
                        <td><?= $fac['no_radicado'] ?></td>
                        <td><?= $fac['fecha_radicacion'] ?></td>
                        <td><?= (($fac['prefijo'] != "") ? $fac['prefijo'] . ' ' : '') . $fac['numero_factura'] ?></td>
                        <td><?= $fac['valor'] ?></td>
                        <td><?= $fac['proveedor_nombre'] ?></td>
                        <td><?= $fac['paciente_nombre'] ?></td>
                        <td><?= ($fac['estado_factura'] == 1) ? 'Activa' : 'Anulada' ?></td>
                        <td>
                            <?= ($fac['audFinanciera'] > 0) ? 'OK' : 'Pendiente' ?>
                        </td>
                        <? if (empty($rs_au)): ?>
                            <td width="61">
                                <a>
                                    <span class="addAuditoriaMedica" data-record="<? echo $fac['idFactura']; ?>" <? echo (($_REQUEST['section'])) ? 'data-section="' . $_REQUEST['section'] . '"' : ''; ?> <? echo (($_REQUEST['action'])) ? 'data-action="' . $_REQUEST['action'] . '"' : ''; ?>><button class="btn btn-success"><i class=" icon-plus"></i></button></span>
                                </a>
                            </td>
                        <? else: ?>
                            <td width="130">
                                <a>
                                    <button class="btn btn-primary verAuditoriaMedica" data-record="<? echo $fac['idFactura']; ?>" <? echo (($_REQUEST['section'])) ? 'data-section="' . $_REQUEST['section'] . '"' : ''; ?> <? echo (($_REQUEST['action'])) ? 'data-action="' . $_REQUEST['action'] . '"' : ''; ?>><i class="icon-check"></i></button>
                                    <?php if ($isGlosa) {
                                        ?>
                                        <button class="btn btn-warning agregarNuevaGlosa" role="button" data-auditoria='<?php echo $rs_au['idauditoria_medica']; ?>' data-toggle="modal" href="#agregarNuevaGlosa" data-record="<? echo $fac['idFactura']; ?>" <? echo (($_REQUEST['section'])) ? 'data-section="' . $_REQUEST['section'] . '"' : ''; ?> <? echo (($_REQUEST['action'])) ? 'data-action="' . $_REQUEST['action'] . '"' : ''; ?>><i class=" icon-medkit"></i></button>
                                        <button class="btn btn-success verGlosasAgregadas" role="button" data-auditoria='<?php echo $rs_au['idauditoria_medica']; ?>' data-toggle="modal" href="#verGlosa" data-record="<? echo $fac['idFactura']; ?>" <? echo (($_REQUEST['section'])) ? 'data-section="' . $_REQUEST['section'] . '"' : ''; ?> <? echo (($_REQUEST['action'])) ? 'data-action="' . $_REQUEST['action'] . '"' : ''; ?>><i class=" icon-inbox"></i></button>
                                    <?php }
                                    ?>
                                </a>
                            </td>
                        <? endif ?>
                    </tr>
                <? } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="9" id="pager" class="holder" align="center">

                    </td>
                </tr>
            </tfoot>
        </table>

    </div>
    <script type="text/javascript" src="<? echo $SERVER_NAME; ?>auditoria_medica/js/factura.js"></script>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $('.agregarNuevaGlosa').click(function() {
            $('.auditoria_glosa').val($(this).attr('data-auditoria'));
        })
        _autocompletar("#autoc-idglosa2", init.XNG_WEBSITE_URL + "auditoria_medica/ajax/busqueda.php?case=glosas&tipo=-1", function(ui) {
            $("#idglosa2").val(ui.item.id);
        }, function(ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.icon + "</a>")
                    .appendTo(ul);
        })

        $('.verGlosasAgregadas').click(function() {
            $.post(init.XNG_WEBSITE_URL + 'auditoria_medica/ajax/consultaGlosas.php', {auditoria_glosa:$(this).attr('data-auditoria'), id:$(this).attr('data-record')}, function(data) {
                $('#verGlosa .modal-body').html(data);
            })
        })
        $('.guardarNuevaGlosa').click(function() {
            $.post(init.XNG_WEBSITE_URL + 'auditoria_medica/ajax/save.php?type=addNewGlosa', $('.addOtherGlosa').serialize(), function(data) {
                alert('Se ha agregado una nueva glosa para esta auditoria.')
                $('#agregarNuevaGlosa').modal('hide');
            })
        })
    })
</script>
<!-- Modal -->
<div id="verGlosa" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Historial de Glosas</h3>
    </div>
    <div class="modal-body">
        
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
</div>

<!-- Modal -->
<div id="agregarNuevaGlosa" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Agregar Nueva Glosa</h3>
    </div>
    <div class="modal-body">
        <form class='addOtherGlosa' method="post" >


            <input type="hidden" value="" name='auditoria_glosa' class='auditoria_glosa' />
            <fieldset>
                <table width="100%" class="responsive">
                    <tbody>
                        <tr>
                            <td width='200'>Concepto Auditoría</td>
                            <td>
                                <input type="number" name="glosa_codConcepto" id="codConcepto" value="" class="validate[condRequired[chk_2],custom[numberP]]" />
                            </td>
                        </tr>
                        <tr>
                            <td>Fecha Concepto Auditoría</td>
                            <td>
                                <input type="text" name="glosa_fecha_concepto"  class="fecha validate[]" />
                            </td>
                        </tr>
                        <tr>
                            <td>Codigo Glosa Inicial</td>
                            <td>
                                <input type="text" id="autoc-idglosa2" class="validate[required,funcCall[_validarHiddenAutoC]] autoc_txt" />
                                <input type="hidden" name="glosa_idglosa" id="idglosa2" class="validate[custom[numberP]]" />
                            </td>
                        </tr>
                        <tr>
                            <td>Fecha de Glosa</td>
                            <td>
                                <input type="text" name="glosa_fecha_glosa"  class="fecha validate[custom[date2]]" />
                            </td>
                        </tr>
                        <tr>
                            <td>Valor de la Glosa</td>
                            <td>
                                <input type="number" name="glosa_valor_glosa" id="valor_glosa-chk_2" class=" pesos" />
                            </td>
                        </tr>
                        <tr>
                            <td>Observaciones </td>
                            <td>
                                <textarea name="glosa_observaciones" id="observaciones-chk_2" class="validate[funcCall[_validarGlosas]]" ></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button class="btn btn-primary guardarNuevaGlosa">guardar</button>
    </div>
</div>