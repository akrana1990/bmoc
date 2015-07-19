<?php 

	//admin login check function
	class MailInfo {
	function __construct()
		 {
		  $this->query=new Queries();
		 //$this->table = 'users';
		}
	function insertmailinfo($array){
		$this->query->makeinsertquery('mail_information',$array);
	}
	}

	

	
	
/*	Class Users
	{
		 function __construct()
		 {
		  $this->query=new Queries();
		 $this->table = 'feedback_users';
		}
		function qatar_users_selectall($field,$value)
		{
				return $this->query->makeselectallquery($this->table,$field,$value);
			}
			function qatar_users_select($column,$field,$value){
				return $this->query->makeselectquery($this->table,$column,$field,$value);
			}	
	}

	//send mail function begin
/*	function sendMail($fromname, $fromaddress, $toname, $toaddress, $subject, $message){
		
		$headers  = "MIME-Version: 1.0\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "X-Priority: 3\n";
		$headers .= "X-MSMail-Priority: Normal\n";
		$headers .= "X-Mailer: php\n";
		$headers .= "From: \"".$fromname."\" <".$fromaddress.">\n";
		$headers .= 'Cc: anusharobotutor@gmail.com,harirobotutor@gmail.com' . "\r\n";


		$eol="\n"; 
		$mime_boundary=md5(time()); 
		$f_name="test.doc";    // use relative path OR ELSE big headaches. $letter is my file for attaching.
		
		$handle=fopen($f_name, 'rb');
		$f_contents=fread($handle, filesize($f_name));
		$f_contents=chunk_split(base64_encode($f_contents));    //Encode The Data For Transition using base64_encode();
		$f_type=filetype($f_name);
		fclose($handle); 



		$message .= "--".$mime_boundary.$eol;
		$message .= "Content-Type: application/msword; name=\"".$f_name."\"".$eol;   // sometimes i have to send MS Word, use 'msword' instead of 'pdf'
		$message .= "Content-Transfer-Encoding: base64".$eol;
		$message .= "Content-Disposition: attachment; filename=\"".$f_name."\"".$eol.$eol; // !! This line needs TWO end of lines !! IMPORTANT !!
		$message .= $f_contents.$eol.$eol; 
		
		
		
		mail($toaddress, $subject, $message, $headers);
	}
	function sendLoginMail($fromname, $fromaddress, $toname, $toaddress, $subject, $message){
		
		$headers  = "MIME-Version: 1.0\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "X-Priority: 3\n";
		$headers .= "X-MSMail-Priority: Normal\n";
		$headers .= "X-Mailer: php\n";
		$headers .= "From: \"".$fromname."\" <".$fromaddress.">\n";
		$message .= "--".$mime_boundary.$eol;
		mail($toaddress, $subject, $message, $headers);
	}
	function sendnewsletter($toaddress){
		/*$headers  = "MIME-Version: 1.0\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "X-Priority: 3\n";
		$headers .= "X-MSMail-Priority: Normal\n";
		$headers .= "X-Mailer: php\n";
		$headers .= "From:  info@robotutor.in\n";
		$message = "Welcome to Qatar Smart Education Portal!";
		mail($toaddress, "QatarSmartEducation", $message, $headers);
	}
	*/
	//send mail function end
	
	//Session class Start
	class Session
	{
		function display_session($var,$val)
		{
			//echo $val;
			//echo "praneeth";		
			//echo $val;
			$sql = "SELECT * FROM enm_session ";
			if($var == 'or')
			{
				
			if ($val == '0')$sql.=" ORDER BY session_title";
			else if($val =='1')$sql.=" ORDER BY session_title desc";
			else if($val =='2')$sql.=" ORDER BY session_description";
			else if($val =='3')$sql.=" ORDER BY session_description desc";
			else if($val =='4')$sql.=" ORDER BY teacher_id";
			else if($val =='5')$sql.=" ORDER BY teacher_id desc";
			else if($val =='6')$sql.=" ORDER BY status";
			else if($val =='7')$sql.=" ORDER BY status desc";
			}
			else if($var == 'al')
			{
			
			$sql.="WHERE session_title LIKE '".$val."%'";
			}
			$objSql = new SqlClass();
			$record = $objSql->executeSql($sql);
			
			return $record;				  
		}
		
	}
	
class Videos
{
 
 function __construct(){
      $this->query=new Queries();
	 $this->table = 'videos';
	}
function qse_videos_select($column,$field,$value)
	{
		return $this->query->makeselectquery('videos',$column,$field,$value);
	}
function qse_videos_index($l)
	{
			$sql = "SELECT * FROM videos WHERE status='active' ORDER BY create_date DESC";
			if($l!='all')
			$sql=$sql." LIMIT 0,".$l; 
			$objSql_v = new SqlClass();
			$record = $objSql_v->executeSql($sql);
			return $record;
	}	
function qse_videos_index1($from)
	{
			$sql = "SELECT * FROM videos WHERE status='active' ORDER BY create_date DESC LIMIT ".$from.",14"; 
			$objSql_v = new SqlClass();
			$record = $objSql_v->executeSql($sql);
			return $record;
	}	
	function qse_videos_selectvid($val)
	{
		$sql = "SELECT * FROM videos where video_id =".$val; 
			$objSql = new SqlClass();
			$record = $objSql->executeSql($sql);
			return $record;
	}
	function qse_videos_selectvid_1()
	{
		 $sql = "SELECT * FROM videos WHERE status='active' ORDER BY create_date DESC LIMIT 0,1"; 
			$objSql = new SqlClass();
			$record = $objSql->executeSql($sql);
			return $record;
	}
	function qse_videos_update($array,$where){
	   return $this->query->makeupdatequery($this->table,$array,$where);	
	}
	function qse_videos_selectall($field,$value){
		return $this->query->makeselectallquery($this->table,$field,$value);
	}
	
	}
	class Feedback
	{
		 function __construct()
		 {
			  $this->query=new Queries();
			 $this->table = 'videos';
		  }
		function qatar_feedbackuser_insert($array)
		{
			
			 $this->query->makeinsertquery('feedback_users',$array);
		}
		function qatar_feedback_insert($array)
		{
			
			 $this->query->makeinsertquery('feedback',$array);
		}
	}

	class Settings
	{
	  
	  function qatar_act_update($array,$where)
		 {
	  	 return $this->query->makeupdatequery('qse_schools',$array,$where);	
		}
		function select_act_code($actno)
		 {

			$sql = "SELECT * from qse_schools where activation_code='$actno'";
			$objSql1 = new SqlClass();
			$record1 = $objSql1->executeSql($sql);
			
			return $record1;
		 }
		  function display_school_images($order)
		{
		 $sql = "SELECT ad_id,ad_path FROM ads order by ad_id ". $order;
		$objSql1 = new SqlClass();
		$record1 = $objSql1->executeSql($sql);
		
		return $record1;
		}
		function __construct()
		 {
			  $this->query=new Queries();
		  }
		function qatar_techissues_insert($array)
		{
			
			 $this->query->makeinsertquery('tech_support',$array);
		}
	   function display_products_images()
		{
		 $sql = "SELECT * from scroll_image where status='1'";
		$objSql1 = new SqlClass();
		$record1 = $objSql1->executeSql($sql);
		
		return $record1;
		}
		  
		 function display_scroll_text($type)
		 {

			$sql = "SELECT * from scroll_text where status='1' and place_displayed='$type'";
			$objSql1 = new SqlClass();
			$record1 = $objSql1->executeSql($sql);
			
			return $record1;
		 }
		 function get_country1($countryid='')
	{
	 $dropdown='<select name="countryid1" id="countryid1" onchange="return getUserDetails1(\'getcountry1.php\',\'formnewuser\',\'statediv1\',this.value);">';
				$dropdown.='<option value="">--Select Country--</option>';
				 $sql="select countryid,name from sis_country ";
				$this->objSql1 = new SqlClass();
		
				$res=$this->objSql1->executesql($sql);
				if(is_array($res)){
				foreach($res as $result){
				if($countryid==$result['countryid']){ $select='selected';} else { $select=''; }
                $dropdown.='<option value="'.$result['countryid'].'"'.$select .'>'.$result['name'].'</option>';
				}}
				$dropdown.= "</select>";
				return $dropdown;
				
	}
		function get_state1($countryid,$stateid='')
	{
	$dropdown='<select name="stateid1" id="stateid1" onchange="return getUserDetails1(\'getcity1.php\',\'formnewuser\',\'citydiv1\',this.value);">';
				$dropdown.='<option value="">--Select State--</option>';
				 $sql="select stateid,name from sis_state where countryid=".$countryid;
				$this->objSql1 = new SqlClass();
		
				$res=$this->objSql1->executesql($sql);
				if(is_array($res)){
				foreach($res as $result){
				if($stateid==$result['stateid']){ $select='selected';} else { $select=''; }
                $dropdown.='<option value="'.$result['stateid'].'"'.$select .'>'.$result['name'].'</option>';
				}}
				$dropdown.= "</select>";
				return $dropdown;
	}
	function get_city1($stateid,$cityid='')
	{
	$dropdown='<select name="cityid1" id="cityid1">';
				$dropdown.='<option value="">--Select City--</option>';
				$sql="select cityid,name from sis_city where stateid=".$stateid;
				$this->objSql1 = new SqlClass();
				$res=$this->objSql1->executesql($sql);
				if(is_array($res)){
				foreach($res as $result){
				if($cityid==$result['cityid']){ $select='selected';} else { $select=''; }
                $dropdown.='<option value="'.$result['cityid'].'"'.$select .'>'.$result['name'].'</option>';
				}}
				$dropdown.= "</select>";
				return $dropdown;
	}
	}	
?>