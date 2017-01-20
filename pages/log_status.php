<?php 
    require_once("includes/header.php");
?>
<!-- including page specific JS -->
 <script src="js/log_project_status.js"></script>

        <!-- Page Main content starts -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Weekly Status!</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Account: Maritz
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form id="lg-wkly-sts-frm" role="form">
                                    <div class="row">
                                        <div class="form-group">
                                            <div id="sts_frm_msg" style="display: none" class="alert alert-danger"></div>
                                        </div>
                                    </div>
                                    <!-- 1st Row of Form elements -->
                                        <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label>Team Details</label>
                                        </div>
                                        <div class="col-lg-3" >
                                            <div class="form-group">
                                                <select id="set-projects" class="form-control" data-toggle="tooltip" title="Select your project">
                                                <option value="">Select your Project</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">    
                                                <input id="team-size" data-toggle="tooltip" title="Enter Team size" class="form-control" placeholder="Enter Team size" type="number" min=0>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">    
                                                <input id="sprint-end-date" data-toggle="tooltip" title="Sprint End date mm/dd//yyyy" class="form-control" type="date" placeholder="mm/dd//yyyy">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">    
                                                <input id="project-poc" data-toggle="tooltip" title="Project point of contact" class="form-control" placeholder="Emp Id's with coma delimiter">
                                            </div>
                                        </div>
                                        </div>
                                        <!-- 2nd row form Elements -->
                                        <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label>Work Details</label>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">    
                                                <textarea id="cur-work" data-toggle="tooltip" title="Current week work" class="form-control" placeholder="Your current week work status..." rows="6" ></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group"> 
                                                <textarea id="future-work" data-toggle="tooltip" title="Next week expected work" class="form-control" placeholder="Your next week Expected work..." rows="6" ></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <select id="prj-chlng" class="form-control" data-toggle="tooltip" title="Any challenge in project">
                                                <option value="">Challenges in project</option>
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                                </select>
                                                <textarea id="prj-chlng-desc" data-toggle="tooltip" title="Explain in detail" class="form-control" placeholder="Explain in detail..." rows="4" disabled="disabled"></textarea>
                                            </div>
                                        </div>
                                        </div>
                                        <!-- 3rd Row Elements -->
                                        <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label>RAG-WMP Status &amp; Metrics</label>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group input-group">    
                                                 <input id="prj-qlty" data-toggle="tooltip" title="Project Quality" class="form-control" type="number" max="100" min="0" placeholder="Quality">
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group input-group">    
                                                 <input id="prj-impact" data-toggle="tooltip" title="Risk Impact on Schedules, if any" class="form-control" type="number" max="100" min="0" placeholder="Impact">
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group input-group">    
                                                 <input id="tst-exe" data-toggle="tooltip" title="Test Execution" class="form-control" type="number" max="100" min="0" placeholder="Execution">
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group input-group">    
                                                 <input id="tst-dsgn" data-toggle="tooltip" title="Test Design" class="form-control" type="number" max="100" min="0" placeholder="Design">
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">    
                                                 <select id="ram-up-dwn" class="form-control" data-toggle="tooltip" title="Project Ramp up/down">
                                                <option value="NA">Ram up/down</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        </div>
                                        <!-- 4th Row Elements -->
                                        <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label>Appreciation Mail</label>
                                        </div>
                                         <div class="col-lg-12">
                                            <div class="form-group">
                                                <!-- <span class="input-group-addon">Appreciation mails</span> -->
                                                <input id="appr-file-pth" type="file" rows="2">
                                            </div>
                                        </div>
                                        </div>
                                        <!-- 5th Row Elements -->
                                        <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label>Go on</label>
                                        </div>
                                         <div class="col-lg-4">
                                            <div class="form-group"> 
                                                <button id="wkly-sts-sbmt" type="button" class="btn btn-primary">I'm Done! Take my note</button>
                                            </div>
                                        </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
<script type="text/javascript">
    $("documnet").ready(setEmpProjects());
</script>
<?php 
    require_once("includes/footer.php");
?>