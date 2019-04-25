<div class="row">
    <div class="col-sm">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Section B & C - Must Be Completed By Transferor/Seller</h2>
            </div>
        </div>
    </div>
</div>
</div>
<form action="" method="post" id="save_sectionB_form">
    <div class="container">
        <div class="row">
            <input type="hidden" name="record_id" value="<?php echo $id; ?>">
            <div class="col-md-6 section_B">
                <div class="card sectionB_card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-info-circle"></i> Purchase Details</h5>
                        <label for="name"> Type of firearm(s) to be transferred</label>
                        <small>(check or mark all that apply)</small>
                        <div class="row">
                            <div class="col-sm">
                                <table class="table ">
                                    <tr>
                                        <td>Handgun
                                        <td class="text-right">
                                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                <label class="btn btn-secondary btn-sm">
                                                    <input type="radio" <?php echo (!empty($record['handgun_options']) && $record['handgun_options'] == 2) ? 'checked' : '' ?>
                                                           value="2" name="handgun_options" id="option1"
                                                           autocomplete="off">
                                                    YES </label>
                                                <label class="btn btn-secondary btn-sm">
                                                    <input type="radio" value="1" checked name="handgun_options"
                                                           id="option2" autocomplete="off"
                                                        <?php echo (empty($record['handgun_options']) && $record['handgun_options'] != 2) ? 'checked' : '' ?>>
                                                    NO </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Long Gun <em>(rifles or shotgun)</em>
                                        <td class="text-right">
                                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                <label class="btn btn-secondary btn-sm">
                                                    <input type="radio" value="2" name="long_gun_options" id="option1"
                                                           autocomplete="off"
                                                        <?php echo (!empty($record['long_gun_options']) && $record['long_gun_options'] == 2) ? 'checked' : '' ?>>
                                                    YES </label>
                                                <label class="btn btn-secondary btn-sm ">
                                                    <input type="radio" value="1" checked name="long_gun_options"
                                                           id="option2" autocomplete="off"
                                                        <?php echo (empty($record['long_gun_options']) && $record['long_gun_options'] != 2) ? 'checked' : '' ?>>
                                                    NO </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Other Firearm <em>(frame, receiver, etc. See Instructions for Question
                                                16.)</em>
                                        <td class="text-right">
                                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                <label class="btn btn-secondary btn-sm">
                                                    <input type="radio" value="2" name="other_firearm" id="options"
                                                           autocomplete="off"
                                                        <?php echo (!empty($record['other_firearm']) && $record['other_firearm'] == 2) ? 'checked' : '' ?>>
                                                    YES </label>
                                                <label class="btn btn-secondary btn-sm">
                                                    <input type="radio" value="1" checked name="other_firearm"
                                                           id="options" autocomplete="off"
                                                        <?php echo (empty($record['other_firearm']) && $record['other_firearm'] != 2) ? 'checked' : '' ?>>
                                                    NO </label>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <hr/>
                        <label for="name">If transfer is at a qualifying gun show or event:</label>
                        <div class="row">
                            <div class="col-sm">
                                <label for="name">Name of Function</label>
                                <input type="text" name="name_of_functions" class="form-control multi-in-one" id="fName"
                                       aria-describedby=""
                                       placeholder="Name of Function"
                                       value="<?php echo (!empty($record['name_of_functions'])) ? $record['name_of_functions'] : ''; ?>">
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-12 form-group">
                                <select class="form-control" name="function_state" id="exampleFormControlSelect1">
                                    <option>State</option>
                                    <?php
                                    if (!empty($states)) {
                                        foreach ($states as $index => $val) {
                                            $k = ($record['function_state'] == $val['state'])?'selected':'';
                                            ?>
                                            <option <?php echo $k; ?> value="<?php echo $val['state'] ?>"><?php echo $val['state'] ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control multi-in-one" name="birthCity"
                                       aria-describedby=""
                                       placeholder="City" value="<?php echo (!empty($record['function_city']))?$record['function_city']:'';?>">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-6 section_B">
                <div class="card sectionB_card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-id-card"></i> Identification</h5>
                        <label for="name">Presented Identification</label> <em>
                            <small>(e.g., Virginia Driver's license (VA DL) or other valid government-issued photo
                                identification.) (See Instructions for Question 18.a.)
                            </small>
                        </em>

                        <div class="row">
                            <div class="col-sm">

                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="text" name="issuing_authority" class="form-control multi-in-one"
                                               id="fName"
                                               aria-describedby="" placeholder="Issuing Authority"
                                               value="<?php echo (!empty($record['issuing_authority'])) ? $record['issuing_authority'] : ''; ?>">
                                        <input type="text" class="form-control multi-in-one" id="fName"
                                               aria-describedby="" name="type_of_identification"
                                               placeholder="Type of Identification"
                                               value="<?php echo (!empty($record['type_of_identification'])) ? $record['type_of_identification'] : ''; ?>">
                                    </div>
                                    <div class="col-md-5 snap-id">
                                        <button type="button"
                                                class="btn btn-lg btn-outline-secondary btn-block load_file"><i
                                                    class="fas fa-camera fa-lg"></i><br>
                                            <small>Take a Photo of ID</small>
                                        </button>
                                        <input type="file" name="identification_photo_id" id="identification_photo_id"
                                               class="over_hidden"
                                               value="<?php echo (!empty($record['identification_photo_id'])) ? $record['identification_photo_id'] : ''; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="text" class="form-control multi-in-one" id="fName"
                                               aria-describedby="" name="number_identification"
                                               placeholder="Number of Identification"
                                               value="<?php echo (!empty($record['number_identification'])) ? $record['number_identification'] : ''; ?>">
                                    </div>
                                    <div class="col-md-5 snap-id">
                                        <input id="datepicker" name="identification_exp_date"
                                               placeholder="Expiration Date"
                                               value="<?php echo (!empty($record['identification_exp_date'])) ? $record['identification_exp_date'] : ''; ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label for="name">Supplemental Government Issued Documentation</label> <em>
                            <small>(if identification document does not show current residence address) (See
                                Instructions for Question 18.b.)
                            </small>
                        </em>
                        <div class="row">
                            <div class="col-md-7">
                                <input type="text" class="form-control multi-in-one"
                                       name="government_issued_documentation" id="fName" aria-describedby=""
                                       placeholder="Government Issued Documentation"
                                       value="<?php echo (!empty($record['government_issued_documentation'])) ? $record['government_issued_documentation'] : ''; ?>">
                            </div>
                            <div class="col-md-5 snap-id">
                                <button type="button" class="btn btn-outline-secondary btn-block load_file"><i
                                            class="fas fa-camera fa-lg"></i> Take a Photo
                                </button>
                                <input type="file" name="government_photo" id="government_photo" class="over_hidden"
                                       value="<?php echo (!empty($record['government_photo'])) ? $record['government_photo'] : ''; ?>">
                            </div>
                        </div>
                        <hr/>
                        <label for="name">Exception to the Nonimmigrant Alien Prohibition: </label> <em>
                            <small>If the transferee/buyer answered "YES" to 12.d.2. the transferor/seller must record
                                the type of documentation showing the exception to the prohibition and attach a copy to
                                this ATF Form 4473. (See Instructions for Question 18.c.)
                            </small>
                        </em>
                        <div class="row">
                            <div class="col-md-7">
                                <input type="text" name="exception_documentation" class="form-control multi-in-one"
                                       id="fName" aria-describedby=""
                                       placeholder="Exception Documentation"
                                       value="<?php echo (!empty($record['exception_documentation'])) ? $record['exception_documentation'] : ''; ?>">
                            </div>
                            <div class="col-md-5 snap-id">
                                <button type="button" class="btn btn-outline-secondary btn-block load_file"><i
                                            class="fas fa-camera fa-lg"></i> Take a Photo
                                </button>
                                <input type="file" name="exception_photo" id="exception_photo" class="over_hidden">
                            </div>
                        </div>
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
                        <h5 class="card-title">Questions Below Must Be Completed Prior To The Transfer Of The
                            Firearm(s)</h5> <em>(See Instructions for Questions 19, 20 and 21.)</em>
                        <table class="table table-striped">
                            <tr>
                                <td>19.a. Date the transferee's/buyer's identifying information in Section A was
                                    transmitted
                                    to NICS or the appropriate State agency:
                                </td>
                                <td><input id="datepicker2" name="date_19a" placeholder="Date"
                                           value="<?php echo (!empty($record['date_19a'])) ? $record['date_19a'] : ''; ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td>19.b. The NICS or State transaction number (if provided) was:</td>
                                <td><input type="text" name="transaction_number" class="form-control multi-in-one"
                                           id="fName" aria-describedby=""
                                           placeholder="State transaction number"
                                           value="<?php echo (!empty($record['transaction_number'])) ? $record['transaction_number'] : ''; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>19.c. The response initially (first) provided by NICS or the appropriate State
                                    agency
                                    was:
                                </td>
                                <td>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" value="1" name="c19_nics_options" id="option1"
                                                   autocomplete="off"
                                                <?php echo (!empty($record['c19_nics_options']) && $record['c19_nics_options'] == 1) ? 'checked' : '' ?>>
                                            Proceed </label>
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" value="2" name="c19_nics_options" id="option2"
                                                   autocomplete="off"
                                                <?php echo (!empty($record['c19_nics_options']) && $record['c19_nics_options'] == 2) ? 'checked' : '' ?>>
                                            Denied </label>
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" value="3" name="c19_nics_options" id="option2"
                                                   autocomplete="off"
                                                <?php echo (!empty($record['c19_nics_options']) && $record['c19_nics_options'] == 3) ? 'checked' : '' ?>>
                                            Canceled </label>
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" value="4" name="c19_nics_options" id="option2"
                                                   autocomplete="off"
                                                <?php echo (!empty($record['c19_nics_options']) && $record['c19_nics_options'] == 4) ? 'checked' : '' ?>>
                                            Delayed </label>
                                    </div>
                                    <label>The firearm(s) may be transferred on </label><em>[if State law permits
                                        (optional)]</em>
                                    <input type="text" name="state_transaction" class="form-control multi-in-one"
                                           id="fName" aria-describedby=""
                                           placeholder="State transaction"
                                           value="<?php echo (!empty($record['state_transaction'])) ? $record['state_transaction'] : ''; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>19.d. The following response(s) was/were later received from NICS or the appropriate
                                    State agency:
                                </td>
                                <td>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" checked value="1" name="d19_nics_options" id="option1"
                                                   autocomplete="off"
                                                <?php echo (!empty($record['d19_nics_options']) && $record['d19_nics_options'] == 1) ? 'checked' : '' ?>>
                                            Proceed </label>
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" value="2" name="d19_nics_options" id="option2"
                                                   autocomplete="off"
                                                <?php echo (!empty($record['d19_nics_options']) && $record['d19_nics_options'] == 2) ? 'checked' : '' ?>>
                                            Denied </label>
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" value="3" name="d19_nics_options" id="option2"
                                                   autocomplete="off"
                                                <?php echo (!empty($record['d19_nics_options']) && $record['d19_nics_options'] == 3) ? 'checked' : '' ?>>
                                            Canceled </label>
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" value="4" name="d19_nics_options" id="option2"
                                                   autocomplete="off"
                                                <?php echo (!empty($record['d19_nics_options']) && $record['d19_nics_options'] == 4) ? 'checked' : '' ?>>
                                            Overturned </label>
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" value="5" name="d19_nics_options" id="option2"
                                                   autocomplete="off"
                                                <?php echo (!empty($record['d19_nics_options']) && $record['d19_nics_options'] == 5) ? 'checked' : '' ?>>
                                            NR </label>
                                    </div>
                                    <small class=" multi-in-one"><em>NR = No response was provided within 3 business
                                            days.</em></small>
                                    <input id="datepicker3" name="d19_nics_date" placeholder="Date"
                                           value="<?php echo (!empty($record['d19_nics_date'])) ? $record['d19_nics_date'] : ''; ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td>19.e. (Complete if applicable.) After the firearm was transferred, the following
                                    response was received from NICS or the appropriate State agency on:
                                </td>
                                <td>
                                    <div class="multi-in-one">
                                        <input id="datepicker4" name="e19_nics_date" placeholder="Date"
                                               value="<?php echo (!empty($record['e19_nics_date'])) ? $record['e19_nics_date'] : ''; ?>"/>
                                    </div>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" checked value="1" name="e19_nics_options" id="option1"
                                                   autocomplete="off"
                                                <?php echo (!empty($record['e19_nics_options']) && $record['e19_nics_options'] == 1) ? 'checked' : '' ?>>
                                            Proceed </label>
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" value="2" name="e19_nics_options" id="option2"
                                                   autocomplete="off"
                                                <?php echo (!empty($record['e19_nics_options']) && $record['e19_nics_options'] == 2) ? 'checked' : '' ?>>
                                            Denied </label>
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" value="3" name="e19_nics_options" id="option2"
                                                   autocomplete="off"
                                                <?php echo (!empty($record['e19_nics_options']) && $record['e19_nics_options'] == 3) ? 'checked' : '' ?>>
                                            Canceled </label>
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <td>19.f. The name and Brady identification number of the NICS examiner.<em>
                                        (Optional)</em>
                                </td>
                                <td>
                                    <input type="text" name="f19_name" class="form-control multi-in-one" id="fName"
                                           aria-describedby=""
                                           placeholder="Name"
                                           value="<?php echo (!empty($record['f19_name'])) ? $record['f19_name'] : ''; ?>">
                                    <input type="text" name="f19_number" class="form-control" id="fName"
                                           aria-describedby=""
                                           placeholder="Number"
                                           value="<?php echo (!empty($record['f19_number'])) ? $record['f19_number'] : ''; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>19.g. Name of FFL Employee Completing NICS check. <em>(Optional)</em></td>
                                <td>
                                    <input type="text" name="g19_name" class="form-control multi-in-one" id="fName"
                                           aria-describedby=""
                                           placeholder="Name"
                                           value="<?php echo (!empty($record['g19_name'])) ? $record['g19_name'] : ''; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>20. No NICS check was required because a background check was completed during the
                                    NFA
                                    approval process on the individual who will receive the NFA firearm(s), as reflected
                                    on
                                    the approved NFA application. <em>(See Instructions for Question 20.)</em></td>
                                <td>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" value="2" name="nifs_20" id="option1" autocomplete="off"
                                                <?php echo (!empty($record['e19_nics_options']) && $record['e19_nics_options'] == 2) ? 'checked' : '' ?>>
                                            YES </label>
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" name="nifs_20" checked value="1" id="option2"
                                                   autocomplete="off"
                                                <?php echo (empty($record['e19_nics_options']) || $record['e19_nics_options'] != 2) ? 'checked' : '' ?>>
                                            NO </label>
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <td>21. No NICS check was required because the transferee/buyer has a valid permit from
                                    the
                                    State where the transfer is to take place, which qualifies as an exemption to NICS.
                                    <em>(See
                                        Instructions for Question 21.)</em></td>
                                <td>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" value="2" name="nifc_21" id="option1" autocomplete="off"
                                                <?php echo (!empty($record['nifc_21']) && $record['nifc_21'] == 2) ? 'checked' : '' ?>>
                                            YES </label>
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" value="1" checked name="nifc_21" id="option2"
                                                   autocomplete="off"
                                                <?php echo (empty($record['nifc_21']) || $record['nifc_21'] != 2) ? 'checked' : '' ?>>
                                            NO </label>
                                    </div>
                                </td>
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
                        <h5 class="card-title">
                            Section C - Must Be Completed Personally By Transferee/Buyer
                        </h5>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="name">Issuing State and Permit Type</label>
                                    <input type="text" name="state_permit_dade" class="form-control" id="fName"
                                           aria-describedby=""
                                           placeholder="Issuing State and Permit Type"
                                           value="<?php echo (!empty($record['state_permit_dade'])) ? $record['state_permit_dade'] : ''; ?>">
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="name">Date of Issuance <em>(if any)</em> </label>
                                    <input id="datepicker5" name="issuance_date" placeholder="Date"
                                           value="<?php echo (!empty($record['issuance_date'])) ? $record['issuance_date'] : ''; ?>"/>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="name">Expiration Date <em>(if any)</em></label>
                                    <input id="datepicker6" name="expiration_date" placeholder="Date"
                                           value="<?php echo (!empty($record['expiration_date'])) ? $record['expiration_date'] : ''; ?>"/>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="name">Permit Number <em>(if any)</em></label>
                                    <input type="text" name="permit_number" class="form-control" id="fName"
                                           aria-describedby=""
                                           placeholder="Permit Number"
                                           value="<?php echo (!empty($record['permit_number'])) ? $record['permit_number'] : ''; ?>">
                                </div>
                            </div>
                        </div>


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
                            <div class="col-md-8">
                                <h5 class="card-title">
                                    The Person Transferring The Firearm(s) Must Complete Questions 34-37.
                                </h5>
                            </div>
                            <div class="col-md-4 text-right">

                                <button class="btn btn-light btn-sm" id="clear-signature">Clear Signature</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 signature_text">
                                <h5>
                                    For Denied/Cancelled Transactions, the Person Who Completed Section B & C Must Complete
                                    Questions 34-36.</h5>
                                <small>I certify that: (1) I have read and understand the Notices, Instructions, and
                                    Definitions on this ATF Form 4473; (2) the information recorded in Sections B and D
                                    is
                                    true, correct, and complete; and (3) this entire transaction record has been
                                    completed
                                    at my licensed business premises ("licensed premises" includes business temporarily
                                    conducted from a qualifying gun show or event in the same State in which the
                                    licensed
                                    premises is located) unless this transaction has met the requirements of 18 U.S.C.
                                    922(c). Unless this transaction has been denied or cancelled, I further certify on
                                    the
                                    basis of — (1) the transferee's/buyer's responses in Section A (and Section C, if
                                    applicable); (2) my verification of the identification recorded in question 18 (and
                                    my
                                    re-verification at the time of transfer, if Section C was completed); and (3) State
                                    or
                                    local law applicable to the firearms business — it is my belief that it is not
                                    unlawful
                                    for me to sell, deliver, transport, or otherwise dispose of the firearm(s) listed on
                                    this form to the person identified in Section A.
                                </small>
                            </div>
                            <div class="col-md-12">
                                <canvas class="multi-in-one" id="signature" width="1050" height="320"
                                        style="border: 1px solid #ddd; border-radius: 5px; float:right"></canvas>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="name">Transferor's/Seller's Name </label>
                                    <input type="text" class="form-control" name="transferror_seller_fname" id="fName"
                                           aria-describedby=""
                                           placeholder="Full Name"
                                           value="<?php echo (!empty($record['transferror_seller_fname'])) ? $record['transferror_seller_fname'] : ''; ?>">
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="name">Transferor's/Seller's Title</label>
                                    <input type="text" class="form-control" name="transferror_seller_title" id="fName"
                                           aria-describedby=""
                                           placeholder="Title"
                                           value="<?php echo (!empty($record['transferror_seller_title'])) ? $record['transferror_seller_title'] : ''; ?>">
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="name">Date Transferred</label>
                                    <input id="datepicker7" name="transferred_date" placeholder="Date"
                                           value="<?php echo (!empty($record['transferred_date'])) ? $record['transferred_date'] : ''; ?>"/>
                                </div>
                            </div>

                            <div class="col-sm">
                                <label for="name">Submit</label>
                                <button type="button" class="btn btn-success btn-block " id="save_section_b">Submit Section B & C
                                </button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="modal" id="error_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body show_error">
            </div>
        </div>
    </div>
</div>