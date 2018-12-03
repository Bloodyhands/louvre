$('#add-ticket').click(function(){
	//je récupère le numero des futurs champs que je vais créer en ajoutant +1 à l'index à chaque fois que l'on rajoute un ticket (même si une ticket est enlevé)
	const index = +$('#widgets-counter').val();

	//je récupère le prototype des entrées
	const tmpl = $('#booking_tickets').data('prototype').replace(/__name__/g, index);

	//J'injecte ce code au sein de la div
	$('#booking_tickets').append(tmpl);

	$('#widgets-counter').val(index + 1);

	//je gere le bouton supprimer
	handleDeleteButtons();
});

function handleDeleteButtons(){
	$('button[data-action="delete"]').click(function(){
		const target = this.dataset.target;
		$(target).remove();
	});
}

function updateCounter(){
	const count = +$('#booking_tickets div.form-group').length;

	$('#widgets-counter').val(count);
}

updateCounter();
handleDeleteButtons();