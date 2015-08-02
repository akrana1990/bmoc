<?php

	define('DB_SERVER', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASSWD', '');
	define('DB_NAME', 'bmoc');
	
	
	
	define('ADMIN_URL', 'http://localhost/bmoc/admin/');
	define('URL', 'http://localhost/bmoc/');
	define('IMAGEURL', 'http://localhost/bmoc/');
	define('Site_Admin_Name','http://localhost/bmoc/admin/');
	define('Site_Name', 'http://localhost/bmoc/');
	define('Admin_folder_Name', 'http://localhost/bmoc/admin/web');
	define('Admin_Path','<a href="../home.php" style="text-decoration: none;">Admin</a>
                             <span class="org_arrow"><b>&raquo;</b></span>');
	define('Site_Title', 'Brain Master');
	define('Admin_Site_Title', 'Brain Master :: Admin Panel');

	class DatabaseClass 
	{
		var $_dbhostName;
		var $_dbName;
		var $_dbUser;
		var $_dbPwd;
		var $_dbCon;

		function DatabaseClass ()
		{
			$this->_dbhostName = DB_SERVER;
			$this->_dbName = DB_NAME;
			$this->_dbUser = DB_USER;
			$this->_dbPwd = DB_PASSWD;	
			$this->dbOpen();
		}
		function dbOpen()
		{
			$this->_dbCon=mysql_connect($this->_dbhostName,$this->_dbUser,$this->_dbPwd) or die ("Could not connect DB");
			mysql_select_db($this->_dbName,$this->_dbCon) or die ("Could not select DatabaseClass");
		}
		function dbClose()
		{
			mysql_close($this->_dbCon);	
		}
		function getConn()
		{
			return $this->_dbCon;
		}
	}//DatabaseClass

	class SqlClass
	{
		var $_dbSql;
		var $_dbTotalRecord;
		var $_dbFields=array();	
		var $_objDatabaseClass;
		var $_dbNewID;		// This field will be used to get newly inserted id
		var $_dbAffectedRows;
		var $_dbfieldnames;
		var $_dbErrMsg;
		var $_fieldsname;
		var $_dbErr;	// Boolean
		var $_dbShowAdvanceError;	// Boolean

		function SqlClass()
		{
			$this->_dbSql="";
			$this->_fieldsname="";
			$this->_dbTotalRecord=NULL;
			$this->_dbNewID=NULL;
			$this->_dbAffectedRows=NULL;
			$this->_dbErr=false;
			$this->_dbShowAdvanceError=false;
			$this->_dbErrMsg="";
			$this->_objDatabaseClass=new DatabaseClass();
			
		}
		function executeSql($sql,$doubtedFields=0)
		{
			if(strtoupper(substr($sql,0,6))=="SELECT")
			{
				$Mode="Read";
			}
			else{
				$Mode="Write";
			}
			
			//$this->_objDatabaseClass->dbOpen();
			# To check Weather Doubted Fields are present or Not
			if(is_array($doubtedFields) && $doubtedFields!=0)
			{
				for($i=0; $i<count($doubtedFields); $i++)
				{
					if(strpos($sql,'?')!==false)
					{
						$start=substr($sql,0,strpos($sql,'?'));			
						$end=substr($sql,strpos($sql,'?')+1);
						$sql=$start.$this->sql_quote($doubtedFields[$i]).$end;
					}
				}
			}//end Doubted Field Check
			switch($Mode)
			{
				case "Read":
		
				$row=array();
			
				if($record=mysql_query($sql,$this->_objDatabaseClass->getConn()))
				{
					$this->_dbTotalRecord=mysql_num_rows($record);
					if($this->_dbTotalRecord>0)
					{
                        //$fieldsname="";
						for($i=0; $i<mysql_num_fields($record); $i++)
						{
							$this->fieldsname .= mysql_field_name($record,$i).",";
						}
						$this->_dbfieldnames = $this->fieldsname;
						$rawData=array();			
						
						while($row=mysql_fetch_array($record))
						{			
							foreach ($row as $fieldName => $fieldValue) 
							{
								$rawData["$fieldName"]=stripslashes($fieldValue);
							} 
							$this->_dbFields[]=$rawData;
						}
                		 mysql_free_result($record);
	
						#Reversing The Array Coz I need to Fetch Record below function Using POP built in function Function
						$this->_dbFields = array_reverse($this->_dbFields, true);	
						return $this->_dbFields;
					}
					else{
						$this->_dbErrMsg="<li>No Record Found</li>";
						$this->_dbErr=true;
						//$this->_objDatabaseClass->dbClose();	// DisConnecting From DB
						return true;				
					}
				}
				else{
					if($this->_dbShowAdvanceError)
					{
						$this->_dbErrMsg='<br><b style="color:#FF0000">Your Query is</b> <br> '.$sql.' <br><b style="color:#FF0000"> Mysql Says</b><br>'.mysql_error();
					}
					else{
						$this->_dbErrMsg="<li> A Problem Occur While Executing the Your Query</li>";
					}
					$this->_dbErr=true;
					$this->_objDatabaseClass->dbClose();	// DisConnecting From DB
					return false;
				}
			break;

			case "Write":
	
				if(mysql_query($sql,$this->_objDatabaseClass->getConn()))
				{
					$this->_dbNewID=mysql_insert_id($this->_objDatabaseClass->getConn());
					$this->_dbAffectedRows=mysql_affected_rows($this->_objDatabaseClass->getConn());
					$this->_dbErrMsg="Record Sucessfully Inserted";
					$this->_dbErr=true;
					$this->_objDatabaseClass->dbClose();	// DisConnecting From DB
					return true;
				}
				else{
					if($this->_dbShowAdvanceError)
					{
						$this->_dbErrMsg='<br><b style="color:#FF0000">Your Query is</b> <br> '.$sql.' <br><b style="color:#FF0000"> Mysql Says</b><br>'.mysql_error();
					}
					else{
						$this->_dbErrMsg="<li> A Problem Occur While Executing the Your Query</li>";
					}
					$this->_dbErr=true;
					$this->_objDatabaseClass->dbClose();	// DisConnecting From DB		
					return false;
				}
			break;
			}
		}
		function fetchRow(&$dbRows)
		{
			if(is_array($dbRows))
			{
				$returnValue = array_pop($dbRows);
				if(!is_null($returnValue))
				{					
					return $returnValue;
				}
				else{
					return false;
				}
			}
			else{
				$this->_dbErrMsg="0 Rows Found";
				$this->_dbErr=true;
				return false;
			}
		}
		function isError()
		{
			 return $this->_dbErr;
		}
		function getErrMsg()
		{
			 return $this->_dbErrMsg;
		}
		function feald_name()
		{
			return $this->_dbfieldnames;
		}
		function getNumRecord()
		{
			 return $this->_dbTotalRecord;
		}	
		function setAdvanceErr($value)
		{
			 $this->_dbShowAdvanceError=$value;
		}			
		function getNewID()
		{
			return $this->_dbNewID;
		}	
		function getAffectedRows()
		{
			return $this->_dbAffectedRows;
		}
		function sql_quote($value)
		{ 
			if( get_magic_quotes_gpc() )
			{ 
			  $value = stripslashes($value); 
			} 
			$link = mysql_connect(DB_SERVER, DB_USER, DB_PASSWD);
			//check if this function exists 
			if( function_exists( "mysql_real_escape_string" ) )
			{ 
				  $value = mysql_real_escape_string($value); 
			} 
			//for PHP version < 4.3.0 use addslashes 
			else { 
			  $value = addslashes($value); 
			} 
			return $value; 
		}
        //function to inputs inputs and get valuse
        //Ads by Ankit
        function cleanInput($string)
        {   //cleaning string to prevent XSS
            $string=trim($string);
            $string=strip_tags($string);
            return $string;
        }
        //function to sanitize inputs and get valuse

        //@Ankit
        function sanitize($input) {
            $output='';
            if (is_array($input)) {
                foreach($input as $var=>$val) {
                    $output[$var] = $this->sanitize($val);
                }
            }
            else
            {
                if (get_magic_quotes_gpc()) {
                    $input = stripslashes($input);
                }
                $input  = $this->cleanInput($input);
                $output = mysql_real_escape_string($input);
            }
            return $output;
        }
		
	}// SqlClass
	
	class Queries
	{
		/**************
		 makeinsertquery($table,$tab)
			$table = tablename;
			$tab is an array contains field names and those corsponding values
			Ex -> $tab = array("sid = 1","sname = name");
		**************/
		
		function makeinsertquery($table,$tab)
		{
			$query="insert into $table (";
			$ck=count($tab);
			
			for($i=0;$i<$ck;$i++)
			{
				$field=explode("=",$tab[$i]);
				$query.=$field[0].",";
			}
			$query=substr($query,0,strlen($query)-1);
			$query.=') values (';
			for($j=0;$j<$ck;$j++)
			{
				$value=explode("=",$tab[$j]);
				$query.="'".trim($value[1])."'".",";
			}
			$query=substr($query,0,strlen($query)-1);
			$query.=")";
			//echo $query;
			//exit;
			$objSql = new SqlClass();
			$res = $objSql->executeSql($query);
			return $res;
		}
		/**************
			 makeupdatequery($table,$tab,$where)
			$table = tablename;
			$tab is an array contains field names and those corsponding values
			Ex -> $tab = array("sid = 1","sname = name");
			where Condition
			Ex -> $where =  "sno = 1";
		 **************/
		function makeupdatequery($table,$tab,$where)
		{
			$query="update $table set ";
			$ck=count($tab);
			for($i=0;$i<$ck;$i++)
			{
				$attributes=explode("=",$tab[$i]);
				$query.=$attributes[0]."="."'".trim($attributes[1])."'".", ";
			}
			$query=substr($query,0,strlen($query)-2);
			if($where!="")
			{
				$query.=" where ";
				if(is_array($where))
				{
					$ck=count($where);
					for($i=0;$i<$ck;$i++)
					{
						$attributes=explode("=",$where[$i]);
		
						$query.=$attributes[0]."="."'".trim($attributes[1])."'";
						if($i+1!=$ck)
						{
							$query.=" and ";
						}					
					}					           
				}   
				else
				{	
					$arr=explode("=",$where);
					$query.=$arr[0]."=";
					$query.="'".trim($arr[1])."'";
				}       
			}
			//echo $query;
			//exit;
			$objSql = new SqlClass();
			$res = $objSql->executeSql($query);
			return $res;
		}
		function makeinsertquery_uploadfiles($table,$tab)
		{
		    $query="insert into $table (";
			$ck=count($tab);

			for($i=0;$i<$ck;$i++)
			{
				$field=explode("~!@",$tab[$i]);
				$query.=$field[0].",";
			}
			$query=substr($query,0,strlen($query)-1);
			$query.=') values (';
			for($j=0;$j<$ck;$j++)
			{
				
				$value=explode("~!@",$tab[$j]);

				$query.='"'.trim($value[1]).'"'.",";
			}
			$query=substr($query,0,strlen($query)-1);
			$query.=')';
			//echo $query."<br>";
			
			$objSql = new SqlClass();
			$res = $objSql->executeSql($query);
			return $res;
			
		}
		function makeupdatequery_uploadfiles($table,$tab,$where)
		{
			$query="update $table set ";
			$ck=count($tab);
			for($i=0;$i<$ck;$i++)
			{
				$attributes=explode("~!@",$tab[$i]);
				$query.=$attributes[0]."="."'".trim($attributes[1])."'".", ";
			}
			$query=substr($query,0,strlen($query)-2);
			if($where!="")
			{
				$query.=" where ";
				if(is_array($where))
				{
					$ck=count($where);
					for($i=0;$i<$ck;$i++)
					{
						$attributes=explode("=",$where[$i]);
		
						$query.=$attributes[0]."="."'".trim($attributes[1])."'";
						if($i+1!=$ck)
						{
							$query.=" and ";
						}					
					}					           
				}   
				else
				{	
					$arr=explode("=",$where);
					$query.=$arr[0]."=";
					$query.="'".trim($arr[1])."'";
				}       
			}
			$objSql = new SqlClass();
			$res = $objSql->executeSql($query);
			//echo $query; exit;
			return $res;
		}
		/***************/
		/* makedeletequery($table,$field,$value)
			$table = tablename;
			$field Table filed name
			Ex -> $field = 'sid';
			$value value
			Ex -> $value = 1;
			
		*/
		/***************/
		function makedeletequery($table,$field,$value)
		{
			$query="DELETE from ".$table." where ".$field."='".trim($value)."'";
			$objSql = new SqlClass();
			$res = $objSql->executeSql($query);
			return $res;
		}
	
		/***************/
		/* makeselectquery($table,$column,$field,$value)
			$table = tablename;
			$column Required field name
			Ex -> $column = 'firstname';
			$field Condation field name
			$field = "sid";
			$value value
			Ex -> $value = 1;
			
		*/
		/***************/
		function makeselectquery($table,$column,$field,$value)
		{
			$query="select ".$column." from ".$table." where ".$field."='".trim($value)."'";
			$objSql = new SqlClass();
			$res = $objSql->executeSql($query);
			$row = $objSql->fetchRow($res);
			$val = $row['0'];
			return $val;
		}
		/***************/
		/* makeselectallquery($table,$field,$value)
			$table = tablename;
			$field Condation field name
			$field = "sid";
			$value value
			Ex -> $value = 1;
			
		*/
		/***************/
		function makeselectallquery($table,$field,$value)
		{
			$query="select * from ".$table." where ".$field."='".trim($value)."'";
			$objSql = new SqlClass();
			$res = $objSql->executeSql($query);
			$row = $objSql->fetchRow($res);
			return $row;
		}
		function makeselectallvalues($table,$where='')
		{
			$query="select * from ".$table;
			if($where!="")
			{
				$query.=" where ";
				if(is_array($where))
				{
					$ck=count($where);
					for($i=0;$i<$ck;$i++)
					{
						$attributes=explode("=",$where[$i]);
		
						$query.=$attributes[0]."="."'".trim($attributes[1])."'";
						if($i+1!=$ck)
						{
							$query.=" and ";
						}					
					}					           
				}   
				else
				{	
					$arr=explode("=",$where);
					$query.=$arr[0]."=";
					$query.="'".trim($arr[1])."'";
				}       
			}
			
			$objSql = new SqlClass();
			$res = $objSql->executeSql($query);
			while($row = $objSql->fetchRow($res)){
			$rows[]=$row;
			}
			return $rows;
		}
		function makeselectallfields($table,$field,$value)
		{   
		    $rows=array();
			$query="select * from ".$table." where ".$field."='".trim($value)."'";
			//echo $query;
			$objSql = new SqlClass();
			$res = $objSql->executeSql($query);
			while($row = $objSql->fetchRow($res)){
			$rows[]=$row;
			}
			return $rows;
		}
		
		function makeselectall($table)
		{
			$query="select * from ".$table;
			$objSql = new SqlClass();
			$res = $objSql->executeSql($query);
			while($row = $objSql->fetchRow($res)){
			$rows[]=$row;
			}
			return $rows;
		}
		
		function makeselectall1($table)
		{
			$query="select * from ".$table." where debate_state='1'";			
			$objSql = new SqlClass();
			$res = $objSql->executeSql($query);
			while($row = $objSql->fetchRow($res)){
			$rows[]=$row;
			}
			return $rows;
		}
		function makeselectallas($table)
		{
			$query="select * from ".$table." WHERE status='active'";
			//echo $query;
			$objSql = new SqlClass();
			$res = $objSql->executeSql($query);
			while($row = $objSql->fetchRow($res)){
			$rows[]=$row;
			}
			return $rows;
		}
		//count
		function makecount($table,$field,$value)
		{
			$query="select count(".$field.") from ".$table." where ".$field."='".$value."'";
			//echo $query;
			$objSql = new SqlClass();
			$res = $objSql->executeSql($query);
			$row = $objSql->fetchRow($res);
			return $row;
		}
	}
	//Pagination
	class pagination 
	{
		var $fullresult;    // record set that contains whole result from database
		var $totalresult;   // Total number records in database
		var $query;         // User passed query
		var $resultPerPage; //Total records in each pages
		var $resultpage;	// Record set from each page
		var $pages;			// Total number of pages required
		var $openPage;		// currently opened page
		
	function createPaging($query,$resultPerPage) 
	{
		//Db Connection for pagination
		mysql_connect (DB_SERVER, DB_USER, DB_PASSWD, DB_NAME,$bPersistant=TRUE) or die ("unable to connect to database");
		mysql_select_db(DB_NAME) or die ("unable to select DB");
		$this->query		=	$query;
		$this->resultPerPage=	$resultPerPage;
		$this->fullresult	=	mysql_query($this->query);
		$this->totalresult	=	mysql_num_rows($this->fullresult);
		$this->pages		=	$this->findPages($this->totalresult,$this->resultPerPage);
		if(isset($_GET['page']) && $_GET['page']>0) {
			$this->openPage	=	$_GET['page'];
			if($this->openPage > $this->pages) {
				$this->openPage	=	1;
			}
			$start	=	$this->openPage*$this->resultPerPage-$this->resultPerPage;
			$end	=	$this->resultPerPage;
			$this->query.=	" LIMIT $start,$end";
		}
		elseif($_GET['page']>$this->pages) {
			$start	=	$this->pages;
			$end	=	$this->resultPerPage;
			$this->query.=	" LIMIT $start,$end";
		}
		else {
			$this->openPage	=	1;
			$this->query .=	" LIMIT 0,$this->resultPerPage";
		}
		$this->resultpage =	mysql_query($this->query);
	}

	function findPages($total,$perpage) 
	{
		$pages	=	intval($total/$perpage);
		if($total%$perpage > 0) $pages++;
		return $pages;
	}
	
/*
function to display the pagination
*/
	function totalrecords()
	{
		if($_GET['page']=='')
		$page_no='1';
		else
		$page_no=$_GET['page'];
		$f='<span class="poll_bg1">Page '.$page_no.' of '.$this->pages.'</span>    ';
		return $f; 
	}
	function displayPaging() 
	{
		$self	=	$_SERVER['PHP_SELF'];
		if($this->openPage<=0) {
			$next	=	2;
		}

		else {
			$next	=	$this->openPage+1;
		}
		$prev	=	$this->openPage-1;
		$last	=	$this->pages;

		if($this->openPage > 1) {
			//echo"<a href=$self?option=".$_GET['option']."&page=1 class = 'more_news'>First</a>&nbsp&nbsp;";
			//echo "<a href=$self?option=".$_GET['option']."&page=$prev class = 'more_news'>Prev</a>&nbsp&nbsp;";
		}
		else {
			//echo "First&nbsp&nbsp;";
			//echo "Prev&nbsp&nbsp;";
		}
	$ff="";
		for($i=1;$i<=$this->pages;$i++) {
			if($i == $this->openPage) 
				$ff.="<span class='poll_bg'>$i</span>&nbsp&nbsp;";
			else
				//echo "<input type='button' value='$i' onclick='poll_page($i)' />";
				 $ff.="<a onclick='poll_page($i)' style='cursor:pointer' class ='poll_bg1'>$i</a>&nbsp&nbsp;";
		}
		
		if($this->openPage < $this->pages) {
			//echo "<a href=$self?option=".$_GET['option']."&page=$next class = 'more_news'>Next</a>&nbsp&nbsp;";
			//echo "<a href=$self?option=".$_GET['option']."&page=$last class = 'more_news'>Last</a>&nbsp&nbsp;";
		}
		else {
			//echo "<span>Next&nbsp&nbsp;</span>";
			//echo "Last&nbsp&nbsp;";
		}return $ff;	
	}
}
//Pagination
    class pagination_ise
    {
       
	    var $fullresult;    // record set that contains whole result from database
        var $totalresult;   // Total number records in database
        var $query;         // User passed query
        var $resultPerPage; //Total records in each pages
        var $resultpage;    // Record set from each page
        var $pages;            // Total number of pages required
        var $openPage;        // currently opened page
       
    function createPaging($query,$resultPerPage)
    {
        //Db Connection for pagination
        mysql_connect (DB_SERVER, DB_USER, DB_PASSWD, DB_NAME,$bPersistant=TRUE) or die ("unable to connect to database");
        mysql_select_db(DB_NAME) or die ("unable to select DB");
        $this->query        =    $query;
        $this->resultPerPage=    $resultPerPage;
        $this->fullresult    =    mysql_query($this->query);
        $this->totalresult    =    mysql_num_rows($this->fullresult);
        $this->pages        =    $this->findPages($this->totalresult,$this->resultPerPage);
        if(isset($_GET['page']) && $_GET['page']>0) {
            $this->openPage    =    $_GET['page'];
            if($this->openPage > $this->pages) {
                $this->openPage    =    1;
            }
            $start    =    $this->openPage*$this->resultPerPage-$this->resultPerPage;
            $end    =    $this->resultPerPage;
            $this->query.=    " LIMIT $start,$end";
        }
        elseif($_GET['page']>$this->pages) {
            $start    =    $this->pages;
            $end    =    $this->resultPerPage;
            $this->query.=    " LIMIT $start,$end";
        }
        else {
            $this->openPage    =    1;
            $this->query .=    " LIMIT 0,$this->resultPerPage";
        }
        $this->resultpage =    mysql_query($this->query);
    }

    function findPages($total,$perpage)
    {
        $pages    =    intval($total/$perpage);
        if($total%$perpage > 0) $pages++;
        return $pages;
    }
   
/*
function to display the pagination
*/
    function totalrecords()
    {
        if($_GET['page']=='')
        $page_no='1';
        else
        $page_no=$_GET['page'];
       // $f='<span class="poll_bg">Page '.$page_no.' of '.$this->pages.'</span>    ';
	   $f='';
       return $f;
    }
    function displayPaging($al='')
    {
        $self    =    $_SERVER['PHP_SELF'];
        if($this->openPage<=0) {
            $next    =    2;
        }
        else {
            $next    =    $this->openPage+1;
        }
        $prev    =    $this->openPage-1;
        $last    =    $this->pages;

       
	    $dis_min = intval($this->openPage - 5); 
		$dis_max = intval($this->openPage + 5);		
		
		if($dis_max > $this->pages) { $dis_max = $this->pages; $dis_min = ($this->pages - 10); }
		if($dis_min < 1) { $dis_min = 1; $dis_max = 10; }

	   //$out.='<div class="pagination">';
	   
	    if($this->openPage > 1) {
            if($dis_min > 1)
			{
				//$out.="<a href=$self?option=".$_GET['option']."&page=1 class = 'more_news'>First</a>&nbsp&nbsp;";
				//$out.= "<span class='poll_bg1'>...</span>&nbsp&nbsp;";
			}
           // echo "<a href=$self?option=".$_GET['option']."&page=$prev class = 'more_news'>Prev</a>&nbsp&nbsp;";
        }
        else {
            //echo "First&nbsp&nbsp;";
            //echo "Prev&nbsp&nbsp;";
        }
		
				
		
		
       for($i=$dis_min;$i<=$dis_max;$i++) 
		{
			if(($i >=1) && ($i <= $this->pages))	
			{	
				if($i == $this->openPage) $out.= "<a href=$self?option=".$_GET['option']."&page=$i&al=$al style='cursor:pointer' class='active'>$i</a>&nbsp&nbsp;";
				else 
				{				
					$out.= "<a href=$self?option=".$_GET['option']."&page=$i&al=$al style='cursor:pointer' >$i</a>&nbsp&nbsp;";
				}
			}	
        }		
		

        if($this->openPage < $this->pages) {
            //echo "<a href=$self?option=".$_GET['option']."&page=$next class = 'more_news'>Next</a>&nbsp&nbsp;";
            if($dis_max < $this->pages) 
			{
				$out.= "<span class='poll_bg1'>...</span>&nbsp&nbsp;";
				$out.= "<a href=$self?option=".$_GET['option']."&page=$last&al=$al >Last</a>&nbsp&nbsp;";
			}	
        }
        else {
           // echo "<span>Next&nbsp&nbsp;</span>";
            //echo "Last&nbsp&nbsp;";
        }  
		//$out.='</div> ';
		return $out; 
    }
	}
	
	
	
	
	//Pagination
    class pagination_isechapter
    {
       
	    var $fullresult;    // record set that contains whole result from database
        var $totalresult;   // Total number records in database
        var $query;         // User passed query
        var $resultPerPage; //Total records in each pages
        var $resultpage;    // Record set from each page
        var $pages;            // Total number of pages required
        var $openPage;        // currently opened page
        var $gid;
		var $sid;
    function createPagingchapter($query,$resultPerPage,$gid,$sid)
    {
	       //Db Connection for pagination
        mysql_connect (DB_SERVER, DB_USER, DB_PASSWD, DB_NAME,$bPersistant=TRUE) or die ("unable to connect to database");
        mysql_select_db(DB_NAME) or die ("unable to select DB");
        $this->query        =    $query;
        $this->resultPerPage=    $resultPerPage;
		$this->gid=$gid;
		$this->sid=$sid;
		echo $this->gid;
		echo $this->sid;
        $this->fullresult    =    mysql_query($this->query);
        $this->totalresult    =    mysql_num_rows($this->fullresult);
        $this->pages        =    $this->findPages($this->totalresult,$this->resultPerPage);
        if(isset($_GET['page']) && $_GET['page']>0) {
            $this->openPage    =    $_GET['page'];
            if($this->openPage > $this->pages) {
                $this->openPage    =    1;
            }
            $start    =    $this->openPage*$this->resultPerPage-$this->resultPerPage;
            $end    =    $this->resultPerPage;
            $this->query.=    " LIMIT $start,$end";
        }
        elseif($_GET['page']>$this->pages) {
            $start    =    $this->pages;
            $end    =    $this->resultPerPage;
            $this->query.=    " LIMIT $start,$end";
        }
        else {
            $this->openPage    =    1;
            $this->query .=    " LIMIT 0,$this->resultPerPage";
        }
        $this->resultpage =    mysql_query($this->query);
    }

    function findPages($total,$perpage)
    {
        $pages    =    intval($total/$perpage);
        if($total%$perpage > 0) $pages++;
        return $pages;
    }
   
/*
function to display the pagination
*/
    function totalrecords()
    {
        if($_GET['page']=='')
        $page_no='1';
        else
        $page_no=$_GET['page'];
        $f='<span class="poll_bg">Page '.$page_no.' of '.$this->pages.'</span>    ';
       return  $f;
    }
    function displayPaging($gid,$sid)
    {
        $self    =    $_SERVER['PHP_SELF'];
        if($this->openPage<=0) {
            $next    =    2;
        }
        else {
            $next    =    $this->openPage+1;
        }
        $prev    =    $this->openPage-1;
        $last    =    $this->pages;

        if($this->openPage > 1) {
            //echo"<a href=$self?option=".$_GET['option']."&page=1 class = 'more_news'>First</a>&nbsp&nbsp;";
           // echo "<a href=$self?option=".$_GET['option']."&page=$prev class = 'more_news'>Prev</a>&nbsp&nbsp;";
        }
        else {
            //echo "First&nbsp&nbsp;";
            //echo "Prev&nbsp&nbsp;";
        }
        for($i=1;$i<=$this->pages;$i++) {
            if($i == $this->openPage)
               return "<span class='poll_bg1'>$i</span>&nbsp&nbsp;";
            else
                return "<a href=$self?option=".$_GET['option']."&gid=".$gid."&sid=".$sid."&page=$i style='cursor:pointer' class ='poll_bg'>$i</a>&nbsp&nbsp;";
        }
        if($this->openPage < $this->pages) {
            //echo "<a href=$self?option=".$_GET['option']."&page=$next class = 'more_news'>Next</a>&nbsp&nbsp;";
           // echo "<a href=$self?option=".$_GET['option']."&page=$last class = 'more_news'>Last</a>&nbsp&nbsp;";
        }
        else {
           // echo "<span>Next&nbsp&nbsp;</span>";
            //echo "Last&nbsp&nbsp;";
        }   
    }
	}
	
	class pagination_key
    {
       
	    var $fullresult;    // record set that contains whole result from database
        var $totalresult;   // Total number records in database
        var $query;         // User passed query
        var $resultPerPage; //Total records in each pages
        var $resultpage;    // Record set from each page
        var $pages;            // Total number of pages required
        var $openPage;        // currently opened page
       var $argument;
	   
     function createPaging($query,$resultPerPage)
    {
        //Db Connection for pagination
        mysql_connect (DB_SERVER, DB_USER, DB_PASSWD, DB_NAME,$bPersistant=TRUE) or die ("unable to connect to database");
        mysql_select_db(DB_NAME) or die ("unable to select DB");
        $this->query        =    $query;
        $this->resultPerPage=    $resultPerPage;
        $this->fullresult    =    mysql_query($this->query);
        $this->totalresult    =    mysql_num_rows($this->fullresult);
        $this->pages        =    $this->findPages($this->totalresult,$this->resultPerPage);
		$this->arguement = $arg;
        if(isset($_GET['page']) && $_GET['page']>0) {
            $this->openPage    =    $_GET['page'];
            if($this->openPage > $this->pages) {
                $this->openPage    =    1;
            }
            $start    =    $this->openPage*$this->resultPerPage-$this->resultPerPage;
            $end    =    $this->resultPerPage;
            $this->query.=    " LIMIT $start,$end";
        }
        elseif($_GET['page']>$this->pages) {
            $start    =    $this->pages;
            $end    =    $this->resultPerPage;
            $this->query.=    " LIMIT $start,$end";
        }
        else {
            $this->openPage    =    1;
            $this->query .=    " LIMIT 0,$this->resultPerPage";
        }
		//echo $this->query ;
        $this->resultpage =    mysql_query($this->query);
    }
	
	
	function recordsize()
	{return $this->totalresult;
	}

    function findPages($total,$perpage)
    {
        $pages    =    intval($total/$perpage);
        if($total%$perpage > 0) $pages++;
        return $pages;
    }
   
/*
function to display the pagination
*/
    function totalrecords()
    {
        if($_GET['page']=='')
        $page_no='1';
        else
        $page_no=$_GET['page'];
        $f='<span class="page_bg1">Page '.$page_no.' of '.$this->pages.'</span>    ';
        return $f;
    }
    function displayPaging()
    {
        $self    =    $_SERVER['PHP_SELF'];
        if($this->openPage<=0) {
            $next    =    2;
        }
        else {
            $next    =    $this->openPage+1;
        }
        $prev    =    $this->openPage-1;
        $last    =    $this->pages;
		
		$dis_min = intval($this->openPage - 5); 
		$dis_max = intval($this->openPage + 5);		
		
		if($dis_max > $this->pages) { $dis_max = $this->pages; $dis_min = ($this->pages - 10); }
		if($dis_min < 1) { $dis_min = 1; $dis_max = 10; }
		

        if($this->openPage > 1) {
             if($dis_min > 1)
			{
				$out="<a href=$self?option=".$_GET['option']."&page=1 class = 'more_news'>First</a>&nbsp&nbsp;";
				$out.= "<span class='page_bg1'>...</span>&nbsp&nbsp;";
			}
           // echo "<a href=$self?option=".$_GET['option']."&page=$prev class = 'more_news'>Prev</a>&nbsp&nbsp;";
        }
        else {
            //echo "First&nbsp&nbsp;";
            //echo "Prev&nbsp&nbsp;";
        }
       for($i=$dis_min;$i<=$dis_max;$i++) 
		{
			if(($i >=1) && ($i <= $this->pages))	
			{	
				if($i == $this->openPage) $out.= "<span class='poll_bg1'>$i</span>&nbsp&nbsp;";
				else 
				{				
					$out.= "<a href=$self?option=".$_GET['option']."&page=$i style='cursor:pointer' class ='page_bg1'>$i</a>&nbsp&nbsp;";
				}
			}	
        }
        if($this->openPage < $this->pages) {
            //echo "<a href=$self?option=".$_GET['option']."&page=$next class = 'more_news'>Next</a>&nbsp&nbsp;";
           if($dis_max < $this->pages) 
			{
				$out.= "<span class='page_bg1'>...</span>&nbsp&nbsp;";
				$out.= "<a href=$self?option=".$_GET['option']."&page=$last class = 'more_news'>Last</a>&nbsp&nbsp;";
			}	
        }
        else {
           // echo "<span>Next&nbsp&nbsp;</span>";
            //echo "Last&nbsp&nbsp;";
        }  
		return $out; 
    }
	
	}
	function ajax_pagination($tot_pages,$pg,$url,$div)
	{
				$pglist='';

				$dis_min = intval($pg - 5); 
				$dis_max = intval($pg + 5);				

		if($dis_max > $tot_pages)
		{
			 $dis_max = $tot_pages;
			 $dis_min = ($tot_pages - 10);
		}
		if($dis_min < 1)
		{
			$dis_min = 1;
			$dis_max = 10;
		}
		
			// echo $dis_min;
			// echo $dis_max;

			if($pg > 1) {
				 if($dis_min > 1)
					{
						$pglist.='&nbsp;<span class="page_txt1"><a href="javascript:void();" onclick="ahahscript.ahah(\''.$url.'&page=1\', \''.$div.'\', \'\', \'GET\', \'\', this);" >First</a></span>&nbsp;';
						$pglist.='&nbsp;<span class="page_bg"><a href="javascript:void();" onclick="ahahscript.ahah(\''.$url.'&page='.($dis_min-1).'\', \''.$div.'\', \'\', \'GET\', \'\', this);">...</a></span>&nbsp;';
					}
					else
					{
						 $pglist.='&nbsp;<span class="page_bg"><a href="javascript:void();" onclick="ahahscript.ahah(\''.$url.'&page=1\', \''.$div.'\', \'\', \'GET\', \'\', this);" >First</a></span>&nbsp;';
					} 
				}
			else
			{
				// $pglist.='<span class="disabled">&nbsp;&nbsp; First &nbsp;&nbsp;</span>';
			}

       for($i=$dis_min;$i<=$dis_max;$i++) 
		{
			if(($i >=1) && ($i <= $tot_pages))	
			{	
				if($i == $pg)
				 $pglist.='&nbsp;<span class="page_txt">'.$i.'</span>&nbsp;';
				else 
				{				
				 $pglist.='&nbsp;<span class="page_bg"><a href="javascript:void();" onclick="ahahscript.ahah(\''.$url.'&page='.$i.'\', \''.$div.'\', \'\', \'GET\', \'\', this);" >'.$i.'</a></span>&nbsp;';
				}
			}	
        }
        if($pg < $tot_pages) {
            //echo "<a href=$self?option=".$_GET['option']."&page=$next class = 'more_news'>Next</a>&nbsp&nbsp;";
           if($dis_max < $tot_pages) 
			{
				$pglist.='&nbsp;<span class="page_bg"><a href="javascript:void();" onclick="ahahscript.ahah(\''.$url.'&page='.($dis_max+1).'\', \''.$div.'\', \'\', \'GET\', \'\', this);">...</a></span>&nbsp;';
				$pglist.='&nbsp;<span class="page_bg">&nbsp;<a href="javascript:void();" onclick="ahahscript.ahah(\''.$url.'&page='.$tot_pages.'\', \''.$div.'\', \'\', \'GET\', \'\', this);">&nbsp;Last&nbsp;</a></span>&nbsp;';
			}
		  else
			{
				$pglist.='&nbsp;<span class="page_bg"><a href="javascript:void();" onclick="ahahscript.ahah(\''.$url.'&page='.$tot_pages.'\', \''.$div.'\', \'\', \'GET\', \'\', this);">Last</a></span>&nbsp;';
			}
        }
		else if($pg==$tot_pages)
		{
			// $pglist.='<span class="disabled">&nbsp;&nbsp; Last &nbsp;&nbsp;</span>';
		}

				return $pglist;
		
	}
	
	
	function getExtension($str) 
	{
		$i = strrpos($str,".");
		if (!$i) { return ""; }
		$l = strlen($str) - $i;
		$ext = substr($str,$i+1,$l);
		return $ext;
	}

class pagination_new
    {
       
	    var $fullresult;    // record set that contains whole result from database
        var $totalresult;   // Total number records in database
        var $query;         // User passed query
        var $resultPerPage; //Total records in each pages
        var $resultpage;    // Record set from each page
        var $pages;            // Total number of pages required
        var $openPage;        // currently opened page
       var $argument;
    function createPaging($query,$resultPerPage)
    {
        //Db Connection for pagination
        mysql_connect (DB_SERVER, DB_USER, DB_PASSWD, DB_NAME,$bPersistant=TRUE) or die ("unable to connect to database");
        mysql_select_db(DB_NAME) or die ("unable to select DB");
        $this->query        =    $query;
        $this->resultPerPage=    $resultPerPage;
        $this->fullresult    =    mysql_query($this->query);
        $this->totalresult    =    mysql_num_rows($this->fullresult);
        $this->pages        =    $this->findPages($this->totalresult,$this->resultPerPage);
		$this->arguement = $arg;
        if(isset($_GET['page']) && $_GET['page']>0) {
            $this->openPage    =    $_GET['page'];
            if($this->openPage > $this->pages) {
                $this->openPage    =    1;
            }
            $start    =    $this->openPage*$this->resultPerPage-$this->resultPerPage;
            $end    =    $this->resultPerPage;
            $this->query.=    " LIMIT $start,$end";
        }
        elseif($_GET['page']>$this->pages) {
            $start    =    $this->pages;
            $end    =    $this->resultPerPage;
            $this->query.=    " LIMIT $start,$end";
        }
        else {
            $this->openPage    =    1;
            $this->query .=    " LIMIT 0,$this->resultPerPage";
        }
        $this->resultpage =    mysql_query($this->query);
    }
	
	
	function recordsize()
	{return $this->totalresult;
	}

    function findPages($total,$perpage)
    {
        $pages    =    intval($total/$perpage);
        if($total%$perpage > 0) $pages++;
        return $pages;
    }
   
/*
function to display the pagination
*/
  /*  function totalrecords()
    {
        if($_GET['page']=='')
        $page_no='1';
        else
        $page_no=$_GET['page'];
        $f='<span class="poll_bg1">Page '.$page_no.' of '.$this->pages.'</span>    ';
        echo $f;
    }
    function displayPaging($option='')
    {
        $self    =    $_SERVER['PHP_SELF'];
        if($this->openPage<=0) {
            $next    =    2;
        }
        else {
            $next    =    $this->openPage+1;
        }
        $prev    =    $this->openPage-1;
        $last    =    $this->pages;
		
		$dis_min = intval($this->openPage - 5); 
		$dis_max = intval($this->openPage + 5);		
		
		if($dis_max > $this->pages) { $dis_max = $this->pages; $dis_min = ($this->pages - 10); }
		if($dis_min < 1) { $dis_min = 1; $dis_max = 10; }
		

        if($this->openPage > 1) {
             if($dis_min > 1)
			{
				echo"<a href=$self?option=".$option."&page=1 class = 'more_news'>First</a>&nbsp&nbsp;";
				echo "<span class='poll_bg1'>...</span>&nbsp&nbsp;";
			}
           // echo "<a href=$self?option=".$_GET['option']."&page=$prev class = 'more_news'>Prev</a>&nbsp&nbsp;";
        }
        else {
            //echo "First&nbsp&nbsp;";
            //echo "Prev&nbsp&nbsp;";
        }
       for($i=$dis_min;$i<=$dis_max;$i++) 
		{
			if(($i >=1) && ($i <= $this->pages))	
			{	
				if($i == $this->openPage) echo "<span class='poll_bg1'>$i</span>&nbsp&nbsp;";
				else 
				{				
					echo "<a href=$self?option=".$option."&page=$i style='cursor:pointer' class ='poll_bg1'>$i</a>&nbsp&nbsp;";
				}
			}	
        }
        if($this->openPage < $this->pages) {
            //echo "<a href=$self?option=".$_GET['option']."&page=$next class = 'more_news'>Next</a>&nbsp&nbsp;";
           if($dis_max < $this->pages) 
			{
				echo "<span class='poll_bg1'>...</span>&nbsp&nbsp;";
				echo "<a href=$self?option=".$option."&page=$last class = 'more_news'>Last</a>&nbsp&nbsp;";
			}	
        }
        else {
           // echo "<span>Next&nbsp&nbsp;</span>";
            //echo "Last&nbsp&nbsp;";
        }   
    }*/
	function totalrecords()
    {
        if($_GET['page']=='')
        $page_no='1';
        else
        $page_no=$_GET['page'];
        $f='<span  class="page_txt1">Page '.$page_no.' of '.$this->pages.'</span>    ';
        echo $f;
    }
    function displayPaging($option='')
    {
        $self    =    $_SERVER['PHP_SELF'];
        if($this->openPage<=0) {
            $next    =    2;
        }
        else {
            $next    =    $this->openPage+1;
        }
        $prev    =    $this->openPage-1;
        $last    =    $this->pages;
		
		$dis_min = intval($this->openPage - 5); 
		$dis_max = intval($this->openPage + 5);		
		
		if($dis_max > $this->pages) { $dis_max = $this->pages; $dis_min = ($this->pages - 10); }
		if($dis_min < 1) { $dis_min = 1; $dis_max = 10; }
		

        if($this->openPage > 1) {
             if($dis_min > 1)
			{
				echo"<a href=$self?option=".$option."&page=1 class = 'more_news'>First</a>&nbsp&nbsp;";
				echo "<span class='page_bg'>...</span>&nbsp&nbsp;";
			}
           // echo "<a href=$self?option=".$_GET['option']."&page=$prev class = 'more_news'>Prev</a>&nbsp&nbsp;";
        }
        else {
            //echo "First&nbsp&nbsp;";
            //echo "Prev&nbsp&nbsp;";
        }
       for($i=$dis_min;$i<=$dis_max;$i++) 
		{
			if(($i >=1) && ($i <= $this->pages))	
			{	
				if($i == $this->openPage) echo "<span class='page_txt'>$i</span>&nbsp&nbsp;";
				else 
				{				
					echo "<a href=$self?option=".$option."&page=$i style='cursor:pointer' class='page_bg'>$i</a>&nbsp&nbsp;";
				}
			}	
        }
        if($this->openPage < $this->pages) {
            //echo "<a href=$self?option=".$_GET['option']."&page=$next class = 'more_news'>Next</a>&nbsp&nbsp;";
           if($dis_max < $this->pages) 
			{
				echo "<span class='page_txt'>...</span>&nbsp&nbsp;";
				echo "<a href=$self?option=".$option."&page=$last class = 'more_news'>Last</a>&nbsp&nbsp;";
			}	
        }
        else {
           // echo "<span>Next&nbsp&nbsp;</span>";
            //echo "Last&nbsp&nbsp;";
        }   
    }
	}
	function user_login_check($flag = 0)
	{
		if(isset($_SESSION["user_id"]) && $_SESSION["user_id"]!= "")
		{
		}
		else
		{
			if(!empty($flag))
			{
				$_SESSION['log_msg'] = "Please Login";
				$_SESSION['msg'] = '<div class="wrong">Please Login to Continue</div>';
				$_SESSION['navigation']=$_SERVER['PHP_SELF'];

					if($_SERVER['HTTP_REFERER']!='')
						header("Location:".$_SERVER['HTTP_REFERER']);
					else
						header("Location:index.php");
				// header("Location:index.php");
				exit;
			}
			else
			{	
				$_SESSION['log_msg'] = "Please Login";
				$_SESSION['msg'] = '<div class="wrong">Please Login to Continue</div>';
				$qst=$_SERVER['QUERY_STRING'];
				if($qst!='')	
					$_SESSION['navigation']=$_SERVER['PHP_SELF'].'?'.$qst;
				else
					$_SESSION['navigation']=$_SERVER['PHP_SELF'];
				
					if($_SERVER['HTTP_REFERER']!='')
						header("Location:".$_SERVER['HTTP_REFERER']);
					else
						header("Location:index.php");
				exit;
			}
		}
		
	}
	
function generateCode($characters) {
		$possible = '23456789bcdfghjklmnpqrstvwxyz';
		$code = '';
		$i = 0;
		while ($i < $characters) { 
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		return $code;
	}	

function sendMail($fromname, $fromaddress, $toname, $toaddress, $subject, $message){
		
		$headers  = "MIME-Version: 1.0\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
		$headers .= "X-Priority: 3\n";
		$headers .= "X-MSMail-Priority: Normal\n";
		$headers .= "X-Mailer: php\n";
		$headers .= "From: \"".$fromname."\" <".$fromaddress.">\n";

/*		$eol="\n"; 
		$mime_boundary=md5(time()); 
		$f_name="test.doc";    // use relative path OR ELSE big headaches. $letter is my file for attaching.
		
		$handle=fopen($f_name, 'rb');
		$f_contents=fread($handle, filesize($f_name));
		$f_contents=chunk_split(base64_encode($f_contents));    //Encode The Data For Transition using base64_encode();
		$f_type=filetype($f_name);
		fclose($handle); 
*/


/*		$message .= "--".$mime_boundary.$eol;
		$message .= "Content-Type: application/msword; name=\"".$f_name."\"".$eol;   // sometimes i have to send MS Word, use 'msword' instead of 'pdf'
		$message .= "Content-Transfer-Encoding: base64".$eol;
		$message .= "Content-Disposition: attachment; filename=\"".$f_name."\"".$eol.$eol; // !! This line needs TWO end of lines !! IMPORTANT !!
		$message .= $f_contents.$eol.$eol; 
*/		
		
		
		mail($toaddress, $subject, $message, $headers);
	}


class aray_pagination
  {
    var $page = 1; // Current Page
    var $perPage = 10; // Items on each page, defaulted to 10
    var $showFirstAndLast = false; // if you would like the first and last page options.
    
    function generate($array, $perPage = 10)
    {
      // Assign the items per page variable
      if (!empty($perPage))
        $this->perPage = $perPage;
      
      // Assign the page variable
      if (!empty($_GET['page'])) {
        $this->page = $_GET['page']; // using the get method
      } else {
        $this->page = 1; // if we don't have a page number then assume we are on the first page
      }
      
      // Take the length of the array
      $this->length = count($array);
      
      // Get the number of pages
      $this->pages = ceil($this->length / $this->perPage);
      
      // Calculate the starting point 
      $this->start  = ceil(($this->page - 1) * $this->perPage);
      
      // Return the part of the array we have requested
      return array_slice($array, $this->start, $this->perPage);
    }
    
    function links()
    {
      // Initiate the links array
      $plinks = array();
      $links = array();
      $slinks = array();
      
      // Concatenate the get variables to add to the page numbering string
      if (count($_GET)) {
        $queryURL = '';
        foreach ($_GET as $key => $value) {
          if ($key != 'page') {
            $queryURL .= '&'.$key.'='.$value;
          }
        }
      }
      
	$f='<span  class="page_txt1">Page '.$this->page.' of '.$this->pages.' </span>&nbsp;&nbsp;';

		$dis_min = intval($this->page - 5); 
		$dis_max = intval($this->page + 5);		
		
		if($dis_max > $this->pages) { $dis_max = $this->pages; $dis_min = ($this->pages - 10); }
		if($dis_min < 1) { $dis_min = 1; $dis_max = 10; }
		

        if($this->page > 1) {
             if($dis_min > 1)
			{
				$f.='<a href="?page=1'.$queryURL.'" class="page_txt1">&laquo;&laquo; First </a>&nbsp&nbsp;';
				$f.="<span class='page_bg'>...</span>&nbsp&nbsp;";
			}
		}

       for($i=$dis_min;$i<=$dis_max;$i++) 
		{
			if(($i >=1) && ($i <= $this->pages))	
			{	
				if($i == $this->page)
				 $f.="<span class='page_txt'>$i</span>&nbsp&nbsp;";
				else 
				{				
					$f.='<a href="?page='.$i.$queryURL.'" class="page_bg">'.$i.'</a>&nbsp&nbsp;'; 
				}
			}	
        }
        if($this->page < $this->pages) {
            //echo "<a href=$self?option=".$_GET['option']."&page=$next class = 'more_news'>Next</a>&nbsp&nbsp;";
           if($dis_max < $this->pages) 
			{
				$f.="<span class='page_bg'>...</span>&nbsp&nbsp;";
				$f.=' <a href="?page='.($this->pages).$queryURL.'" class="page_txt1"> Last &raquo;&raquo; </a> ';
			}	
        }

        // Push the array into a string using any some glue
        return $f.implode(' ', $plinks).implode($this->implodeBy, $links).implode(' ', $slinks);
	   // return $f;
      }
  }

	function replace_p_tags($str)
	{
		$rep = array('<p>','</p>');
		$rep_str = str_replace($rep,'', $str);
		return $rep_str;
	}
function perPage(){
		return 5;
	}
	 class pagination_qatar
    {
       
	    var $fullresult;    // record set that contains whole result from database
        var $totalresult;   // Total number records in database
        var $query;         // User passed query
        var $resultPerPage; //Total records in each pages
        var $resultpage;    // Record set from each page
        var $pages;            // Total number of pages required
        var $openPage;        // currently opened page
       
    function createPaging($query,$resultPerPage)
    {
        //Db Connection for pagination
        mysql_connect (DB_SERVER, DB_USER, DB_PASSWD, DB_NAME,$bPersistant=TRUE) or die ("unable to connect to database");
        mysql_select_db(DB_NAME) or die ("unable to select DB");
        $this->query        =    $query;
        $this->resultPerPage=    $resultPerPage;
        $this->fullresult    =    mysql_query($this->query);
        $this->totalresult    =    mysql_num_rows($this->fullresult);
        $this->pages        =    $this->findPages($this->totalresult,$this->resultPerPage);
        if(isset($_GET['page']) && $_GET['page']>0) {
            $this->openPage    =    $_GET['page'];
            if($this->openPage > $this->pages) {
                $this->openPage    =    1;
            }
            $start    =    $this->openPage*$this->resultPerPage-$this->resultPerPage;
            $end    =    $this->resultPerPage;
            $this->query.=    " LIMIT $start,$end";
        }
        elseif($_GET['page']>$this->pages) {
            $start    =    $this->pages;
            $end    =    $this->resultPerPage;
            $this->query.=    " LIMIT $start,$end";
        }
        else {
            $this->openPage    =    1;
            $this->query .=    " LIMIT 0,$this->resultPerPage";
        }
        $this->resultpage =    mysql_query($this->query);
    }

    function findPages($total,$perpage)
    {
        $pages    =    intval($total/$perpage);
        if($total%$perpage > 0) $pages++;
        return $pages;
    }
   
/*
function to display the pagination
*/
    function totalrecords()
    {
        if($_GET['page']=='')
        $page_no='1';
        else
        $page_no=$_GET['page'];
       // $f='<span class="poll_bg">Page '.$page_no.' of '.$this->pages.'</span>    ';
	   $f='';
       return $f;
    }
    function displayPaging($al='')
    {
        $self    =    $_SERVER['PHP_SELF'];
        if($this->openPage<=0) {
            $next    =    2;
        }
        else {
            $next    =    $this->openPage+1;
        }
        $prev    =    $this->openPage-1;
        $last    =    $this->pages;

       
	    $dis_min = intval($this->openPage - 5); 
		$dis_max = intval($this->openPage + 5);		
		
		if($dis_max > $this->pages) { $dis_max = $this->pages; $dis_min = ($this->pages - 10); }
		if($dis_min < 1) { $dis_min = 1; $dis_max = 10; }

	   //$out.='<div class="pagination">';
	   
	    if($this->openPage > 1) {
            if($dis_min > 1)
			{
				//$out.="<a href=$self?option=".$_GET['option']."&page=1 class = 'more_news'>First</a>&nbsp&nbsp;";
				//$out.= "<span class='poll_bg1'>...</span>&nbsp&nbsp;";
			}
           // echo "<a href=$self?option=".$_GET['option']."&page=$prev class = 'more_news'>Prev</a>&nbsp&nbsp;";
        }
        else {
            //echo "First&nbsp&nbsp;";
            //echo "Prev&nbsp&nbsp;";
        }
		
				
		
		
       for($i=$dis_min;$i<=$dis_max;$i++) 
		{
			if(($i >=1) && ($i <= $this->pages))	
			{	
				if($i == $this->openPage) $out.= "<a href=$self?option=".$_GET['option']."&page=$i&al=$al style='cursor:pointer' class='active'>$i</a>&nbsp&nbsp;";
				else 
				{				
					$out.= "<a href=$self?option=".$_GET['option']."&page=$i&al=$al style='cursor:pointer' >$i</a>&nbsp&nbsp;";
				}
			}	
        }		
		

        if($this->openPage < $this->pages) {
            //echo "<a href=$self?option=".$_GET['option']."&page=$next class = 'more_news'>Next</a>&nbsp&nbsp;";
            if($dis_max < $this->pages) 
			{
				$out.= "<span class='poll_bg1'>...</span>&nbsp&nbsp;";
				$out.= "<a href=$self?option=".$_GET['option']."&page=$last&al=$al >Last</a>&nbsp&nbsp;";
			}	
        }
        else {
           // echo "<span>Next&nbsp&nbsp;</span>";
            //echo "Last&nbsp&nbsp;";
        }  

		return $out; 
    }
	}
	
		function admin_login_check($flag = 0,$val)
		{
	
			if($_SESSION['adminuser'] == "")
			{
				$_SESSION['msg'] = "<font size='2' color='#FF0000'>Please Login To access the Admin Panel</font>";
				header("Location:".ADMIN_URL."login.php");
				exit;
			
			}
		}
?>
