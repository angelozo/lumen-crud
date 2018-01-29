function CandidateManager() {
	this.list =  function() {
		var ajax = $.ajax({
			url: 'localhost:8000/candidate',
			dataType: 'JSON',
			method: 'GET'
		});

		ajax.done(function(data) {

		});
	};

	this.create = function(params) {

	};

	this.delete = function(id) {

	};

	this.update = function(params, id) {

	};
};

function DomManipulator() {
	this.candidateManager = new CandidateManager();

	this.updateList = function() {
		this.candidateManager.list(function() {
			var $list = $('#candidate_list ul');
			$list.innerHTML = '';

			candidates.forEach(function(candidate, index, array) {
				var $item = document.createElement('li');

				var $information = document.createElement('label');
				$information.innerHTML = candidate.name + ' | ' + candidate.email;

				var $deleteLink = document.createElement('a');
				$deleteLink.innerHTML = 'Deletar';
				$($deleteLink).attr('candidate_id', candidate.id);
				$($deleteLink).addClass('delete');

				$($list).append($item);
				$($item).append($information);
				$($information).append($deleteLink);
			});
		});
	};
};

$(document).ready(function() {
	var candidateManager = new CandidateManager();
	var domManipulator = new DomManipulator();

	// load and list candidates
	var $list = document.createElement('ul');
	$('#candidate_list').append($list);
	domManipulator.updateList();

	// listener to delete
	$('#candidate_list').on('click', '.delete', function() {
		let id = $(this).attr('candidate_id');

		candidateManager.delete(id);
	});

	// listener to edit

	// listener to click new
});
