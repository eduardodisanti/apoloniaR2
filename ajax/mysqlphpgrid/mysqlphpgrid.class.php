<?PHP
/* MySQLPHPGrid version 0.6.4
 * MySQLPHPGrid is released under the LGPL license: 
 * Copyright (C) 2006 email: mysqlphpgrid@drasticdata.nl
 * 
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * =========================================================================================
 * If you find this sofware useful, we appreciate your donation on http://www.drasticdata.nl
 * Suggestions for improvement can be sent to: mysqlphpgrid@drasticdata.nl
 * ========================================================================================= 
 */
class mysqlphpgrid {
	public $add_allowed 	= true;		// may the user add records?
	public $delete_allowed 	= true;		// may the user delete records?
	public $update_allowed 	= true;		// may the user update individual fields of records?
	public $pagelength		= 20;		// length of the grid. If longer it will do pagination
	public $show_id_field	= true;		// to show the id field or not

	protected $server, $user, $pw, $db, $table; 
	protected $connection;
	protected $orderbystr;
	protected $ordstr;
	private $ord, $desc;
	private $idname = "";
	private $idcolnr;

	function __construct($server, $user, $pw, $db, $table) {
		$this->server = $server;
		$this->user = $user;
		$this->pw = $pw;
		$this->db = $db;
		$this->table = $table;
		$this->conn = mysql_connect($this->server, $this->user, $this->pw) or die(mysql_error());
		mysql_select_db($this->db) or die (mysql_error());
		
		// Initialize the name of the id field:
		$result = mysql_query("SELECT * FROM $this->table LIMIT 1", $this->conn);
		for($i=0; $i < mysql_num_fields($result); $i++)  {
			$fld = mysql_fetch_field($result, $i);
			if ($fld->primary_key == 1) { 
				$this->idname = $fld->name;
				$this->idcolnr = $i;
			}
			elseif ($fld->unique_key == 1) {
				$this->idname = $fld->name;
				$this->idcolnr = $i;
			}
		}
		if ($this->idname == "") die("Could not find primary or unique key");
		mysql_free_result($result);
		
	}
	function __destruct() {
		 mysql_close($this->conn);
	}
	function UpdateData() {
		$res = $this->update_data();
		if ($_REQUEST["a"]) exit($res);	//Ajax: don't do any further processing'
		$this->do_orderby();
	}
	function ShowTable(){
		?>
		<script type="text/javascript" src="mootools.js"></script>
		<script type="text/javascript">
		var ajaxongoing = false;
		function td_change(obj) {
			var url = '<?echo $_SERVER['PHP_SELF']?>?a=1&op=u&id='+input_obj.id+'&value='+escape(obj.value);
			myajax = new Ajax(url, {
				method: 'get',
				onComplete: function(){
					if(this.transport.responseText[0]=='0')
						remove_form(null);
					else
						remove_form(unescape(this.transport.responseText.slice(1)));
					ajaxongoing = false;
				}
			}).request();
			ajaxongoing = true;
		}
		
		var input_obj;
		var input_obj_old_innerHTML;
		var input_obj_old_onclick;
		function keyPressed(obj, e) {
			if(window.event)	k = e.keyCode // IE
			else				k = e.which // Netscape/Firefox/Opera
			//if(k==13) td_change(obj);				//enter key; works in IE and FF but enter in FF already causes a change event,...
			if(k==27) remove_form(null); 			//escape key; doesn't work in IE
		}
		function remove_form(str){
			if (input_obj) {
				input_obj.innerHTML = (str)? str : input_obj_old_innerHTML;
				if (str) new Fx.Color(input_obj.id, 'color', {duration: 4000}).fromColor('F00');
				input_obj.parentNode.onclick = input_obj_old_onclick;
			}
			input_obj = null;
		}
		function create_form(obj){
			if (ajaxongoing) return;
			remove_form(null);
			input_obj = obj;
			input_obj_old_innerHTML = obj.innerHTML;
			input_obj_old_onclick 	= obj.parentNode.onclick;
			
			obj.parentNode.onclick = null;
			width = obj.parentNode.clientWidth - 2;
			value = obj.innerHTML;
			
			formid = obj.id + "|1"; // to prevent two objects from having the same id
			fldcode = obj.id.slice(obj.id.indexOf("|")+1);
			fldtype = get_fldtype(fldcode);
			if (fldtype.search("^enum") == 0) {
				arr = fldtype.split("'");
				str = "<select onChange=\"td_change(this)\" onKeyDown=\"keyPressed(this, event)\" ID=\""+ formid + "\" > \n"
				for (i=1; i<arr.length; i+=2) {
					str += "<option" + ((value==arr[i])?" selected":"") + " value=\'" + arr[i] + "\'>" + arr[i] + "</option>\n";
				}
				obj.innerHTML = str + "</select>\n";
			} 
			else if (fldtype.search("^char") == 0 || fldtype.search("^varchar")){
				maxlength = fldtype.slice(fldtype.indexOf("(")+1,-1);
				obj.innerHTML = "<input type=\"text\" maxlength="+maxlength+ " onChange=\"td_change(this)\" onKeyDown=\"keyPressed(this, event)\" ID=\""+ formid + "\" VALUE=\""+ value + "\">";
			} else {
				obj.innerHTML = "<input type=\"text\" onChange=\"td_change(this)\" onKeyDown=\"keyPressed(this, event)\" ID=\""+ formid + "\" VALUE=\""+ value + "\">";
			}
			document.getElementById(formid).style.width = width;
			document.getElementById(formid).focus();
			if (fldtype.search("^enum") != 0) document.getElementById(formid).select();	
		}	
		function tr_del(obj) {
			new Fx.Color('row'+obj.id, 'color', {duration: 300}).toColor('#A0A0A0');
			if (window.confirm("Really delete this row?")) { 
				open('<?echo $_SERVER['PHP_SELF']?>?op=d&id=' + obj.id + '&ord=<?echo $this->ordstr?>' + '&s=<?echo $_REQUEST['s']?>', '_self');
			}
			new Fx.Color('row'+obj.id, 'color', {duration: 300}).toColor('#000000');
		}
		function tr_add(obj) {
			open('<?echo $_SERVER['PHP_SELF']?>?op=a' + '&s=l', '_self');
		}
		function td_sort_desc(obj){
			open('<?echo $_SERVER['PHP_SELF']?>?ord='+obj.id+',d', '_self');
		}
		function td_sort(obj){
			open('<?echo $_SERVER['PHP_SELF']?>?ord='+obj.id, '_self');
		}
		</script>
		<?
		$result = $this->select();
		$str = "<div class=\"divmysqlphpgrid\">\n";
		$str .= "<table class=\"mysqlphpgrid\">\n";
		//Header:
		$str .= "<tr>\n";
		if ($this->delete_allowed) $str .= "<th id=\"th__del\"></th>\n";
		for($i=0; $i < mysql_num_fields($result); $i++)  {
			$fldname = mysql_fetch_field($result)->name;
			$id = $fldname . ((($this->ord == $fldname) && (!$this->desc))? ",d" : "");
			$imgsrc = (($this->ord != $fldname)? "sortno.gif" : (($this->desc)? "sort2.gif" : "sort1.gif"));
			
			if (($fldname == $this->idname) && ($this->show_id_field == false)) continue;
			
			$str .= "<th class=\"th\" id=\"th" . $fldname . "\">";
			$str .= "<div class=\"divth\" id=\"" . $id . "\" onclick=\"td_sort(this)\" title=\"Click to sort\">";
			$str .= $fldname;
			$str .= "<img src=\"" . $imgsrc . "\">";
			$str .= "</div>";
			$str .= "</th>\n";
		}
		$str .= "</tr>\n";
		
		//write javascript function for getting field types:
		$colresult = mysql_query("SHOW COLUMNS FROM " . $this->table . " FROM " . $this->db, $this->conn) or die(mysql_error());		
		$str .= "<script>function get_fldtype(fldname){\n";
		for($i=0; $i < mysql_num_rows($colresult); $i++)  {
			list($fldname, $fldtype, $fldnull, $fldkey, $flddefault, $fldextra) = mysql_fetch_row($colresult);	
			$str .= "if (fldname == \"$fldname\") return(\"$fldtype\");\n";
		}
		$str .= "return(\"\");}</script>\n";
		mysql_free_result($colresult);		
		
		//Rows:
		$c = 0;
		$s = $_REQUEST["s"];
		if ($s == "") $s = 0;
		if ($s[0] == 'l') $s = floor((mysql_num_rows($result)-1)/$this->pagelength);
		for (($i=$s*$this->pagelength) && mysql_data_seek($result, $i); $i < min(mysql_num_rows($result), ($s+1)*$this->pagelength) ; $i++)  {
			$row = mysql_fetch_array($result);
			$id = mysql_result($result, $i, $this->idname);
			$str .= "<tr id=\"row" . $id . "\">\n";
			
			if ($c++ % 2 == 0) 	$class = "tdeven";
						else	$class = "tdodd";
			
			if ($this->delete_allowed) $str .= "<td class=\"tddel\" >" . 
					"<img src=\"del.gif\" onclick=\"tr_del(this)\"" . "id=\"" . $id . "\"" . 
					"onmouseover=\"this.src='del2.gif'\" onmouseout=\"this.src='del.gif'\" title=\"Delete this row\"/>" . 
					"</td>\n";
			for($j=0; $j < mysql_num_fields($result); $j++)  {
				$fldname = mysql_fetch_field($result, $j)->name;
				if (($fldname == $this->idname) && ($this->show_id_field == false)) continue;
				$data = trim($row[$j]);
				$str .= "<td class=\"$class\"  " .
						(($this->update_allowed)? ("onclick=\"create_form(this.firstChild)\" title=\"Click to edit\"") : "" ) .
						">" .
						"<div class=\"divtd\" " .
						(($this->update_allowed)? ("id=\"" . $id .	"|" . $fldname . "\"") : "" ) .						
						">" .						
						$data .
						"</div>" .
						"</td>\n";
			}
			$str .= "</tr>\n";
		}
		//An extra row for adding records:
		if ($this->add_allowed) {
			$str .= "<tr>\n";	
			$str .= "<td>" .
				"<img src=\"add.gif\" onclick=\"tr_add(this)\"" . 
				"onmouseover=\"this.src='add2.gif'\" onmouseout=\"this.src='add.gif'\"" .
				"title=\"Add a new row\"/>" .
				"</td>\n";	
			$str .= "<td colspan='" . mysql_num_fields($result) . "'> </td>\n";
			$str .= "</tr>\n";
		}
		
		// Page pointers:
		if (mysql_num_rows($result) > $this->pagelength) {
			$str .= "<tr><td class=\"tdpp\" colspan='" . (mysql_num_fields($result)+1) . "' align='center'>\n";
			if ($s > 0)
				$str .= "<a href=\"" . $_SERVER["PHP_SELF"] . "?s=" . ($s-1) . "&ord=" . $this->ordstr . "\">" . "<" . "</a>\n";
			else
				$str .= "&nbsp;&nbsp;";
			for ($j=0; ($j*$this->pagelength) < mysql_num_rows($result); $j++) {
				if ($j == $s)
					$str .= ($j+1) . "&nbsp";
				else
					$str .= "<a href=\"" . $_SERVER["PHP_SELF"] . "?s=" . ($j) . "&ord=" . $this->ordstr . "\">" . ($j+1) . "</a>\n";
			}
			if ($s < $j-1)
				$str .= "<a href=\"" . $_SERVER["PHP_SELF"] . "?s=" . ($s+1) . "&ord=" . $this->ordstr . "\">" . ">" . "</a>\n";
			$str .= "</td></tr>\n";
		}

		//Close Table
		$str .=  "</table>\n";		
		$str .= "</div>\n";
		
		mysql_free_result($result);  
		return $str;
	}
	
	// Effectuate changes in database
	private function update_data(){
		$op    = $_REQUEST["op"];
		$id    = $_REQUEST["id"];
		$value = $_REQUEST["value"];
		list ($id1, $fld) = split('[|]', $id);
		$id1 = mysql_real_escape_string($id1);
		$fld = mysql_real_escape_string($fld);
		switch ($op) {
			case ("a") : if ($this->add_allowed) return($this->add()); else return(false);
			case ("d") : if ($this->delete_allowed) return($this->delete($id1)); else return(false);
			case ("u") : if ($this->update_allowed) return($this->update($id1, $fld, rawurldecode($value))); else return(0);
		}
		return(false);
	}
	
	protected function select(){
		$res = mysql_query("SELECT * FROM $this->table" . $this->orderbystr, $this->conn) or die(mysql_error());
		return ($res);
	}	
	protected function add(){
		mysql_query("INSERT INTO $this->table () VALUES()", $this->conn) or die(mysql_error());
		if (mysql_affected_rows($this->conn) == 1) return(true); else return(false);
	}
	private function exists($id, $fld = "") {
		$res = $this -> select();
		// check field
		if ($fld != "") {
			$found = false;
			while (($field = mysql_fetch_field($res)) != null) {
				if ($field->name == $fld) {
					$found = true;
					break;
				}
			}
			if (!$found) return(false);
		} 
		// check id
		for ($i=0; $i < mysql_num_rows($res); $i++)  {
			$row = mysql_fetch_array($res);
			if ($row[$this->idcolnr] == $id) return(true);
		}
		return(false);
	}	
	private function delete($id){
		if (!$this->exists($id)) return(false);
		mysql_query("DELETE FROM $this->table WHERE $this->idname='$id'", $this->conn) or die(mysql_error());
		if (mysql_affected_rows($this->conn) == 1) return(true); else return(false);
	}
	private function update($id, $fld, $value){
		if ($this->exists($id, $fld)) {
			mysql_query("UPDATE $this->table SET $fld='$value' WHERE $this->idname='$id'", $this->conn) or die(mysql_error());
			if (mysql_affected_rows($this->conn) == 1) { 
				$res = mysql_query("SELECT $fld FROM $this->table WHERE $this->idname='$id'", $this->conn) or die(mysql_error());
				$row = mysql_fetch_array($res);
				return("1" . rawurlencode($row[0]));
			}
		}
		return("0");
	}
	
	// Do the sorting
	private function do_orderby(){
		if ($_REQUEST["ord"] != "") 
			$this->ordstr = mysql_real_escape_string($_REQUEST["ord"]);
		else
			$this->ordstr = $this->idname;
		list ($this->ord, $this->desc) = split('[,]', $this->ordstr);
		if ($this->ord)  $this->orderbystr = " ORDER BY " . $this->ord;
		if ($this->desc) $this->orderbystr .= " DESC";
	}	
}
?>
