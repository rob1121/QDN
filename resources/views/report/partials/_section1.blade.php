            <!-- SECOND PANEL -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">DISPOSITION:</h3>
                </div>
                <div class="panel-body">
                    <div class="container table">
                    @foreach ($disposition_check as $disposition)
                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 pull-left"><input type='radio' name='disposition' disabled   value='{{ $disposition }}' <?=$qdn->disposition == Str::upper($disposition) ? 'checked' : '';?>> {{ Str::upper($disposition) }}</div>
                    @endforeach
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
                    @foreach ($cod_check as $cod)
                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 pull-left"><input type='radio' name='cause_of_defect'   value='{{ $cod }}' <?=$qdn->causeOfDefect->cause_of_defect == Str::upper($cod) ? 'checked' : '';?>> {{ Str::upper($cod) }}</div>
                    @endforeach
                    </div>
                    <div class="row">
                        <!-- CAUSE OF DEFECT OE -->
                        <div class='form-group text-left col-sm-3'><label for="">CAUSE OF DEFECTS OE:</label>
                             <br>
                             <span class="btn btn-default" id="upload-btn">
                                 <i class="fa fa-plus"></i>
                                 <span>Select File..</span>
                             </span>
                            <div class="hide-file-uploader"><input type='file' name='upload_cod' id="upload-file"></div>
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
                        <textarea rows="12" id="containment-action-textarea" name="containment_action_textarea">
                            {{ $qdn->containmentAction->what }}
                        </textarea>
                    </div>
                    <div class="col-sm-3">
                        <br>
                        <div class="form-group">
                            <strong> WHO:</strong>
                            <input type='text' class="form-control" placeholder='Input Personnel' name='containment_action_who' value="<?php echo htmlentities($qdn->containmentAction->who);?>" >
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
                            <div class="hide-file-uploader"><input type='file' name='upload_containment_action' id="upload-file"></div>
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
                            <input type='text' class="form-control" placeholder='Input Personnel' name='corrective_action_whi' value="<?php echo htmlentities($qdn->correctiveAction->who);?>" >
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
                            <div class="hide-file-uploader"><input type='file' name='upload_corrective_action' id="upload-file"></div>
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
                            <input type='text' class="form-control" placeholder='Input Personnel' name='preventive_action_who' value="<?php echo htmlentities($qdn->preventiveAction->who);?>" ></div>
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