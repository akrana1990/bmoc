<?php include('includes/header.php');?>
<?php
$objSql = new SqlClass();

$sql = "SELECT id,subject FROM bm_subject_master";
$records = $objSql->executeSql($sql);


?>
<!-- page heading start-->
<div class="page-heading">
    <h3>Manage Subjects</h3>
    <ul class="breadcrumb">
        <li>
            <a href="index.php">Dashboard</a>
        </li>
        <li class="active"> Manage Subjects </li>
    </ul>
</div>
<!-- page heading end-->

<!--body wrapper start-->
<section class="wrapper">
    <!-- page start-->
    <?php if(isset($_GET['updated'])): ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-success">Subject Updated Successfully</div>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    All Subjects
                </header>
                <div class="panel-body">
                    <table  class="display table table-bordered table-striped" id="dynamic-table">
                        <thead>
                        <tr>
                            <th width="70%">Subject</th>
                            <th>Edit</th>
                            <th>Trash</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while($record=$objSql->fetchRow($records)): ?>
                            <tr>
                                <td><?php echo $record['subject']; ?></td>
                                <td><a href="edit_subject.php?id=<?php echo $record['id']; ?>"><i class="fa fa-edit"></i></a></td>
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


