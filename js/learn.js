'use strict';

//TODO: inject using AJAX instead
document.addEventListener('DOMContentLoaded', function() {
    // Initialize the chessboard
    let learnBoard1 = Chessboard('learnBoard1', {
        position: 'start', // set the starting position
        draggable: true,  // make the pieces draggable
        showNotation: false
    });

    let learnBoard2 = Chessboard('learnBoard2', {
        position: 'start', // set the starting position
        draggable: true,  // make the pieces draggable
        showNotation: false
    });

    let learnBoard3 = Chessboard('learnBoard3', {
        position: 'start', // set the starting position
        draggable: true,  // make the pieces draggable
        showNotation: false
    });

    let learnBoard4 = Chessboard('learnBoard4', {
        position: 'start', // set the starting position
        draggable: true,  // make the pieces draggable
        showNotation: false
    });

    let learnBoard5 = Chessboard('learnBoard5', {
        position: 'start', // set the starting position
        draggable: true,  // make the pieces draggable
        showNotation: false
    });
});

function loadApp(){
    document.getElementById('form').addEventListener('submit', searchOpenings);
}

loadApp();