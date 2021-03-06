<?php
include("../../vigiaAjax.php");
include("../../libphp/config.inc.php");
include("../../libphp/mysql.php");
include("../../radicacion/clases/facturas_class.php");
include("../../radicacion/clases/contrato_class.php");
include("../../radicacion/clases/tipo_servicio.php");
include("../../auditoria_financiera/clases/auditoria_financiera.php");
//include("../clases/auditoria_financiera.php");
$factura = new facturas($conexion['local']);
//se obtiene la informacion de la factura a auditar
$data = $factura->getFactura($_REQUEST['id']);
$contrato = new contrato($conexion['local']);
$contrat = $contrato->getOne($data['contrato']);

$tipo_servicio = new tipo_servicio($conexion['local']);
//aud financiera
$auFinanciera = new auditoria_financiera($conexion['local']);
?>
<input type="hidden" id="nombre_archivo" value="auditoria_medica/index_factura.php" />
<div id="contenido" class="dividido">
    <div class="partes">
        <fieldset>
            <legend>Auditoría Médica</legend>
            <form id="addAuditoria" class="formulario">
                <input type="hidden" name="idFactura" id="idFactura" value="<?= $_REQUEST['id'] ?>" />
                <input type="hidden" name="id_auditor" id="id_auditor" value="<?= $_SESSION['usrid'] ?>" />
                <table class="responsive table">
                    <tbody>
                        <tr>
                            <td width="30%"><label>Modalidad de pago</label></td>

                            <td>
                                <?= $contrato->_select("c.idproveedor=" . $data['idproveedor'], "modalidad_pago", "modalidad_pago", $data['contrato']) ?>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Tipo de Servicio</label></td>
                            <td>
                                <?= $tipo_servicio->_select("", "idtipo_servicio", "idtipo_servicio"); ?>
                            </td>
                        </tr>
                        <tr class='nivel'>
                    <script>
                        $(".checkbox_").click(function() {
                                if ($(this).is(':checked')) {
                                    console.log('entra')
                                    $(this).removeClass("checked");
                                } else {
                                    $(this).addClass("checked");
                                }
                            })
                    
                                                    </script>
                            <td><label>Nivel de atención  según  CRES Acuerdo 008/2008 y Acuerdo 028/2011</label></td>
                            <td>
                                <label>1</label>
                                <input type="checkbox" name="idcres_1" value="1"  />
                                <label>2</label>
                                <input type="checkbox" name="idcres_3"  class='checkbox_' value="1"  />
                                <label>3</label>
                                <input type="checkbox" name="idcres_2"  class='checkbox_' value="1"  />
                            </td>
                    </tr>
                    <tr>
                        <td><label>CIE 10 de la atención</label></td>
                        <td>
                            <input type="text" id="autoc-idcie10" class="validate[required,funcCall[_validarHiddenAutoC]] autoc_txt" />
                            <input type="hidden" id="idcie10" name="idcie10" class="validate[required]"  />
                        </td>
                    </tr>
                    <tr>
                        <td><label>En Combate</label></td>

                        <td>
                            <input type="radio" name="en_combate" id="en_combate_si" value="SI" class="validate[required]" /><label>SI</label>
                            <input type="radio" name="en_combate" id="en_combate_no" value="NO" class="validate[required]" /><label>NO</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class='glosa-tipo'>
                            <label >Pago</label> <input type="checkbox" name="estado_factura" id="chk_0" value="0" onclick="glosas(this)" class="validate[required]">
                            <label >Devolución</label><input type="checkbox" name="estado_factura" id="chk_1" value="1" onclick="glosas(this)" class="validate[required]">
                            <label >Glosas</label><input type="checkbox" name="estado_factura" id="chk_2" value="2" onclick="glosas(this)" class="validate[required]">
                        </td>
                    </tr>

                    <tr id="tr_devoluciones" style="display: none;">
                        <td colspan="2">
                            <fieldset>
                                <legend>Devoluciones</legend>
                                <table width="100%">
                                    <thead>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width='320'>Concepto Auditoría</td>
                                            <td>
                                                <input type="number" name="devoluciones_codConcepto" id="codConcepto-chk_0" value="" class="validate[funcCall[_validarGlosas]]" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Fecha Concepto Auditoría</td>
                                            <td>
                                                <input type="text" name="devoluciones_fecha_concepto"  class="fecha validate[custom[date2]]" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Codigo Devolución</td>
                                            <td>
                                                <input type="text" id="autoc-iddevolucion" class="validate[funcCall[_validarHiddenAutoC]] autoc_txt" />
                                                <input type="hidden" name="devoluciones_iddevolucion" id="iddevolucion" class="validate[custom[numberP]]" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Fecha de Devolución</td>
                                            <td>
                                                <input type="text" name="devoluciones_fecha_devolucion"  class="fecha validate[custom[date2]]" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Observaciones </td>
                                            <td>
                                                <textarea name="devoluciones_observaciones" id="observaciones-chk_2" class="validate[funcCall[_validarGlosas]]" ></textarea>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                    <tr id="tr_glosas" style="display: none;">
                        <td colspan="2">
                            <fieldset>
                                <legend>Glosas</legend>
                                <table width="100%">
                                    <thead>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width='320'>Concepto Auditoría</td>
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
                                                <input type="text" id="autoc-idglosa" class="validate[required,funcCall[_validarHiddenAutoC]] autoc_txt" />
                                                <input type="hidden" name="glosa_idglosa" id="idglosa" class="validate[custom[numberP]]" />
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
                        </td>
                    </tr>
                    <tr id="tr_pago" style="display: none;">
                        <td colspan="2">
                            <fieldset>
                                <legend>Pago</legend>
                                <table width="100%">
                                    <thead>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width='320'>Concepto Auditoría</td>
                                            <td>
                                                <input type="number" name="pago_codConcepto" id="codConcepto" value="" class="validate[funcCall[chk_0],custom[numberP]]" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Fecha Concepto Auditoría</td>
                                            <td>
                                                <input type="text" name="pago_fecha_concepto" class="fecha validate[custom[date2]]" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Valor del Pago</td>
                                            <td>
                                                <input type="number" name="pago_valor_pago" id="valor_pago" class="validate[custom[numberP]] pesos" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Fecha Pago</td>
                                            <td>
                                                <input type="text" name="pago_fecha_pago"  class="fecha validate[custom[date2]]" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
            <table width="100%">
                <tbody>
                    <tr>
                        <td align="right">
                            <button class="guardarDaata btn btn-primary">
                                Guardar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </fieldset>

    </div>
    <div class="partes">
        <div id="acordeon">
            <h3>Información de la Factura</h3>
            <div>
                <table align="center">
                    <tbody>
                        <tr>
                            <td width='320'><label>No. Radicado</label></td>
                            <td align="right"><?= $data['no_radicado'] ?></td>
                        </tr>
                        <tr>
                            <td><label>No. Factura</label></td>
                            <td align="right"><?= (($data['prefijo'] != "") ? $data['prefijo'] . ' ' : '') . $data['numero_factura'] ?></td>
                        </tr>
                        <tr>
                            <td><label>Fecha de emisión Factura</label></td>
                            <td align="right"><?= $data['fecha_emision'] ?></td>
                        </tr>
                        <tr>
                            <td><label>Fecha Presentación</label></td>
                            <td align="right"><?= $data['fecha_radicacion'] ?></td>
                        </tr>
                        <tr>
                            <td><label>Valor de la Factura</label></td>
                            <td align="right">$<?= number_format($data['valor'], 2); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <fieldset>
                                    <legend>Proveedor</legend>
                                    <table width="100%">
                                        <tr>
                                            <td><label>Nombre</label></td>
                                            <td align="right"><?= $data['proveedor_nombre'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><label>No. Documento</label></td>
                                            <td align="right"><?= $data['doc_proveedor'] ?></td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <? if ($contrat['numero_contrato'] != 'RG'): ?>
                                <td colspan="2">
                                    <fieldset>
                                        <legend>Contrato</legend>
                                        <table width="100%">
                                            <tr>
                                                <td><label>No. Contrato</label></td>
                                                <td align="right"><?= $contrat['numero_contrato'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><label>Fecha Inicio del Contrato</label></td>
                                                <td align="right"><?= $contrat['fecha_contrato'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><label>Valor Contrato</label></td>
                                                <td align="right">$<?= number_format($contrat['valor_contrato'], 2) ?></td>
                                            </tr>
                                        </table>
                                    </fieldset>
                                <td>
                                <? else: ?>
                                <td><label>Tipo</label></td>
                                <td align="right"><?= $contrat['numero_contrato'] ?></td>
                            <? endif; ?>
                        </tr>
                        <tr>
                            <td><label>Unidad de Atención GAVD-CENAF</label></td>
                            <td align="right"><?= $data['Uatencion'] ?></td>
                        </tr>
                        <tr>
                            <td><label>Unidad de Atención GAVD-CENAF Centralizada</label></td>
                            <td align="right"><?= $data['UatencionC'] ?></td>
                        </tr>
                        <tr>
                            <td><label>Unidad de Atención GAVD-CENAF Centralizadora</label></td>
                            <td align="right"><?= $data['UatencionCe'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <fieldset>
                                    <legend>Paciente</legend>
                                    <table width="100%">
                                        <tr>
                                            <td><label>Nombre</label></td>
                                            <td align="right"><?= $data['paciente_nombre'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><label>No. Documento</label></td>
                                            <td align="right"><?= $data['doc_paciente'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><label>Unidad del Paciente</label></td>
                                            <td align="right"><?= $data['Upaciente'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><label>Grado</label></td>
                                            <td align="right"><?= $data['grado'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><label>Fuerza</label></td>
                                            <td align="right"><?= $data['fuerza'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><label>Parentesco</label></td>
                                            <td align="right"><?= ($data['idparentesco'] == 1) ? 'Titular' : 'Beneficiario' ?></td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </td>
                        </tr>

                        <tr>
                            <td><label>Número Autorización</label></td>
                            <td align="right"><?= $data['no_autorizacion'] ?></td>
                        </tr>
                        <tr>
                            <td><label>Fecha Autorización del Servicio</label></td>
                            <td align="right"><?= $data['fecha_autorizacion_servicio'] ?></td>
                        </tr>
                        <tr>
                            <td><label>Fecha Ingreso del Paciente</label></td>
                            <td align="right"><?= $data['fecha_ingreso_paciente'] ?></td>
                        </tr>
                        <tr>
                            <td><label>Fecha Salida del Paciente</label></td>
                            <td align="right"><?= $data['fecha_egreso_paciente'] ?></td>
                        </tr>
                        <tr>
                            <td><label>Estado</label></td>
                            <td align="right"><?= (($data['estado_factura'] == 1) ? 'En proceso' : 'Paga') ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3>Auditoría Financiera</h3>
            <div>
                <?
                $dataFin = $auFinanciera->getOne(0, $_GET['idfactura']);
                echo $dataFin['concepto_auditoria'];
                ?>

            </div>
        </div>
    </div>
</div>
<script>
                       
                        
                        $(function() {
                            
                            _loadADDForms();
                            $(".fecha").datepicker({
                                showOn: "button",
                                buttonImage: "/imagenes/calendar.gif",
                                buttonImageOnly: true,
                                dateFormat: "yy-mm-dd"
                            });
                        });



                        $(function() {




                            _botonesIcons('.guardarDaata', "ui-icon-disk", "", function() {
                                _guardarMods("addAuditoria", "#addAuditoria", "Auditoría");
                            })
                            $("#acordeon").accordion({
                                collapsible: true,
                                active: false,
                                heightStyle: "content"
                            });
                            _fechaFields();
                        });


                        function glosas(e) {
                            $(".glosa-tipo .icheckbox_flat-blue").removeClass("checked");
                            $('.glosa-tipo .icheckbox_flat-blue').click(function() {
                                $(this).addClass('checked');
                            })
                            if ($(e).is(":checked") == true) {
                                if (e.id == 'chk_1') {
                                    $("#chk_2").removeAttr("checked");
                                    $("#chk_0").removeAttr("checked");

                                    $("#tr_devoluciones").show();
                                    $("#tr_pago").hide();
                                    $("#tr_glosas").hide();
                                } else if (e.id == 'chk_2') {
                                    $("#chk_1").removeAttr("checked");
                                    $("#chk_0").removeAttr("checked");
                                    $("#tr_devoluciones").hide();
                                    $("#tr_pago").hide();
                                    $("#tr_glosas").show();
                                } else {
                                    $("#chk_2").removeAttr("checked");
                                    $("#chk_1").removeAttr("checked");
                                    $("#tr_devoluciones").hide();
                                    $("#tr_pago").show();
                                    $("#tr_glosas").hide();
                                }
                            } else {
                                if (e.id == 'chk_1') {
                                    $("#tr_devoluciones").hide();
                                } else if (e.id == 'chk_2') {
                                    $("#tr_glosas").hide();
                                } else {
                                    $("#tr_pago").hide();
                                }
                            }
                        }

                        var _loadADDForms = function() {
                            _autocompletar("#autoc-idcie10", init.XNG_WEBSITE_URL + "radicacion/ajax/busqueda.php?case=cie10", function(ui) {
                                $("#idcie10").val(ui.item.id);
                            }, '')
                            _autocompletar("#autoc-iddevolucion", init.XNG_WEBSITE_URL + "radicacion/ajax/busqueda.php?case=glosas", function(ui) {
                                $("#iddevolucion").val(ui.item.id);
                            }, function(ul, item) {
                                return $('<li style="width:50%"></li>')
                                        .data("item.autocomplete", item)
                                        .append("<a>" + item.icon + "</a>")
                                        .appendTo(ul);
                            })
                            _autocompletar("#autoc-idglosa", init.XNG_WEBSITE_URL + "radicacion/ajax/busqueda.php?case=glosas", function(ui) {
                                $("#idglosa").val(ui.item.id);
                            }, function(ul, item) {
                                return $("<li></li>")
                                        .data("item.autocomplete", item)
                                        .append("<a>" + item.icon + "</a>")
                                        .appendTo(ul);
                            })
                        }

</script>
