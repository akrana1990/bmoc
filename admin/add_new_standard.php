<?php include('includes/header.php');?>
<?php
$objSql = new SqlClass();

if(isset($_POST['submit']))
{
    $new_standard=$objSql->sanitize($_POST['new_standard']);
    $sql = "INSERT INTO bm_standard_master(standard) values('".$new_standard."')";
    $record = $objSql->executeSql($sql);
    if(!$record)
    {
        header('location:add_new_standsrd.php?error');
    }
}


?>
<!-- page heading start-->
<div class="page-heading">
    <h3>Add New Standard</h3>
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
                New Standard Addition Form
            </header>
            <div class="panel-body">
                <form action="" role="form" method="post">
                    <div class="form-group">
                        <label for="new_standard">Add New Standard</label>
                        <input required="required" class="form-control" name="new_standard" id="new_standard" placeholder="Enter Standard Name" type="text">
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


