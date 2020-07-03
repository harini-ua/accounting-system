<form class="form invoice-item-repeater">
    <div data-repeater-list="group-a">
        <div class="mb-2" data-repeater-item>
            <!-- invoice Titles -->
            <div class="row mb-1">
                <div class="col s3 m4">
                    <h6 class="m-0">Item</h6>
                </div>
                <div class="col s3">
                    <h6 class="m-0">Cost</h6>
                </div>
                <div class="col s3">
                    <h6 class="m-0">Qty</h6>
                </div>
                <div class="col s3 m2">
                    <h6 class="m-0">Total</h6>
                </div>
            </div>
            <div class="invoice-item display-flex mb-1">
                <div class="invoice-item-filed row pt-1">
                    <div class="col s12 m4 input-field">
                        <select class="invoice-item-select browser-default">
                            <option value="Frest Admin Template">Frest Admin Template</option>
                            <option value="Stack Admin Template">Stack Admin Template</option>
                            <option value="Robust Admin Template">Robust Admin Template</option>
                            <option value="Apex Admin Template">Apex Admin Template</option>
                            <option value="Modern Admin Template">Modern Admin Template</option>
                        </select>
                    </div>
                    <div class="col m3 s12 input-field">
                        <input type="text" placeholder="0">
                    </div>
                    <div class="col m3 s12 input-field">
                        <input type="text" placeholder="0">
                    </div>
                    <div class="col m2 s12 input-field">
                        <input type="text" placeholder="$00" disabled>
                    </div>
                    <div class="col m4 s12 input-field">
                        <input type="text" class="invoice-item-desc"
                               value="The most developer friendly & highly customization HTML5 Admin">
                    </div>
                    <div class="col m8 s12 input-field">
                        <span>Discount: </span>
                        <span class="discount-value mr-1">0%</span>
                        <span class="mr-1 tax1">0%</span>
                        <span class="mr-1 tax2">0%</span>
                    </div>
                </div>
                <div class="invoice-icon display-flex flex-column justify-content-between">
                      <span data-repeater-delete class="delete-row-btn">
                        <i class="material-icons">clear</i>
                      </span>
                    <div class="dropdown">
                        <i class="material-icons dropdown-button" data-target="dropdown-discount">brightness_low</i>
                        <div class="dropdown-content" id="dropdown-discount">
                            <div class="row mr-0 ml-0">
                                <div class="col s12 input-field">
                                    <label for="discount">Discount(%)</label>
                                    <input type="number" id="discount" placeholder="0">
                                </div>
                                <div class="col s6">
                                    <select id="Tax1" class="invoice-tax browser-default">
                                        <option value="0%" selected disabled>Tax1</option>
                                        <option value="1%">1%</option>
                                        <option value="10%">10%</option>
                                        <option value="18%">18%</option>
                                        <option value="40%">40%</option>
                                    </select>
                                </div>
                                <div class="col s6">
                                    <select id="Tax2" class="invoice-tax browser-default">
                                        <option value="0%" selected disabled>Tax2</option>
                                        <option value="1%">1%</option>
                                        <option value="10%">10%</option>
                                        <option value="18%">18%</option>
                                        <option value="40%">40%</option>
                                    </select>
                                </div>
                            </div>
                            <div class="display-flex justify-content-between mt-4">
                                <button type="button" class="btn invoice-apply-btn">
                                    <span>Apply</span>
                                </button>
                                <button type="button" class="btn invoice-cancel-btn ml-1 indigo">
                                    <span>Cancel</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="input-field">
        <button class="btn invoice-repeat-btn" data-repeater-create type="button">
            <i class="material-icons left">add</i>
            <span>{{ __('Add Item') }}</span>
        </button>
    </div>
</form>
