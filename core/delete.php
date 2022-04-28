<?
	session_start();
	if (isset($_GET['id'])) {
		$ret = [];

		if($_GET['_csrf']!=$_SESSION['_csrf']){
            $ret += ['errors' => "1"];
            $ret += ['message' => "Prohibited request"];
            $ret += ['_csrf' => $_SESSION['_csrf']];
		}
		else{
			$_SESSION['_csrf'] = md5(time());
			require '../model.php';
			$id = filter($_GET['id']);
			$table = filter($_GET['table']);
			 
			$fetch = Functions::delete($table,$id);
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
		echo json_encode($ret);
	}
?>