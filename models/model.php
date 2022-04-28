<?php

    ////*****  MYSQL CONNECT begin *****\\\\
	$link = mysqli_connect("Host", "username", "Password", "DBName");

	if (!$link) {
	    echo "Error: Could not connect to MySQL !";
	    exit();
	}
	mysqli_set_charset($link, "utf8");
	function filter($s)  //This function filters the value of the data
	{
		$s = trim($s);
        $s = htmlspecialchars($s, ENT_QUOTES);
        $s = str_replace("'", "\'", $s);
        return $s;

	}


	function clean($string) { //This function filters the data key
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

		return preg_replace('/[^A-Za-z0-9_\-]/', '', $string); // Removes  special chars.
	 }
	////***** MYSQL CONNECT end *****\\\\


    class Functions 
    {   
        static function MyQuery($sql)
        {
            global $link;
            return mysqli_query($link,$sql);
        }

        /////////////////******************GETS******************\\\\\\\\\\\\\\\\\\
        // GET BY Conditional selection  BEGIN \\
        static function getByCond($table,$val)
        {
            return Functions::MyQuery("SELECT * FROM `$table` WHERE $val");
        }
        // GET BY Conditional selection  END \\

        // GET ID VALUE  BEGIN \\
        static function getById($table,$id)
        {
            return Functions::MyQuery("SELECT * FROM `$table` WHERE `id` = '$id'");
        }
        // GET ID VALUE  END \\

        // GET ALL  BEGIN \\
        static function getAll($table)
        {
            return Functions::MyQuery("SELECT * FROM `$table`");
        }
        // GET ALL  END \\


/////////////////******************GETS******************\\\\\\\\\\\\\\\\\\


  /////////////////******************ADD******************\\\\\\\\\\\\\\\\\\


        
        // ADDALL BEGIN \\
        static function add($arr,$table)
        {
            $query = "INSERT INTO `$table` ";
            $vname = "";
            $val = "";
            foreach ($arr as $key => $value) {
                $vname .= " `$key` ,";
                $val .= " '$value' ,";
            }
            $vname= rtrim($vname,",");
            $val= rtrim($val,",");
            $query.= "($vname) VALUES ($val); ";
            return Functions::MyQuery($query);
        }
        // ADDALL END \\


/////////////////******************ADD******************\\\\\\\\\\\\\\\\\\


  

/////////////////******************DELETES******************\\\\\\\\\\\\\\\\\\


	// DELETEALL BEGIN \\
	static function delete($table,$id)
	{
		return Functions::MyQuery("DELETE FROM `$table` WHERE `id` = '$id'");
	}
	// DELETEALL END \\


/////////////////******************DELETES******************\\\\\\\\\\\\\\\\\\





/////////////////******************UPDATES******************\\\\\\\\\\\\\\\\\\




	// EDITALL BEGIN \\
	static function edit($arr,$table)
	{

		$query = "UPDATE $table SET ";
		$vname = "";
		$id = "";
		foreach ($arr as $key => $value) {
			$value1 = $value;
			if($key == "id"){
				$id = $value1;
			}else{
				$vname .= " `$key` = '$value1' ,";
			}
		}
		$query.= rtrim($vname,",");
		$query.= " WHERE `id` = $id";
		return Functions::MyQuery($query);
	}
	// EDITALL END \\





/////////////////******************UPDATES******************\\\\\\\\\\\\\\\\\\




    }
    
?>