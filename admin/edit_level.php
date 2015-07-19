<?php include('includes/header.php');?>
<?php
$objSql = new SqlClass();
$level='';

if(isset($_GET['id']))
{
    $record_id=$objSql->sanitize($_GET['id']);

    $sql = "SELECT id,level FROM bm_level_master WHERE id='$record_id'";
    $query = $objSql->executeSql($sql);
    if($query)
    {
        $record=$objSql->fetchRow($query);
        $level=$record['level'];
    }

}

if(isset($_POST['submit']))
{
    $record_id=$objSql->sanitize($_GET['id']);
    $level=$objSql->sanitize($_POST['level']);
    $sql = "UPDATE bm_level_master SET level='$level' WHERE id='$record_id'";
    $record = $objSql->executeSql($sql);
    if($record)
    {
        header('location:manage_levels.php?updated');
    }
}


?>
<!-- page heading start-->
<div class="page-heading">
    <h3>Edit Level</h3>
    <ul class="breadcrumb">
        <li>
            <a href="index.php">Dashboard</a>
        </li>
        <li class="active"> Add New Level </li>
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
                    Edit Level Form
                </header>
                <div class="panel-body">
                    <form action="" role="form" method="post">
                        <div class="form-group">
                            <label for="new_level">Edit Level</label>
                            <input required="required" class="form-control" name="level" id="new_level" placeholder="Enter Level Name" type="text" value="<?php echo ($level)?$level:'';  ?>">
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


