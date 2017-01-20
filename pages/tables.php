<?php 
    require_once("includes/header.php");
?>
<!-- including page specific JS -->
 <script src="js/dashboard_basic_scripts.js"></script>
 <!-- including JS & CSS files for bootsrap multi select dropdown -->
<script type="text/javascript" src="js/bootstrap-multiselect.js" ></script>
<link href="css/bootstrap-multiselect.css" rel="stylesheet">
        <!-- Page main content Starts -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Customized Metric Stats</h1>
                    <div class="form-group">
                            <div id="sts_fltr_msg" style="display: none;" class="alert alert-danger"></div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
                <div style="display: block;" class="sts-filter col-lg-12">
                    <div class="col-lg-3" >
                        <div class="form-group">
                            <input id="report-strt-dt" data-toggle="tooltip" title="Week Start date yyyy/mm/dd" class="form-control" type="date" placeholder="yyyy/mm/dd">
                        </div>
                    </div>
                    <div class="col-lg-3" >
                        <div class="form-group">
                            <input id="report-end-dt" data-toggle="tooltip" title="Week End date yyyy/mm/dd" class="form-control" type="date" placeholder="yyyy/mm/dd">
                        </div>
                    </div>
                    <div class="col-lg-2" >
                        <div class="form-group">
                            <select id="set-projects" class="form-control" data-toggle="tooltip" title="Select your project" multiple="multiple">
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2" >
                        <div class="form-group">
                            <select id="display-cols" class="form-control" data-toggle="tooltip" title="Columns to display" multiple="multiple">
                            <option value="0">Week</option>
                            <option value="1">Project</option>
                            <option value="2">POC(s)</option>
                            <option value="3">Team Size</option>
                            <option value="4">Sprint End date</option>
                            <option value="5">Current Work</option>
                            <option value="6">Future work</option>
                            <option value="7">Challenges</option>
                            <option value="8">Quality</option>
                            <option value="9">Impact</option>
                            <option value="10">Test execution</option>
                            <option value="11">Test Design</option>
                            <option value="12">Ramp up/down</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">    
                            <button id="sts-fltr-srch" type="button" class="btn btn-primary">Search <i class="fa fa-search"></i> </button>
                        </div>
                    </div>
                </div>  
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <!-- <div class="text-right">DataTables Advanced Tables</div> -->
                           
                            <div class="dropdown text-left">
                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Export
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <!-- <li><a href="#" onClick ="$('#dataTables-example').tableExport({type:'pdf',escape:'false'});">PDF</a></li> -->
                                    <li><a href="#" onClick ="$('#prj-sts-reports-tbl').tableExport({type:'excel',escape:'false'});">Excell</a></li>
                                </ul>
                                <button class="btn btn-default" id="fltr-tgl-btn">Filter results</button>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" id="sts-table-panel" style="overflow-x: scroll;">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="prj-sts-reports-tbl" style="position:relative">
                                <thead>
                                    <tr>
                                        <th>Week</th>
                                        <th>Project</th>
                                        <th>POC(s)</th>
                                        <th>Team Size</th>
                                        <th>Sprint End date</th>
                                        <th>Current Work</th>
                                        <th>Future work</th>
                                        <th>Challenges</th>
                                        <th>Quality</th>
                                        <th>Impact</th>
                                        <th>Test execution</th>
                                        <th>Test Design</th>
                                        <th>Ramp up/down</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // Creating SQL Connection
                                        $con=create_sqlConnection();
                                        // Setting the query string
                                        $sts_query="select * from `project_maritz`";
                                        // Executing Query to get login details
                                        $res=exeQuery($sts_query,$con);
                                        if($res->num_rows > 0)
                                        {
                                            $i=1;
                                            while ($row = $res->fetch_assoc()) 
                                            {   
                                                //  Getting Date of report logged
                                                $raw_week=$row['for week'];
                                                $week_year=explode(",",$raw_week);
                                                $year=$week_year[1];
                                                $week=$week_year[0];
                                                //Returns the date of monday in week
                                                $from = date("d", strtotime("{$year}-W{$week}-1"));
                                                //Returns the date of Sunday in week 
                                                $to = date("d-M-y", strtotime("{$year}-W{$week}-7"));
                                                // Calculating search data for report
                                                $srch_key=(new DateTime($to, new DateTimeZone('Asia/Calcutta')))->format('U');
                                                //  Getting name Project for which report logged for

                                                // printing data to table
                                                echo "<tr class='gradeX ".($i%2==0 ? "odd" : "even")."' >
                                                <td data-search='".$srch_key."'value='".$raw_week."'>".$from." to ".$to."</td>
                                                <td>".getProjectName($row['project id'], $con)."</td>
                                                <td>".$row['point of contact']."</td>
                                                <td>".$row['team_size']."</td>
                                                <td>".$row['sprint_end_date']."</td>
                                                <td>".$row['current work']."</td>
                                                <td>".$row['future work']."</td>
                                                <td>".$row['challenges']."</td>
                                                <td>".$row['quality']."</td>
                                                <td>".$row['impact']."</td>
                                                <td>".$row['execution']."</td>
                                                <td>".$row['design']."</td>
                                                <td>".$row['ramupdown']."</td>
                                                </tr>";
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper Main content Ends-->
<!-- Including some page level required JS files -->
<!-- Base JS file for exporting function -->
    <script type="text/javascript" src="js/tableExport.js" ></script>
    <script type="text/javascript" src="js/jquery.base64.js" ></script>
    <!-- JS to Export to PDF -->
    <script type="text/javascript" src="jspdf/libs/sprintf.js" ></script>
    <script type="text/javascript" src="jspdf/jspdf.js" ></script>
    <script type="text/javascript" src="jspdf/libs/base64.js" ></script>
    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
    <!-- Scripts required for this page -->
    <script type="text/javascript" src="js/table_scripts.js" ></script>

<?php
    require_once("includes/footer.php");
?>