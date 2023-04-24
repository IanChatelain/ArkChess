function footerLogoSeparator(){
    let footerul = document.getElementById("footerul");

    for (let n = 0; n < footerul.children.length + 1; n++){

        if(n % 2 == 0){
            let img = document.createElement("img");
            footerul.appendChild(img);

            img.setAttribute("src", "/images/ArkChessLogoTransparentC9.png");

            footerul.insertBefore(img, footerul.children[n]);
        }
    }
}

function load(){
    footerLogoSeparator();
}

document.addEventListener("DOMContentLoaded", load);