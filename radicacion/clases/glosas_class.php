<?PHP
class glosas_devoluciones extends BD{
	public function __construct($conexion){
		$this->BD($conexion);
	}
	public function _sql($campos="*", $where="", $groupby="", $orderby=""){
		$sql= "SELECT ".$campos."
		FROM glosas".
		(($where!="")?" WHERE ".$where:"").
		(($groupby!="")?" GROUP BY ".$groupby:"").
		(($orderby!="")? " ORDER BY ".$orderby:"");
		
		return $sql;
	}
	public function getall(){
		$campos="*";
		return $this->consultar($this->_sql($campos,"","idglosas_devoluciones","descripcion ASC"));
	}

	public function getOne($id){
			$rs = $this->consultar($this->_sql("*","idglosas_devoluciones=".$id));
			return $rs[0];
	}
	public function getallAutoC($term, $tipo){
            $categorias ='8,9';
            if($tipo == '-1'){
                $categorias ='1,2,3,4,5,6,7';
            }
               $rs =  $this->consultar($this->_sql("*"," (UPPER(codigo) LIKE UPPER('%".$term."%') OR UPPER(descripcion) LIKE UPPER('%".$term."%')) and categoria IN(".$categorias.")"));
		$array=array();
                foreach($rs as $g){
			$data = explode('-',$g['descripcion']);
			$html_data ='<table class="" ><tr><td><b>'.$g['codigo'].'-'.$g['item'].'  '.trim($data[0]).'</b></td></tr><tr><td><p align=\'justify\'>'.trim($data[1]).'</p></td></tr></table>';
			$array[] = array(
                            'value'=>$g['codigo'].' - '.$g['descripcion'],
                            'id'=>$g['idglosas_devoluciones'],
                            'icon'=>$html_data
                        ); 
                              
		}
                
		return json_encode($array);
	}

	public function _select($where, $name, $id, $select=""){
		$campos="idglosas_devoluciones, codigo, UPPER(descripcion) AS descripcion";
		$rs = $this->consultar($this->_sql($campos, $where,"","descripcion ASC"));
		$html='<select name="'.$name.'" id="'.$id.'" class="validate[required]" >';
			$html.='<option value="">SELECCIONE</option>';
			foreach($rs as $r){
				$html.='<option value="'.$r['idglosas_devoluciones'].'" '.(($select==$r['idcie10'])?'selected="selected"':'').'>'.$r['codigo'].' - '.$r['descripcion'].'</option>';
			}
		$html.='</select>';
		return $html;
	}
}
?>
