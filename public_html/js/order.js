$('#order-form').on('submit', function(e){
    e.preventDefault();

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
            payment: $('input[name="payment"]').val(),
            callback: $('input[name="callback"]').val()
        }
    })
        .done(function(data) {

            if (data.result == 'success') {

                swal({
                    title: 'Спасибо за заказ!',
                    text: 'Номер Вашего заказа: '+ data.order_id,
                    type: 'success',
                    confirmButtonColor: '#619c34',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $('#order-form')[0].reset();
                });

            } else {
                // Здесь сообщение об ошибке с номером ошибки
            }

        })
        .fail(function() {
            // Здесь просто сообщение об ошибке
        });

});
