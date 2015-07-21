<?php include('includes/header.php');?>
<?php


$objSql1 = new SqlClass();
$getStandardSql="SELECT id,standard FROM bm_standard_master";
$standards=$objSql1->executeSql($getStandardSql);

$objSql2 = new SqlClass();
$getSubjectSql="SELECT id,subject FROM bm_subject_master";
$subjects=$objSql2->executeSql($getSubjectSql);

$objSql3 = new SqlClass();
$getLevelSql="SELECT id,level FROM bm_level_master";
$levels=$objSql3->executeSql($getLevelSql);

if(isset($_POST['submit']))
{


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
    <form class="form-horizontal" action="" role="form" method="post">
        <div class="row">
            <div class="col-lg-12">
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
                                    <label class="col-sm-3 control-label" for="question">Question</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="question" id="question" placeholder="Type Question">
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
                                    <label class="col-sm-3 control-label" for="marks">Marks</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="marks" id="marks" placeholder="Type Marks in Number">
                                    </div>
                                </div>

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
                                    <label class="col-sm-3 control-label" for="question">Question</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="question" id="question" placeholder="Type Question">
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
                                    <label class="col-sm-3 control-label" for="question">Upload Audio</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="question" id="question" placeholder="Type Question">
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

                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="marks">Marks</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="marks" id="marks" placeholder="Type Marks in Number">
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

                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="marks">Marks</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="marks" id="marks" placeholder="Type Marks in Number">
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
