<!-- Forms header -->
<div class="row">
    <div class="col-sm">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title"><?= $sectionTitle; ?></h2>
            </div>
        </div>
    </div>
</div>
<!--Main Content-->
<?= form_open_multipart('form', array('id' => 'buyerForm')); ?>
<input type="hidden" name="id" value="<?php echo (!empty($record['id']))?$record['id']:'';?>">
<!-- Personal Info-->
<div class="row">
    <div class="col-sm card-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-user"></i> Personal Info</h5>
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control multi-in-one" name="fName"
                           aria-describedby=""
                           placeholder="First Name" value="<?php echo (!empty($record['first_name_1']))?$record['first_name_1']:'';?>">
                    <input type="text" class="form-control multi-in-one" name="mName"
                           aria-describedby=""
                           placeholder="Middle Name"  value="<?php echo (!empty($record['middle_name_1']))?$record['middle_name_1']:'';?>">
                    <input type="text" class="form-control multi-in-one" name="lName"
                           aria-describedby=""
                               placeholder="Last Name" value="<?php echo (!empty($record['last_name_1']))?$record['last_name_1']:'';?>">
                </div>
                <hr/>
                <div class="form-group">

                    <label for="">Date &amp; Place of Birth</label>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-7">

                                <div class="multi-in-one" style="width: 109%">
                                    <input id="datepicker" name="datepicker" alt="date"
                                           value="<?php echo (!empty($record['birth_date_7']))?$record['birth_date_7']:'';?>" readonly style="font-size: 14px; padding: 1px;" />
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary active">
                                            <input type="radio" name="birthPlace"
                                                   autocomplete="off" value="US"
                                                   checked>US
                                        </label>
                                        <label class="btn btn-secondary">
                                            <input type="radio" name="birthPlace"
                                                   autocomplete="off" value="foreign">
                                            Foreign
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!--<div class="col-sm">
                              <input type="text" class="form-control multi-in-one" id="lName" aria-describedby="" placeholder="Zip">
                            </div>-->
                            <div class="col-md-6">
                                <select class="form-control" name="birthState">
                                    <option value="">State</option>
                                     <?php
                                     if(!empty($states)){
                                         foreach ($states as $index => $val){
                                             $k = ($record['birth_state_3'] == $val['state'])?'selected':'';
                                             ?>
                                             <option <?php echo $k; ?> value="<?php echo $val['state']?>"><?php echo $val['state']?></option>
                                         <?php } }  ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control multi-in-one" name="birthCity"
                                       aria-describedby=""
                                       placeholder="" value="<?php echo (!empty($record['birth_city_3']))?$record['birth_city_3']:'';?>">
                            </div>
                            <div class="col-sm">
                                <select class="form-control multi-in-one" id="foreignCountry" name="foreignCountry">
                                    <option value="">Country</option>
                                    <option <?php echo (!empty($record['birth_country_3']) && $record['birth_country_3'] == 2)?'selected':'' ?> value="2">2</option>
                                    <option <?php echo (!empty($record['birth_country_3']) && $record['birth_country_3'] == 3)?'selected':'' ?> value="3">3</option>
                                    <option <?php echo (!empty($record['birth_country_3']) && $record['birth_country_3'] == 4)?'selected':'' ?> value="4">4</option>
                                    <option <?php echo (!empty($record['birth_country_3']) && $record['birth_country_3'] == 5)?'selected':'' ?> value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <label for="name">Height, Weight, Gender</label>
                    <div class="row">
                        <div class="col-sm">
                            <div class="input-group">
                                <input type="text" aria-label="" placeholder="ft" class="form-control"
                                       name="height_ft" value="<?php echo (!empty($record['height_4']))? cm2feetIn($record['height_4'])['ft']:'';?>">
                                <input type="text" aria-label="" placeholder="in" class="form-control"
                                       name="height_in" value="<?php echo (!empty($record['height_4']))? cm2feetIn($record['height_4'])['in']:'';?>">
                            </div>
                        </div>

                        <div class="col-sm">
                            <input type="text" class="form-control multi-in-one" aria-describedby=""
                                   placeholder="lb" name="weight" value="<?php echo (!empty($record['weight_5']))? kg2pound($record['weight_5']):'';?>">
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-secondary active">
                                        <input type="radio" name="gender" autocomplete="off"
                                               value="Male" <?php echo (!empty($record['gender_6']) && $record['gender_6'] == 'Male')?'checked':'' ?>>
                                        M
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" value="Female" name="gender" autocomplete="off"
                                            <?php echo (!empty($record['gender_6']) && $record['gender_6'] == 'Female')?'checked':'' ?>>
                                        F
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm card-3">
        <div class="card">
            <div class="card-body" id="sectionA_container">
                <h5 class="card-title"><i class="fas fa-map-marker-alt"></i> Addresses</h5>
                <label for="name">Home Address</label>
                <input type="text" class="form-control multi-in-one" aria-describedby=""
                       placeholder="Address 1" name="homeAddress1"
                       value="<?php echo (!empty($record['home_address1_2']))?$record['home_address1_2']:'';?>">
                <input type="text" class="form-control multi-in-one" aria-describedby=""
                       placeholder="Address 2" name="homeAddress2"
                       value="<?php echo (!empty($record['home_address2_2']))?$record['home_address2_2']:'';?>">
                <div class="row">
                    <div class="col-sm">
                        <input type="text" class="form-control multi-in-one search_zip_code zip" aria-describedby=""
                               placeholder="Zip" name="homeZip" id="sectionA_zip"
                               value="<?php echo (!empty($record['home_zip_2']))?$record['home_zip_2']:'';?>">
                             <div class="zip_answer" id="homeZip_div" style="display: none;"></div>
                    </div>
                    <div class="col-sm">
                        <select class="form-control multi-in-one state" name="homeState">
                            <option value="">State</option>
                            <?php
                            if(!empty($states)){
                                foreach ($states as $index => $val){
                                    $k = ($record['home_state_2'] == $val['state'])?'selected':'';
                                    ?>
                                    <option <?php echo $k;?> value="<?php echo $val['state']?>"><?php echo $val['state']?></option>
                                <?php } }  ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <input type="text" class="form-control multi-in-one city" name="homeCity"
                               aria-describedby="" id="sectionA_city"
                               placeholder="City" value="<?php echo (!empty($record['home_city_2']))?$record['home_city_2']:'';?>">
                    </div>
                </div>

                <hr/>
                <label for="name">State of Residency &amp; Citizenship</label>
                <select class="form-control multi-in-one" name="residencyState">
                    <option value="">State</option>
                    <?php
                    if(!empty($states)){
                        foreach ($states as $index => $val){
                            $k = ($record['home_county_2'] == $val['state'])?'selected':'';
                            ?>
                            <option <?php echo $k;?> value="<?php echo $val['state']?>"><?php echo $val['state']?></option>
                        <?php } }  ?>
                </select>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary active">
                                    <input type="radio" name="residencyCountry"
                                           autocomplete="off" value="1" >
                                    US
                                </label>
                                <label class="btn btn-secondary">
                                    <input type="radio" name="residencyCountry"
                                           autocomplete="off" value="0" >
                                    Other
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <select class="form-control multi-in-one citizenship" name="otherCountryCitizen">
                            <option value="">Citizenship</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-sm card-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-users"></i> Ethicity &amp; Race</h5>
                <label for="name">Ethnicity</label>
                <small>Select one</small>
                <div class="row">
                    <div class="col-sm">
                        <table class="table ">
                            <tr>
                                <td>Hispanic/Latino
                                <td class="text-right">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" name="ethnicity"
                                                   autocomplete="off" value="1">
                                            YES
                                        </label>
                                        <label class="btn btn-secondary btn-sm active">
                                            <input type="radio" name="ethnicity"
                                                   autocomplete="off" value="0" checked>
                                            NO
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <hr/>
                <label for="name">Race</label>
                <small>Select one or more</small>
                <div class="row">
                    <div class="col-sm">
                        <table class="table">
                            <tr>
                                <td>AM Indian or AK Native
                                <td class="text-right">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" name="indianOrAk"
                                                   autocomplete="off" value="1">
                                            YES
                                        </label>
                                        <label class="btn btn-secondary btn-sm active">
                                            <input type="radio" name="indianOrAk"
                                                   autocomplete="off"
                                                   checked value="0">
                                            NO
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Asian
                                <td class="text-right">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" name="asianRace" value="1"
                                                   autocomplete="off">
                                            YES
                                        </label>
                                        <label class="btn btn-secondary btn-sm active">
                                            <input type="radio" name="asianRace" value="0"
                                                   autocomplete="off"
                                                   checked>
                                            NO
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Black or African American
                                <td class="text-right">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" name="blackOrAfro" value="1"
                                                   autocomplete="off">
                                            YES </label>
                                        <label class="btn btn-secondary btn-sm active">
                                            <input type="radio" name="blackOrAfro" value="0"
                                                   autocomplete="off"
                                                   checked>
                                            NO
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Native HAW / Pacific Is.
                                <td class="text-right">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" name="raceNativeHawaiian"
                                                   value="1"
                                                   autocomplete="off">
                                            YES
                                        </label>
                                        <label class="btn btn-secondary btn-sm active">
                                            <input type="radio" name="raceNativeHawaiian"
                                                   value="0"
                                                   autocomplete="off"
                                                   checked>
                                            NO
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>White
                                <td class="text-right">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary btn-sm active">
                                            <input type="radio" name="isRaceWhite" value="1"
                                                   autocomplete="off"
                                                   checked>
                                            YES
                                        </label>
                                        <label class="btn btn-secondary btn-sm">
                                            <input type="radio" name="isRaceWhite" value="0"
                                                   autocomplete="off">
                                            NO
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!--Addresses-->
<div class="row">
    <div class="col-sm">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Answer the following questions by checking or marking "YES" or "NO" in
                    the
                    boxes to the right of the questions.</h5>
                <table class="table table-striped">
                    <tr>
                        <td>a. Are you the actual transferee/buyer of the firearm(s) listed on this form?
                            <strong>Warning:
                                You are not the actual transferee/buyer if you are acquiring the firearm(s) on
                                behalf of another person. If you are not the actual transferee/buyer, the
                                licensee
                                cannot transfer the firearm(s) to you</strong>. Exception: <strong>If you are
                                picking up a repaired firearm(s)</strong> for another person, you are not
                            required
                            to answer 11.a. and may proceed to question 11.b.<em> (See Instructions for Question
                                11.a.)</em></td>
                        <td class="text-right">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary btn-sm">
                                    <input type="radio" name="isActualTransferee"
                                           autocomplete="off" value="1"> YES
                                </label>
                                <label class="btn btn-secondary btn-sm active">
                                    <input type="radio" name="isActualTransferee"
                                           autocomplete="off" value="0" checked>
                                    NO
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>b. Are you under indictment or information in any court for a felony, or any other
                            crime
                            for which the judge could imprison you for more than one year? <em>(See Instructions
                                for
                                Question 11.b.)</em></td>
                        <td class="text-right">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary btn-sm">
                                    <input type="radio" name="isUnderIndictment"
                                           autocomplete="off" value="1"> YES
                                </label>
                                <label class="btn btn-secondary btn-sm active">
                                    <input type="radio" name="isUnderIndictment"
                                           autocomplete="off" value="0" checked>
                                    NO
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>c. Have you ever been convicted in any court of a felony, or any other crime for
                            which
                            the judge could have imprisoned you for more than one year, even if you received a
                            shorter sentence including probation? <em>(See Instructions for Question 11.c.)</em>
                        </td>
                        <td class="text-right">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary btn-sm">
                                    <input type="radio" name="isConvicted" autocomplete="off" value="1"> YES
                                </label>
                                <label class="btn btn-secondary btn-sm active">
                                    <input type="radio" name="isConvicted" autocomplete="off" value="0" checked>
                                    NO
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>d. Are you a fugitive from justice? <em>(See Instructions for Question 11.d.)</em>
                        </td>
                        <td class="text-right">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary btn-sm">
                                    <input type="radio" name="isFugitive" autocomplete="off" value="1"> YES
                                </label>
                                <label class="btn btn-secondary btn-sm active">
                                    <input type="radio" name="isFugitive" autocomplete="off" value="0" checked>
                                    NO
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>e. Are you an unlawful user of, or addicted to, marijuana or any depressant,
                            stimulant,
                            narcotic drug, or any other controlled substance? <strong>Warning: The use or
                                possession
                                of marijuana remains unlawful under Federal law regardless of whether it has
                                been
                                legalized or decriminalized for medicinal or recreational purposes in the state
                                where you reside.</strong></td>
                        <td class="text-right">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary btn-sm">
                                    <input type="radio" name="isAddicted" autocomplete="off" value="1"> YES
                                </label>
                                <label class="btn btn-secondary btn-sm active">
                                    <input type="radio" name="isAddicted" autocomplete="off" value="0" checked>
                                    NO
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>f. Have you ever been adjudicated as a mental defective OR have you ever been
                            committed
                            to a mental institution? <em>(See Instructions for Question 11.f.)</em></td>
                        <td class="text-right">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary btn-sm">
                                    <input type="radio" name="isAdjudicated" autocomplete="off" value="1">
                                    YES
                                </label>
                                <label class="btn btn-secondary btn-sm active">
                                    <input type="radio" name="isAdjudicated" autocomplete="off" value="0" checked>
                                    NO
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>g. Have you been discharged from the Armed Forces under dishonorable conditions?
                        </td>
                        <td class="text-right">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary btn-sm">
                                    <input type="radio" name="isDischarged" value="1" autocomplete="off">
                                    YES
                                </label>
                                <label class="btn btn-secondary btn-sm active">
                                    <input type="radio" name="isDischarged" value="0" autocomplete="off" checked>
                                    NO
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>i. Have you ever been convicted in any court of a misdemeanor crime of domestic
                            violence? <em>(See Instructions for Question 11.i.)</em></td>
                        <td class="text-right">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary btn-sm">
                                    <input type="radio" name="haveMisdemeanor" value="1" autocomplete="off">
                                    YES
                                </label>
                                <label class="btn btn-secondary btn-sm active">
                                    <input type="radio" name="haveMisdemeanor" value="0" autocomplete="off"
                                           checked>
                                    NO
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>12.b. Have you ever renounced your United States citizenship?</td>
                        <td class="text-right">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary btn-sm">
                                    <input type="radio" name="isRenouncedUsCitizenship" value="1"
                                           autocomplete="off">
                                    YES
                                </label>
                                <label class="btn btn-secondary btn-sm active">
                                    <input type="radio" name="isRenouncedUsCitizenship" value="0"
                                           autocomplete="off" checked>
                                    NO
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>h. Are you subject to a court order restraining you from harassing, stalking, or
                            threatening your child or an intimate partner or child of such partner? <em>(See
                                Instructions for Question 11.h.)</em></td>
                        <td class="text-right">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary btn-sm">
                                    <input type="radio" name="isRestraining" value="1" autocomplete="off">
                                    YES
                                </label>
                                <label class="btn btn-secondary btn-sm active">
                                    <input type="radio" name="isRestraining" value="0" autocomplete="off" checked>
                                    NO
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>12.c. Are you an alien illegally or unlawfully in the United States?</td>
                        <td class="text-right">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary btn-sm">
                                    <input type="radio" name="isIllegally" value="1" autocomplete="off">
                                    YES
                                </label>
                                <label class="btn btn-secondary btn-sm active">
                                    <input type="radio" name="isIllegally" value="0" autocomplete="off" checked>
                                    NO
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>12.d.1. Are you an alien who has been admitted to the United States under a
                            nonimmigrant
                            visa? <em>(See Instructions for Question 12.d.)</em></td>
                        <td class="text-right">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary btn-sm">
                                    <input type="radio" name="alienWithNonimmigrantVisa" value="1"
                                           autocomplete="off">
                                    YES
                                </label>
                                <label class="btn btn-secondary btn-sm active">
                                    <input type="radio" name="alienWithNonimmigrantVisa" value="0"
                                           autocomplete="off"
                                           checked>
                                    NO
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>12.d.2. If &quot;yes&quot;, do you fall within any of the exceptions stated in the
                            instructions?
                        </td>
                        <td class="text-right">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary btn-sm">
                                    <input type="radio" name="withinAlienExceptions" autocomplete="off" value="1">
                                    YES
                                </label>
                                <label class="btn btn-secondary btn-sm">
                                    <input type="radio" name="withinAlienExceptions" value="0" autocomplete="off">
                                    NO
                                </label>
                                <label class="btn btn-secondary btn-sm active">
                                    <input type="radio" name="withinAlienExceptions" value="2" autocomplete="off"
                                           checked>
                                    N/A
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>13. If you are an alien, record your U.S.-Issued Alien or Admission number (AR#,
                            USCIS#,
                            or I94#)
                        </td>
                        <td class="text-right">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary btn-sm">
                                    <input type="radio" name="alienAdmissionNumber" value="1" autocomplete="off">
                                    YES
                                </label>
                                <label class="btn btn-secondary btn-sm active">
                                    <input type="radio" name="alienAdmissionNumber" value="0" autocomplete="off"
                                           checked>
                                    NO
                                </label>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Ethicity & Race-->
<div class="row">
    <div class="col-sm">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    Optional Information
                </h5>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="name">Social Security Number</label>
                            <input type="text" class="form-control not_string socialSecNumber" name="socialSecNumber" aria-describedby=""
                                   placeholder="Social Security">
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="name">Phone </label>
                            <input type="text" class="form-control phoneNumber" name="phoneNumber" aria-describedby=""
                                   placeholder="Phone">
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="name">Email</label>
                            <input type="text" class="form-control" name="email" aria-describedby=""
                                   placeholder="Email">
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="name">UPIN</label>
                            <input type="text" class="form-control" name="upin" aria-describedby=""
                                   placeholder="UPIN">
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<!--Questions-->
<div class="row">
    <div class="col-sm">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h5 class="card-title">
                            Signature
                        </h5>
                    </div>
                    <div class="col-md-4 text-right">

                        <button class="btn btn-light btn-sm" id="clear-signature">Clear Signature</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 signature_text">
                        <small>I certify that my answers in Section A are true, correct, and complete. I have
                            read
                            and understand the Notices, Instructions, and Definitions on ATF Form 4473. I
                            understand
                            that answering &quot;yes&quot; to question 11.a. if I am not the actual
                            transferee/buyer
                            is a crime punishable as a felony under Federal law, and may also violate State
                            and/or
                            local law. I understand that a person who answers &quot;yes&quot; to any of the
                            questions 11.b. through 11.i and/or 12.b. through 12.c. is prohibited from
                            purchasing or
                            receiving a firearm. I understand that a person who answers &quot;yes&quot; to
                            question
                            12.d.1. is prohibited from receiving or possessing a firearm, unless the person
                            answers
                            &quot;yes&quot; to question 12.d.2. and provides the documentation required in 18.c.
                            I
                            also understand that making any false oral or written statement, or exhibiting any
                            false
                            or misrepresented identification with respect to this transaction, is a crime
                            punishable
                            as a felony under Federal law, and may also violate State and/or local law. I
                            further
                            understand that the repetitive purchase of firearms for the purpose of resale for
                            livelihood and profit without a Federal firearms license is a violation of Federal
                            law.
                            <em>(See Instructions for Question 14.)</em></small>
                    </div>
                    <div class="col-md-12">
                        <canvas class="multi-in-one" id="signature" width="1050" height="320"
                                style="border: 1px solid #ddd; border-radius: 5px; float:right"></canvas>
                        <button type="button" class="btn btn-success btn-block right-class col-2" id="submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php form_close(); ?>

<div class="modal" id="error_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div class="show_error"></div>
                <div class="show_error1"></div>
            </div>
        </div>
    </div>
</div>