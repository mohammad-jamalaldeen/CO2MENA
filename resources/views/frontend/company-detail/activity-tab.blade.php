<div class="details-tabs emission-management">
    <div class="tab-list">
        
        @if ($companyActivities = optional($companyData)->companyactivities)
            <div class="nav-prev arrow disabled">
                <picture>
                    <img src="{{ asset('assets/images/prev-arrow.svg') }}" alt="back-arrow" width="169" height="40" />
                </picture>
            </div>
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                @foreach ($companyActivities as $index => $activity)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{$index === 0 ? 'active' : '' }}"
                                id="{{ 'pills-home-tab-' . generateSlug($activity['activity']['name']) }}"
                                data-bs-toggle="pill"
                                data-bs-target="#{{ generateSlug($activity['activity']['name']) }}" type="button"
                                role="tab" aria-controls="pills-home"
                                aria-selected="{{ $index === 0 ? 'true' : 'false' }}" title="{{ generateSlug($activity['activity']['name']) }}">
                                {{ $activity['activity']['name'] }}
                            </button>
                        </li>
                    
                @endforeach
            </ul>
            <div class="nav-next arrow">
                <picture>
                    <img src="{{ asset('assets/images/next-arrow.svg') }}" alt="back-arrow" width="169"
                        height="40" />
                </picture>
            </div>
        @else
            <div class="nav-item no-record-emission" >No Record Found.</div>
        @endif
    </div>
    @if ($errors->all())
        @php
            $arrayerr = array_unique($errors->all());
        @endphp
        <span class="error-mgs mb-3">Please select at least one emission for these activities:
            {{ implode(', ', $arrayerr) }}</span>
    @endif
    <div class="tab-content" id="pills-tabContent">

        @if ($companyActivities = optional($companyData)->companyactivities)
            @foreach ($companyActivities as $index => $activity)
                @if (isset($activity['activity']['name']))
                    @if (generateSlug($activity['activity']['name']) == \App\Models\Activity::REFRIGERANTS)
                        <div class="tab-pane fade show  {{ $index === 0 ? 'active' : '' }}"
                            id="{{ generateSlug($activity['activity']['name']) }}" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="checkbox-main custome-scrollbar-m">
                                <ul class="custome-checkbox ">
                                    <li class="all-select">
                                        <label class="checkbox" for="select-all-{{ generateSlug($activity['activity']['name']) }}">
                                            <input type="checkbox" name="remember" name="all" value="all" checked
                                                id="select-all-{{ generateSlug($activity['activity']['name']) }}">All<span
                                                class="checkmark"></span>
                                        </label>
                                    </li>
                                    @if (count(getActivity(generateSlug($activity['activity']['name']))) > 0)
                                        @foreach (getActivity(generateSlug($activity['activity']['name'])) as $value)
                                            <li>
                                                <label class="checkbox"
                                                    for="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}">
                                                    <input type="checkbox"
                                                        name="{{ generateSlug($activity['activity']['name']) }}[]"
                                                        value="{{ $value['id'] }}"
                                                        id="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}"
                                                        class="{{ generateSlug($activity['activity']['name']) }}-checkbox"
                                                        {{ old(generateSlug($activity['activity']['name'])) ? (in_array($value['id'], old(generateSlug($activity['activity']['name']))) ? 'checked' : '') : (in_array($value['id'], getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) ? 'checked' : '') }}>{{ $value['emission'] }}<span
                                                        class="checkmark"></span>
                                                </label>
                                            </li>
                                        @endforeach
                                        <input type="hidden"
                                            value="{{ count(getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) }}"
                                            id="{{ generateSlug($activity['activity']['name']) . '-checkbox-' }}-count"
                                            class ="activities-data"
                                            data-checkbox="{{ generateSlug($activity['activity']['name']) . '-checkbox' }}"
                                            data-allcheck="select-all-{{ generateSlug($activity['activity']['name']) }}">
                                    @else
                                        <li>
                                            <label class="checkbox">Coming Soon</label>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @elseif (generateSlug($activity['activity']['name']) == \App\Models\Activity::FUELS)
                        <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                            id="{{ generateSlug($activity['activity']['name']) }}" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="checkbox-main custome-scrollbar-m">
                                <ul class="custome-checkbox ">
                                    <li class="all-select">
                                        <label class="checkbox" for="select-all-{{ generateSlug($activity['activity']['name']) }}">
                                            <input type="checkbox" name="remember" name="all" value="all" checked
                                                id="select-all-{{ generateSlug($activity['activity']['name']) }}">All<span
                                                class="checkmark"></span>
                                        </label>
                                    </li>
                                    @if (count(getActivity(generateSlug($activity['activity']['name']))) > 0)
                                        @foreach (getActivity(generateSlug($activity['activity']['name'])) as $value)
                                            <li>
                                                <label class="checkbox"
                                                    for="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}">
                                                    <input type="checkbox"
                                                        name="{{ generateSlug($activity['activity']['name']) }}[]"
                                                        value="{{ $value['id'] }}"
                                                        id="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}"
                                                        class="{{ generateSlug($activity['activity']['name']) . '-checkbox' }}"
                                                        {{ old(generateSlug($activity['activity']['name'])) ? (in_array($value['id'], old(generateSlug($activity['activity']['name']))) ? 'checked' : '') : (in_array($value['id'], getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) ? 'checked' : '') }}>{{ $value['fuel'] }}<span
                                                        class="checkmark"></span>
                                                </label>
                                            </li>
                                        @endforeach
                                        <input type="hidden"
                                            value="{{ count(getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) }}"
                                            id="{{ generateSlug($activity['activity']['name']) . '-checkbox-' }}-count"
                                            class ="activities-data"
                                            data-checkbox="{{ generateSlug($activity['activity']['name']) . '-checkbox' }}"
                                            data-allcheck="select-all-{{ generateSlug($activity['activity']['name']) }}">
                                    @else
                                        <li>
                                            <label class="checkbox">Coming Soon</label>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @elseif (generateSlug($activity['activity']['name']) == \App\Models\Activity::WTT_FULES)
                        <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                            id="{{ generateSlug($activity['activity']['name']) }}" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="checkbox-main custome-scrollbar-m">
                                <ul class="custome-checkbox ">
                                    <li class="all-select">
                                        <label class="checkbox" for="select-all-{{ generateSlug($activity['activity']['name']) }}">
                                            <input type="checkbox" name="remember" name="all" checked value="all"
                                                id="select-all-{{ generateSlug($activity['activity']['name']) }}">All<span
                                                class="checkmark"></span>
                                        </label>
                                    </li>
                                    @if (count(getActivity(generateSlug($activity['activity']['name']))) > 0)
                                        @foreach (getActivity(generateSlug($activity['activity']['name'])) as $value)
                                            <li>
                                                <label class="checkbox"
                                                    for="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}">
                                                    <input type="checkbox"
                                                        name="{{ generateSlug($activity['activity']['name']) }}[]"
                                                        value="{{ $value['id'] }}"
                                                        id="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}"
                                                        class="{{ generateSlug($activity['activity']['name']) }}-checkbox"
                                                        {{ old(generateSlug($activity['activity']['name'])) ? (in_array($value['id'], old(generateSlug($activity['activity']['name']))) ? 'checked' : '') : (in_array($value['id'], getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) ? 'checked' : '') }}>{{ $value['fuel'] }}<span
                                                        class="checkmark"></span>
                                                </label>
                                            </li>
                                        @endforeach
                                        <input type="hidden"
                                            value="{{ count(getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) }}"
                                            id="{{ generateSlug($activity['activity']['name']) . '-checkbox-' }}-count"
                                            class ="activities-data"
                                            data-checkbox="{{ generateSlug($activity['activity']['name']) . '-checkbox' }}"
                                            data-allcheck="select-all-{{ generateSlug($activity['activity']['name']) }}">
                                    @else
                                        <li>
                                            <label class="checkbox">Coming Soon</label>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @elseif (generateSlug($activity['activity']['name']) == \App\Models\Activity::FOOD)
                        <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                            id="{{ generateSlug($activity['activity']['name']) }}" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="checkbox-main custome-scrollbar-m">
                                <ul class="custome-checkbox ">
                                    <li class="all-select">
                                        <label class="checkbox" for="select-all-{{ generateSlug($activity['activity']['name']) }}">
                                            <input type="checkbox" name="remember" name="all" checked
                                                value="all"
                                                id="select-all-{{ generateSlug($activity['activity']['name']) }}">All<span
                                                class="checkmark"></span>
                                        </label>
                                    </li>

                                    @if (count(getActivity(generateSlug($activity['activity']['name']))) > 0)
                                        @foreach (getActivity(generateSlug($activity['activity']['name'])) as $value)
                                            <li>
                                                <label class="checkbox"
                                                    for="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}">
                                                    <input type="checkbox"
                                                        name="{{ generateSlug($activity['activity']['name']) }}[]"
                                                        value="{{ $value['id'] }}"
                                                        id="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}"
                                                        class="{{ generateSlug($activity['activity']['name']) }}-checkbox"
                                                        {{ old(generateSlug($activity['activity']['name'])) ? (in_array($value['id'], old(generateSlug($activity['activity']['name']))) ? 'checked' : '') : (in_array($value['id'], getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) ? 'checked' : '') }}>{{ $value['vehicle'] }}<span
                                                        class="checkmark"></span>
                                                </label>
                                            </li>
                                        @endforeach
                                        <input type="hidden"
                                            value="{{ count(getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) }}"
                                            id="{{ generateSlug($activity['activity']['name']) . '-checkbox-' }}-count"
                                            class ="activities-data"
                                            data-checkbox="{{ generateSlug($activity['activity']['name']) . '-checkbox' }}"
                                            data-allcheck="select-all-{{ generateSlug($activity['activity']['name']) }}">
                                    @else
                                        <li>
                                            <label class="checkbox">Coming Soon</label>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @elseif (generateSlug($activity['activity']['name']) == \App\Models\Activity::BUSSINESSTRAVEL)
                        <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                            id="{{ generateSlug($activity['activity']['name']) }}" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="checkbox-main custome-scrollbar-m">
                                <ul class="custome-checkbox ">
                                    <li class="all-select">
                                        <label class="checkbox" for="select-all-{{ generateSlug($activity['activity']['name']) }}">
                                            <input type="checkbox" name="remember" name="all" checked
                                                value="all"
                                                id="select-all-{{ generateSlug($activity['activity']['name']) }}">All<span
                                                class="checkmark"></span>
                                        </label>
                                    </li>
                                    @if (count(getActivity(generateSlug($activity['activity']['name']))) > 0)
                                        @foreach (getActivity(generateSlug($activity['activity']['name'])) as $value)
                                            <li>
                                                <label class="checkbox"
                                                    for="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}">
                                                    <input type="checkbox"
                                                        name="{{ generateSlug($activity['activity']['name']) }}[]"
                                                        value="{{ $value['id'] }}"
                                                        id="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}"
                                                        class="{{ generateSlug($activity['activity']['name']) }}-checkbox"
                                                        {{ old(generateSlug($activity['activity']['name'])) ? (in_array($value['id'], old(generateSlug($activity['activity']['name']))) ? 'checked' : '') : (in_array($value['id'], getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) ? 'checked' : '') }}>{{ $value['vehicles'] . '-' . $value['type'] . '-' . $value['fuel'] }}<span
                                                        class="checkmark"></span>
                                                </label>
                                            </li>
                                        @endforeach
                                        <input type="hidden"
                                            value="{{ count(getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) }}"
                                            id="{{ generateSlug($activity['activity']['name']) . '-checkbox-' }}-count"
                                            class ="activities-data"
                                            data-checkbox="{{ generateSlug($activity['activity']['name']) . '-checkbox' }}"
                                            data-allcheck="select-all-{{ generateSlug($activity['activity']['name']) }}">
                                    @else
                                        <li>
                                            <label class="checkbox">Coming Soon</label>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @elseif (generateSlug($activity['activity']['name']) == \App\Models\Activity::EMPLOYEECOMMUNTING)
                        <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                            id="{{ generateSlug($activity['activity']['name']) }}" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="checkbox-main custome-scrollbar-m">
                                <ul class="custome-checkbox ">
                                    <li class="all-select">
                                        <label class="checkbox" for="select-all-{{ generateSlug($activity['activity']['name']) }}">
                                            <input type="checkbox" name="remember" name="all" checked
                                                value="all"
                                                id="select-all-{{ generateSlug($activity['activity']['name']) }}">All<span
                                                class="checkmark"></span>
                                        </label>
                                    </li>

                                    @if (count(getActivity(generateSlug($activity['activity']['name']))) > 0)
                                        @foreach (getActivity(generateSlug($activity['activity']['name'])) as $value)
                                            <li>
                                                <label class="checkbox"
                                                    for="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}">
                                                    <input type="checkbox"
                                                        name="{{ generateSlug($activity['activity']['name']) }}[]"
                                                        value="{{ $value['id'] }}"
                                                        id="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}"
                                                        class="{{ generateSlug($activity['activity']['name']) }}-checkbox"
                                                        {{ old(generateSlug($activity['activity']['name'])) ? (in_array($value['id'], old(generateSlug($activity['activity']['name']))) ? 'checked' : '') : (in_array($value['id'], getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) ? 'checked' : '') }}>{{ $value['vehicle'] . '-' . $value['type'] . '-' . $value['fuel'] }}<span
                                                        class="checkmark"></span>
                                                </label>
                                            </li>
                                        @endforeach
                                        <input type="hidden"
                                            value="{{ count(getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) }}"
                                            id="{{ generateSlug($activity['activity']['name']) . '-checkbox-' }}-count"
                                            class ="activities-data"
                                            data-checkbox="{{ generateSlug($activity['activity']['name']) . '-checkbox' }}"
                                            data-allcheck="select-all-{{ generateSlug($activity['activity']['name']) }}">
                                    @else
                                        <li>
                                            <label class="checkbox">Coming Soon</label>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @elseif (generateSlug($activity['activity']['name']) == \App\Models\Activity::WASTEDISPOSAL)
                        <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                            id="{{ generateSlug($activity['activity']['name']) }}" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="checkbox-main custome-scrollbar-m">
                                <ul class="custome-checkbox ">
                                    <li class="all-select">
                                        <label class="checkbox" for="select-all-{{ generateSlug($activity['activity']['name']) }}">
                                            <input type="checkbox" name="remember" name="all" checked
                                                value="all"
                                                id="select-all-{{ generateSlug($activity['activity']['name']) }}">All<span
                                                class="checkmark"></span>
                                        </label>
                                    </li>

                                    @if (count(getActivity(generateSlug($activity['activity']['name']))) > 0)
                                        @foreach (getActivity(generateSlug($activity['activity']['name'])) as $value)
                                            <li>
                                                <label class="checkbox"
                                                    for="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}">
                                                    <input type="checkbox"
                                                        name="{{ generateSlug($activity['activity']['name']) }}[]"
                                                        value="{{ $value['id'] }}"
                                                        id="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}"
                                                        class="{{ generateSlug($activity['activity']['name']) }}-checkbox"
                                                        {{ old(generateSlug($activity['activity']['name'])) ? (in_array($value['id'], old(generateSlug($activity['activity']['name']))) ? 'checked' : '') : (in_array($value['id'], getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) ? 'checked' : '') }}>{{ $value['waste_type'] }}<span
                                                        class="checkmark"></span>
                                                </label>
                                            </li>
                                        @endforeach
                                        <input type="hidden"
                                            value="{{ count(getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) }}"
                                            id="{{ generateSlug($activity['activity']['name']) . '-checkbox-' }}-count"
                                            class ="activities-data"
                                            data-checkbox="{{ generateSlug($activity['activity']['name']) . '-checkbox' }}"
                                            data-allcheck="select-all-{{ generateSlug($activity['activity']['name']) }}">
                                    @else
                                        <li>
                                            <label class="checkbox">Coming Soon</label>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @elseif (generateSlug($activity['activity']['name']) == \App\Models\Activity::T_D)
                        <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                            id="{{ generateSlug($activity['activity']['name']) }}" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="checkbox-main custome-scrollbar-m">
                                <ul class="custome-checkbox ">
                                    <li class="all-select">
                                        <label class="checkbox" for="select-all-{{ generateSlug($activity['activity']['name']) }}">
                                            <input type="checkbox" name="remember" name="all" checked
                                                value="all"
                                                id="select-all-{{ generateSlug($activity['activity']['name']) }}">All<span
                                                class="checkmark"></span>
                                        </label>
                                    </li>

                                    @if (count(getActivity(generateSlug($activity['activity']['name']))) > 0)
                                        @foreach (getActivity(generateSlug($activity['activity']['name'])) as $value)
                                            <li>
                                                <label class="checkbox"
                                                    for="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}">
                                                    <input type="checkbox"
                                                        name="{{ generateSlug($activity['activity']['name']) }}[]"
                                                        value="{{ $value['id'] }}"
                                                        id="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}"
                                                        class="{{ generateSlug($activity['activity']['name']) }}-checkbox"
                                                        {{ old(generateSlug($activity['activity']['name'])) ? (in_array($value['id'], old(generateSlug($activity['activity']['name']))) ? 'checked' : '') : (in_array($value['id'], getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) ? 'checked' : '') }}>
                                                    {{ $value['activity'] }}<span class="checkmark"></span>
                                                </label>
                                            </li>
                                        @endforeach
                                        <input type="hidden"
                                            value="{{ count(getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) }}"
                                            id="{{ generateSlug($activity['activity']['name']) . '-checkbox-' }}-count"
                                            class ="activities-data"
                                            data-checkbox="{{ generateSlug($activity['activity']['name']) . '-checkbox' }}"
                                            data-allcheck="select-all-{{ generateSlug($activity['activity']['name']) }}">
                                    @else
                                        <li>
                                            <label class="checkbox">Coming Soon</label>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @elseif (generateSlug($activity['activity']['name']) == \App\Models\Activity::WATER)
                        <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                            id="{{ generateSlug($activity['activity']['name']) }}" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="checkbox-main custome-scrollbar-m">
                                <ul class="custome-checkbox ">
                                    <li class="all-select">
                                        <label class="checkbox" for="select-all-{{ generateSlug($activity['activity']['name']) }}">
                                            <input type="checkbox" name="remember" name="all" checked
                                                value="all"
                                                id="select-all-{{ generateSlug($activity['activity']['name']) }}">All<span
                                                class="checkmark"></span>
                                        </label>
                                    </li>

                                    @if (count(getActivity(generateSlug($activity['activity']['name']))) > 0)
                                        @foreach (getActivity(generateSlug($activity['activity']['name'])) as $value)
                                            <li>
                                                <label class="checkbox"
                                                    for="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}">
                                                    <input type="checkbox"
                                                        name="{{ generateSlug($activity['activity']['name']) }}[]"
                                                        value="{{ $value['id'] }}"
                                                        id="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}"
                                                        class="{{ generateSlug($activity['activity']['name']) }}-checkbox"
                                                        {{ old(generateSlug($activity['activity']['name'])) ? (in_array($value['id'], old(generateSlug($activity['activity']['name']))) ? 'checked' : '') : (in_array($value['id'], getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) ? 'checked' : '') }}>{{ $value['type'] }}<span
                                                        class="checkmark"></span>
                                                </label>
                                            </li>
                                        @endforeach
                                        <input type="hidden"
                                            value="{{ count(getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) }}"
                                            id="{{ generateSlug($activity['activity']['name']) . '-checkbox-' }}-count"
                                            class ="activities-data"
                                            data-checkbox="{{ generateSlug($activity['activity']['name']) . '-checkbox' }}"
                                            data-allcheck="select-all-{{ generateSlug($activity['activity']['name']) }}">
                                    @else
                                        <li>
                                            <label class="checkbox">Coming Soon</label>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @elseif (generateSlug($activity['activity']['name']) == \App\Models\Activity::MATERIAL_USE)
                        <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                            id="{{ generateSlug($activity['activity']['name']) }}" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="checkbox-main custome-scrollbar-m">
                                <ul class="custome-checkbox ">
                                    <li class="all-select">
                                        <label class="checkbox" for="select-all-{{ generateSlug($activity['activity']['name']) }}">
                                            <input type="checkbox" name="remember" name="all" checked
                                                value="all"
                                                id="select-all-{{ generateSlug($activity['activity']['name']) }}">All<span
                                                class="checkmark"></span>
                                        </label>
                                    </li>

                                    @if (count(getActivity(generateSlug($activity['activity']['name']))) > 0)
                                        @foreach (getActivity(generateSlug($activity['activity']['name'])) as $value)
                                            <li>
                                                <label class="checkbox"
                                                    for="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}">
                                                    <input type="checkbox"
                                                        name="{{ generateSlug($activity['activity']['name']) }}[]"
                                                        value="{{ $value['id'] }}"
                                                        id="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}"
                                                        class="{{ generateSlug($activity['activity']['name']) }}-checkbox"
                                                        {{ old(generateSlug($activity['activity']['name'])) ? (in_array($value['id'], old(generateSlug($activity['activity']['name']))) ? 'checked' : '') : (in_array($value['id'], getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) ? 'checked' : '') }}>{{ $value['waste_type'] }}<span
                                                        class="checkmark"></span>
                                                </label>
                                            </li>
                                        @endforeach
                                        <input type="hidden"
                                            value="{{ count(getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) }}"
                                            id="{{ generateSlug($activity['activity']['name']) . '-checkbox-' }}-count"
                                            class ="activities-data"
                                            data-checkbox="{{ generateSlug($activity['activity']['name']) . '-checkbox' }}"
                                            data-allcheck="select-all-{{ generateSlug($activity['activity']['name']) }}">
                                    @else
                                        <li>
                                            <label class="checkbox">Coming Soon</label>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @elseif (generateSlug($activity['activity']['name']) == \App\Models\Activity::OWNED_VEHICLES)
                        <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                            id="{{ generateSlug($activity['activity']['name']) }}" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="checkbox-main custome-scrollbar-m">
                                <div class="checkbox-group-box">
                                    <ul class="custome-checkbox custom-group-list">
                                        <li class="checklist-title">Passenger Vehicles </li>
                                        <li class="all-select">
                                            <label class="checkbox" for="select-all-{{ generateSlug($activity['activity']['name']) . '-passenger' }}">
                                                <input type="checkbox" name="remember" name="all" checked
                                                    value="all"
                                                    id="select-all-{{ generateSlug($activity['activity']['name']) . '-passenger' }}">All<span
                                                    class="checkmark"></span>
                                            </label>
                                        </li>
                                        @if (count(getActivity(generateSlug($activity['activity']['name']))) > 0)
                                            @foreach (getVehicleData('1') as $value)
                                                <li>
                                                    <label class="checkbox"
                                                        for="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}">
                                                        <input type="checkbox"
                                                            name="{{ generateSlug($activity['activity']['name']) . '_passenger' }}[]"
                                                            value="{{ $value['id'] }}"
                                                            id="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}"
                                                            class="{{ generateSlug($activity['activity']['name']) . '-passenger' }}-checkbox"
                                                            {{ old(generateSlug($activity['activity']['name']) . '_passenger', in_array($value['id'], getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id))) ? 'checked' : '' }}>{{ $value['vehicle'] . '-' . $value['type'] . '-' . $value['fuel'] }}<span
                                                            class="checkmark"></span>
                                                    </label>
                                                </li>
                                            @endforeach
                                            <input type="hidden"
                                                value="{{ count(getSelectedOwnedVehicle('1', $companyData->id)) }}"
                                                id="{{ generateSlug($activity['activity']['name']) . '-checkbox-' }}passenger-count"
                                                class ="activities-data"
                                                data-checkbox="{{ generateSlug($activity['activity']['name']) . '-passenger' }}-checkbox"
                                                data-allcheck="select-all-{{ generateSlug($activity['activity']['name']) . '-passenger' }}">
                                        @endif
                                    </ul>
                                    <ul class="custome-checkbox custom-group-list">
                                            <li class="checklist-title">Delivery Vehicles</li>
                                            <li class="all-select">
                                                <label class="checkbox" for="select-all-{{ generateSlug($activity['activity']['name']) . '-delivery' }}">
                                                    <input type="checkbox" name="remember" name="all" checked
                                                        value="all"
                                                        id="select-all-{{ generateSlug($activity['activity']['name']) . '-delivery' }}">All<span
                                                        class="checkmark"></span>
                                                </label>
                                            </li>
                                        @if (count(getActivity(generateSlug($activity['activity']['name']))) > 0)
                                            @foreach (getVehicleData('2') as $value)
                                                <li>
                                                    <label class="checkbox"
                                                        for="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}">
                                                        <input type="checkbox"
                                                            name="{{ generateSlug($activity['activity']['name']) . '_delivery' }}[]"
                                                            value="{{ $value['id'] }}"
                                                            id="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}"
                                                            class="{{ generateSlug($activity['activity']['name']) . '-delivery' }}-checkbox"
                                                            {{ old(generateSlug($activity['activity']['name']) . '_delivery') && in_array($value['id'], old(generateSlug($activity['activity']['name']) . '_delivery')) ? 'checked' : (in_array($value['id'], getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) ? 'checked' : '') }}>{{ $value['vehicle'] . '-' . $value['type'] . '-' . $value['fuel'] }}<span
                                                            class="checkmark"></span>
                                                    </label>
                                                </li>
                                            @endforeach
                                            <input type="hidden"
                                                value="{{ count(getSelectedOwnedVehicle('2', $companyData->id)) }}"
                                                id="{{ generateSlug($activity['activity']['name']) . '-checkbox-' }}-count"
                                                class ="activities-data"
                                                data-checkbox="{{ generateSlug($activity['activity']['name']) . '-delivery' . '-checkbox' }}"
                                                data-allcheck="select-all-{{ generateSlug($activity['activity']['name']) . '-delivery' }}">
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @elseif (generateSlug($activity['activity']['name']) == \App\Models\Activity::ELECTRICITY_HEAT_COOLING)
                        <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                            id="{{ generateSlug($activity['activity']['name']) }}" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="checkbox-main custome-scrollbar-m">
                                <ul class="custome-checkbox">
                                    <li class="all-select">
                                        <label class="checkbox" for="select-all-{{ generateSlug($activity['activity']['name']) }}">
                                            <input type="checkbox" name="remember" name="all" checked
                                                value="all"
                                                id="select-all-{{ generateSlug($activity['activity']['name']) }}">All<span
                                                class="checkmark"></span>
                                        </label>
                                    </li>

                                    @if (count(getActivity(generateSlug($activity['activity']['name']))) > 0)
                                        <li class="checklist-title checklist-title">Electricity Grid</li>
                                        @foreach (getElectrticityData('1') as $value)
                                            <li>
                                                <label class="checkbox"
                                                    for="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}">
                                                    <input type="checkbox"
                                                        name="{{ generateSlug($activity['activity']['name']) }}[]"
                                                        value="{{ $value['id'] }}"
                                                        id="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}"
                                                        class="{{ generateSlug($activity['activity']['name']) }}-checkbox"
                                                        {{ old(generateSlug($activity['activity']['name'])) ? (in_array($value['id'], old(generateSlug($activity['activity']['name']))) ? 'checked' : '') : (in_array($value['id'], getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) ? 'checked' : '') }}>{{ $value['activity'] . '-' . isset($value['country']['name']) ? $value['country']['name'] : '' }}<span
                                                        class="checkmark"></span>
                                                </label>
                                            </li>
                                        @endforeach
                                        <li class="checklist-title checklist-title">Heat And Steam</li>
                                        @foreach (getElectrticityData('2') as $value)
                                            <li>
                                                <label class="checkbox"
                                                    for="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}">
                                                    <input type="checkbox"
                                                        name="{{ generateSlug($activity['activity']['name']) }}[]"
                                                        value="{{ $value['id'] }}"
                                                        id="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}"
                                                        class="{{ generateSlug($activity['activity']['name']) }}-checkbox"
                                                        {{ old(generateSlug($activity['activity']['name'])) ? (in_array($value['id'], old(generateSlug($activity['activity']['name']))) ? 'checked' : '') : (in_array($value['id'], getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) ? 'checked' : '') }}>{{ $value['activity'] . '-' . $value['type'] }}<span
                                                        class="checkmark"></span>
                                                </label>
                                            </li>
                                        @endforeach
                                        <li class="checklist-title">District Cooling</li>
                                        @foreach (getElectrticityData('3') as $value)
                                            <li>
                                                <label class="checkbox"
                                                    for="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}">
                                                    <input type="checkbox"
                                                        name="{{ generateSlug($activity['activity']['name']) }}[]"
                                                        value="{{ $value['id'] }}"
                                                        id="{{ generateSlug($activity['activity']['name']) . '_' . $value['id'] }}"
                                                        class="{{ generateSlug($activity['activity']['name']) }}-checkbox"
                                                        {{ old(generateSlug($activity['activity']['name'])) ? (in_array($value['id'], old(generateSlug($activity['activity']['name']))) ? 'checked' : '') : (in_array($value['id'], getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) ? 'checked' : '') }}>{{ $value['activity'] . '-' . isset($value['country']['name']) ? $value['country']['name'] : '' }}<span
                                                        class="checkmark"></span>
                                                </label>
                                            </li>
                                        @endforeach
                                        <input type="hidden"
                                            value="{{ count(getSelectedActivity(generateSlug($activity['activity']['name']), $companyData->id)) }}"
                                            id="{{ generateSlug($activity['activity']['name']) . '-checkbox-' }}-count"
                                            class ="activities-data"
                                            data-checkbox="{{ generateSlug($activity['activity']['name']) . '-checkbox' }}"
                                            data-allcheck="select-all-{{ generateSlug($activity['activity']['name']) }}">
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @elseif (generateSlug($activity['activity']['name']) == \App\Models\Activity::FREIGHTING_GOODS)
                        <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                            id="{{ generateSlug($activity['activity']['name']) }}" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="checkbox-main custome-scrollbar-m">
                                <div class="checkbox-group-box">
                                    <ul class="custome-checkbox custom-group-list">
                                        <li class="checklist-title">Freighting Goods: Vans And Hgv</li>
                                        <li class="all-select">
                                            <label class="checkbox" for="select-all-freighting-goods-vansHgv">
                                                <input type="checkbox" name="remember" name="all" checked
                                                    value="all" id="select-all-freighting-goods-vansHgv">All<span
                                                    class="checkmark"></span>
                                            </label>
                                        </li>
                                        @foreach (getFreightingGgoods('vans') as $value)
                                            <li>
                                                <label class="checkbox" for="{{ 'vans_' . $value['id'] }}">
                                                    <input type="checkbox" name="freighting_goods_vansHgv[]"
                                                        value="{{ $value['id'] }}" id="{{ 'vans_' . $value['id'] }}"
                                                        class="freighting-goods-vansHgv-checkbox"
                                                        {{ in_array($value['id'], old('freighting_goods_vansHgv', [])) || in_array($value['id'], getSelectedActivity(\App\Models\Activity::FREIGHTING_GOODS_VansHgv, $companyData->id)) ? 'checked' : '' }}>{{ $value['type'] . '-' . $value['fuel'] }}<span
                                                        class="checkmark"></span>
                                                </label>
                                            </li>
                                        @endforeach
                                        <input type="hidden"
                                            value="{{ count(getSelectedFreightingGgoods('vans', $companyData->id)) }}"
                                            id="freightinggoodsvansHgvcheckcount" class ="activities-data"
                                            data-checkbox="freighting-goods-vansHgv-checkbox"
                                            data-allcheck="select-all-freighting-goods-vansHgv">
                                    </ul>
                                    <ul class="custome-checkbox custom-group-list">
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
                                                        {{ in_array($value['id'], old('freighting_goods_flights_rail', [])) || in_array($value['id'], getSelectedActivity(\App\Models\Activity::FREIGHTING_GOODS_VansHgv, $companyData->id)) ? 'checked' : '' }}>{{ $value['type'] }}<span
                                                        class="checkmark"></span>
                                                </label>
                                            </li>
                                        @endforeach
                                        <input type="hidden"
                                            value="{{ count(getSelectedFreightingGgoods('', $companyData->id)) }}"
                                            id="freightinggoodsflightsrailcheckcount" class ="activities-data"
                                            data-checkbox="freighting-goods-flights-rail-checkbox"
                                            data-allcheck="select-all-freighting-goods-flights-rail">
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @elseif (generateSlug($activity['activity']['name']) == \App\Models\Activity::FLIGHT_AND_ACCOMMODATION)
                        <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                            id="{{ generateSlug($activity['activity']['name']) }}" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="checkbox-main custome-scrollbar-m">
                                <div class="checkbox-group-box">
                                    <ul class="custome-checkbox custom-group-list">
                                        <li></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @elseif (generateSlug($activity['activity']['name']) == \App\Models\Activity::HOME_OFFICE)
                        <div class="tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                            id="{{ generateSlug($activity['activity']['name']) }}" role="tabpanel"
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
                @endif
            @endforeach
        @endif
    </div>
</div>
