if ('Notification' in window) {
    notification();
}

toast();

// ---------------------------------------------------------------------------------------------------------------------

function notification() {

    Notification.requestPermission();

    setInterval(function() {
        var appts = filterAppointments();

        var displayTime = 5000;
        var i = 0;

        for(var k = 0; k < notifications_list.length; k++) {
            var not = notifications_list[k];

            not.close();
        }

        notifications_list = [];

        appts.forEach(function(appt) {
            setTimeout(function() {
                var notification = new Notification('Compromisso: ' + appt.company.name, {
                    body: appt.interaction.description,
                    silent: false,
                    data: {
                        appointment_id: appt.id
                    }
                });

                notifications_list.push(notification);

                notification.onclick = function() {
                    ignore_ids.push(appt.id);
                    updateViewedAt(appt.id, moment().format('YYYY-MM-DD HH:mm:ss'), appointments);
                    notification.close();
                };

                notification.onclose = function() {

                };

                notification.onshow = function() {

                };
            }, displayTime * i);

            i++;
        });
    }, 20000);

    /*missedAppointmentsNotification();

    setInterval(function() {
        missedAppointmentsNotification();
    }, 18000000);*/

}

function toast() {
    setInterval(function () {
        const appts = filterAppointments();

        appts.forEach(function (appt) {
            toastr.info(
                appt.name,
                'Compromisso: ' + appt.company.name,
                {positionClass: "toast-bottom-right", preventDuplicates: true}
            );
        });
    }, 20000);
}

function filterAppointments() {
    const date = new Date;
    const hour = date.getHours();
    const minutes = date.getMinutes();

    const appts = appointments.filter(function (appt) {
        var apptLimit = moment(appt.time, 'HH:mm').add(30, 'minutes').format('HH:mm');
        var now = moment().format('HH:mm');

        return appt.viewed_at == null &&
            appt.status.constant_name != 'REALIZADO' &&
            !ignore_ids.includes(appt.id) &&
            (moment(appt.time, 'HH:mm').format('HH:mm') <= moment().format('HH:mm')) &&
            Date.parse('01/01/2011 ' + now) < Date.parse('01/01/2011 ' + apptLimit);
    });

    return appts;
}

function missedAppointments() {

    const date = new Date;
    const hour = date.getHours();
    const minutes = date.getMinutes();

    return appointments.filter(function (appt) {
        return appt.viewed_at == null && !ignore_ids.includes(appt.id) && (moment(appt.time, 'HH:mm').format('HH:mm') != moment().format('HH:mm'));
    });

}

function updateViewedAt(compromisso_id, viewed_at, appointments) {

    $.ajax({
        type: "POST",
        url: APP_URL + '/appointment/view_notification',
        data: {
            compromisso_id: compromisso_id,
            viewed_at: viewed_at
        },
        success: function(msg) {
            for(var i = 0; i < appointments.length; i++) {
                if(appointments[i].id == compromisso_id) {
                    appointments[i].viewed_at = viewed_at;

                    break;
                }
            }

            window.location.href = APP_URL + '/appointment/' + compromisso_id;
        },
        error: function(response, textStatus, errorThrown) {
            /*console.log(response);
            console.log(textStatus);
            console.log(errorThrown);*/
        }
    });

}

function missedAppointmentsNotification() {

    var missedAppts = missedAppointments();

    if(missedAppts.length > 0) {
        var notification = new Notification('Você possui ' + missedAppts.length + ' compromissos perdidos hoje.', {
            body: 'Clique aqui para ver os compromissos que você perdeu.',
            silent: false
        });
    }

}