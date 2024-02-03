<div class="details-tabs">
    <div class="tab-list">
        <div class="nav-prev arrow disabled">
            <picture>
                <img src="{{ asset('assets/images/prev-arrow.svg') }}" alt="back-arrow" width="169" height="40" />
            </picture>
        </div>

        <ul class="nav nav-pills" id="pills-tab" role="tablist">
            @if ($companyActivities = $companyData['companyactivities'])
                @foreach ($companyActivities as $index => $activity)
                    <li class="nav-item {{ $index === 0 ? 'active' : '' }}" role="presentation">
                        <button class="nav-link" id="pills-home-tab" data-bs-toggle="pill" title="{{ generateSlug($activity['name']) }}"
                            data-bs-target="#{{ generateSlug($activity['name']) }}" type="button" role="tab"
                            aria-controls="pills-home" aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                            {{ $activity['name'] }}
                        </button>
                    </li>
                @endforeach
            @endif
        </ul>
        <div class="nav-next arrow">
            <picture>
                <img src="{{ asset('assets/images/next-arrow.svg') }}" alt="back-arrow" width="169" height="40" />
            </picture>
        </div>
    </div>
    <div class="emission-management">
        <span class="error-mgs mb-3" id="errorMessagesID"></span>
    </div>
    <div class="tab-content" id="pills-tabContent">
        @if ($companyActivities = $companyData['companyactivities'])
            @foreach ($companyActivities as $index => $activity)
                @if (generateSlug($activity['name']) == \App\Models\Activity::REFRIGERANTS)
                    <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                        id="{{ generateSlug($activity['name']) }}" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="checkbox-main custome-scrollbar-m">
                            <ul class="custome-checkbox ">
                                <li class="all-select">
                                    <label class="checkbox"  for="select-all-{{ generateSlug($activity['name']) }}">
                                        <input type="checkbox" name="remember" name="all" value="all" checked
                                            id="select-all-{{ generateSlug($activity['name']) }}">All<span
                                            class="checkmark"></span>
                                    </label>
                                </li>
                                @if (count(getActivity(generateSlug($activity['name']))) > 0)
                                    @foreach (getActivity(generateSlug($activity['name'])) as $value)
                                        <li>
                                            <label class="checkbox"
                                                for="{{ generateSlug($activity['name']) . $value['id'] }}">
                                                <input type="checkbox" name="{{ generateSlug($activity['name']) }}[]"
                                                    value="{{ $value['id'] }}"
                                                    id="{{ generateSlug($activity['name']) . $value['id'] }}"
                                                    class="{{ generateSlug($activity['name']) }}-checkbox"
                                                    {{ in_array($value['id'], getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) ? 'checked' : '' }}
                                                    >{{ $value['emission'] }}<span
                                                    class="checkmark"></span>
                                            </label>
                                        </li>
                                    @endforeach
                                    <input type="hidden"
                                        value="{{ count(getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) }}"
                                        id="{{ generateSlug($activity['name']) . '-checkbox-' }}-count"
                                        class ="activities-data"
                                        data-checkbox="{{ generateSlug($activity['name']) . '-checkbox' }}"
                                        data-allcheck="select-all-{{ generateSlug($activity['name']) }}">
                                @endif
                            </ul>
                        </div>
                    </div>
                @elseif (generateSlug($activity['name']) == \App\Models\Activity::FUELS)
                    <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                        id="{{ generateSlug($activity['name']) }}" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="checkbox-main custome-scrollbar-m">
                            <ul class="custome-checkbox ">
                                <li class="all-select">
                                    <label class="checkbox"  for="select-all-{{ generateSlug($activity['name']) }}">
                                        <input type="checkbox" name="remember" name="all" value="all" checked
                                            id="select-all-{{ generateSlug($activity['name']) }}">All<span
                                            class="checkmark"></span>
                                    </label>
                                </li>
                                @if (count(getActivity(generateSlug($activity['name']))) > 0)
                                    @foreach (getActivity(generateSlug($activity['name'])) as $value)
                                        <li>
                                            <label class="checkbox"
                                                for="{{ generateSlug($activity['name']) . $value['id'] }}">
                                                <input type="checkbox" name="{{ generateSlug($activity['name']) }}[]"
                                                    value="{{ $value['id'] }}"
                                                    id="{{ generateSlug($activity['name']) . $value['id'] }}"
                                                    class="{{ generateSlug($activity['name']) }}-checkbox"
                                                    {{ in_array($value['id'], getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) ? 'checked' : '' }}
                                                    >{{ $value['fuel'] }}<span
                                                    class="checkmark"></span>
                                            </label>
                                        </li>
                                    @endforeach
                                    <input type="hidden"
                                        value="{{ count(getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) }}"
                                        id="{{ generateSlug($activity['name']) . '-checkbox-' }}-count"
                                        class ="activities-data"
                                        data-checkbox="{{ generateSlug($activity['name']) . '-checkbox' }}"
                                        data-allcheck="select-all-{{ generateSlug($activity['name']) }}">
                                @endif
                            </ul>
                        </div>
                    </div>
                @elseif (generateSlug($activity['name']) == \App\Models\Activity::WTT_FULES)
                    <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                        id="{{ generateSlug($activity['name']) }}" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="checkbox-main custome-scrollbar-m">
                            <ul class="custome-checkbox ">
                                <li class="all-select">
                                    <label class="checkbox" for="select-all-{{ generateSlug($activity['name']) }}">
                                        <input type="checkbox" name="remember" name="all" value="all" checked
                                            id="select-all-{{ generateSlug($activity['name']) }}">All<span
                                            class="checkmark"></span>
                                    </label>
                                </li>
                                @if (count(getActivity(generateSlug($activity['name']))) > 0)
                                    @foreach (getActivity(generateSlug($activity['name'])) as $value)
                                        <li>
                                            <label class="checkbox"
                                                for="{{ generateSlug($activity['name']) . $value['id'] }}">
                                                <input type="checkbox" name="{{ generateSlug($activity['name']) }}[]"
                                                    value="{{ $value['id'] }}"
                                                    id="{{ generateSlug($activity['name']) . $value['id'] }}"
                                                    class="{{ generateSlug($activity['name']) }}-checkbox"
                                                    {{ in_array($value['id'], getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) ? 'checked' : '' }}
                                                    >{{ $value['fuel'] }}<span
                                                    class="checkmark"></span>
                                            </label>
                                        </li>
                                    @endforeach
                                    <input type="hidden"
                                        value="{{ count(getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) }}"
                                        id="{{ generateSlug($activity['name']) . '-checkbox-' }}-count"
                                        class ="activities-data"
                                        data-checkbox="{{ generateSlug($activity['name']) . '-checkbox' }}"
                                        data-allcheck="select-all-{{ generateSlug($activity['name']) }}">
                                @endif
                            </ul>
                        </div>
                    </div>
                @elseif (generateSlug($activity['name']) == \App\Models\Activity::FOOD)
                    <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                        id="{{ generateSlug($activity['name']) }}" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="checkbox-main custome-scrollbar-m">
                            <ul class="custome-checkbox ">
                                <li class="all-select">
                                    <label class="checkbox" for="select-all-{{ generateSlug($activity['name']) }}">
                                        <input type="checkbox" name="remember" name="all" value="all" checked
                                            id="select-all-{{ generateSlug($activity['name']) }}">All<span
                                            class="checkmark"></span>
                                    </label>
                                </li>
                                @if (count(getActivity(generateSlug($activity['name']))) > 0)
                                    @foreach (getActivity(generateSlug($activity['name'])) as $value)
                                        <li>
                                            <label class="checkbox"
                                                for="{{ generateSlug($activity['name']) . $value['id'] }}">
                                                <input type="checkbox" name="{{ generateSlug($activity['name']) }}[]"
                                                    value="{{ $value['id'] }}"
                                                    id="{{ generateSlug($activity['name']) . $value['id'] }}"
                                                    class="{{ generateSlug($activity['name']) }}-checkbox"
                                                    {{ in_array($value['id'], getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) ? 'checked' : '' }}
                                                    >{{ $value['vehicle'] }}<span
                                                    class="checkmark"></span>
                                            </label>
                                        </li>
                                    @endforeach
                                    <input type="hidden"
                                        value="{{ count(getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) }}"
                                        id="{{ generateSlug($activity['name']) . '-checkbox-' }}-count"
                                        class ="activities-data"
                                        data-checkbox="{{ generateSlug($activity['name']) . '-checkbox' }}"
                                        data-allcheck="select-all-{{ generateSlug($activity['name']) }}">
                                @endif
                            </ul>
                        </div>
                    </div>
                @elseif (generateSlug($activity['name']) == \App\Models\Activity::BUSSINESSTRAVEL)
                    <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                        id="{{ generateSlug($activity['name']) }}" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="checkbox-main custome-scrollbar-m">
                            <ul class="custome-checkbox ">
                                <li class="all-select">
                                    <label class="checkbox" for="select-all-{{ generateSlug($activity['name']) }}">
                                        <input type="checkbox" name="remember" name="all" value="all" checked
                                            id="select-all-{{ generateSlug($activity['name']) }}">All<span
                                            class="checkmark"></span>
                                    </label>
                                </li>
                                @if (count(getActivity(generateSlug($activity['name']))) > 0)
                                    @foreach (getActivity(generateSlug($activity['name'])) as $value)
                                        <li>
                                            <label class="checkbox"
                                                for="{{ generateSlug($activity['name']) . $value['id'] }}">
                                                <input type="checkbox" name="{{ generateSlug($activity['name']) }}[]"
                                                    value="{{ $value['id'] }}"
                                                    id="{{ generateSlug($activity['name']) . $value['id'] }}"
                                                    class="{{ generateSlug($activity['name']) }}-checkbox"
                                                    {{ in_array($value['id'], getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) ? 'checked' : '' }}
                                                    >{{ $value['vehicles'] . ' - ' . $value['type'] . ' - ' . $value['fuel'] }}<span
                                                    class="checkmark"></span>
                                            </label>
                                        </li>
                                    @endforeach
                                    <input type="hidden"
                                        value="{{ count(getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) }}"
                                        id="{{ generateSlug($activity['name']) . '-checkbox-' }}-count"
                                        class ="activities-data"
                                        data-checkbox="{{ generateSlug($activity['name']) . '-checkbox' }}"
                                        data-allcheck="select-all-{{ generateSlug($activity['name']) }}">
                                @endif
                            </ul>
                        </div>
                    </div>
                @elseif (generateSlug($activity['name']) == \App\Models\Activity::EMPLOYEECOMMUNTING)
                    <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                        id="{{ generateSlug($activity['name']) }}" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="checkbox-main custome-scrollbar-m">
                            <ul class="custome-checkbox ">
                                <li class="all-select">
                                    <label class="checkbox" for="select-all-{{ generateSlug($activity['name']) }}">
                                        <input type="checkbox" name="remember" name="all" value="all" checked
                                            id="select-all-{{ generateSlug($activity['name']) }}">All<span
                                            class="checkmark"></span>
                                    </label>
                                </li>
                                @if (count(getActivity(generateSlug($activity['name']))) > 0)
                                    @foreach (getActivity(generateSlug($activity['name'])) as $value)
                                        <li>
                                            <label class="checkbox"
                                                for="{{ generateSlug($activity['name']) . $value['id'] }}">
                                                <input type="checkbox" name="{{ generateSlug($activity['name']) }}[]"
                                                    value="{{ $value['id'] }}"
                                                    id="{{ generateSlug($activity['name']) . $value['id'] }}"
                                                    class="{{ generateSlug($activity['name']) }}-checkbox"
                                                    {{ in_array($value['id'], getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) ? 'checked' : '' }}
                                                    >{{ $value['vehicle'] . ' - ' . $value['type'] . ' - ' . $value['fuel'] }}<span
                                                    class="checkmark"></span>
                                            </label>
                                        </li>
                                    @endforeach
                                    <input type="hidden"
                                        value="{{ count(getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) }}"
                                        id="{{ generateSlug($activity['name']) . '-checkbox-' }}-count"
                                        class ="activities-data"
                                        data-checkbox="{{ generateSlug($activity['name']) . '-checkbox' }}"
                                        data-allcheck="select-all-{{ generateSlug($activity['name']) }}">
                                @endif
                            </ul>
                        </div>
                    </div>
                @elseif (generateSlug($activity['name']) == \App\Models\Activity::WASTEDISPOSAL)
                    <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                        id="{{ generateSlug($activity['name']) }}" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="checkbox-main custome-scrollbar-m">
                            <ul class="custome-checkbox ">
                                <li class="all-select">
                                    <label class="checkbox"  for="select-all-{{ generateSlug($activity['name']) }}">
                                        <input type="checkbox" name="remember" name="all" value="all" checked
                                            id="select-all-{{ generateSlug($activity['name']) }}">All<span
                                            class="checkmark"></span>
                                    </label>
                                </li>
                                @if (count(getActivity(generateSlug($activity['name']))) > 0)
                                    @foreach (getActivity(generateSlug($activity['name'])) as $value)
                                        <li>
                                            <label class="checkbox"
                                                for="{{ generateSlug($activity['name']) . $value['id'] }}">
                                                <input type="checkbox" name="{{ generateSlug($activity['name']) }}[]"
                                                    value="{{ $value['id'] }}"
                                                    id="{{ generateSlug($activity['name']) . $value['id'] }}"
                                                    class="{{ generateSlug($activity['name']) }}-checkbox"
                                                    {{ in_array($value['id'], getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) ? 'checked' : '' }}
                                                    >{{ $value['waste_type'] }}<span
                                                    class="checkmark"></span>
                                            </label>
                                        </li>
                                    @endforeach
                                    <input type="hidden"
                                        value="{{ count(getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) }}"
                                        id="{{ generateSlug($activity['name']) . '-checkbox-' }}-count"
                                        class ="activities-data"
                                        data-checkbox="{{ generateSlug($activity['name']) . '-checkbox' }}"
                                        data-allcheck="select-all-{{ generateSlug($activity['name']) }}">
                                @endif
                            </ul>
                        </div>
                    </div>
                @elseif (generateSlug($activity['name']) == \App\Models\Activity::T_D)
                    <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                        id="{{ generateSlug($activity['name']) }}" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        <div class="checkbox-main custome-scrollbar-m">
                            <ul class="custome-checkbox ">
                                <li class="all-select">
                                    <label class="checkbox" for="select-all-{{ generateSlug($activity['name']) }}">
                                        <input type="checkbox" name="remember" name="all" value="all" checked
                                            id="select-all-{{ generateSlug($activity['name']) }}">All<span
                                            class="checkmark"></span>
                                    </label>
                                </li>
                                @if (count(getActivity(generateSlug($activity['name']))) > 0)
                                    @foreach (getActivity(generateSlug($activity['name'])) as $value)
                                        <li>
                                            <label class="checkbox"
                                                for="{{ generateSlug($activity['name']) . $value['id'] }}">
                                                <input type="checkbox"
                                                    name="{{ generateSlug($activity['name']) }}[]"
                                                    value="{{ $value['id'] }}"
                                                    id="{{ generateSlug($activity['name']) . $value['id'] }}"
                                                    class="{{ generateSlug($activity['name']) }}-checkbox"
                                                    {{ in_array($value['id'], getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) ? 'checked' : '' }}
                                                    >{{ $value['activity'] }}<span
                                                    class="checkmark"></span>
                                            </label>
                                        </li>
                                    @endforeach
                                    <input type="hidden"
                                        value="{{ count(getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) }}"
                                        id="{{ generateSlug($activity['name']) . '-checkbox-' }}-count"
                                        class ="activities-data"
                                        data-checkbox="{{ generateSlug($activity['name']) . '-checkbox' }}"
                                        data-allcheck="select-all-{{ generateSlug($activity['name']) }}">
                                @endif
                            </ul>
                        </div>
                    </div>
                @elseif (generateSlug($activity['name']) == \App\Models\Activity::WATER)
                    <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                        id="{{ generateSlug($activity['name']) }}" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        <div class="checkbox-main custome-scrollbar-m">
                            <ul class="custome-checkbox ">
                                <li class="all-select">
                                    <label class="checkbox" for="select-all-{{ generateSlug($activity['name']) }}">
                                        <input type="checkbox" name="remember" name="all" value="all" checked
                                            id="select-all-{{ generateSlug($activity['name']) }}">All<span
                                            class="checkmark"></span>
                                    </label>
                                </li>
                                @if (count(getActivity(generateSlug($activity['name']))) > 0)
                                    @foreach (getActivity(generateSlug($activity['name'])) as $value)
                                        <li>
                                            <label class="checkbox"
                                                for="{{ generateSlug($activity['name']) . $value['id'] }}">
                                                <input type="checkbox"
                                                    name="{{ generateSlug($activity['name']) }}[]"
                                                    value="{{ $value['id'] }}"
                                                    id="{{ generateSlug($activity['name']) . $value['id'] }}"
                                                    class="{{ generateSlug($activity['name']) }}-checkbox"
                                                    {{ in_array($value['id'], getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) ? 'checked' : '' }}
                                                    >{{ $value['type'] }}<span
                                                    class="checkmark"></span>
                                            </label>
                                        </li>
                                    @endforeach
                                    <input type="hidden"
                                        value="{{ count(getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) }}"
                                        id="{{ generateSlug($activity['name']) . '-checkbox-' }}-count"
                                        class ="activities-data"
                                        data-checkbox="{{ generateSlug($activity['name']) . '-checkbox' }}"
                                        data-allcheck="select-all-{{ generateSlug($activity['name']) }}">
                                @endif
                            </ul>
                        </div>
                    </div>
                @elseif (generateSlug($activity['name']) == \App\Models\Activity::MATERIAL_USE)
                    <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                        id="{{ generateSlug($activity['name']) }}" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        <div class="checkbox-main custome-scrollbar-m">
                            <ul class="custome-checkbox ">
                                <li class="all-select">
                                    <label class="checkbox" for="select-all-{{ generateSlug($activity['name']) }}">
                                        <input type="checkbox" name="remember" name="all" value="all" checked
                                            id="select-all-{{ generateSlug($activity['name']) }}">All<span
                                            class="checkmark"></span>
                                    </label>
                                </li>
                                @if (count(getActivity(generateSlug($activity['name']))) > 0)
                                    @foreach (getActivity(generateSlug($activity['name'])) as $value)
                                        <li>
                                            <label class="checkbox"
                                                for="{{ generateSlug($activity['name']) . $value['id'] }}">
                                                <input type="checkbox"
                                                    name="{{ generateSlug($activity['name']) }}[]"
                                                    value="{{ $value['id'] }}"
                                                    id="{{ generateSlug($activity['name']) . $value['id'] }}"
                                                    class="{{ generateSlug($activity['name']) }}-checkbox"
                                                    {{ in_array($value['id'], getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) ? 'checked' : '' }}
                                                    >{{ $value['waste_type'] }}<span
                                                    class="checkmark"></span>
                                            </label>
                                        </li>
                                    @endforeach
                                    <input type="hidden"
                                        value="{{ count(getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) }}"
                                        id="{{ generateSlug($activity['name']) . '-checkbox-' }}-count"
                                        class ="activities-data"
                                        data-checkbox="{{ generateSlug($activity['name']) . '-checkbox' }}"
                                        data-allcheck="select-all-{{ generateSlug($activity['name']) }}">
                                @endif
                            </ul>
                        </div>
                    </div>
                @elseif (generateSlug($activity['name']) == \App\Models\Activity::OWNED_VEHICLES)
                    <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                        id="{{ generateSlug($activity['name']) }}" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        <div class="checkbox-main custome-scrollbar-m">
                            <div class="checkbox-group-box">
                                <ul class="custome-checkbox custom-group-list">
                                    @if (count(getActivity(generateSlug($activity['name']))) > 0)
                                        <li class="checklist-title">Passenger Vehicles</li>
                                        <li class="all-select">
                                            <label class="checkbox" for="select-all-{{ generateSlug($activity['name']) . '-passenger' }}">
                                                <input type="checkbox" name="remember" name="all" value="all"
                                                    checked
                                                    id="select-all-{{ generateSlug($activity['name']) . '-passenger' }}">All<span
                                                    class="checkmark"></span>
                                            </label>
                                        </li>
                                        @foreach (getVehicleData('1') as $value)
                                            <li>
                                                <label class="checkbox"
                                                    for="{{ generateSlug($activity['name']) . $value['id'] }}">
                                                    <input type="checkbox"
                                                        name="{{ generateSlug($activity['name']) . '_passenger' }}[]"
                                                        value="{{ $value['id'] }}"
                                                        id="{{ generateSlug($activity['name']) . $value['id'] }}"
                                                        class="{{ generateSlug($activity['name']) . '-passenger' }}-checkbox"
                                                        {{ in_array($value['id'], getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) ? 'checked' : '' }}
                                                        >{{ $value['vehicle'] . ' - ' . $value['type'] . ' - ' . $value['fuel'] }}<span
                                                        class="checkmark"></span>
                                                </label>
                                            </li>
                                            @endforeach
                                </ul>
                                <ul class="custome-checkbox custom-group-list">
                                        
                                        <input type="hidden"
                                            value="{{ count(getSelectedOwnedVehicle('1', $activity['company_id'])) }}"
                                            id="{{ generateSlug($activity['name']) . '-checkbox-' }}passenger-count"
                                            class ="activities-data"
                                            data-checkbox="{{ generateSlug($activity['name']) . '-passenger' }}-checkbox"
                                            data-allcheck="select-all-{{ generateSlug($activity['name']) . '-passenger' }}">

                                        <li class="checklist-title">Delivery Vehicles</li>
                                        <li class="all-select">
                                            <label class="checkbox" for="select-all-{{ generateSlug($activity['name']) . '-delivery' }}">
                                                <input type="checkbox" name="remember" name="all" value="all"
                                                    checked
                                                    id="select-all-{{ generateSlug($activity['name']) . '-delivery' }}">All<span
                                                    class="checkmark"></span>
                                            </label>
                                        </li>
                                        @foreach (getVehicleData('2') as $value)
                                            <li>
                                                <label class="checkbox" for="{{ $value['id'] }}">
                                                    <input type="checkbox"
                                                        name="{{ generateSlug($activity['name']) . '_delivery' }}[]"
                                                        value="{{ $value['id'] }}" id="{{ $value['id'] }}"
                                                        class="{{ generateSlug($activity['name']) . '-delivery' }}-checkbox"
                                                        {{ in_array($value['id'], getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) ? 'checked' : '' }}
                                                        >{{ $value['vehicle'] . ' - ' . $value['type'] . ' - ' . $value['fuel'] }}<span
                                                        class="checkmark"></span>
                                                </label>
                                            </li>
                                        @endforeach
                                        <input type="hidden"
                                            value="{{ count(getSelectedOwnedVehicle('2', $activity['company_id'])) }}"
                                            id="{{ generateSlug($activity['name']) . '-checkbox-' }}-count"
                                            class ="activities-data"
                                            data-checkbox="{{ generateSlug($activity['name']) . '-delivery' . '-checkbox' }}"
                                            data-allcheck="select-all-{{ generateSlug($activity['name']) . '-delivery' }}">
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                @elseif (generateSlug($activity['name']) == \App\Models\Activity::ELECTRICITY_HEAT_COOLING)
                    <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                        id="{{ generateSlug($activity['name']) }}" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        <div class="checkbox-main custome-scrollbar-m">
                            <ul class="custome-checkbox">
                                <li class="all-select">
                                    <label class="checkbox"  for="select-all-{{ generateSlug($activity['name']) }}">
                                        <input type="checkbox" name="remember" name="all" value="all" checked
                                            id="select-all-{{ generateSlug($activity['name']) }}">All<span
                                            class="checkmark"></span>
                                    </label>
                                </li>
                                @if (count(getActivity(generateSlug($activity['name']))) > 0)
                                    <li class="checklist-title">Electricity Grid</li>
                                    @foreach (getElectrticityData('1') as $value)
                                        <li>
                                            <label class="checkbox"
                                                for="{{ generateSlug($activity['name']) . $value['id'] }}">
                                                <input type="checkbox"
                                                    name="{{ generateSlug($activity['name']) }}[]"
                                                    value="{{ $value['id'] }}"
                                                    id="{{ generateSlug($activity['name']) . $value['id'] }}"
                                                    class="{{ generateSlug($activity['name']) }}-checkbox"
                                                    {{ in_array($value['id'], getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) ? 'checked' : '' }}
                                                    >{{ $value['activity'] . '-'. optional($value['country'])['name']}}<span
                                                    class="checkmark"></span>
                                            </label>
                                        </li>
                                    @endforeach
                                    <li class="checklist-title">Heat And Steam</li>
                                    @foreach (getElectrticityData('2') as $value)
                                        <li>
                                            <label class="checkbox"
                                                for="{{ generateSlug($activity['name']) . $value['id'] }}">
                                                <input type="checkbox"
                                                    name="{{ generateSlug($activity['name']) }}[]"
                                                    value="{{ $value['id'] }}"
                                                    id="{{ generateSlug($activity['name']) . $value['id'] }}"
                                                    class="{{ generateSlug($activity['name']) }}-checkbox"
                                                    {{ in_array($value['id'], getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) ? 'checked' : '' }}
                                                    >{{ $value['activity'] . '-'. optional($value['country'])['name']}}<span
                                                    class="checkmark"></span>
                                            </label>
                                        </li>
                                    @endforeach
                                    <li class="checklist-title">District Cooling</li>
                                    @foreach (getElectrticityData('3') as $value)
                                        <li>
                                            <label class="checkbox"
                                                for="{{ generateSlug($activity['name']) . $value['id'] }}">
                                                <input type="checkbox"
                                                    name="{{ generateSlug($activity['name']) }}[]"
                                                    value="{{ $value['id'] }}"
                                                    id="{{ generateSlug($activity['name']) . $value['id'] }}"
                                                    class="{{ generateSlug($activity['name']) }}-checkbox"
                                                    {{ in_array($value['id'], getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) ? 'checked' : '' }}
                                                    >{{ $value['activity'] . '-'. optional($value['country'])['name']}}<span
                                                    class="checkmark"></span>
                                            </label>
                                        </li>
                                    @endforeach
                                    <input type="hidden"
                                        value="{{ count(getSelectedActivity(generateSlug($activity['name']), $activity['company_id'])) }}"
                                        id="{{ generateSlug($activity['name']) . '-checkbox-' }}-count"
                                        class ="activities-data"
                                        data-checkbox="{{ generateSlug($activity['name']) . '-checkbox' }}"
                                        data-allcheck="select-all-{{ generateSlug($activity['name']) }}">
                                @endif
                            </ul>
                        </div>
                    </div>
                @elseif (generateSlug($activity['name']) == \App\Models\Activity::FREIGHTING_GOODS)
                    <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                        id="{{ generateSlug($activity['name']) }}" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        <div class="checkbox-main custome-scrollbar-m">
                            <div class="checkbox-group-box">
                                <ul class="custome-checkbox custom-group-list">
                                    @if (count(getFreightingGgoods('vans')) > 0)
                                        <li class="checklist-title">Freighting Goods: Vans and HGV</li>
                                        <li class="all-select">
                                            <label class="checkbox" for="select-all-freighting-goods-vansHgv">
                                                <input type="checkbox" name="remember" name="all" value="all"
                                                    checked id="select-all-freighting-goods-vansHgv">All<span
                                                    class="checkmark"></span>
                                            </label>
                                        </li>
                                        @foreach (getFreightingGgoods('vans') as $value)
                                            <li>
                                                {{-- <label class="checkbox"
                                                    for="freighting_goods_vansHgv{{ $value['id'] }}">
                                                    <input type="checkbox" name="freighting_goods_vansHgv[]"
                                                        value="{{ $value['id'] }}"
                                                        id="freighting_goods_vansHgv{{ $value['id'] }}"
                                                        class="freighting-goods-vansHgv-checkbox"
                                                        {{ in_array($value['id'], getSelectedFreightingGgoods('vans', $activity['company_id'])) ? 'checked' : '' }}
                                                        >{{ $value['type'] . ' - ' . $value['fuel'] }}<span
                                                        class="checkmark"></span>
                                                </label> --}}
                                                <label class="checkbox" for="{{ 'vans_' . $value['id'] }}">
                                                    <input type="checkbox" name="freighting_goods_vansHgv[]"
                                                        value="{{ $value['id'] }}" id="{{ 'vans_' . $value['id'] }}"
                                                        class="freighting-goods-vansHgv-checkbox"
                                                        {{ in_array($value['id'], getSelectedActivity(\App\Models\Activity::FREIGHTING_GOODS_VansHgv, $activity['company_id'])) ? 'checked' : '' }}>{{ $value['type'] . '-' . $value['fuel'] }}<span
                                                        class="checkmark"></span>
                                                </label>
                                            </li>
                                        @endforeach
                                        <input type="hidden"
                                            value="{{ count(getSelectedFreightingGgoods('vans', $activity['company_id'])) }}"
                                            id="freightinggoodsvansHgvcheckcount" class ="activities-data"
                                            data-checkbox="freighting-goods-vansHgv-checkbox"
                                            data-allcheck="select-all-freighting-goods-vansHgv">
                                    @endif
                                </ul>
                                <ul class="custome-checkbox custom-group-list">
                                    {{-- @if (count(getFreightingGgoods()) > 0) --}}
                                        <li class="checklist-title">Freighting Goods: Flights And Rail</li>
                                        <li class="all-select">
                                            <label class="checkbox" for="select-all-freighting-goods-flights-rail">
                                                <input type="checkbox" name="remember" name="all" value="all"
                                                    checked id="select-all-freighting-goods-flights-rail">All<span
                                                    class="checkmark"></span>
                                            </label>
                                        </li>
                                        @foreach (getFreightingGgoods('xdg') as $value)
                                            <li>
                                                <label class="checkbox" for="{{ 'xdg_' . $value['id'] }}">
                                                    <input type="checkbox" name="freighting_goods_flights_rail[]"
                                                        value="{{ $value['id'] }}" id="{{ 'xdg_' . $value['id'] }}"
                                                        class="freighting-goods-flights-rail-checkbox"
                                                        {{ in_array($value['id'], getSelectedActivity(\App\Models\Activity::FREIGHTING_GOODS_VansHgv, $activity['company_id'])) ? 'checked' : '' }}>{{ $value['type'] }}<span
                                                        class="checkmark"></span>
                                                </label>
                                            </li>
                                        @endforeach
                                        {{-- @foreach (getFreightingGgoods() as $value)
                                            <li>
                                                <label class="checkbox"
                                                    for="freighting_goods_flights_rail{{ $value['id'] }}">
                                                    <input type="checkbox" name="freighting_goods_flights_rail[]"
                                                        value="{{ $value['id'] }}"
                                                        id="freighting_goods_flights_rail{{ $value['id'] }}"
                                                        class="freighting-goods-flights-rail-checkbox"
                                                        {{ in_array($value['id'], getSelectedFreightingGgoods('',$activity['company_id'])) ? 'checked' : '' }}
                                                        >{{ $value['type'] }}<span
                                                        class="checkmark"></span>
                                                </label>
                                            </li>
                                        @endforeach --}}
                                        <input type="hidden"
                                            value="{{ count(getSelectedFreightingGgoods('', $activity['company_id'])) }}"
                                            id="freightinggoodsflightsrailcheckcount" class ="activities-data"
                                            data-checkbox="freighting-goods-flights-rail-checkbox"
                                            data-allcheck="select-all-freighting-goods-flights-rail">
                                    {{-- @endif --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                    @elseif (generateSlug($activity['name']) == \App\Models\Activity::FLIGHT_AND_ACCOMMODATION)
                    <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                        id="{{ generateSlug($activity['name']) }}" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        <div class="checkbox-main custome-scrollbar-m">
                            <div class="checkbox-group-box">
                                <ul class="custome-checkbox custom-group-list">
                                    <li></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @elseif (generateSlug($activity['name']) == \App\Models\Activity::HOME_OFFICE   )
                    <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                        id="{{ generateSlug($activity['name']) }}" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        <div class="checkbox-main custome-scrollbar-m">
                            <div class="checkbox-group-box">
                                <ul class="custome-checkbox custom-group-list">
                                    <li></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>
<script type="text/javascript">
    (function($) {
        $("#pills-tab li:first").find("button").addClass('active');
        $(".nav.nav-pills").on('scroll', function() {
            $val = $(this).scrollLeft();

            if ($(this).scrollLeft() + $(this).innerWidth() >= $(this)[0].scrollWidth) {
                $(".nav-next").addClass("disabled");
            } else {
                $(".nav-next").removeClass("disabled");
            }

            if ($val == 0) {
                $(".nav-prev").addClass("disabled");
            } else {
                $(".nav-prev").removeClass("disabled");
            }
        });
        // console.log('init-scroll: ' + $(".nav-next").scrollLeft());
        $(".nav-next").on("click", function() {
            $(".nav.nav-pills").animate({
                scrollLeft: '+=200'
            }, 200);

        });
        $(".nav-prev").on("click", function() {
            $(".nav.nav-pills").animate({
                scrollLeft: '-=200'
            }, 200);
        });
    })(jQuery);
    // $(document).ready(function() {
    //     function handleCheckboxChange(checkboxClass, selectAllCheckboxId, checkCount) {
    //         var checkboxes = $('.' + checkboxClass);
    //         var selectAllCheckbox = $('#' + selectAllCheckboxId);
    //         checkboxes.change(function() {
    //             var totalCheckboxes = checkboxes.length;
    //             selectAllCheckbox.prop('checked', totalCheckboxes === checkedCheckboxes);
    //         });

    //         selectAllCheckbox.change(function() {
    //             var isChecked = $(this).prop('checked');
    //             checkboxes.prop('checked', isChecked);
    //         });

    //         if (checkCount == 0) {
    //             //checkboxes.prop('checked', true);
    //             selectAllCheckbox.prop('checked', checkboxes.length === checkboxes.filter(':checked').length);
    //             return false;
    //         } else {
    //             selectAllCheckbox.prop('checked', checkboxes.length === checkboxes.filter(':checked').length);
    //         }
    //     }
    //     $(".activities-data").each(function() {
    //         var allcheck = $(this).data('allcheck');
    //         var checkbox = $(this).data('checkbox');
    //         handleCheckboxChange(checkbox, allcheck, $(this).val());
    //     });
    // });
    $(document).ready(function() {
    $("#pills-tab li:first").find("button").addClass('active');
    function handleCheckboxChange(checkboxClass, selectAllCheckboxId, checkCount) {
        var checkboxes = $('.' + checkboxClass);
        var selectAllCheckbox = $('#' + selectAllCheckboxId);
        
        checkboxes.change(function() {
            var totalCheckboxes = checkboxes.length;
            var checkedCheckboxes = checkboxes.filter(':checked').length; // Added this line
            selectAllCheckbox.prop('checked', totalCheckboxes === checkedCheckboxes);
        });

        selectAllCheckbox.change(function() {
            var isChecked = $(this).prop('checked');
            checkboxes.prop('checked', isChecked);
        });

        if (checkCount == 0) {
            //checkboxes.prop('checked', true);
            selectAllCheckbox.prop('checked', checkboxes.length === checkboxes.filter(':checked').length);
            return false;
        } else {
            selectAllCheckbox.prop('checked', checkboxes.length === checkboxes.filter(':checked').length);
        }
    }
    
    $(".activities-data").each(function() {
        var allcheck = $(this).data('allcheck');
        var checkbox = $(this).data('checkbox');
        handleCheckboxChange(checkbox, allcheck, $(this).val());
    });
});
   
</script>
