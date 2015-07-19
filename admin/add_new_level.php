<?php include('includes/header.php');?>
<?php
$objSql = new SqlClass();

if(isset($_POST['submit']))
{
    $new_level=$objSql->sanitize($_POST['new_level']);
    $sql = "INSERT INTO bm_level_master(level) values('".$new_level."')";
    $record = $objSql->executeSql($sql);
    if(!$record)
    {
        header('location:add_new_level.php?error');
    }
    else
    {
        header('location:manage_levels.php');
    }
}


?>
<!-- page heading start-->
<div class="page-heading">
    <h3>Add New Level</h3>
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
                    New Level Addition Form
                </header>
                <div class="panel-body">
                    <form action="" role="form" method="post">
                        <div class="form-group">
                            <label for="new_level">Add New Level</label>
                            <input required="required" class="form-control" name="new_level" id="new_level" placeholder="Enter Level Name" type="text">
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


