<?php include('includes/header.php');?>
<?php
define("UPLOAD_DIR", "uploads/");
/**
 *
 */
function check_upload_dir()
{
    if(!is_dir('uploads'))
    {
        die('Upload folder not exists');
    }
    elseif(!is_writable('uploads'))
    {
        die('Not enough permission on uploads folder');
    }
}

/**
 * @param $CSV
 * @return string
 */
function move_csv_to_uploads($CSV)
{
    $message='';
    $file_type='';
    $file_path='';
    //if no errors...
    if(!$CSV['bulk_question_file']['error'])
    {
        $valid_file=true;
        //now is the time to modify the future file name and validate the file

        //print_r($CSV['bulk_question_file']['type']);

        $mimes = array('application/vnd.ms-excel','text/csv','text/tsv');
        if($CSV['bulk_question_file']['size'] > (2048000)) //can't be larger than 2 MB
        {
            $valid_file = false;
            $message = 'Oops!  Your file\'s size is to large.';
            echo $message;
        }
        elseif(!in_array($CSV['bulk_question_file']['type'],$mimes))
        {
            die("Sorry, File type not allowed. Upload a valid CSV fie");
        }

        //if the file has passed the test
        if($valid_file)
        {

            //generate a new random unique name
            //$new_file_name = hash('sha1', uniqid(mt_rand(), true)).'csv';
            $new_file_name = hash('sha1', uniqid(mt_rand(), true)).basename($_FILES['bulk_question_file']['name']);
            //echo $new_file_name;
            //move it to where we want it to be

            if(move_uploaded_file($CSV['bulk_question_file']['tmp_name'], UPLOAD_DIR.'questions-csv/'.$new_file_name))
            {
                $file_path=UPLOAD_DIR.'questions-csv/'.$new_file_name;
                $message = 'Congratulations!  Your file was accepted.';
            }
            else
            {
                $message = 'OOPS!  Your file was not accepted.';
            }

        }
    }
    //if there is an error...
    else
    {
        //set that to be the returned message
        $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['bulk_question_file']['error'];
    }
    return $file_path;
}


$objSql1 = new SqlClass();
$getStandardSql="SELECT id,standard FROM bm_standard_master";
$standards=$objSql1->executeSql($getStandardSql);

$objSql2 = new SqlClass();
$getSubjectSql="SELECT id,subject FROM bm_subject_master";
$subjects=$objSql2->executeSql($getSubjectSql);

$objSql3 = new SqlClass();
$getLevelSql="SELECT id,level FROM bm_level_master";
$levels=$objSql3->executeSql($getLevelSql);

if(isset($_POST['upload_questions']))
{
    /*echo '<pre>';
    print_r($_POST);
    echo '</pre>';*/
    $objSql4 = new SqlClass();
    $_POST=$objSql4->sanitize($_POST);

    if(isset($_POST['question_type']))
    {
        $success=true;
        check_upload_dir();

        //if they DID upload a file...
        if($_FILES['bulk_question_file']['name'])
        {
            $file_path= move_csv_to_uploads($_FILES);
            if(empty($file_path))
            {
                $errorMsg .= "<br />Input file is not specified";
                return $errorMsg;
            }

            $file_handle = fopen($file_path, "r");
            if ($file_handle === FALSE)
            {
                // File could not be opened...
                $errorMsg .= 'Source file could not be opened!<br />';
                $errorMsg .= "Error on fopen('$file_path')"; // Catch any fopen() problems.
                return $errorMsg;
            }

            $db_columns=array(
                'standard',
                'subject',
                'author',
                'question_level',
                'status',
                'marks',
                'question_type',
                'question',
                'answer'
            );

            $column_string = implode(',', $db_columns);
            $csv_columns = array();


            // if question type was single answer
            if($_POST['question_type']=='single_answer')
            {
                $row = 1;
                while (!feof($file_handle))
                {
                    $line_of_text = fgetcsv($file_handle, 1024);
                    /*echo '<pre>';
                    print_r($line_of_text);
                    echo '</pre>';*/
                    if ($row == 1 )
                    {
                        foreach ($line_of_text as $k => $v) {
                            $v = strtolower($v);
                            if (in_array($v, $db_columns)) {
                                $csv_columns[$k] = $v;
                            }
                            else{
                                die('CSV columns does\'t match DB columns. Try again with a valid CSV file' );
                            }
                        }//endforeach

                    }
                    else
                    {
                        $columns = count($line_of_text);
                        if ($columns > 1)
                        {
                            $column_vals = '';

                            $column_vals="'".$_POST['standard']."'";
                            $column_vals.=','."'".$_POST['subject']."'";
                            $column_vals.=','."'".$_POST['author']."'";
                            $column_vals.=','."'".$_POST['level']."'";
                            $column_vals.=','."'".$_POST['status']."'";
                            $column_vals.=','."'".$_POST['marks']."'";
                            $column_vals.=','."'".$_POST['question_type']."'";

                            foreach ($csv_columns as $c => $v)
                            {
                                $column_vals.=','."'".$line_of_text[$c]."'";
                            }//end foreach
                            echo $column_vals.'<br>';
                            $insertSql="INSERT INTO bm_questions($column_string) VALUES ($column_vals)";
                            //echo $insertSql.'<br>';
                            //$insertQuery=$objSql3->executeSql($insertSql);
                            $insertQuery=mysql_query($insertSql) or die(mysql_error());

                            if($insertQuery)
                            {
                                $success=true;
                            }
                            else
                            {
                                $success=false;
                            }
                        }//end if

                    }//end else
                    $row++;
                }//endwhile
            }
            elseif($_POST['question_type']=='objective')
            {
                $objective_csv_columns=array(
                    'option_a',
                    'option_b',
                    'option_c',
                    'option_d',
                );
                $row = 1;
                while (!feof($file_handle))
                {
                    $line_of_text = fgetcsv($file_handle, 1024);
                    /*echo '<pre>';
                    print_r($line_of_text);
                    echo '</pre>';*/
                    if ($row == 1 )
                    {
                        foreach ($line_of_text as $k => $v) {
                            $v = strtolower($v);
                            if ($v!='question' && $v!='answer' && !in_array($v, $objective_csv_columns)) {
                                die('CSV columns don\'t match with the valid CSV format. Try again with a valid CSV file' );
                            }
                        }//endforeach

                    }
                    else
                    {
                        $columns = count($line_of_text);
                        if ($columns > 1)
                        {
                            $column_vals = '';

                            $column_vals="'".$_POST['standard']."'";
                            $column_vals.=','."'".$_POST['subject']."'";
                            $column_vals.=','."'".$_POST['author']."'";
                            $column_vals.=','."'".$_POST['level']."'";
                            $column_vals.=','."'".$_POST['status']."'";
                            $column_vals.=','."'".$_POST['marks']."'";
                            $column_vals.=','."'".$_POST['question_type']."'";

                            $obj_question_array=array(
                                'question'=>$line_of_text[0],
                                'option_a'=>$line_of_text[1],
                                'option_b'=>$line_of_text[2],
                                'option_c'=>$line_of_text[3],
                                'option_d'=>$line_of_text[4]
                            );
                            $obj_question=json_encode($obj_question_array);

                            $column_vals.=','."'".$obj_question."'";
                            $column_vals.=','."'".$line_of_text[5]."'";

                            /*echo '<pre>';
                            print_r($obj_question_array);
                            echo '</pre>';*/

                            //echo $column_vals.'<br>';
                            $insertSql="INSERT INTO bm_questions($column_string) VALUES ($column_vals)";
                            //echo $insertSql.'<br>';
                            //$insertQuery=$objSql3->executeSql($insertSql);
                            $insertQuery=mysql_query($insertSql) or die(mysql_error());

                            if($insertQuery)
                            {
                                $success=true;
                            }
                            else
                            {
                                $success=false;
                            }
                        }//end if

                    }//end else
                    $row++;
                }//endwhile
            }




        }//if
        if($success){
            header('location:bulk_question_upload.php?success');
        }
    }//endif

}

?>

<!-- page heading start-->
<div class="page-heading">
    <h3>Bulk Question Upload</h3>
    <ul class="breadcrumb">
        <li>
            <a href="index.php">Dashboard</a>
        </li>
        <li class="active"> Bulk Question Upload </li>
    </ul>
</div>
<!-- page heading end-->

<!--body wrapper start-->
<section class="wrapper">
<!-- page start-->
<form class="form-horizontal" action="" role="form" method="post" enctype="multipart/form-data">
<div class="row">
    <div class="col-lg-12">
        <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-success">Questions Successfully Uploaded.</div>
        <?php endif; ?>
        <section class="panel">
            <header class="panel-heading">
                New Question Addition Form
            </header>
            <div class="panel-body">

                <aside class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="standard">Standard</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="standard" name="standard" required="required">
                                    <option disabled selected>Select Standard</option>
                                    <?php while($standard=$objSql1->fetchRow($standards)): ?>
                                        <option value="<?php echo $standard['id']; ?>"><?php echo $standard['standard']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="subject">Subject</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="subject" name="subject" required="required">
                                    <option disabled selected>Select Subject</option>
                                    <?php while($subject=$objSql2->fetchRow($subjects)): ?>
                                        <?php var_dump($subject) ?>
                                        <option value="<?php echo $subject['id']; ?>"><?php echo $subject['subject']; ?></option>
                                    <?php endwhile; ?>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="author">Author</label>
                            <div class="col-sm-9">
                                <input class="form-control" name="author" id="author" required="required" placeholder="Type Author Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="marks">Marks</label>
                            <div class="col-sm-9">
                                <input class="form-control" name="marks" id="marks" placeholder="Type Marks in Number">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="level">Question Level</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="level" name="level" required="required">
                                    <option disabled selected>Select Level</option>
                                    <?php while($level=$objSql3->fetchRow($levels)): ?>
                                        <option value="<?php echo $level['id']; ?>"><?php echo $level['level']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="status">Status</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="status" name="status" required="required">
                                    <option disabled selected>Status</option>
                                    <option>Active</option>
                                    <option>Inactive</option>
                                    <option>Suspended</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="question_type">Question Type</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="question_type" required="required">
                                    <option value="objective" selected>Objective</option>
                                    <option value="single_answer">Single Answer Type</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </section>
    </div>
</div>

<div id="objective" class="row question_section">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Upload Bulk Question CSV file
            </header>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="bulk_question_file">Select CSV File</label>
                            <div class="col-sm-9">
                                <input type="file" name="bulk_question_file" id="bulk_question_file" placeholder="Type Question" required="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Save Question
            </header>
            <div class="panel-body">
                <button class="btn btn-primary" type="submit" name="upload_questions">Upload Questions</button>
                <button class="btn btn-info" type="reset">Reset</button>
            </div>
        </section>
    </div>
</div>
</form>
<!-- page end-->
</section>
<!--body wrapper end-->

<?php include('includes/footer.php');?>
