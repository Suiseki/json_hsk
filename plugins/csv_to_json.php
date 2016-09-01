<?php 
/**
* 2016
* csv to json example
* This source file was created to help converting 
* lists of words and phrases provided by http://english.hanban.org/  
* for Chinese HSK exams.
*/


/**
 * convert_scv_to_array
 *
 * function gets csv file contents and puts each row into array
 * all converted rows are part of agregation array.
 * Depending on second argument you get all rows or certain number of rows
 *
 * @param (string) ($_file_handler) csv file contents
 * @param (boolean) ($rows_to_convert) rows to parse, if parameter not provided, 
 ** all rows would be iterated
 * @return (array) 
 */
function convert_scv_to_array ($_file_handler, $rows_to_convert = false) {

	$_agregate_array = array();
	$prop_names = array ('item_id', 'hsk', 'characters', 'pron', 'translation');
	if (!$rows_to_convert) {

		$i = 0;
		while(!feof($_file_handler)){
			$j = 0;
			$single_data_item = fgetcsv($_file_handler, '', ',');
			foreach ($prop_names as $pr_val) {
				$_agregate_array['glossary']['items'][$i][$pr_val] = $single_data_item[$j];
				$j++;
		}
		$i++;

		}
	} else {
		//if items number is set, function iterates given number of times
		for($i=0; $i<=$rows_to_convert; $i++) {
			$single_data_item = fgetcsv($_file_handler, '', ',');
			$j = 0;
			foreach ($prop_names as $pr_val) {
				$_agregate_array['glossary']['items'][$i][$pr_val] = $single_data_item[$j];
				$j++;
			}
		}
		
	}
		return $_agregate_array;


}

$file_handler = fopen('../files/hsk4.csv', 'r');
$agregate_array = convert_scv_to_array($file_handler, false);
fclose($file_handler);

$manage = json_encode($agregate_array, JSON_UNESCAPED_UNICODE);

$fp = fopen('../data/hsk'.date('Ymd').'.json', 'wb');
fwrite($fp, "\xEF\xBB\xBF".$manage);
fclose($fp);

?>