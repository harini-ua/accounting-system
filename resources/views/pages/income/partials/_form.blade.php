<form class=" handle-submit-form edit-contact-item  " method="POST"
      data-created-item="income"
      action="{{ route('incomes.store') }}">
    @csrf
    <div class="row">
        <div class="col s12 m6">
            <x-linked-selects
                firstName="client_id"
                firstTitle="Client"
                secondName="contract_id"
                secondTitle="Contract"
                dataUrl="/clients/[id]/contracts"
                view="components.linked-selects.clients-contracts"
                :options="$clients"
            />
        </div>
        <div class="col s12 m6">
            <x-linked-selects
                firstName="wallet_id"
                firstTitle="Wallet"
                secondName="account_id"
                secondTitle="Account"
                dataUrl="/wallets/[id]/accounts"
                view="components.linked-selects.wallets-accounts"
                :options="$wallets"
            />
        </div>
        <div class="col s12 m6">
            <x-date name="plan_date" title="Planning Date"></x-date>
        </div>
        <div class="col s12 m6">
            <x-input name="plan_sum" title="Planning Sum"></x-input>
        </div>
        <div class="col s12">
            <div class="col s12 display-flex justify-content-end mt-3">
                <button type="button" class="btn btn-light mr-1 cancel-btn slide-up-btn">Cancel</button>
                <button type="submit" class="btn waves-effect waves-light">
                    Save
                </button>
            </div>
        </div>
    </div>
</form>
