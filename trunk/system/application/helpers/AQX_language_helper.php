<?php
	function lang($line, $id = ''){
		$CI =& get_instance();
		$linet = $CI->lang->line($line);
    if (strlen($linet) == 0){
      //$linet = 'NT:'.$line;
      $linet = $line;
    }

		if ($id != ''){
			$linet = '<label for="'.$id.'">'.$linet."</label>";
		}

		return $linet;
	}?>
