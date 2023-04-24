function footerLogoSeparator(){
    let footerul = document.getElementById("footerul");

    for(let n = 0; n < footerul.children.length + 1; n++){

        if(n % 2 == 0){
            let img = document.createElement("img");
            footerul.appendChild(img);

            img.setAttribute("src", "/images/ArkChessLogoTransparentC9.png");

            footerul.insertBefore(img, footerul.children[n]);
        }
    }
}

function createChessTable(){
    let ChessTable = document.getElementById("chessTable");

    for(let i = 0; i < 8; i++){
        let tr = document.createElement("tr");
        for(let j = 0; j < 8; j++) {
            let td = document.createElement("td");
    
            if((i + j) % 2 == 0){

                td.setAttribute("class", "cell whitecell");
                tr.appendChild(td);
            }
            else{
                td.setAttribute("class", "cell blackcell");
                tr.appendChild(td);
            }
        }

        ChessTable.appendChild(tr);
    }

    ChessTable.setAttribute("cellspacing", "0");
    ChessTable.setAttribute("width", "350px");
    ChessTable.setAttribute("height", "350px");
}

function load(){
    createChessTable();
    footerLogoSeparator();
}

document.addEventListener("DOMContentLoaded", load);