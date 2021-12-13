const backgrounds = [
    '/images/Backgrounds/Sekiro_Shadows_Die_Twice.jpg',
    '/images/Backgrounds/ac_valhalla.jpg',
    '/images/Backgrounds/Honkai_Impact_3rd.jpg',
    '/images/Backgrounds/persona5_01.jpg',
    '/images/Backgrounds/singularity_station.jpg',
    '/images/Backgrounds/tw3.jpg',
    '/images/Backgrounds/a2.jpg',
    '/images/Backgrounds/touka.jpg',
    '/images/Backgrounds/dust2.jpg',
    '/images/Backgrounds/samurai_girl.jpg',
    '/images/Backgrounds/gta_v.jpg',
    '/images/Backgrounds/nier_automata01.jpg',
    '/images/Backgrounds/ff_xiv.jpg',
    '/images/Backgrounds/persona5_02.jpg',
    '/images/Backgrounds/the_world_tree.jpg',
    '/images/Backgrounds/gow.jpg',
    '/images/Backgrounds/ff_vii.jpg',
    '/images/Backgrounds/ac_odyssey.jpg',
    '/images/Backgrounds/spider_man.jpg',
    '/images/Backgrounds/meditating_warrior.jpg',
    '/images/Backgrounds/dmc.jpg',
    '/images/Backgrounds/tos.jpg',
    '/images/Backgrounds/ff_xv.jpg',
    '/images/Backgrounds/bf_v.jpg',
    '/images/Backgrounds/the_ship.jpg',
    '/images/Backgrounds/kayle.jpg',
    '/images/Backgrounds/sf_v.jpg',
    '/images/Backgrounds/persona4.jpg',
    '/images/Backgrounds/levi.jpg',
    '/images/Backgrounds/ac_valhalla2.jpg',
    '/images/Backgrounds/links_house.jpg',
    '/images/Backgrounds/travel_girl.jpg',
    '/images/Backgrounds/dota2.jpg',
    '/images/Backgrounds/jean_genshin.jpg',
    '/images/Backgrounds/nier_automata02.jpg',
    '/images/Backgrounds/akali.jpg',
    '/images/Backgrounds/link.jpg',
    '/images/Backgrounds/sky_island.jpg',
];

let indexRef = 0;

// Auto Change Background
function updateBG() {
    const body = document.querySelector('body');

    let index = Math.floor(Math.random() * backgrounds.length);

    while (index === indexRef) {
        index = Math.floor(Math.random() * backgrounds.length);
    }

    const image = new Image();
    image.onload = function () {
        body.style.backgroundImage = `url("/images/texture_grid.png"), url("${backgrounds[index]}")`;
    };
    image.src = backgrounds[index];

    indexRef = index;
}

$(document).ready(function () {
    updateBG();

    setInterval(updateBG, 8000);
});

//------------------------------------------------------------------------------------------------//

document.addEventListener(
    'contextmenu',
    function (e) {
        e.preventDefault();
    },
    false
);

document.addEventListener('keydown', function (e) {
    if ((e.ctrlKey && e.shiftKey) || (e.ctrlKey && e.keyCode == 85) || e.keyCode == 123) {
        e.stopPropagation();
        e.preventDefault();
    }
});
