<?php 
/**
* 2016
* csv to json example
* This source file was created to help converting 
* lists of words and phrases provided by http://english.hanban.org/  
* for Chinese HSK exams.
*/


/**
 * transfer_scv_to_array
 *
 * function gets csv file contents and puts each row into array
 * all rows are part of agregation array.
 * Depending on secodn argument you get all rows or certain amount of rows
 *
 * @param (string) ($_file_handler) csv file contents
 * @param (boolean) ($items_no) rows to parse, if parameten not provided, 
 ** all rows would be iterated
 * @return (array) 
 */
function transfer_scv_to_array ($_file_handler, $items_no = false) {

	$_agregate_array = array();
	$prop_names = array ('item_id', 'hsk', 'characters', 'pron', 'translation');
	if (!$items_no) {
		//dopisać przypadek, gdy nie podano liczby wierszy
		$i = 0;
		while(!feof($_file_handler)){
			$j = 0;
			$single_data_item = fgetcsv($_file_handler, '', ',');
			foreach ($prop_names as $pr_val) {
				$_agregate_array['glossary']['items'][$i][$pr_val] = $single_data_item[$j];
				$j++;
		}
		$i++;
		//echo ('i='.$i.' '.'j='.$j.'<br>');
			// array_push($_agregate_array, $single_data_item);
		}
	} else {
		//if items number is stet function iterates given amount of times
		for($i=0; $i<=$items_no; $i++) {
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
$agregate_array = transfer_scv_to_array($file_handler, false);
fclose($file_handler);

$manage = json_encode($agregate_array, JSON_UNESCAPED_UNICODE);

echo $manage;

?>