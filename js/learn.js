'use strict';

function initChessboard(elementId, fen) {
    var config = {
        position: fen,
        draggable: true,
        showNotation: false
    };
    var board = Chessboard(elementId, config);
    return board;
}

function fetchAndDisplayOpenings(query = '', limit = 20) {
    fetch('https://explorer.lichess.ovh/masters?topGames=20')
        .then(response => response.json())
        .then(data => {
            const movesData = data.moves;
            const filteredMoves = movesData.slice(0, limit);

            const openingsContainer = document.querySelector('.openingsContainer');
            openingsContainer.innerHTML = '';

            filteredMoves.forEach((move, index) => {
                const chess = new Chess();
                const result = chess.move({ from: move.uci.slice(0, 2), to: move.uci.slice(2, 4) });

                if (result === null) {
                    console.error('Illegal move or incorrect UCI string:', move.uci);
                    return;
                }

                const fen = chess.fen();
                const openingTile = document.createElement('div');
                openingTile.className = 'openingTile';
                openingTile.innerHTML = `
                    <div class="openingInfo">
                        <span class="openingName">Move: ${move.san}</span>
                        <span class="openingStats">Played by ${move.white} white, ${move.draws} draws, ${move.black} black</span>
                        <span class="openingMove">Rating: ${move.averageRating}</span>
                    </div>
                    <div class="playBoard" id="learnBoard${index}"></div>
                `;
                openingsContainer.appendChild(openingTile);
                initChessboard(`learnBoard${index}`, fen);
            });
        })
        .catch(error => {
            console.error('Error fetching data from Lichess:', error);
        });
}

function searchOpenings(event) {
    event.preventDefault();
    const query = document.getElementById('openingSearch').value;
    fetchAndDisplaySearchOpenings(query);
}

function loadApp(){
    fetchAndDisplayOpenings();
    const form = document.getElementById('openingForm');
    if (form) {
        form.addEventListener('submit', searchOpenings);
    }
}

// Hides any number of elements specified in the parameters.
function hideElements(){
    for(let x = 0; x < arguments.length; x++){
        arguments[x].style.display = "none";
    }
}

// Hides any number of elements specified in the parameters.
function showElements(){
    for(let x = 0; x < arguments.length; x++){
        arguments[x].style.display = "block";
    }
}

// Hides all errors on the page.
function hideErrors(){
	let error = document.getElementsByClassName("error");

	for(let i = 0; i < error.length; i++) {
		error[i].style.display = "none";
	}
}

document.addEventListener('DOMContentLoaded', loadApp);

document.getElementsByName("signIn")[0].addEventListener("click", function() {
    clearFields(emailInput, emailLabel);
    hideElements(emailInput, emailLabel);
    hideErrors();
});

document.getElementsByName("register")[0].addEventListener("click", function() {
    clearFields(emailInput, emailLabel);
    showElements(emailInput, emailLabel);
    hideErrors();
});
