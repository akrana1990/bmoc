<?php include('includes/header.php');?>

        <!-- page heading start-->
        <div class="page-heading">
            <h3>Upload Sample Paper</h3>
            <ul class="breadcrumb">
                <li>
                     <a href="index.php">Dashboard</a>
                </li>
                <li class="active"> Upload Sample Paper </li>
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
                        Upload Sample Paper Form
                    </header>
                    <div class="panel-body">
                        <form role="form">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">File input</label>
                                <input type="file" id="exampleInputFile">
                                <p class="help-block">Example block-level help text here.</p>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> Check me out
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

                    </div>
                </section>
            </div>
            <div class="col-lg-6">
                <section class="panel">
                    <header class="panel-heading">
                        Horizontal Forms
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Email</label>
                                <div class="col-lg-10">
                                    <input type="email" class="form-control" id="inputEmail1" placeholder="Email">
                                    <p class="help-block">Example block-level help text here.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword1" class="col-lg-2 col-sm-2 control-label">Password</label>
                                <div class="col-lg-10">
                                    <input type="password" class="form-control" id="inputPassword1" placeholder="Password">
                                    <!--<p class="help-block">Example block-level help text here.</p>-->
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile2" class="col-lg-2 col-sm-2 control-label">File input</label>
                                <div class="col-lg-10">
                                <input type="file" id="exampleInputFile2">
                                <p class="help-block">Example block-level help text here.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Remember me
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button type="submit" class="btn btn-primary">Sign in</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>

            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">

                    <div class="panel-body">
                        <a href="#myModal" data-toggle="modal" class="btn btn-xs btn-info">
                            Form in Modal
                        </a>
                        <a href="#myModal-1" data-toggle="modal" class="btn btn-xs btn-success">
                            Form in Modal 2
                        </a>
                        <a href="#myModal-2" data-toggle="modal" class="btn btn-xs btn-warning">
                            Form in Modal 3
                        </a>

                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title">Form Tittle</h4>
                                    </div>
                                    <div class="modal-body">

                                        <form role="form">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Enter email">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Password</label>
                                                <input type="password" class="form-control" id="exampleInputPassword3" placeholder="Password">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputFile">File input</label>
                                                <input type="file" id="exampleInputFile3">
                                                <p class="help-block">Example block-level help text here.</p>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox"> Check me out
                                                </label>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal-1" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title">Form Tittle</h4>
                                    </div>
                                    <div class="modal-body">

                                        <form class="form-horizontal" role="form">
                                            <div class="form-group">
                                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Email</label>
                                                <div class="col-lg-10">
                                                    <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputPassword1" class="col-lg-2 col-sm-2 control-label">Password</label>
                                                <div class="col-lg-10">
                                                    <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox"> Remember me
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">
                                                    <button type="submit" class="btn btn-primary">Sign in</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal-2" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title">Form Tittle</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-inline" role="form">
                                            <div class="form-group">
                                                <label class="sr-only" for="exampleInputEmail2">Email address</label>
                                                <input type="email" class="form-control sm-input" id="exampleInputEmail5" placeholder="Enter email">
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only" for="exampleInputPassword2">Password</label>
                                                <input type="password" class="form-control sm-input" id="exampleInputPassword5" placeholder="Password">
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox"> Remember me
                                                </label>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Sign in</button>
                                        </form>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- page end-->
        </section>
        <!--body wrapper end-->

<?php include('includes/footer.php');?>
