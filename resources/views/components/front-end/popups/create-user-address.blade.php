<!-- Modal -->
<div id="save-address-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
                <h4 class="modal-title">Add New Address</h4>
            </div>
            {{ Form::open(['url' => URL::to('user-address'), 'method' => 'Post']) }}
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-md-4 form-group">
                        <label>Full Name*</label>
                        <input type="text" name="full_name" class="form-control" required="required">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Email*</label>
                        <input type="email" class="form-control" name="email" required="required">
                    </div>
                    <div class="col-md-4">
                        <label>Phone Number*</label>
                        <input type="number" class="form-control" name="phone_number" required="required">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label>Address*</label>
                        <textarea class="form-control" name="address" required="required" rows="5"></textarea>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 form-group">
                        <label>Pin Code*</label>
                        <input type="text" class="form-control" name="pin_code" required="required">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>State*</label>
                        <input type="text" class="form-control" name="state" required="required">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>City*</label>
                        <input type="text" class="form-control" name="city" required="required">
                    </div>
                </div>
                {{-- <div class="row check_input_mr">
                    <div class="col-md-12">
                        <div class="remember d-flex align-items-center">
                            <input type="radio" name="is_default" id="is_default">
                            <label for="remem">
                                <p class="set_as font-bold mx-2 mr-0">Set as Default Address
                                </p>
                            </label>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="modal-footer">
                <button type="submit" class="submit site_button font-bold" data-dismiss="modal">SAVE</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
