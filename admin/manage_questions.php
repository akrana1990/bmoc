<?php include('includes/header.php');?>
<?php
define("UPLOAD_DIR", "uploads/");
$objSql = new SqlClass();

$sql = "SELECT bmq.id,bmq.question_type,bmq.status,bmq.question,bmq.created_at,
              bmst.standard,bmsub.subject,bmlevel.level

        FROM bm_questions as bmq
        LEFT JOIN bm_standard_master as bmst ON bmq.standard = bmst.id
        LEFT JOIN bm_subject_master as bmsub ON bmq.subject = bmsub.id
        LEFT JOIN bm_level_master as bmlevel ON bmq.question_level = bmlevel.id
        ORDER BY created_at DESC LIMIT 50
        ";

$records = $objSql->executeSql($sql);

/*echo'<pre>';
print_r($records);
echo'</pre>';*/


?>
<!-- page heading start-->
<div class="page-heading">
    <h3>Manage Questions</h3>
    <ul class="breadcrumb">
        <li>
            <a href="index.php">Dashboard</a>
        </li>
        <li class="active"> Manage Questions </li>
    </ul>
</div>
<!-- page heading end-->

<!--body wrapper start-->
<section class="wrapper">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Search Questions
                </header>
                <div class="panel-body">
                    <form class="form-inline" action="" method="post">
                        <div class="form-group">
                            <select class="form-control">
                                <option>Select Standard</option>
                                <option>Standard1</option>
                                <option>Standard2</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control">
                                <option>Select Subject</option>
                                <option>Subject</option>
                                <option>Subject</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control">
                                <option>Select Level</option>
                                <option>Level</option>
                                <option>Level</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <select class="form-control">
                                <option>Select Type</option>
                                <option>Type</option>
                                <option>Type</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control">
                                <option>Select Status</option>
                                <option>Status</option>
                                <option>Status</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" name="search"><i class="fa fa-search"></i>&nbsp;Search</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Questions
                </header>
                <div class="panel-body">
                    <table  class="display table table-striped" id="dynamic-table">
                        <thead>
                        <tr>
                            <th>Standard</th>
                            <th>Subject</th>
                            <th>Level</th>
                            <th>Question</th>
                            <th>Type</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Edit</th>
                            <th class="text-center">Trash</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while($record=$objSql->fetchRow($records)): ?>
                            <tr>
                                <td><?php echo $record['standard']; ?></td>
                                <td><?php echo $record['subject']; ?></td>
                                <td><?php echo $record['level']; ?></td>

                                <td style="width: 350px;word-break: break-all;word-wrap: break-word"><?php
                                    if($record['question_type']=='objective')
                                    {
                                        $question_array=json_decode($record['question'],true);
                                        if($question_array){ echo $question_array['question']; }
                                    }
                                    elseif($record['question_type']=='single_answer')
                                    {
                                        echo $record['question'];
                                    }
                                    elseif($record['question_type']=='audio')
                                    {?>
                                        <audio controls>
                                            <source src="<?php echo UPLOAD_DIR.'audio/'.$record['question']; ?>" type="audio/mpeg">
                                            <source src="horse.ogg" type="audio/ogg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    <?php
                                    }
                                    elseif($record['question_type']=='video')
                                    {?>
                                        <video width="320" height="240" autoplay>
                                            <source src="<?php echo UPLOAD_DIR.'video/'.$record['question']; ?>" type="video/mp4">
                                            <source src="movie.ogg" type="video/ogg">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php
                                    }
                                    elseif($record['question_type']=='static_image')
                                    {
                                        echo '<img style="max-height:100px" src="'.UPLOAD_DIR.'image/'.$record['question'].'">';
                                    }

                                    ?>
                                </td>

                                <td><?php echo $record['question_type']; ?></td>
                                <td class="text-center"><?php echo $record['status']; ?></td>
                                <td class="text-center"><a href="edit_question.php?id=<?php echo $record['id']; ?>"><i class="fa fa-edit"></i></a></td>
                                <td class="text-center"><a href="#"><i class="fa fa-trash text-danger"></i></a></td>
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


