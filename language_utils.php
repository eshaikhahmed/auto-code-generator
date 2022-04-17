<?php

function getRelatedDatatoPage($totalrow=0,$lang='',$type='', $feature_name='User')
{
    $seq=0 ;//is to get values sequence wise
    $seqvalue=0;//is the value of every sequene
    $data= []; //	All the related data that we want to print will come into this variable

    if($lang=='Springboot' && $type=='CRUD APIs') {
        $tableName = $feature_name;
        $filename_entity = "input/springboot/entity.txt";
        $filename_repository = "input/springboot/repository.txt";
        $filename_service = "input/springboot/service.txt";
        $filename_controller = "input/springboot/controller.txt";
        $filename_response = "input/springboot/response.txt";

        $entity_class = getModifiedContent($filename_entity, $totalrow, $tableName);
        $repository_class = getModifiedContent($filename_repository, $totalrow, $tableName);
        $service_class = getModifiedContent($filename_service, $totalrow, $tableName);
        $controller_class = getModifiedContent($filename_controller, $totalrow, $tableName);
        $response_class = getModifiedContent($filename_response, $totalrow, $tableName);
                //echo $replaced_repeater_content;
        //$modified_content = replace_all_text_between($content, 'LOOP_START', 'LOOP_END', $replaced_repeater_content);
        //echo $modified_content;
        $data[] = array('data'=> $entity_class, 'filename'=> $tableName."Entity");
        $data[] = array('data'=> $repository_class, 'filename'=> $tableName."Repository");
        $data[] = array('data'=> $service_class, 'filename'=> $tableName."Service");
        $data[] = array('data'=> $controller_class, 'filename'=> $tableName."Controller");
        $data[] = array('data'=> $response_class, 'filename'=> $tableName."Response");
    }

    return $data;
}
		
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

function replace_all_text_between($str, $start, $end, $replacement) {

    echo $replacement;
    $link = $str;
    $newText = $replacement;
    $result = preg_replace('/(%'.$start.'.*?%).*?(%'.$end.'%)/', '$1'.$newText.'$2', $link);

    $find = '~%'.$start.'%.*?%'.$end.'%~';
    echo preg_replace($find, $newText, $str);

    //echo $result;
    return $result;
    // $replacement = $start . $replacement . $end;

    // $start = preg_quote($start, '/');
    // $end = preg_quote($end, '/');
    // $regex = "/({$start})(.*?)({$end})/";

    // return preg_replace($regex,$replacement,$str);
}


function getModifiedContent($filename, $totalrow, $tableName){
    $seq = 0 ;//is to get values sequence wise
    $seqvalue = 0;//is the value of every sequene

    $fp = fopen($filename, "r");
        
    $content = fread($fp, filesize($filename));
    $lines = explode("\n", $content);
    fclose($fp);

    $repeater = get_string_between($content, '%LOOP_START%', '%LOOP_END%');
    
    $replaced_repeater_content = '';
    for($i=0; $i < $totalrow; $i++) {	
        $seq = $seq + 1;
    
        
        if(isset($_REQUEST['deltedstatus'.$seq]) && $_REQUEST['deltedstatus'.$seq]!='D') {
            $variableValue = $_REQUEST['variable'.$seq];
            $cameCaseVariable = $variableValue;
            if (strpos($variableValue, '_') !== false) { 
                $cameCaseVariable = explode("_",$variableValue)[0]."".ucfirst(explode("_",$variableValue)[1]);
            }
            
            $replaced_repeater_content = $replaced_repeater_content."".str_replace("%REPEAT_SAME_VALUE%", $variableValue, $repeater)."\n";
            $replaced_repeater_content = str_replace("%REPEAT_CAMELCASE_VALUE%", $cameCaseVariable, $replaced_repeater_content);

        }
    }
    
    $modified_content = str_replace($repeater, $replaced_repeater_content, $content);
    $modified_content = str_replace('%LOOP_START%', "", $modified_content);
    $modified_content = str_replace('%LOOP_END%', "", $modified_content);
    $modified_content = str_replace("%CLASSNAME%", ucfirst($tableName), $modified_content);
    $modified_content = str_replace("%CLASSNAME_SMALLCASE%", strtolower($tableName), $modified_content);

    return $modified_content;
}
?>