function pop(games) {
	games = JSON.parse(games);
	for(var i = 0; i < games.length; i++) {
		$.TokenList.insert_token(games[i].id, games[i].title);
	}
}
$(function(){
	$('.games-tokeninput').tokenInput('/games/autocomplete/', {
		hintText : 'Start typing game\'s title',
		method : 'GET'
	});
});
