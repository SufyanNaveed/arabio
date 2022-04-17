<style>
.top-margin{
    margin-top:15px;
}
</style>
<div class="content-body">
    <div class="card card-block bg-white">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" class="card-body" action="<?php echo base_url('complaints/submit_user') ?>">

            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
            <h5><?php echo 'Add Complaint' ?> </h5>
            <?php if ($this->session->flashdata("messagePr")) { ?>
                <div class="alert alert-info">
                    <?php echo $this->session->flashdata("messagePr") ?>
                </div>
            <?php } ?>
            <hr>
            <h4><strong>Part 1: Employee Information *</strong></h4>            
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">&nbsp;</label>
                <div class="col-sm-2 top-margin">
                    <input type="radio" placeholder="Name" class="required" name="request" value="new_request">
                    New Request
                </div>
                <div class="col-sm-3 top-margin">
                    <input type="radio" placeholder="Name" class="required" name="request" value="change_request">
                    Change Request
                </div>
                <label class="col-sm-1 col-form-label" for="name">Date</label>
                <div class="col-sm-4">
                    <input type="date" placeholder="Date" class="form-control margin-bottom" name="date" required="required">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="address">Employee Name</label>
                <div class="col-sm-5">
                    <input type="text" placeholder="(Last, first, middle initial)" class="form-control margin-bottom" name="emp_name" required="required">
                </div>
                <label class="col-sm-1 col-form-label" for="address">Department</label>
                <div class="col-sm-4">
                    <input type="text" placeholder="Department" class="form-control margin-bottom" name="department" required="required">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="address">Employee Title</label>
                <div class="col-sm-5">
                    <input type="text" placeholder="Employee Title" class="form-control margin-bottom" name="emp_title" required="required">
                </div>
                <label class="col-sm-1 col-form-label" for="address">Network ID</label>
                <div class="col-sm-4">
                    <input type="text" placeholder="Network ID" class="form-control margin-bottom" name="network_Id" required="required">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="address">Primary phone number </label>
                <div class="col-sm-5">
                    <input type="text" placeholder="Primary phone number" class="form-control margin-bottom" name="primary_phone" required="required">
                </div>
                <label class="col-sm-1 col-form-label" for="address">Email Address</label>
                <div class="col-sm-4">
                    <input type="text" placeholder="Email address (if any)" class="form-control margin-bottom" name="email_address" required="required">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="city">SAP Position (For New Staff)</label>
                <div class="col-sm-10">
                    <input type="text" placeholder="Create New SAP Position" class="form-control margin-bottom" name="sap_position" required="required">
                </div>
            </div>
            <h4><strong>Part 2: SYSTEM ACCESS</strong></h4> 
            <small>Please indicate for which applications, shares, and environments you are requesting access.  If role-based access exists, please identify the role requested.</small>           
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">&nbsp;</label>
                <div class="col-sm-2 top-margin"><strong> Application </strong></div>
                <div class="col-sm-8 top-margin"><strong> Role (if applicable) </strong></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">&nbsp;</label>
                <div class="col-sm-2 top-margin">
                    <input type="checkbox" placeholder="Name" class="required" name="system_access[]" value="1"> SAP
                </div>
                <div class="col-sm-3">
                    <input type="text" placeholder="" class="form-control margin-bottom" name="SAP_role">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">&nbsp;</label>
                <div class="col-sm-2 top-margin">
                    <input type="checkbox" placeholder="Name" class="required" name="system_access[]" value="2"> Serialization
                </div>
                <div class="col-sm-3">
                    <input type="text" placeholder="" class="form-control margin-bottom" name="serialization_role">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">&nbsp;</label>
                <div class="col-sm-2 top-margin">
                    <input type="checkbox" placeholder="Name" class="required" name="system_access[]" value="3"> Shared Drive
                </div>
                <div class="col-sm-3">
                    <input type="text" placeholder="" class="form-control margin-bottom" name="shared_role">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">&nbsp;</label>
                <div class="col-sm-2 top-margin">
                    <input type="checkbox" placeholder="Name" class="required" name="system_access[]" value="4"> Acrobat Writer
                </div>
                <div class="col-sm-3">
                    <input type="text" placeholder="" class="form-control margin-bottom" name="acrobat_role">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">&nbsp;</label>
                <div class="col-sm-2 top-margin">
                    <input type="checkbox" placeholder="Name" class="required" name="system_access[]" value="5"> Microsoft Access
                </div>
                <div class="col-sm-3">
                    <input type="text" placeholder="" class="form-control margin-bottom" name="microsoft_role">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">&nbsp;</label>
                <div class="col-sm-2 top-margin">
                    <input type="checkbox" placeholder="Name" class="required" name="system_access[]" value="6"> Fortinet Mobile
                </div>
                <div class="col-sm-3">
                    <input type="text" placeholder="" class="form-control margin-bottom" name="fortinet_role">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">&nbsp;</label>
                <div class="col-sm-2 top-margin">
                    <input type="checkbox" placeholder="Name" class="required" name="system_access[]" value="7"> Other
                </div>
                <div class="col-sm-3">
                    <input type="text" placeholder="" class="form-control margin-bottom" name="other_role">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">&nbsp;</label>
                <div class="col-sm-2"><strong> Microsoft 365(Including email) </strong> </div>
                <div class="col-sm-8">&nbsp;</div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">&nbsp;</label>
                <div class="col-sm-4">
                    <input type="checkbox" placeholder="Name" class="required" name="microsoft_365[]" value="1"> Business Standard (Suitable for office-based users)
                </div> 
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">&nbsp;</label>
                <div class="col-sm-4">
                    <input type="checkbox" placeholder="Name" class="required" name="microsoft_365[]" value="2"> Basic
                </div> 
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">&nbsp;</label>
                <div class="col-sm-4">
                    <input type="checkbox" placeholder="Name" class="required" name="microsoft_365[]" value="3"> None
                </div> 
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">&nbsp;</label>
                <div class="col-sm-2"><strong> Justification </strong></div>
                <div class="col-sm-3">
                    <input type="text" placeholder="" class="form-control margin-bottom" name="justification">
                </div> 
            </div>            
            <h4><strong>Part 3: HARDWARE REQUIRMENTS</strong></h4> 
            <small>Please indicate any specific hardware needed.</small>           
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">&nbsp;</label>
                <div class="col-sm-3 top-margin"><strong> Equipment </strong></div>
                <div class="col-sm-7 top-margin"><strong> Comments </strong></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">&nbsp;</label>
                <div class="col-sm-3 top-margin">
                    <input type="checkbox" placeholder="Name" class="required" name="machine[]" value="1"> Laptop
                    &nbsp;&nbsp;&nbsp;
                    <input type="checkbox" placeholder="Name" class="required" name="machine[]" value="2"> Desktop
                </div>
                <div class="col-sm-3">
                    <input type="text" placeholder="" class="form-control margin-bottom" name="machine_comment">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">&nbsp;</label>
                <div class="col-sm-3 top-margin">
                    <input type="checkbox" placeholder="Name" class="required" name="accessories[]" value="1"> Headsets
                    &nbsp;&nbsp;&nbsp;
                    <input type="checkbox" placeholder="Name" class="required" name="accessories[]" value="2"> Monitor
                    &nbsp;&nbsp;&nbsp;
                    <input type="checkbox" placeholder="Name" class="required" name="accessories[]" value="3"> Docking Station                    
                </div>
                <div class="col-sm-3">
                    <input type="text" placeholder="" class="form-control margin-bottom" name="accessories_comment">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">&nbsp;</label>
                <div class="col-sm-3 top-margin">
                    <input type="checkbox" placeholder="Name" class="required" name="wireless_mouse" value="1"> Wireless Mouse/Keyboard
                </div>
                <div class="col-sm-3">
                    <input type="text" placeholder="" class="form-control margin-bottom" name="wireless_mouse_comment">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">&nbsp;</label>
                <div class="col-sm-3 top-margin">
                    <input type="checkbox" placeholder="Name" class="required" name="other" value="1"> Other                    
                </div>
                <div class="col-sm-3">
                    <input type="text" placeholder="" class="form-control margin-bottom" name="other_comment">
                </div>
            </div>
            
            <h4><strong>Part 4: APPROVALS</strong></h4>            
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">&nbsp;</label>
                <label class="col-sm-1 col-form-label" for="name">Requestor :</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="" class="form-control margin-bottom" name="requestor">
                </div>
                <label class="col-sm-1 col-form-label" for="name">Signature :</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="" class="form-control margin-bottom" name="signature_req">
                </div>
                <label class="col-sm-1 col-form-label" for="name">Date :</label>
                <div class="col-sm-2">
                    <input type="date" placeholder="" class="form-control margin-bottom" name="date_req">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">&nbsp;</label>
                <label class="col-sm-1 col-form-label" for="name">BBO/HOD :</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="" class="form-control margin-bottom" name="bbo_hod">
                </div>
                <label class="col-sm-1 col-form-label" for="name">Signature :</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="" class="form-control margin-bottom" name="signature_hod">
                </div>
                <label class="col-sm-1 col-form-label" for="name">Date :</label>
                <div class="col-sm-2">
                    <input type="date" placeholder="" class="form-control margin-bottom" name="date_hod">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">&nbsp;</label>
                <label class="col-sm-1 col-form-label" for="name">IT Manager <small>(if applicable) :</small></label>
                <div class="col-sm-2">
                    <input type="text" placeholder="" class="form-control margin-bottom" name="it_manager">
                </div>
                <label class="col-sm-1 col-form-label" for="name">Signature :</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="" class="form-control margin-bottom" name="signature_it">
                </div>
                <label class="col-sm-1 col-form-label" for="name">Date :</label>
                <div class="col-sm-2">
                    <input type="date" placeholder="" class="form-control margin-bottom" name="date_it">
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-4">
                    <input type="submit" class="btn btn-success margin-bottom" value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                    <!-- <input type="hidden" value="employee/submit_user" id="action-url"> -->
                </div>
            </div>


        </form>
    </div>

</div>

<script type="text/javascript">
    $("#profile_add").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'user/submit_user';
        actionProduct1(actionurl);
    });
</script>

<script>

    function actionProduct1(actionurl) {

        $.ajax({

            url: actionurl,
            type: 'POST',
            data: $("#product_action").serialize(),
            dataType: 'json',
            success: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-warning").addClass("alert-success").fadeIn();


                $("html, body").animate({scrollTop: $('html, body').offset().top}, 200);
                $("#product_action").remove();
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);

            }

        });


    }
</script>