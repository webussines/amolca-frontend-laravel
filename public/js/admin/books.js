jQuery(function($){
	getMoreBooks();

	$(document).ready(function() {
		createDataTable();
	});
});

const createDataTable = function() {
	$('table.books').dataTable( {
	    ajax: {
	    	method: "POST",
	    	url: '/am-admin/books/get-books',
	    	data: {
	    		"limit": 40,
				"skip": 0,
				"_token": $('#_token').val()
	    	}
	    },
	    columns: [
	    	{ 
	    		data: "image",
	    		className: "image",
	    		"render": function (data, type, JsonResultRow, meta) {
                    return '<img src="'+ JsonResultRow.image + '">';
                } 
            },
	    	{ 	
	    		data: "title",
	    		className: "title"
	    	},
	    	{ 	
	    		data: "specialty",
	    		className: "specialty",
	    		render: function(data, type, JsonResultRow, meta) {
	    			return JsonResultRow.specialty[1].title;
	    		}
	    	},
	    	{ 	
	    		data: "isbn",
	    		className: "isbn"
	    	},
	    	{ 	
	    		data: "author[0].name",
	    		className: "author",
	    		"render": function (data, type, JsonResultRow, meta) {
                  	switch(JsonResultRow.state) {
                  		case 'PUBLISHED':
                  			return 'Publicado';
                  		break;
                  		case 'DRAFT':
                  			return 'Borrador';
                  		break;
                  		case 'TRASH':
                  			return 'En papelera';
                  		break;
                  		default:
                  			return 'Borrador';
                  		break;
                  	}
                } 
	    	},
	    ]
	});

	$('#DataTables_Table_0_length select').formSelect();
}

const getMoreBooks = function() {

	let skip = $('.table tbody tr').length;
	
	$('#btn-load-more').on('click', function() {

		if($('.loader').hasClass('hidde'))
			$('.loader').removeClass('hidde')

		$.ajax({
			type: "POST",
			url: "/am-admin/books/get-books",
			data: {
				"limit": 40,
				"skip": skip,
				"_token": $('#_token').val()
			}
		}).done(function(resp) {

			if(!$('.loader').hasClass('hidde'))
				$('.loader').addClass('hidde')
			
			if(resp.books.length > 0) {

				for (var i = 0; i < resp.books.length; i++) {
					let el = resp.books[i];
					let state = 'Publicado';

					if(el.state == 'PUBLISHED') 
						state = 'Publicado';

					if(el.state == 'DRAFT')
						state = 'Borrador';

					if(el.state == 'TRASH') 
						state = 'En papelera';

					let row = `
						<tr>
							<td class="image">
								<img src="${el.image}" alt="${el.title}">
							</td>
							<td class="title">
								${el.title}
							</td>
							<td class="specialty">
								${el.specialty[1].title}
							</td>
							<td class="isbn">
								${el.isbn}
							</td>
							<td class="state">
								${state}
							</td>
							<td class="actions">
								<a class="edit" href="/am-admin/libros/${el._id}">
				                    <span class="icon-mode_edit"></span>
				                </a>

				                <a class="actions">
				                    <span class="icon-trash"></span>
				                </a>
							</td>
						</tr>
					`;

					$('.table.books tbody tr:last').after(row);
				}
			}
		});
	});

}