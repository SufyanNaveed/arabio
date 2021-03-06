<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title">
                <?php echo 'Complaints'; ?> <a href="<?php echo base_url('complaints/add') ?>"
                                                               class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?>
                </a>
            </h5>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">
                <?php if ($this->session->flashdata("messagePr")) { ?>
                    <div class="alert alert-info">
                        <?php echo $this->session->flashdata("messagePr") ?>
                    </div>
                <?php } ?>        

                <table id="emptable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Request</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo 'Department' ?></th>
                        <th><?php echo 'Title' ?></th>
                        <th><?php echo 'Network ID' ?></th>
                        <th><?php echo 'Phone' ?></th>
                        <th><?php echo 'Email' ?></th>
                        <th><?php echo 'Position' ?></th>
                        <th><?php echo 'Action' ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; foreach ($complaints as $row) { ?>                       
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row['request'] == 'new_request' ? 'New Request' : 'Change Request'; ?></td>
                            <td><?php echo $row['emp_name']; ?> </td>
                            <td><?php echo $row['department']; ?></td>                 
                            <td><?php echo $row['emp_title']; ?></td>
                            <td><?php echo $row['network_Id']; ?></td>
                            <td><?php echo $row['primary_phone']; ?></td>
                            <td><?php echo $row['email_address']; ?></td>
                            <td><?php echo $row['sap_position']; ?></td>
                            <td><a class="btn btn-primary  btn-sm" href="<?php echo base_url('complaints/printTicket/'.$row['id']) ?>" target="_blank"> <span class="fa fa-print"></span> Print</a></td>
                        </tr>
                    <?php $i++; } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Request</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo 'Department' ?></th>
                        <th><?php echo 'Title' ?></th>
                        <th><?php echo 'Network ID' ?></th>
                        <th><?php echo 'Phone' ?></th>
                        <th><?php echo 'Email' ?></th>
                        <th><?php echo 'Position' ?></th>
                        <th><?php echo 'Action' ?></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {

            //datatables
            $('#emptable').DataTable({
                // responsive: true, <?php datatable_lang();?> dom: 'Blfrtip',
                // buttons: [
                //     {
                //         extend: 'excelHtml5',
                //         footer: false,
                //         exportOptions: {
                //             columns: [0, 1, 2, 3]
                //         }
                //     }
                // ],
            });


        });

        $('.delemp').click(function (e) {
            e.preventDefault();
            $('#empid').val($(this).attr('data-object-id'));

        });
    </script>


    <div id="delete_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title">Deactive Employee</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to deactivate this account ? <br><strong> It will disable this account
                            access
                            to
                            user.</strong></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="object-id" value="">
                    <input type="hidden" id="action-url" value="employee/disable_user">
                    <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm">Confirm
                    </button>
                    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <div id="pop_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Delete'); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="form_model">


                        <div class="modal-body">
                            <p>Are you sure you want to delete this employee? <br><strong> It may interrupt old
                                    invoices,
                                    disable account is a better option.</strong></p>
                        </div>
                        <div class="modal-footer">


                            <input type="hidden" class="form-control required"
                                   name="empid" id="empid" value="">
                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                            <input type="hidden" id="action-url" value="employee/delete_user">
                            <button type="button" class="btn btn-primary"
                                    id="submit_model"><?php echo $this->lang->line('Delete'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>