import './bootstrap';
if (role == "user") {
window.Echo.private(`users.${user_id}`)
    .notification((event)=>{
        let link  = showPostRoute.replace(':slug' , event.post_slug) +'?notify='+event.id;
        $('#pusherNotify').prepend(`
            <div class="dropdown-item d-flex justify-content-between align-items-center">
                                        <p>${event.post_title.substring(0,9)}</p>
                                        <span>${event.comment}</span>
                                        <a href="${link}?notify=${event.id}"><i
                                        class="fa fa-eye"></i></a>
            </div>
            `);
            count = Number($('#countNotify').text());
            count++;
            $('#countNotify').text(count);
    });
}

//Admin
if (role == "admin") {
    window.Echo.private('admins.' + adminId)
        .notification((event) => {
            $('#notify_push').prepend(`
                <a class="dropdown-item d-flex align-items-center" href=${event.link}?notify-admin=${event.id}">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="${ event.userImage }"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">${ event.contact_title }</div>
                                        <div class="small text-gray-500">${ event.date }</div>
                                    </div>
                                </a>`);

            count = Number($('#count_notify').text());
            count++;
            $('#count_notify').text(count);
        });
}

