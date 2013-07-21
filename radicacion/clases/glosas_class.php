<?PHP
class glosas_devoluciones extends BD{
	public function __construct($conexion){
		$this->BD($conexion);
	}
	public function _sql($campos="*", $where="", $groupby="", $orderby=""){
		$sql= "SELECT ".$campos."
		FROM glosas_devoluciones".
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
	public function getallAutoC($term){
		$rs =  $this->consultar($this->_sql("*"," UPPER(codigo) LIKE UPPER('%".$term."%') OR UPPER(descripcion) LIKE UPPER('%".$term."%')"));
		$array=array();
		foreach($rs as $g){
			$data = explode('-',$g['descripcion']);
			$html_data ='<table width=\'500\'><tr><td><b>'.$g['codigo'].'  '.trim($data[0]).'</b></td></tr><tr><td><p align=\'justify\'>'.trim($data[1]).'</p></td></tr></table>';
			
			
			
			$array[] = '{"value":"'.$g['codigo'].' - '.$g['descripcion'].'","id":"'.$g['idglosas_devoluciones'].'","icon":"'.$html_data.'"}';
		}
		return  '['.implode(",",$array).']';
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
