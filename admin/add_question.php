<?php include('includes/header.php');?>
<?php
define("UPLOAD_DIR", "uploads/");
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

$objSql1 = new SqlClass();
$getStandardSql="SELECT id,standard FROM bm_standard_master";
$standards=$objSql1->executeSql($getStandardSql);

$objSql2 = new SqlClass();
$getSubjectSql="SELECT id,subject FROM bm_subject_master";
$subjects=$objSql2->executeSql($getSubjectSql);

$objSql3 = new SqlClass();
$getLevelSql="SELECT id,level FROM bm_level_master";
$levels=$objSql3->executeSql($getLevelSql);

if(isset($_POST['save_question']))
{
    /*echo '<pre>';
    print_r($_POST);
    echo '</pre>';*/
    $objSql4 = new SqlClass();
    $_POST=$objSql4->sanitize($_POST);
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
    $column_sring=implode(',',$db_columns);

    $column_vals="'".$_POST['standard']."'";
    $column_vals.=','."'".$_POST['subject']."'";
    $column_vals.=','."'".$_POST['author']."'";
    $column_vals.=','."'".$_POST['level']."'";
    $column_vals.=','."'".$_POST['status']."'";
    $column_vals.=','."'".$_POST['marks']."'";
    $column_vals.=','."'".$_POST['question_type']."'";

    if(isset($_POST['question_type'])&&$_POST['question_type']=='objective')
    {
        $obj_question_array=array(
            'question'=>$_POST['obj_question'],
            'option_a'=>$_POST['option_a'],
            'option_b'=>$_POST['option_b'],
            'option_c'=>$_POST['option_c'],
            'option_d'=>$_POST['option_d']
        );
        $obj_question=json_encode($obj_question_array);
        //echo $obj_question;
        $column_vals.=','."'".$obj_question."'";
        $column_vals.=','."'".$_POST['obj_answer']."'";
    }

    if(isset($_POST['question_type'])&&$_POST['question_type']=='single_answer')
    {
        $column_vals.=','."'".$_POST['single_question']."'";
        $column_vals.=','."'".$_POST['single_answer']."'";
    }

    /*if(isset($_POST['question_type'])&&$_POST['question_type']=='audio')
    {
        $column_vals.=','."'".'Audio Question'."'";
        $column_vals.=','."'".$_POST['audio_answer']."'";
    }
    if(isset($_POST['question_type'])&&$_POST['question_type']=='video')
    {
        $column_vals.=','."'".'Video Question'."'";
        $column_vals.=','."'".$_POST['video_answer']."'";
    }*/

    if(isset($_POST['question_type'])&&$_POST['question_type']=='static_image')
    {
        $file_type='';
        check_upload_dir();
        //if they DID upload a file...
        if($_FILES['image_question']['name'])
        {

            //if no errors...
            if(!$_FILES['image_question']['error'])
            {
                $valid_file=true;
                //now is the time to modify the future file name and validate the file


                /*$imageinfo = getimagesize($_FILES["image_question"]["tmp_name"]);
                echo '<pre>';
                print_r($imageinfo);
                echo '</pre>';*/

                $new_file_name = 'hello.jpg'; //rename file
                if($_FILES['image_question']['size'] > (1024000)) //can't be larger than 1 MB
                {
                    $valid_file = false;
                    $message = 'Oops!  Your file\'s size is to large.';
                    //echo $message;
                }
                else
                {       //check ext
                    list($width, $height, $file_type) = getimagesize($_FILES["image_question"]["tmp_name"]) or die("<b>Invalid or currupt file input. Try again with JPG,PNG,GIF,JPEG file</b>");
                    if($file_type!=1&&$file_type!=2&&$file_type!=3)
                    {      //check file ext
                        $valid_file = false;
                        $message= "<b>Invalid image file type!</b><br>Only jpg, png, gif are allowed";
                    }
                }

                //if the file has passed the test
                if($valid_file)
                {
                    //set actual file ext
                    if($file_type==1) {$ext=".gif";} else if($file_type==2) {$ext=".jpeg";} else if($file_type==3){$ext=".png";}
                    //generate a new random unique name
                    $new_file_name = hash('sha1', uniqid(mt_rand(), true)).$ext;
                    //move it to where we want it to be
                    if(move_uploaded_file($_FILES['image_question']['tmp_name'], UPLOAD_DIR.'image/'.$new_file_name))
                    {
                        $message = 'Congratulations!  Your file was accepted.';
                    }
                    else
                    {
                        $message = 'OOPS!  Your file was not accepted.';
                    }

                    echo $message;
                }
            }
            //if there is an error...
            else
            {
                //set that to be the returned message
                $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['image_question']['error'];
                echo $message;
            }
        }

        $column_vals.=','."'".$new_file_name."'";
        $column_vals.=','."'".$_POST['image_answer']."'";
    }

    $insertSql="INSERT INTO bm_questions($column_sring) VALUES ($column_vals)";
    //echo $insertSql.'<br>';
    //$insertQuery=$objSql3->executeSql($insertSql);
    $insertQuery=mysql_query($insertSql) or die(mysql_error());

    if($insertQuery)
    {
        header('location:add_question.php?success');
    }
}

?>

<!-- page heading start-->
<div class="page-heading">
    <h3>Add New Question</h3>
    <ul class="breadcrumb">
        <li>
            <a href="index.php">Dashboard</a>
        </li>
        <li class="active"> Add New Question </li>
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
                    <div class="alert alert-success">Question Inserted Successfully.</div>
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
                                        <select class="form-control" id="question_type" name="question_type" required="required">
                                            <option value="objective" selected>Objective</option>
                                            <option value="single_answer">Single Answer</option>
                                            <option value="audio">Audio</option>
                                            <option value="video">Video</option>
                                            <option value="static_image">Static Image</option>
                                            <option value="abacus">Abacus</option>
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
                        Objective Type Question
                    </header>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="obj_question">Question</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="obj_question" id="obj_question" placeholder="Type Question">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="option_a">Option A</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="option_a" id="option_a" placeholder="Type Option A">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="option_a">Option C</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="option_c" id="option_c" placeholder="Type Option C">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="obj_answer">Answer</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="obj_answer" id="obj_answer">
                                            <option disabled selected>Select Answer</option>
                                            <option>Option A</option>
                                            <option>Option B</option>
                                            <option>Option C</option>
                                            <option>Option D</option>
                                        </select>
                                    </div>
                                </div>



                            </div>
                            <div class="col-lg-6">

                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="option_b">Option B</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="option_b" id="option_b" placeholder="Type Option B">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="option_d">Option D</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="option_d" id="option_d" placeholder="Type Option D">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div id="single_answer" class="row question_section" style="display: none">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Single Answer Type Question
                    </header>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="single_question">Question</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="single_question" id="single_question" placeholder="Type Question">
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="single_answer">Answer</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="single_answer" id="single_answer" placeholder="Type Answer">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div id="audio" class="row question_section" style="display: none">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Audio Type Question
                    </header>
                    <div class="panel-body">
                        <aside class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="audio_question">Upload Audio</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="audio_question" id="audio_question" placeholder="Type Question">
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="audio_answer">Answer</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="audio_answer" id="audio_answer" placeholder="Type Answer">
                                    </div>
                                </div>
                            </div>
                        </aside>

                    </div>
                </section>
            </div>
        </div>

        <div id="video" class="row question_section"  style="display: none">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Video Type Question
                    </header>
                    <div class="panel-body">
                        <aside class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="video_question">Upload Video</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="video_question" id="video_question">
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="video_answer">Answer</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="video_answer" id="video_answer" placeholder="Type Answer">
                                    </div>
                                </div>
                            </div>
                        </aside>
                    </div>
                </section>
            </div>
        </div>

        <div id="static_image" class="row question_section" style="display: none">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Image Type Question
                    </header>
                    <div class="panel-body">
                        <aside class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="image_question">Upload Audio</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="image_question" id="image_question" placeholder="Type Question">
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="image_answer">Answer</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="image_answer" id="image_answer" placeholder="Type Answer">
                                    </div>
                                </div>
                            </div>
                        </aside>

                    </div>
                </section>
            </div>
        </div>

        <!--<div id="abacus" class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Objective Question
                    </header>
                    <div class="panel-body">
                        <aside class="row">
                            <div class="col-lg-6">

                            </div>
                            <div class="col-lg-6">

                            </div>
                        </aside>

                    </div>
                </section>
            </div>
        </div>-->

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Save Question
                    </header>
                    <div class="panel-body">
                        <button class="btn btn-primary" type="submit" name="save_question">Save Question</button>
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
