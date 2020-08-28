<form id="contracts" method="POST"
      action="{{ isset($contract) ? route('contracts.update', $contract) : route('contracts.store') }}"
      class="{{ isset($contact) ? 'update' : 'handle-submit-form with-clear-left'  }}">
    @if(isset($contract)) @method('PUT') @endif
    @csrf
    <div class="row">
        <div class="col s12 m6">
            <div class="input-field col s12">
                <input name="name" value="{{ $contract->name ?? null }}"
                       id="name" type="text">
                <label for="name" class="active">{{ __('Contract Name') }}</label>
                @error('name')
                <small class="errorTxt2">
                    <div id="name-error" class="error">{{ $message }}</div>
                </small>
                @enderror
                <span class="error-span"></span>

            </div>
        </div>
        <div class="col s12 m6">
            <div class="input-field col s12">
                <select
                        name="client_id"
                        class="select2 browser-default"
                        id="client_id">
                    <option value="">{{ __('- Select Client -') }}</option>
                    @foreach($clients as $id => $name)
                        <option value="{{ $id }}" {{ isset($contract) && $contract->client_id === $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                <label for="client_id" class="active">{{ __('Client') }}</label>
                @error('client_id')
                <small class="errorTxt2">
                    <div id="client_id-error" class="error">{{ $message }}</div>
                </small>
                @enderror
                <span class="error-span"></span>

            </div>
        </div>
        <div class="col s12 m6">
            <div class="input-field col s12">
                <select name="sales_manager_id"
                        class="select2 browser-default"
                        id="sales_manager_id">
                    <option value="">{{ __('- Select Sales Manager -') }}</option>
                    @foreach($salesManagers as $id => $name)
                        <option value="{{ $id }}" {{ isset($contract) && $contract->sales_manager_id === $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                <label for="client_id"
                       class="active">{{ __('Sales Manager') }}
                </label>
                @error('sales_manager_id')
                <small class="errorTxt2">
                    <div id="sales_manager_id-error" class="error">{{ $message }}</div>
                </small>
                @enderror
                <span class="error-span"></span>

            </div>
        </div>
        <div class="col s12 m6">
            <div class="input-field col s12">
                <textarea name="comment"
                          class="materialize-textarea"
                          placeholder="{{ __('Comment') }}"
                          id="comment">{{ $contract->comment ?? null }}
                </textarea>
                <label for="name" class="active">{{ __('Comment') }}</label>
                <span class="error-span"></span>
                @error('comment')
                <small class="errorTxt2">
                    <div id="comment-error" class="error">{{ $message }}</div>
                </small>
                @enderror
            </div>
        </div>
        <div class="col s12 m6">
            <div class="input-field col s12">
                <select name="status" id="status"
                        class="select2 browser-default">

                    @foreach($status as $id => $name)
                        <option value="{{ $id }}" {{ isset($contract) && $contract->status === $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                <label for="client_id" class="active">{{ __('Status') }}</label>
                @error('status')
                <small class="errorTxt2">
                    <div id="status-error" class="error">{{ $message }}</div>
                </small>
                @enderror
            </div>
        </div>
        <div class="col s12 display-flex justify-content-end mt-3">
            <a href="{{ url()->previous() }}" class="chanel-btn btn btn-light {{ isset($contract) ? __('') : __('slide-up-btn') }} mr-1">{{ __('Cancel') }}</a>
            <button type="submit" class="btn ">{{ isset($contract) ? __('Update') : __('Save') }}</button>
        </div>
    </div>
</form>
