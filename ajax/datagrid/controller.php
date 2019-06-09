<?PHP
/*
* Easy Grid
*
* @package easygrid
* @author $Author: sheiko $  
* @version $Id: controller.php, v 1.0 2006/10/31 15:58:15 sheiko Exp $ 
* @since v.1.0.1 
* @copyright (c) Dmitry Sheiko http://www.cmsdevelopment.com 
*/ 

/**
* Grid Controller Class 
* @package Easy Grid
* @author $Author: sheiko $ 
*/

class Grid {
	
	var $DataSourceFile;
	var $GridContent;
	var $Fields;
	var $Offset = 0;
	var $Limit = 20;
	var $Length = 0;
	var $Filter = array();
	var $OrderBy = array();
	
	/** 
    * Class Constructor
    * @return object
    */ 	
	
	function Grid() {
		$this->DataSourceFile = "sample.csv";
		$this->GridContent = array();
		if(isset($_POST["offset"])) $this->Offset = $_POST["offset"];
		if(isset($_POST["filter_field"])) $this->Filter["field"] = $_POST["filter_field"];
		if(isset($_POST["filter_value"])) $this->Filter["value"] = $_POST["filter_value"];
		if(isset($_POST["orderby"])) $this->OrderBy["field"] = $_POST["orderby"];
		if(isset($_POST["direction"])) $this->OrderBy["direction"] = $_POST["direction"];
		if(isset($_POST["limit"])) $this->Limit = $_POST["limit"];
		if(isset($_POST["fields"])) $this->Fields = split(",", preg_replace("/,$/is", "", $_POST["fields"]));
		return $this;
	}

	/** 
    * Ascend sorting comparing
    * @param array
    * @param array
    * @return boolean
    */ 	
	function grid_tblsort_asc($a, $b){
		$grid_sort_field= $a["orderby"];
	    return ($a[$grid_sort_field] < $b[$grid_sort_field])? -1:1;
	}
	/** 
    * Descend sorting comparing
    * @param array
    * @param array
    * @return boolean
    */ 		
	function grid_tblsort_desc($a, $b){
		$grid_sort_field= $a["orderby"];
	    return ($a[$grid_sort_field] > $b[$grid_sort_field])? -1:1;
	}	
	
	/** 
    * Data getting
    * 
    * @return boolean
    */ 		
	function getData() {
		$data = file($this->DataSourceFile);
		$this->Length = (int)count($data);
		foreach ($data as $key => $line) {
			$arr = split(";", $line);
			foreach($this->Fields as $Index => $Field) { 
				if(count($arr)>2) $this->GridContent[$key][$Field]=$arr[$Index]; 
			}
			if(isset($this->OrderBy["field"])) $this->GridContent[$key]["orderby"] = $this->OrderBy["field"];
			unset($data[$key]);
		}
		// Filtration
		if($this->Filter AND $this->Filter["value"] ) {
		foreach($this->GridContent as $Index => $fetch) {
				if(!preg_match("/^".preg_quote($this->Filter["value"])."/is", $fetch[$this->Filter["field"]])) {
					unset($this->GridContent[$Index]);
				}
			}
			$this->Length=count($this->GridContent);
			$this->Offset=0;
			sort($this->GridContent);
		}
		// Sorting	
		if($this->OrderBy)	{
			$grid_sort_field = $this->OrderBy["field"];
			usort ($this->GridContent, array($this, "grid_tblsort_".$this->OrderBy["direction"]));
		}
	}

	/** 
    * Respond with JSON generation
    * 
    * @return boolean
    */ 		
	function execRespond() {
		
		if($this->Length==0) return false;
		$out = '{
		"tlength" : '.$this->Length.',
		"columns" : [';
		foreach($this->Fields as $Field) { $out .= '"'.$Field.'",'; }
		$out = preg_replace("/,$/is","", $out);
		$out .= '],';
		$out .= '"value" : [';
		
		if($this->Offset<0) $this->Offset=0;
		if($this->Offset>$this->Length) $this->Offset=0;
		if($this->Limit>$this->Length) $this->Limit = $this->Length;
		
		for($i=$this->Offset;$i<$this->Limit;$i++) {
			$line = '{';
			foreach($this->Fields as $Field) { 
				$line .= '"'.$Field.'":"'.addslashes($this->GridContent[$i][$Field]).'",'; 
			}
			$line = preg_replace("/,$/is","", $line);
			$line .= '},';
			$out .= $line;
		}
		$out = preg_replace("/,$/is","", $out);
		$out .= ']}';
		print $out;
	}
}

header("Content-type: text/html; charset=UTF-8");
$grid = new Grid();
$grid->getData();
$grid->execRespond();
?>