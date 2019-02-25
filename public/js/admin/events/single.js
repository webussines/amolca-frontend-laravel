jQuery(function($){

    InitTinyMceEditor();
    
    $(document).on('focusin', function(e) {
        if ($(e.target).closest(".mce-window, .moxman-window").length) {
            e.stopImmediatePropagation();
        }
    });

    $('.save-resource').on('click', SaveEventInfo)

    ResetFormErrors();

    $('.select2-normal').select2();

});

const InitTinyMceEditor = function() {
	tinymce.init({
	    selector: "textarea#description",
        theme: "modern",
        height: 200,
        plugins: [
             "code link image imagetools visualblocks visualchars advcode",
             "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
             "save contextmenu directionality emoticons template paste textcolor"
       ],
	})

	tinymce.init({
	    selector: "textarea.common-editor",
        theme: "modern",
        height: 300,
        plugins: [
             "code link image imagetools visualblocks visualchars advcode",
             "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
             "save contextmenu directionality emoticons template paste textcolor"
       ],
	})
}

const ResetFormErrors = function() {
    $('.required-field').on('keyup change', function() {

        if($(this).val() !== '' && $(this).val() !== ' ') {

            if($(this).hasClass('field-error'))
                $(this).removeClass('field-error')

        }

    })

    $('#autores').on('change', function() {

        if($(this).val().length > 0) {

            if($('.select2-selection--multiple').hasClass('field-error'))
                $('.select2-selection--multiple').removeClass('field-error')

        }

    });
}


const SaveEventInfo = function() {

    let flag = true;
    let _action = $('#_action').val();
    let _token = $('#_token').val();
    let _user = $('#_user').val();

    if($('.loader').hasClass('hidde'))
        $('.loader').removeClass('hidde')

    //Unique values
    let id = $('#id').val();
    let title = $('#title').val();
    let thumbnail = $('#image-url').val();
    let date = $('#date').val();
    let state = $('#state').val();
    let description = tinymce.get('content').getContent().replace(/"/gi, "'");

    let book = {
        title: title,
        state: state,
        content: description,
        thumbnail: thumbnail,
        user_id: _user,
        type: 'event',
        meta: [
            {
                "key": "event_date",
                "value": date
            }
        ]
    }

    let ActionRoute;
    let send;
    
    switch(_action) {
        case 'edit':
            send = book;
            ActionRoute = '/am-admin/events/edit/' + id;
        break;

        case 'create':
            ActionRoute = '/am-admin/eventos';
            book.slug = GenerateSlug(book.title);
            send = [ book ];
        break;
    }

    $('.required-field').each(function(){
        
        let val = $(this).val();

        if(val === ' ' || val === '' || val === null) {
            $(this).addClass('field-error');
            flag = false;
        }

    });

    console.log(send);

    if(flag) {
        $.ajax({
            method: 'POST',
            url: ActionRoute,
            data: {
                "body": send,
                "_token": _token
            }
        }).done(function(resp) {
            console.log(resp)

            let data = JSON.parse(resp);
            
            if(data.error !== undefined) {
                if (data.error == 'token_expired') {
                    window.location.href = '/am-admin/logout';
                }
            }

            if(data.post !== undefined && data.post.id !== undefined) {
                
                switch(_action) {
                    case 'edit':
                        location.reload();
                    break;
                    case 'create':
                        window.location.href = '/am-admin/eventos/' + data.post.id;
                    break;
                }

            }
            
            if(data.posts_id !== undefined && data.posts_id.length > 0) {
                window.location.href = '/am-admin/eventos/' + data.posts_id[0];
            }
        }).catch(function(err) {
            console.log(err)
        })
    } else {

        if(!$('.loader').hasClass('hidde'))
            $('.loader').addClass('hidde')

        let toastMsg = 'Debes llenar los campos obligatorios.';
        M.toast({html: toastMsg, classes: 'red accent-4 bottom left'});
    }

}