import './bootstrap';
window.Echo.private(`users.${id}`)
    .notification((event)=>{
        $('#pusherNotify').prepend(`
            <div class="dropdown-item d-flex justify-content-between align-items-center">
                                        <p>${event.post_title.substring(0,9)}</p>
                                        <span>${event.comment}</span>
                                        <a href="${event.link}?notify=${event.id}"><i
                                        class="fa fa-eye"></i></a>
            </div>
            `);
            count = Number($('#countNotify').text());
            count++;
            $('#countNotify').text(count);
    });
