<div class="container">
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Section D - Must Be Completed By Transferor/Seller Even If The Firearm(s) is
                        Not Transferred</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<form action="" method="post" id="sec_d_form">
    <input type="hidden" name="record_id" value="<?php echo $id; ?>">
    <div class="container">
    <div class="row">
        <div class="col-sm">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="name">Firearm(s)</label>
                            </div>
                        </div>
                        <div class="row section-d-list">
                            <div class="col-sm-1"> 1 )
                               <!-- <button class="btn btn-light"><i class="fa fa-trash-alt"></i></button>-->
                            </div>
                            <div class="col-sm-3"> <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                         title=" (If any) (If the manufacturer and importer are different, the FFL must include both.)"
                                                         style="width:100%">
              <input type="text" class="form-control multi-in-one" name="manufacturer_importer[]"  id="fName" aria-describedby=""
                     placeholder="24. Manufacturer &amp; Importer" value="<?php echo (!empty($firearms[0]['manufacturer_importer']))?$firearms[0]['manufacturer_importer']:'';?>">
              </span></div>
                            <div class="col-sm-2"> <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                         title=" (If Designated) (If the manufacturer and importer are different, the FFL must include both.)"
                                                         style="width:100%">
              <input type="text" class="form-control multi-in-one" name="model[]" id="fName" aria-describedby=""
                     placeholder="25. Model" value="<?php echo (!empty($firearms[0]['model']))?$firearms[0]['model']:'';?>">
              </span></div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control multi-in-one" name="serial_number[]" id="fName" aria-describedby=""
                                       placeholder="26. Serial Number" value="<?php echo (!empty($firearms[0]['serial_number']))?$firearms[0]['serial_number']:'';?>">
                            </div>
                            <div class="col-sm-2"> <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                         title=" (See Instructions for Question 27.)"
                                                         style="width:100%">
              <input type="text" class="form-control multi-in-one" name="type[]" id="fName" aria-describedby=""
                     placeholder="27. Type"  value="<?php echo (!empty($firearms[0]['type']))?$firearms[0]['type']:'';?>">
              </span></div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control multi-in-one" name="caliber_gauge[]" id="fName" aria-describedby=""
                                       placeholder="28. Caliber/Gauge" value="<?php echo (!empty($firearms[0]['caliber_gauge']))?$firearms[0]['caliber_gauge']:'';?>">
                            </div>
                        </div>
                        <div class="row section-d-list">
                            <div class="col-sm-1"> 2 )
                                <!--<button class="btn btn-light"><i class="fa fa-trash-alt"></i></button>-->
                            </div>
                            <div class="col-sm-3"> <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                         title=" (If any) (If the manufacturer and importer are different, the FFL must include both.)"
                                                         style="width:100%">
              <input type="text" class="form-control multi-in-one" name="manufacturer_importer[]"  id="fName" aria-describedby=""
                     placeholder="24. Manufacturer &amp; Importer" value="<?php echo (!empty($firearms[1]['manufacturer_importer']))?$firearms[1]['manufacturer_importer']:'';?>">
              </span></div>
                            <div class="col-sm-2"> <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                         title=" (If Designated) (If the manufacturer and importer are different, the FFL must include both.)"
                                                         style="width:100%">
              <input type="text" class="form-control multi-in-one" name="model[]" id="fName" aria-describedby=""
                     placeholder="25. Model" value="<?php echo (!empty($firearms[1]['model']))?$firearms[1]['model']:'';?>">
              </span></div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control multi-in-one" name="serial_number[]" id="fName" aria-describedby=""
                                       placeholder="26. Serial Number" value="<?php echo (!empty($firearms[1]['serial_number']))?$firearms[1]['serial_number']:'';?>">
                            </div>
                            <div class="col-sm-2"> <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                         title=" (See Instructions for Question 27.)"
                                                         style="width:100%">
              <input type="text" class="form-control multi-in-one" name="type[]" id="fName" aria-describedby=""
                     placeholder="27. Type"  value="<?php echo (!empty($firearms[1]['type']))?$firearms[1]['type']:'';?>">
              </span></div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control multi-in-one" name="caliber_gauge[]" id="fName" aria-describedby=""
                                       placeholder="28. Caliber/Gauge" value="<?php echo (!empty($firearms[1]['caliber_gauge']))?$firearms[1]['caliber_gauge']:'';?>">
                            </div>
                        </div>
                        <div class="row section-d-list">
                            <div class="col-sm-1"> 3 )
                              <!--  <button class="btn btn-light"><i class="fa fa-trash-alt"></i></button>-->
                            </div>
                            <div class="col-sm-3"> <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                         title=" (If any) (If the manufacturer and importer are different, the FFL must include both.)"
                                                         style="width:100%">
              <input type="text" class="form-control multi-in-one" name="manufacturer_importer[]"  id="fName" aria-describedby=""
                     placeholder="24. Manufacturer &amp; Importer" value="<?php echo (!empty($firearms[2]['manufacturer_importer']))?$firearms[2]['manufacturer_importer']:'';?>">
              </span></div>
                            <div class="col-sm-2"> <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                         title=" (If Designated) (If the manufacturer and importer are different, the FFL must include both.)"
                                                         style="width:100%">
              <input type="text" class="form-control multi-in-one" name="model[]" id="fName" aria-describedby=""
                     placeholder="25. Model" value="<?php echo (!empty($firearms[2]['model']))?$firearms[2]['model']:'';?>">
              </span></div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control multi-in-one" name="serial_number[]" id="fName" aria-describedby=""
                                       placeholder="26. Serial Number" value="<?php echo (!empty($firearms[2]['serial_number']))?$firearms[2]['serial_number']:'';?>">
                            </div>
                            <div class="col-sm-2"> <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                         title=" (See Instructions for Question 27.)"
                                                         style="width:100%">
              <input type="text" class="form-control multi-in-one" name="type[]" id="fName" aria-describedby=""
                     placeholder="27. Type"  value="<?php echo (!empty($firearms[2]['type']))?$firearms[2]['type']:'';?>">
              </span></div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control multi-in-one" name="caliber_gauge[]" id="fName" aria-describedby=""
                                       placeholder="28. Caliber/Gauge" value="<?php echo (!empty($firearms[2]['caliber_gauge']))?$firearms[2]['caliber_gauge']:'';?>">
                            </div>
                        </div>
                        <div class="row section-d-list">
                            <div class="col-sm-1"> 4 )
                                <!--<button class="btn btn-light"><i class="fa fa-trash-alt"></i></button>-->
                            </div>
                            <div class="col-sm-3"> <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                         title=" (If any) (If the manufacturer and importer are different, the FFL must include both.)"
                                                         style="width:100%">
              <input type="text" class="form-control multi-in-one" name="manufacturer_importer[]"  id="fName" aria-describedby=""
                     placeholder="24. Manufacturer &amp; Importer" value="<?php echo (!empty($firearms[3]['manufacturer_importer']))?$firearms[3]['manufacturer_importer']:'';?>">
              </span></div>
                            <div class="col-sm-2"> <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                         title=" (If Designated) (If the manufacturer and importer are different, the FFL must include both.)"
                                                         style="width:100%">
              <input type="text" class="form-control multi-in-one" name="model[]" id="fName" aria-describedby=""
                     placeholder="25. Model" value="<?php echo (!empty($firearms[3]['model']))?$firearms[3]['model']:'';?>">
              </span></div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control multi-in-one" name="serial_number[]" id="fName" aria-describedby=""
                                       placeholder="26. Serial Number" value="<?php echo (!empty($firearms[3]['serial_number']))?$firearms[3]['serial_number']:'';?>">
                            </div>
                            <div class="col-sm-2"> <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                         title=" (See Instructions for Question 27.)"
                                                         style="width:100%">
              <input type="text" class="form-control multi-in-one" name="type[]" id="fName" aria-describedby=""
                     placeholder="27. Type"  value="<?php echo (!empty($firearms[3]['type']))?$firearms[3]['type']:'';?>">
              </span></div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control multi-in-one" name="caliber_gauge[]" id="fName" aria-describedby=""
                                       placeholder="28. Caliber/Gauge" value="<?php echo (!empty($firearms[3]['caliber_gauge']))?$firearms[3]['caliber_gauge']:'';?>">
                            </div>
                        </div>

           <!--             <div class="row">
                            <div class="col-sm-3" style="padding-top: 10px;">
                                <button class="btn btn-block btn-success"><i class="fa fa-plus"></i> Add a Firearm
                                </button>
                            </div>
                            <div class="col-sm-9"></div>
                        </div>-->
                    </div>
                </div>

        </div>
    </div>
</div>
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">REMINDER - By the Close of Business Complete ATF Form 3310.4 For Multiple
                            Purchases of Handguns Within 5 Consecutive Business Days</h5>
                        <table class="table table-striped">
                            <tr>
                                <td>29. Total Number of Firearms Transferred <br>
                                    <em>(Please handwrite by printing e.g., zero, one, two, three, etc. Do not use
                                        numerals.)</em></td>
                                <td><input type="text" class="form-control multi-in-one" name="sec_d_one" id="fName" aria-describedby=""
                                           placeholder="One" value="<?php echo (!empty($record['sec_d_one']))?$record['sec_d_one']:'';?>"></td>
                            </tr>
                            <tr>
                                <td>30. Check if any part of this transaction is a pawn redemption.</td>
                                <td>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" value="1" <?php echo (!empty($record['sec_d_30_1']) && $record['sec_d_30_1'] == 1)?'checked':'' ?> name="sec_d_30_1" id="option1" autocomplete="off">
                                            YES </label>
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" value="0" <?php echo (empty($record['sec_d_30_1']) || $record['sec_d_30_1'] != 1)?'checked':'' ?> name="sec_d_30_1" id="option2" autocomplete="off">
                                            NO </label>
                                    </div>
                                    <br>
                                    <label>If Yes, which line item from above? </label>
                                    <input type="text" class="form-control multi-in-one" name="sec_d_30_2" id="fName" aria-describedby=""
                                           placeholder="1" value="<?php echo (!empty($record['sec_d_30_2']))?$record['sec_d_30_2']:'';?>"></td>
                            </tr>
                            <tr>
                                <td>31. For Use by Licensee <br>
                                    <small><em>(This item is for the licensee's use in recording any information he/ she
                                            finds necessary to conduct business.)</em></small>
                                </td>
                                <td><input type="text" class="form-control multi-in-one" name="sec_d_31" id="fName" aria-describedby=""
                                           placeholder="Type here" value="<?php echo (!empty($record['sec_d_31']))?$record['sec_d_31']:'';?>"></td>
                            </tr>
                            <tr>
                                <td>32. Check if this transaction is to facilitate a private party transfer.</td>
                                <td>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" value="1"  <?php echo (!empty($record['sec_d_32']) && $record['sec_d_32'] == 1)?'checked':'' ?> name="sec_d_32" id="option1" autocomplete="off">
                                            YES </label>
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" value="0"  <?php echo (empty($record['sec_d_32']) || $record['sec_d_32'] != 1)?'checked':'' ?> name="sec_d_32" id="option2" autocomplete="off">
                                            NO </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>33. Trade/corporate name and address of transferor/seller and Federal Firearm License
                                    Number <br>
                                    <small><em>(Must contain at least first three and last five digits of FFL Number
                                            X-XX-XXXXX.) (Hand stamp may be used.)</em></small>
                                </td>
                                <td><textarea type="text" style="width:300px; height: 300px;"
                                              class="form-control multi-in-one" name="sec_d_33" id="fName" aria-describedby=""
                                              placeholder="Trade/corporate name and address">
                                        <?php echo (!empty($record['sec_d_33']))?$record['sec_d_33']:'';?>
                                    </textarea></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="card-title">The Person Transferring The Firearm(s) Must Complete Questions 34-37.<br>
                                    For Denied/Cancelled Transactions, the Person Who Completed Section B Must Complete
                                    Questions 34-36.</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <small style="line-height: 1 !important;">I certify that: (1) I have read and understand the
                                    Notices, Instructions, and Definitions on this ATF Form 4473; (2) the information
                                    recorded in Sections B and D is true, correct, and complete; and (3) this entire
                                    transaction record has been completed at my licensed business premises ("licensed
                                    premises" includes business temporarily conducted from a qualifying gun show or event in
                                    the same State in which the licensed premises is located) unless this transaction has
                                    met the requirements of 18 U.S.C. 922(c). Unless this transaction has been denied or
                                    cancelled, I further certify on the basis of — (1) the transferee's/buyer's responses in
                                    Section A (and Section C, if applicable); (2) my verification of the identification
                                    recorded in question 18 (and my re-verification at the time of transfer, if Section C
                                    was completed); and (3) State or local law applicable to the firearms business — it is
                                    my belief that it is not unlawful for me to sell, deliver, transport, or otherwise
                                    dispose of the firearm(s) listed on this form to the person identified in Section A.
                                </small>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-light btn-sm float-right" id="clear-signature">Clear Signature
                                </button>
                                <canvas class="multi-in-one" id="signature" height="300" width="1050"
                                        style="border: 1px solid #ddd; border-radius: 5px;  margin-top:20px;"></canvas>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="name">Transferor's/Seller's Name </label>
                                    <input type="text" class="form-control" name="sec_d_transfer_fname" id="fName" aria-describedby=""
                                           placeholder="Full Name" value="<?php echo (!empty($record['sec_d_transfer_fname']))?$record['sec_d_transfer_fname']:'';?>">
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="name">Transferor's/Seller's Title</label>
                                    <input type="text" class="form-control" name="sec_d_transfer_title" id="fName" aria-describedby=""
                                           placeholder="Title" value="<?php echo (!empty($record['sec_d_transfer_title']))?$record['sec_d_transfer_title']:'';?>">
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="name">Date Transferred</label>
                                    <input id="datepicker7" name="sec_d_transfer_date"
                                           placeholder="Date" value="<?php echo (!empty($record['sec_d_transfer_date']))?$record['sec_d_transfer_date']:'';?>" />
                                </div>
                            </div>
                            <div class="col-sm">
                                <label for="name">Submit</label>
                                <button type="button" class="btn btn-success btn-block" id="save_sec_d">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>