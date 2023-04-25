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

        img.setAttribute("src", "/images/ArkChessLogoTransparentC9.png");
        img.setAttribute("alt", "ArkChess Logo");

        lis[n].appendChild(img);
    }
}

function load(){
    footerLogoSeparator();
}

document.addEventListener("DOMContentLoaded", load);