jQuery(function($){
	getMoreBooks();
});

const getMoreBooks = function() {

	let skip = $('.table tbody tr').length;
	
	$('#btn-load-more').on('click', function() {

		if($('.loader').hasClass('hidde'))
			$('.loader').removeClass('hidde')

		$.ajax({
			method: "POST",
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