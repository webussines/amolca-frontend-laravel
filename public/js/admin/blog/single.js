jQuery(function($){

    InitTinyMceEditor();

    $('.save-resource').on('click', SavePostInfo)

    ResetFormErrors();

    $('#title').on('blur', function() {
        let slug = GenerateSlug($('#title').val());

        $('span#slug span').html(slug);
    });

});

const InitTinyMceEditor = function() {
	tinymce.init({
	    selector: "textarea#content",
        theme: "modern",
        height: 700,
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

const SavePostInfo = (e) => {

    e.preventDefault();

    let flag = true;
    let _action = $('#_action').val();
    let _token = $('#_token').val();
    let _user = $('#_user').val();
    let _id = $('#id').val();

    if($('.loader').hasClass('hidde'))
        $('.loader').removeClass('hidde')

    let post = {
        title: $('#title').val(),
        content: tinymce.activeEditor.getContent(),
        state: $('#state').val(),
        thumbnail: $('#image-url').val()
    }

    if($('#excerpt').val() !== '' && $('#excerpt').val() !== ' ') {
        post.excerpt = $('#excerpt').val();
    }

    let ActionRoute;
    let data_send = { "_token": _token }

    switch(_action) {
        case 'edit':
            ActionRoute = '/am-admin/blogs/edit/' + _id;
            data_send.body = post
        break;

        case 'create':
            ActionRoute = '/am-admin/blog';
            post.slug = GenerateSlug(post.title);
            post.type = 'post';
            data_send.body = [post]
        break;
    }

    $('.required-field').each(function(){
            
        let val = $(this).val();

        if(val === ' ' || val === '' || val === null) {
            $(this).addClass('field-error');
            flag = false;
        }

    });

    if(flag) {

        $.ajax({
            method: 'POST',
            url: ActionRoute,
            data: data_send
        }).done(function(resp) {
            console.log(resp)

            let data = JSON.parse(resp);

            if(data.error !== undefined) {
                if (data.error == 'token_expired') {
                    window.location.href = '/am-admin/logout?redirect=';
                }
            }

            if(data.status !== undefined && (data.status >= 200 || data.status < 300)) {
                
                switch(_action) {
                    case 'edit':
                        location.reload();
                    break;
                    case 'create':
                        window.location.href = '/am-admin/blog/' + data.posts_id[0];
                    break;
                }

            }
        }).catch(function(err) {
            console.log(err);
        })

    } else {
        if(!$('.loader').hasClass('hidde'))
            $('.loader').addClass('hidde')

        let toastMsg = 'Debes llenar los campos obligatorios.';
        M.toast({html: toastMsg, classes: 'red accent-4 bottom left'});
    }
}