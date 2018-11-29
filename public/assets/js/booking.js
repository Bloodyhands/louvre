var $collectionHolder;

var $addTicketButton = $('<button type="button" class="add_ticket_link">Ajouter un ticket</button>');
var $newLinkLi = $('<li></li>').append($addTicketButton);

jQuery(document).ready(function() {
	$collectionHolder = $('ul.tickets');

	$collectionHolder.append($newLinkLi);

	$collectionHolder.data('index', $collectionHolder.find(':input').lenght);

	$addTicketButton.on('click', function(e) {
		addTicketForm($collectionHolder, $newLinkLi);
	});
});

jQuery(document).ready(function(){
	$collectionHolder = $('ul.tickets');

	$collectionHolder.find('li').each(function(){
		addTicketFormDeleteLink($(this));
	});
});

function addTicketForm($collectionHolder, $newLinkLi) {
	var prototype = $collectionHolder.data('prototype');

	var index = $collectionHolder.data('index');

	var newForm = prototype;

	newForm = newForm.replace(/__name__/g, index);

	$collectionHolder.data('index', index + 1);

	var $newFormLi = $('<li></li>').append(newForm);
	$newLinkLi.before($newFormLi);

	addTicketFormDeleteLink($newFormLi);
}

function addTicketFormDeleteLink($ticketFormLi) {
	var $removeFormButton = $('<button type="button">Supprimer ce ticket</button>');
	$ticketFormLi.append($removeFormButton);

	$removeFormButton.on('click', function(e){
		$ticketFormLi.remove();
	});
}
