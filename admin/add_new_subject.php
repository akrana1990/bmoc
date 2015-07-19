<?php include('includes/header.php');?>
<?php
$objSql = new SqlClass();

if(isset($_POST['submit']))
{
    $new_subject=$objSql->sanitize($_POST['new_subject']);
    $sql = "INSERT INTO bm_subject_master(subject) values('".$new_subject."')";
    $record = $objSql->executeSql($sql);
    if(!$record)
    {
        header('location:add_new_subject.php?error');
    }
}


?>
<!-- page heading start-->
<div class="page-heading">
    <h3>Add New Subject</h3>
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
                    New Subject Addition Form
                </header>
                <div class="panel-body">
                    <form action="" role="form" method="post">
                        <div class="form-group">
                            <label for="new_subject">Add New Subject</label>
                            <input required="required" class="form-control" name="new_subject" id="new_subject" placeholder="Enter Subject Name" type="text">
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


