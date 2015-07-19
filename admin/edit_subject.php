<?php include('includes/header.php');?>
<?php
$objSql = new SqlClass();
$subject='';

if(isset($_GET['id']))
{
    $record_id=$objSql->sanitize($_GET['id']);

    $sql = "SELECT id,subject FROM bm_subject_master WHERE id='$record_id'";
    $query = $objSql->executeSql($sql);
    if($query)
    {
        $record=$objSql->fetchRow($query);
        $subject=$record['subject'];
    }

}

if(isset($_POST['submit']))
{
    $record_id=$objSql->sanitize($_GET['id']);
    $subject=$objSql->sanitize($_POST['subject']);
    $sql = "UPDATE bm_subject_master SET subject='$subject' WHERE id='$record_id'";
    $record = $objSql->executeSql($sql);
    if($record)
    {
        header('location:manage_subjects.php?updated');
    }
}


?>
<!-- page heading start-->
<div class="page-heading">
    <h3>Edit Subject</h3>
    <ul class="breadcrumb">
        <li>
            <a href="index.php">Dashboard</a>
        </li>
        <li class="active"> Add New Subject </li>
    </ul>
</div>
<!-- page heading end-->

<!--body wrapper start-->
<section class="wrapper">
    <!-- page start-->

    <div class="row">
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading">
                    Edit Subject Form
                </header>
                <div class="panel-body">
                    <form action="" role="form" method="post">
                        <div class="form-group">
                            <label for="new_subject">Edit Subject</label>
                            <input required="required" class="form-control" name="subject" id="new_subject" placeholder="Enter Subject Name" type="text" value="<?php echo ($subject)?$subject:'';  ?>">
                        </div>
                        <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </section>
        </div>
    </div>

    <!-- page end-->
</section>
<!--body wrapper end-->

<?php include('includes/footer.php');?>


