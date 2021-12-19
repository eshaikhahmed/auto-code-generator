<?php


function getData($totalrow=0, $lang='', $type='')
{
		$seq=0 ;//is to get values sequence wise
		$seqvalue=0;//is the value of every sequene
		$data=''; //	All the related data that we want to print will come into this variable

		
	if($type=='Simple Form')
	{	

		// $data .= "for(\$k=0;\$k<\$total_rows;\$k++)<br>";
		$data .= "{<br><div class='syntax'><code>";
		$saveData = "";
		$controllerData = " <br><div class='syntax'><p>Controller Code</p><pre><code>
&lt;?php
namespace App\Controllers;

use CodeIgnitor\Controller;
use App\Models\MapDataModel;

class MapData extends BaseController {
    public \$model;
    public function __constructor(){
        \$model = new MapDataModel();
        helper(['form', 'url']);
    }
	public function add(){
        \$data = [];
        \$data['page_title'] = 'Add Map List';
        if(\$this->request->getMethod() == 'post') {
            \$this->model->save([
				{{_SAVE_DATA_}}
            ]);
        }
        return view('admin/mapdata/add', \$data);
    }
}
</code></pre></div>
";	
	$modelData = "<br><div class='syntax'><p>Model Code</p><pre><code>
	&lt;?php
	namespace App\Models;
	
	use CodeIgniter\Model;
	
	class MapDataModel extends Model
	{
		protected \$table = 'map_data';
		protected \$primaryKey = 'id';
	
		protected \$useAutoIncrement = true;
		protected \$allowedFields = [{{MODEL_DATA}}];
	}
	</code></pre></div>
	";
	$modelReplacer = "";
		for($i=0;$i<$totalrow;$i++)
		{	
			$seq=$seq+1;
			if(isset($_REQUEST['deltedstatus'.$seq]) && $_REQUEST['deltedstatus'.$seq]!='D')
			{
				$seqvalue=$_REQUEST['variable'.$seq];
				//$data.="\$".$seqvalue."=mysql_result(\$result,\$k,'".$seqvalue."');<br>"	;
				$data.=' 
				&lt;div class="form-group"&gt; <br>
					&lt;label for="exampleInputName1"&gt;'.$seqvalue.'&lt;/label&gt; <br>
					&lt;input type="text" class="form-control" id="'.$seqvalue.'"  name="'.$seqvalue.'" placeholder="'.$seqvalue.'"&gt; <br>
				&lt;/div&gt;

				<br>';
				$saveData.="'".$seqvalue."' => \$this->request->getPost('".$seqvalue."'), <br>";
				$modelReplacer.= "'$seqvalue',";							
			}//End inner if
		} //End For Loop

		$controllerData = str_replace("{{_SAVE_DATA_}}", $saveData, $controllerData);
		$modelData =  str_replace("{{MODEL_DATA}}", $modelReplacer, $modelData);
		$data.= "</code></div>}";
		$data.= $controllerData;
		$data.= $modelData;
	
	}


	
	
	return $data;
	
}

?>