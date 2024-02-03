<header class="company-details-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-4 col-2">
                <a href="#">
                    <picture>
                        <img src="{{ asset('assets/images/logo.svg') }}" alt="welcome-screen-logo"
                            width="46" height="50">
                    </picture>
                </a>
            </div>
            @if (!activeClass(['frontend/{slug}'], Route::getCurrentRoute()->uri()))
                <div class="col-sm-4 col-10 d-flex justify-content-center">
                    <ul class="details-steps">
                        <li
                            class="step {{ activeClass(['company-detail-step-one'], Route::getCurrentRoute()->uri()) }}">
                            1</li>
                        <li
                            class="step {{ activeClass(['company-detail-step-two'], Route::getCurrentRoute()->uri()) }}">
                            2</li>
                        <li
                            class="step {{ activeClass(['company-detail-step-three'], Route::getCurrentRoute()->uri()) }}">
                            3</li>
                        <li
                            class="step {{ activeClass(['company-detail-step-four'], Route::getCurrentRoute()->uri()) }}">
                            4</li>
                        <li
                            class="step {{ activeClass(['company-detail-step-five'], Route::getCurrentRoute()->uri()) }}">
                            5</li>
                    </ul>
                </div>
                <div class="col-sm-4 col-12">
                    <div class="need-help">
                        <a href="{{ url('/frontend/need-help') }}" target="_blank">Need help?</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</header>
