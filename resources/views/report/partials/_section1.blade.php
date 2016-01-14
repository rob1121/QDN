            <!-- SECOND PANEL -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">DISPOSITION:</h3>
                </div>
                <div class="panel-body">
                    <div class="container table">
                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 pull-left"><input type='radio' name='dispo' disabled   value='USE AS IS' <?=$qdn->disposition == 'USE AS IS' ? 'checked' : '';?>> USE AS IS</div>
                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 pull-left"><input type='radio' name='dispo' disabled   value='NCMR#' <?=$qdn->disposition == 'NCMR#' ? 'checked' : '';?>> NCMR#</div>
                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 pull-left"><input type='radio' name='dispo' disabled   value='REWORK' <?=$qdn->disposition == 'REWORK' ? 'checked' : '';?>> REWORK</div>
                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 pull-left"><input type='radio' name='dispo' disabled   value='SPLIT LOT' <?=$qdn->disposition == 'SPLIT LOT' ? 'checked' : '';?>> SPLIT LOT</div>
                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 pull-left"><input type='radio' name='dispo' disabled   value='SHUTDOWN' <?=$qdn->disposition == 'SHUTDOWN' ? 'checked' : '';?>> SHUTDOWN</div>
                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 pull-left"><input type='radio' name='dispo' disabled   value='SHIPBACK' <?=$qdn->disposition == 'SHIPBACK' ? 'checked' : '';?>> SHIPBACK</div>
                    </div>
                </div>
            </div>
            <!-- THIRD PANEL -->
            <div class="panel panel-default">
                <div class="panel-heading">
                <h3 class="panel-title">CAUSE OF DEFECTS/ FAILURE:</h3>
                </div>
                <div class="panel-body">
                    <div class="container table">
                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 pull-left"><input type='radio' name='cod'   value='PRODUCTION' <?=$qdn->causeOfDefect->cause_of_defect == 'PRODUCTION' ? 'checked' : '';?>> PRODUCTION</div>
                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 pull-left"><input type='radio' name='cod'   value='PROCESS' <?=$qdn->causeOfDefect->cause_of_defect == 'PROCESS' ? 'checked' : '';?>> PROCESS</div>
                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 pull-left"><input type='radio' name='cod'   value='MAINTENANCE' <?=$qdn->causeOfDefect->cause_of_defect == 'MAINTENANCE' ? 'checked' : '';?>> MAINTENANCE</div>
                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 pull-left"><input type='radio' name='cod'   value='FACILITIES' <?=$qdn->causeOfDefect->cause_of_defect == 'FACILITIES' ? 'checked' : '';?>> FACILITIES</div>
                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 pull-left"><input type='radio' name='cod'   value='QUALITY ASSURANCE' <?=$qdn->causeOfDefect->cause_of_defect == 'QUALITY ASSURANCE' ? 'checked' : '';?>> QUALITY ASSURANCE</div>
                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 pull-left"><input type='radio' name='cod'   value='OTHERS' <?=$qdn->causeOfDefect->cause_of_defect == 'OTHERS' ? 'checked' : '';?>> OTHERS</div>
                    </div>
                    <div class="row">
                        <!-- CAUSE OF DEFECT OE -->
                        <div class='form-group text-left col-sm-3'><label for="">CAUSE OF DEFECTS OE:</label>
                        <?php if ($qdn->causeOfDefect->objective_evidence != null): ?>
                            <br/><a href="#pd1_modal" class="text-success" data-toggle="modal">Click to View</a> or
                        <?php endif;?>
                        <input type='file' name='uppd1'  data-buttonBefore='true'>
                        <?=isset($err_pd1) ? $err_pd1 : '';?>
                        </div>
                    </div>
                    <textarea rows='5' id='cause_of_defect_description' name='cause_of_defect_description' >
                        {{ $qdn->causeOfDefect->cause_of_Defect_description }}
                    </textarea>
                </div>
            </div>
            <!-- FOURTH PANEL -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">CONTAINMENT ACTION/S:</h3>
                </div>
                <div class="panel-body">
                    <!-- CONTAINEMENT ACTION WHAT -->
                    <div class="col-sm-9">
                        <textarea rows="12" id="containment_action_textarea" name="containment_action_textarea">
                            {{ $qdn->containmentAction->what }}
                        </textarea>
                    </div>
                    <div class="col-sm-3">
                        <br>
                        <div class="form-group">
                            <strong> WHO:</strong>
                            <input type='text' class="form-control" placeholder='Input Personnel' name='whocn1' value="<?php echo htmlentities($qdn->containmentAction->who);?>" >
                        </div>
                        <!-- CONTAINEMENT ACTION WHEN -->
                        <div class="form-group">
                            <strong> WHEN:</strong>
                            <input
                                class="form-control"
                                type="text"
                                name="containment_action_taken"
                                id="containment-action-taken"
                                value="{{ Carbon::parse($qdn->containmentAction->updated_at)
                                    ->format('m/d/Y') }}"
                                placeholder="Input date"
                                readonly
                            >
                        </div>
                        <!-- CONTAINEMENT ACTION OE -->
                        <div class="form-group">
                            <strong>CONTAINMENT ACTION OE:</strong>
                             <br>
                             <span class="btn btn-default" id="upload-btn">
                                 <i class="fa fa-plus"></i>
                                 <span>Select File..</span>
                             </span>
                            <div class="hide-file-uploader"><input type='file' name='upload_preventive_action' id="upload-file"></div>
                        </div>
                </div>
            </div>
            <!-- FIFTH PANEL -->
            <div class="panel panel-default">
                <div class="panel-heading">
                <h3 class="panel-title">CORRECTIVE ACTION/S:</h3>
                </div>
                <div class="panel-body">
                    <!-- CORRECTIVE ACTION/S WHAT -->
                    <div class="col-sm-9 text-center">
                        <textarea rows="12" id="corrective_action_textarea" name="corrective_action_textarea">
                            {{ $qdn->correctiveAction->what }}
                        </textarea>
                    </div>
                    <div class="col-sm-3">
                        <br>
                        <!-- CORRECTIVE ACTION/S WHO -->
                        <div class="form-group">
                            <strong> WHO:</strong>
                            <input type='text' class="form-control" placeholder='Input Personnel' name='whoca1' value="<?php echo htmlentities($qdn->correctiveAction->who);?>" >
                        </div>
                        <!-- CORRECTIVE ACTION/S WHEN -->
                        <div class="form-group">
                            <strong> WHEN:</strong>
                            <input
                                class="form-control"
                                type="text"
                                name="corrective_action_taken"
                                id="corrective-action-taken"
                                value="{{ Carbon::parse($qdn->correctiveAction->updated_at)
                                    ->format('m/d/Y') }}"
                                placeholder="Input date"
                                readonly
                            >
                        </div>
                        <!-- CORRECTIVE ACTION/S OE -->
                        <div class="form-group">
                            <strong>CORRECTIVE ACTION OE:</strong>
                             <br>
                             <span class="btn btn-default" id="upload-btn">
                                 <i class="fa fa-plus"></i>
                                 <span>Select File..</span>
                             </span>
                            <div class="hide-file-uploader"><input type='file' name='upload_preventive_action' id="upload-file"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- SIXTH PANEL -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">PREVENTIVE ACTION/S:</h3>
                </div>
                <div class="panel-body">
                    <!-- PREVENTIVE ACTION/S WHAT -->
                    <div class="col-sm-9 text-center">
                        <textarea rows="12" id="preventive_action_textarea" name="preventive_action_textarea">
                            {{ $qdn->preventiveAction->what }}
                        </textarea>
                        </div>
                    <div class="col-sm-3">
                        <br>
                        <!-- PREVENTIVE ACTION/S WHO -->
                        <div class="form-group">
                            <strong> WHO:</strong>
                            <input type='text' class="form-control" placeholder='Input Personnel' name='whopa1' value="<?php echo htmlentities($qdn->preventiveAction->who);?>" ></div>
                        <!-- PREVENTIVE ACTION/S WHEN -->
                        <div class="form-group">
                            <strong> WHEN:</strong>
                            <input
                                class="form-control"
                                type="text"
                                name="preventive_action_taken"
                                id="preventive-action-taken"
                                value="{{ Carbon::parse($qdn->preventiveAction->updated_at)
                                    ->format('m/d/Y') }}"
                                placeholder="Input date"
                                readonly
                            >
                        </div>
                        <!-- PREVENTIVE ACTION/S OE -->
                        <div class="form-group">
                            <strong>PREVENTIVE ACTION OE:</strong>
                             <br>
                             <span class="btn btn-default" id="upload-btn">
                                 <i class="fa fa-plus"></i>
                                 <span>Select File..</span>
                             </span>
                            <div class="hide-file-uploader"><input type='file' name='upload_preventive_action' id="upload-file"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br/>
    <!-- END OF WELL CLASS -->
    </div>