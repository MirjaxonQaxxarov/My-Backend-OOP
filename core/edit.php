<?php 
session_start();
$ret= [];
if($_POST['_csrf']!=$_SESSION['_csrf']){
	$ret += ['errors' => "1"];
	$ret += ['message' => "Prohibited request"];
	$ret += ['_csrf' => $_SESSION['_csrf']];
}
else{
	$real = intval($_GET['number']/$_SESSION['keyuser']);
	$number = -1;
	$s1 = "";
	foreach ($_POST as $key => $value){
		$number++;
	}
	foreach ($_FILES as $key => $value){
		$number++;
	}

	if (true) {
		$table = str_rot13($_GET['table']);
		$obj = [];
		require_once '../models/model.php';
		foreach ($_POST as $key => $value){
			if ($key != '_csrf') {
				if (strlen($value)>0) {
					$obj += [str_rot13(clean($key)) => filter($value)];
				}
				
			}
		}
		foreach ($_FILES as $key => $value){
			
			  $file='';
			  if (isset($value)) {
		    $target_dir="FOLDER_PATH".str_rot13(clean($key))."/";
		    $y=md5(time());
		    $tip = strtolower(pathinfo($value["name"],PATHINFO_EXTENSION));
		    $value["name"]=str_rot13(clean($key))."_".$y.".".$tip;
		    $target_file=$target_dir.basename($value["name"]);
			if (move_uploaded_file($value["tmp_name"], $target_file))
				$file=$value["name"];
			}

			if(strlen($file)>1){
				$obj += [str_rot13(clean($key)) => filter($file)];
			}
 			
		}
		$fetch = Functions::edit($obj,$table);
			if ($fetch) {
			$ret += ['errors' => "0"];
			$ret += ['message' => "Information entered!"];
			$ret += ['_csrf' => $_SESSION['_csrf']];
			}
			else{
			$ret += ['errors' => "1"];
			$ret += ['message' => "There is a lack of information!"];
			$ret += ['_csrf' => $_SESSION['_csrf']];
			}
			
	}
	else{

		$ret += ['errors' => "$s1"];
		$ret += ['message' => "Not enough information!"];
		$ret += ['_csrf' => $_SESSION['_csrf']];
	}

		
}
echo json_encode($ret);
 ?>