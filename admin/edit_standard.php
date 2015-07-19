<?php include('includes/header.php');?>
<?php
$objSql = new SqlClass();
$standard='';

if(isset($_GET['id']))
{
    $record_id=$objSql->sanitize($_GET['id']);

    $sql = "SELECT id,standard FROM bm_standard_master WHERE id='$record_id'";
    $query = $objSql->executeSql($sql);
    if($query)
    {
        $record=$objSql->fetchRow($query);
        $standard=$record['standard'];
    }

}

if(isset($_POST['submit']))
{
    $record_id=$objSql->sanitize($_GET['id']);

    $standard=$objSql->sanitize($_POST['standard']);
    $sql = "UPDATE bm_standard_master SET standard='$standard' WHERE id='$record_id'";
    $record = $objSql->executeSql($sql);
    if($record)
    {
        header('location:manage_standards.php?updated');
    }
}


?>
<!-- page heading start-->
<div class="page-heading">
    <h3>Edit Standard</h3>
    <ul class="breadcrumb">
        <li>
            <a href="index.php">Dashboard</a>
        </li>
        <li class="active"> Add New Standard </li>
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
                    Edit Standard Form
                </header>
                <div class="panel-body">
                    <form action="" role="form" method="post">
                        <div class="form-group">
                            <label for="new_standard">Edit Standard</label>
                            <input required="required" class="form-control" name="standard" id="new_standard" placeholder="Enter Standard Name" type="text" value="<?php echo ($standard)?$standard:'';  ?>">
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


