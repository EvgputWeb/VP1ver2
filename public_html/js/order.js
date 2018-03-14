$('#order-form').on('submit', function(e){
    e.preventDefault();

    var paymentValue = $('input[name="payment"]:checked').val();
    var callbackValue = $('input[name="callback"]').is(':checked') ? "on" : "";

    // Делаем кнопки недоступными на время работы скрипта
    $('input.order__form-button').css('opacity', '0.2').prop('disabled',true);

    $.ajax({
        url: '/order',
        type: 'POST',
        dataType: 'json',
        data: {
            name: $('input[name="name"]').val(),
            email: $('input[name="email"]').val(),
            phone: $('input[name="phone"]').val(),
            street: $('input[name="street"]').val(),
            home: $('input[name="home"]').val(),
            part: $('input[name="part"]').val(),
            appt: $('input[name="appt"]').val(),
            floor: $('input[name="floor"]').val(),
            comment: $('textarea[name="comment"]').val(),
            payment: paymentValue,
            callback: callbackValue
        }
    })
        .done(function(data) {

            if (data.result == 'success') {
                // Всё хорошо
                swal({
                    title: 'Спасибо за заказ!',
                    text: 'Номер Вашего заказа: '+ data.order_id,
                    type: 'success',
                    confirmButtonColor: '#619c34',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $('#order-form')[0].reset();
                    $('input.order__form-button').css('opacity', '1').prop('disabled',false);
                })
            } else {
                // Ошибка - выдаём сообщение с номером ошибки
                swal({
                    type: 'error',
                    title: 'Произошла ошибка',
                    text: 'Код ошибки = '+data.error_code
                });
                $('input.order__form-button').css('opacity', '1').prop('disabled',false);
            }

        })
        .fail(function() {
            // Здесь просто сообщение об ошибке
            swal({
                type: 'error',
                title: 'Упс...',
                text: 'Что-то пошло не так'
            });
            $('input.order__form-button').css('opacity', '1').prop('disabled',false);
        });

});
