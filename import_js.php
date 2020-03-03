<?php
include_once('template.php');
function makeslug($titlekey) {
	$titlekey = trim(strtolower($titlekey));
	$titlekey = str_replace(',', '', $titlekey);
	$titlekey = str_replace('"', '', $titlekey);
	$titlekey = str_replace('|', '', $titlekey);
	$titlekey = str_replace("'", '', $titlekey);
	$titlekey = str_replace(' ', '_', $titlekey);
	return $titlekey;
}
$row = 0;
$rowindex = 0;
$maindata = array();
$mainfinaldata = array();
if (($handle = fopen("occupations by state short.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		if($row > 0) {
			for ($c=0; $c < count($data); $c++) {
				$maindata[$rowindex]['area'] = $data[0];
				$maindata[$rowindex]['area_title'] = $data[1];
				$maindata[$rowindex]['occ_code'] = $data[2];
				$maindata[$rowindex]['occ_title'] = $data[3];
				$maindata[$rowindex]['occ_title_slug'] = makeslug($data[3]);
				$maindata[$rowindex]['tot_emp'] = str_replace(',', '', $data[4]);
				$maindata[$rowindex]['loc_quotient'] = str_replace(',', '', $data[5]);
				$maindata[$rowindex]['h_mean'] = str_replace(',', '', $data[6]);
				$maindata[$rowindex]['a_mean'] = str_replace(',', '', $data[7]);
			}
			$rowindex++;
		}
		$row++;
    }
	if(count($maindata) > 0) {
		foreach($maindata as $maindatakey=>$maindataval) {
			$mainfinaldata[$maindataval['occ_title_slug']]['tot_emp'][$maindataval['area_title']] = $maindataval['tot_emp'];
			$mainfinaldata[$maindataval['occ_title_slug']]['loc_quotient'][$maindataval['area_title']] = $maindataval['loc_quotient'];
			$mainfinaldata[$maindataval['occ_title_slug']]['h_mean'][$maindataval['area_title']] = $maindataval['h_mean'];
			$mainfinaldata[$maindataval['occ_title_slug']]['a_mean'][$maindataval['area_title']] = $maindataval['a_mean'];
		}
	}
	if(count($mainfinaldata) > 0) {
		$output = '';
		foreach($mainfinaldata as $okey=>$oval) {
			foreach($oval as $vkey=>$vval) {
				$ntemplate = str_replace('[variable]', $okey.'__'.$vkey, $template);
				$ntemplate = str_replace('density', $vkey, $ntemplate);
				foreach($vval as $vvkey=>$vvval) {
					$ntemplate = str_replace('['.$vvkey.']', $vvval, $ntemplate);
				}
				$output .= $ntemplate;
			}
		}
		$fp = fopen('us-states.js', 'w');
		fwrite($fp, $output);
		fclose($fp);
	}
}
?>