function footerLogoSeparator(){
    let footerul = document.getElementById("footerul");
    let footerLength = footerul.children.length + 1;

    for(let n = 0; n < footerLength * 2; n++){
        if(n % 2 == 0){
            let li = document.createElement("li");
            footerul.insertBefore(li, footerul.children[n]);
        }
    }

    let lis = footerul.querySelectorAll("li");

    for(let n = 0; n < lis.length; n += 2){
        var img = document.createElement("img");

        img.setAttribute("src", "images/ArkChessLogoTransparentC9.png");
        img.setAttribute("alt", "ArkChess Logo");

        lis[n].appendChild(img);
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