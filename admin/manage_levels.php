<?php include('includes/header.php');?>
<?php
$objSql = new SqlClass();

$sql = "SELECT id,level FROM bm_level_master";
$records = $objSql->executeSql($sql);


?>
<!-- page heading start-->
<div class="page-heading">
    <h3>Manage Levels</h3>
    <ul class="breadcrumb">
        <li>
            <a href="index.php">Dashboard</a>
        </li>
        <li class="active"> Manage Levels </li>
    </ul>
</div>
<!-- page heading end-->

<!--body wrapper start-->
<section class="wrapper">
    <!-- page start-->
    <?php if(isset($_GET['updated'])): ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-success">Level Updated Successfully</div>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    All Levels
                </header>
                <div class="panel-body">
                    <table  class="display table table-bordered table-striped" id="dynamic-table">
                        <thead>
                        <tr>
                            <th width="70%">Level</th>
                            <th>Edit</th>
                            <th>Trash</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while($record=$objSql->fetchRow($records)): ?>
                            <tr>
                                <td><?php echo $record['level']; ?></td>
                                <td><a href="edit_level.php?id=<?php echo $record['id']; ?>"><i class="fa fa-edit"></i></a></td>
                                <td><a href=""><i class="fa fa-trash text-danger"></i></a></td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>

                </div>
            </section>
        </div>
    </div>

    <!-- page end-->
</section>
<!--body wrapper end-->

<?php include('includes/footer.php');?>


