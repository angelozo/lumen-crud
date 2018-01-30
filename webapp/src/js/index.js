function CandidateManager() {
	this.list =  function(callback) {
		var ajax = $.ajax({
			url: 'http://localhost:8000/candidate',
			dataType: 'JSON',
			type: 'GET'
		});

		ajax.done(callback);
	};

	this.create = function(params, callback) {
		var ajax = $.ajax({
			url: 'http://localhost:8000/candidate',
			type: 'POST',
			data: {name: params.name, email: params.email},
			success: callback()
		});
	};

	this.delete = function(id, callback) {
		var ajax = $.ajax({
			url: 'http://localhost:8000/candidate/' + id,
			type: 'DELETE'
		});

		ajax.done(callback());
	};

	this.update = function(params, id, callback) {
		var ajax = $.ajax({
			url: 'http://localhost:8000/candidate/' + id,
			type: 'PUT',
			data: {name: params.name, email: params.email},
			success: callback(),
			error: function() {
				alert('Erro, algum dos campos é invalido ou e-mail já está cadastrado.');
			}
		});
	};
};

function DomManipulator() {
	const candidateManager = new CandidateManager();

	this.updateList = function() {
		var $list = $('#candidate_list ul');
		$list.empty();

		candidateManager.list(function(data) {
			if(data.length <= 0 || data == null) {
				var $warning = document.createElement('div');
				$($warning).addClass('alert alert-warning');
				$($warning).attr('role', 'alert');
				$($warning).html('Nenhum usuário encontrado');
				$list.append($warning);

				return;
			}

			data.forEach(function(candidate, index, array) {
				var $item = document.createElement('li');
				$($item).addClass('list-group-item');

				var $information = document.createElement('label');
				$information.innerHTML = candidate.name + ' | ' + candidate.email;

				var $deleteButton = document.createElement('a');
				$deleteButton.innerHTML = 'Deletar';
				$($deleteButton).attr('candidate_id', candidate.id);
				$($deleteButton).addClass('delete btn btn-danger');

				var $editButton = document.createElement('a');
				$editButton.innerHTML = 'Editar';
				$($editButton).attr('candidate_id', candidate.id);
				$($editButton).attr('data_name', candidate.name);
				$($editButton).attr('data_email', candidate.email);
				$($editButton).addClass('edit btn btn-info');

				$($list).append($item);
				$($item).append($information);
				$($information).append($deleteButton);
				$($information).append($editButton);
			});
		});
	};
};

$(document).ready(function() {
	const candidateManager = new CandidateManager();
	const domManipulator = new DomManipulator();

	// load and list candidates
	var $list = document.createElement('ul');
	$($list).addClass('list-group');
	$('#candidate_list').append($list);
	domManipulator.updateList();

	// listener to delete
	$('#candidate_list').on('click', '.delete', function() {
		let id = $(this).attr('candidate_id');

		candidateManager.delete(id, function() {
			$('#candidate_list ul').html('<li class="list-group-item">Atualizando...</li>');
			setTimeout(domManipulator.updateList, 500);
		});
	});

	// listener to edit
	$('#candidate_list').on('click', '.edit', function() {
		let id = $(this).attr('candidate_id');
		let name = $(this).attr('data_name');
		let email = $(this).attr('data_email');

		$('#name').val(name);
		$('#email').val(email);

		$('.form_create_new').attr('flag', 'update');
		$('.form_create_new button').html('Atualizar');
		$('#id').val(id);
	})

	// listener to new | Flag edit
	$('.form_create_new').submit(function(e) {
		e.preventDefault();
		var flag = $(this).attr('flag');

		var candidateData = {
			name: $('#name').val(),
			email: $('#email').val()
		};

		if(flag == 'create') {
			candidateManager.create(candidateData, function() {
				$('#name').val('');
				$('#email').val('');
				$('#candidate_list ul').html('<li class="list-group-item">Atualizando...</li>');
				setTimeout(domManipulator.updateList, 500);
			});
		} else {
			var id = $('#id').val();

			candidateManager.update(candidateData, id, function() {
				$('#name').val('');
				$('#email').val('');
				$('#id').val('');
				$('.form_create_new button').html('Cadastrar novo');
				$(this).attr('flag', 'create');

				$('#candidate_list  ul').html('<li class="list-group-item">Atualizando...</li>');
				setTimeout(domManipulator.updateList, 500);
			});
		}
	});
});
