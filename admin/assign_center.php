<?php include('includes/header.php');
$objSql = new SqlClass();
$sql = "SELECT * FROM bm_centers";
$record = $objSql->executeSql($sql);
?>

        <!-- page heading start-->
        <div class="page-heading">
            <h3>
                Assign Center to Student
            </h3>
            <ul class="breadcrumb">
                <li>
                     <a href="index.php">Dashboard</a>
                </li>
                <li class="active"> Assign Center </li>
            </ul>
        </div>
        <!-- page heading end-->

        <!--body wrapper start-->
        <div class="wrapper">
		
		
            <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            All Centers
                        </header>
                        <div class="panel-body">
                            <table class="table  table-hover general-table">
                                <thead>
                                <tr>
                                    <th> Center Name</th>
                                    <th>Center Address</th>
                                    <th>Status</th>
									<th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
								<?php while($row = $objSql->fetchRow($record)) { ?>
                                <tr>
                                    <td><?php echo $row['center_name'];?></td>
									<td><?php echo $row['address'];?></td>
									<?php if($row['status']=="active"){
									$class="label-success";}else{ $class="label-danger";}?>
                                    <td><span class="label <?php echo $class;?> label-mini"><?php echo ucfirst($row['status']);?></span></td>
									<td><p style="float:left;margin-right:5px;"><button type="button" class="btn btn-primary"><i class="fa fa-eye"></i> Edit </button></p><p><button type="button" class="btn btn-danger">Delete</button></p></td>
                                </tr>
								<?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        
		
		
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                        Assign Center
                        </header>
                        <div class="panel-body">
                            <div class="form">
                                <form class="cmxform form-horizontal adminex-form" id="signupForm" method="get" action="">
                                    <div class="form-group ">
                                        <label for="firstname" class="control-label col-lg-2">Firstname</label>
                                        <div class="col-lg-10">
                                            <input class=" form-control" id="firstname" name="firstname" type="text" />
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="lastname" class="control-label col-lg-2">Lastname</label>
                                        <div class="col-lg-10">
                                            <input class=" form-control" id="lastname" name="lastname" type="text" />
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="username" class="control-label col-lg-2">Username</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " id="username" name="username" type="text" />
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="password" class="control-label col-lg-2">Password</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " id="password" name="password" type="password" />
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="confirm_password" class="control-label col-lg-2">Confirm Password</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " id="confirm_password" name="confirm_password" type="password" />
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="email" class="control-label col-lg-2">Email</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " id="email" name="email" type="email" />
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="agree" class="control-label col-lg-2 col-sm-3">Agree to Our Policy</label>
                                        <div class="col-lg-10 col-sm-9">
                                            <input  type="checkbox" style="width: 20px" class="checkbox form-control" id="agree" name="agree" />
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="newsletter" class="control-label col-lg-2 col-sm-3">Receive the Newsletter</label>
                                        <div class="col-lg-10 col-sm-9">
                                            <input  type="checkbox" style="width: 20px" class="checkbox form-control" id="newsletter" name="newsletter" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button class="btn btn-primary" type="submit">Save</button>
                                            <button class="btn btn-default" type="button">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <!--body wrapper end-->

<?php include('includes/footer.php');?>
