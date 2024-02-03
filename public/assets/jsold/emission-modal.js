function emissionModal(input) {
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    $.ajax({
        url: emissionRoute,
        type: 'post',
        data: {
            'name': $(input).data('name'),
            'slug': $(input).data('slug'),
            'company_id': companyId,
            '_token': CSRF_TOKEN
        },
        success: function (response) {
            $("#emission-modal").modal('show');
            $("#emission-title").text($(input).data('name'));
            const ulBody = document.querySelector('.ul-body');
            let li = '';

            const processVehicleType = (vehicleType, title) => {
                if (response[vehicleType]) {
                    li += `<li class="em-title">${title}</li>`;
                    li += response[vehicleType].map(item => `<li>${item}</li>`).join('');
                }
            };

            const inputName = $(input).data('name');

            if (inputName === 'Owned vehicles' || inputName === 'Freighting goods' | inputName === 'Flight and Accommodation') {
                if (inputName === 'Owned vehicles') {
                    processVehicleType('passengerVehicle', 'Passenger vehicles');
                    processVehicleType('deliveryVehicle', 'Delivery vehicles');
                } else if(inputName === 'Flight and Accommodation'){
                    processVehicleType('flights', 'Flights');
                    processVehicleType('hotels', 'Hotels');
                }else {
                    processVehicleType('vansHgsData', 'Vans and HGVs');
                    processVehicleType('flightRailData', 'Flights, rail ,sea tanker and cargo ship');
                }
            }else if(inputName === 'Home Office' ){
                li = '<li>Coming Soon</li>';
            } else {
                li = response.map(item => `<li>${item}</li>`).join('');
            }
            
            ulBody.innerHTML = li;
        },
        error: function (xhr, status, error) {
            if (xhr.status === 422) {
                button.prop('disabled', false);
                button.html('UPDATE');
                companyIndustryError(xhr.responseJSON.errors);
            }
        }
    });


}