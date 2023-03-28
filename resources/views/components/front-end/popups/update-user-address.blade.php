<!-- Modal -->
<div id="update-address-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
                <h4 class="modal-title">Update Address</h4>
            </div>
            {{ Form::open(['id' => 'formUserAddressUpdate', 'method' => 'Put']) }}
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-md-4 form-group">
                        <label>Full Name*</label>
                        <input type="text" name="full_name" id="full_name" class="form-control" required="required">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Email*</label>
                        <input type="email" class="form-control" name="email" id="email" required="required">
                    </div>
                    <div class="col-md-4">
                        <label>Phone Number*</label>
                        <input type="number" class="form-control" name="phone_number" id="phone_number"  required="required">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label>Address*</label>
                        <textarea class="form-control" name="address" required="required" id="address" rows="5"></textarea>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 form-group">
                        <label>Pin Code*</label>
                        <input type="text" class="form-control" name="pin_code" id="pin_code" required="required">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>State*</label>
                        <input type="text" class="form-control" name="state" id="state" required="required">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>City*</label>
                        <input type="text" class="form-control" name="city" id="city" required="required">
                    </div>
                </div>
                <div class="row check_input_mr mt-2" id="update_is_default_div">
                    <div class="col-md-12">
                        <div class="remember d-flex align-items-center">
                            <input type="checkbox" name="is_default" id="is_default">
                            <label for="remem">
                                <p class="set_as font-bold mx-2 mr-0">Set as Default Address
                                </p>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="submit site_button font-bold" data-dismiss="modal">UPDATE</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>


