<form id="add-wallet-form"
      class="handle-submit-form edit-contact-item"
      data-created-item="wallet"
      method="POST"
      action="{{ route('wallets.store') }}"
>
    @csrf
    <div class="row">
        <div class="col s12 m6">
            <div class="input-field col s12">
                <input id="name" name="name" type="text" class="validate">
                <label for="name">Name</label>
                <span class="error-span"></span>
            </div>
        </div>
        <div class="col s12 m6">
            <x-select
                    name="wallet_type_id"
                    title="Wallet Type"
                    :options="$walletTypes"
                    firstTitle="Wallet Type"
            ></x-select>
        </div>
    </div>
    <div class="pl-0 pr-0 right-align">
        <a href="#" class=" mr-1 btn waves-effect cancel-btn slide-up-btn">Cancel</a>
        <button type="submit" class="btn waves-effect waves-light">
            <span>Add Wallet</span>
        </button>
    </div>
</form>