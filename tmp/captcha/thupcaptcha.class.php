<?php
/*
Author: Thupten Choephel
Date: Jan 26, 2012
A simple captcha class. You make your own captcha images. Then create a csv file that contains the "image_name, solution" format. This class checks user input with the csv.
*/
class ThupCaptcha{
	private $filepath;
	
	function __construct(){
		$this->debug('constructor');
		$this->filepath = '';
	}
	
	private function debug($msg){
	 //  echo '<pre style="color:red">'.$msg."\n".'</pre>';
	}
	public function setPathToCsvFile($path){
		$this->debug('setPathToCsvFile');
		$this->filepath = $path;
	}
	
	public function getRandomImage(){
		$files = $this->find_all_files('forms/captcha/images');
		if($files == false){ die('Error: image folder not found');}
		$randomNumber = rand (2 , count($files)-1);
		return $files[$randomNumber];
	}
	
	private function find_all_files($dir){ 
		$root = scandir($dir); 
		foreach($root as $value) 
		{ 
			if($value === '.' || $value === '..'||$value === 'index.html') {continue;} 
			if(is_file("$dir/$value")) {$result[]="$dir/$value";continue;} 
			foreach(find_all_files("$dir/$value") as $value) 
			{ 
				$result[]=$value; 
			} 
		} 
		return $result; 
	}	 
	
	
	public function checkCaptcha($userinput, $img_filename){
		$userinputValidated = strtolower($userinput);
		$this->debug('checkCaptcha'.$userinputValidated.'  '.$img_filename);
		$success = false;
		if($this->filepath != ''){
			if($img_filename){
				$solution = $this->getSolution($img_filename);
				$this->debug($solution);
			} else { die('image filename is null');}
		} else { die('Error: file path is null. use setPathToCsvFile method before checkCaptcha method');}
		
		if(($solution)&&($solution == $userinputValidated)){
			$success = true;
		}
		return $success;
	}
	
	private function getSolution($img_filename){
		$solution = false;
		$filename = basename($img_filename);
		if (($handle = fopen($this->filepath, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$row++;
				$num = count($data);
				for ($c=0; $c < $num; $c++) {
					if($data[$c] == $filename){
						$solution = $data[$c+1];
					}
				}
			}
		fclose($handle);
		}
		return $solution;
	}	
}
?>