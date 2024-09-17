// waits for the page to load before running the code
document.addEventListener('DOMContentLoaded', () => {
    const startButton = document.getElementById('start-button');
    const cherry = document.querySelector('.heart');
    if (!startButton || !cherry) {
        console.error('Start button or cherry picture not found');
        return;
    }

    startButton.addEventListener('click', startGame);
    cherry.addEventListener('click', startGameWithNate);
});

// starts the game with Nate as the pacman
function startGameWithNate() {
    const pacman = document.getElementById('pacman');
    const cherry = document.querySelector('.heart');
    if (!pacman || !cherry) {
        console.error('Pacman or cherry picture not found');
        return;
    }
    pacman.style.backgroundImage = "url('../public/img/nate528-pacman.gif')";
    pacman.style.top = "calc(50% - 20px)";
    cherry.removeEventListener('click', startGameWithNate);
    startGame();
}


// starts the game/animation
function startGame() {
    const cherry = document.querySelector('.heart');
    if (!cherry) {
        console.error('Cherry picture not found');
        return;
    }
    cherry.removeEventListener('click', startGameWithNate); 
    
    const pacman = document.getElementById('pacman');
    const pelletsContainer = document.getElementById('pellets-container');
    if (!pacman || !pelletsContainer) {
        console.error('Pacman or pellets container not found');
        return;
    }
    createPellets(5, pelletsContainer);

    pacman.style.display = 'block';
    pacman.style.animation = 'popUp 1s';
    const playButton = document.getElementById('start-button');
    if (playButton) {
        playButton.style.display = 'none';
    }
    
    pacman.style.display = 'block';
    let pacmanCurrentX = 0;
    const pacmanSpeed = 1;
    const interval = setInterval(() => {
        pacmanCurrentX += pacmanSpeed;
        pacman.style.left = pacmanCurrentX + 'px';
        const pellets = document.querySelectorAll('.pellet');
        pellets.forEach(pellet => {
            const pelletX = parseInt(pellet.style.left, 10);
            if (pacmanCurrentX >= pelletX - 10 && pacmanCurrentX <= pelletX + 10) {
                eatPellet(pacman, pellet);
            }
        });
        if (pacmanCurrentX > 250) {
            clearInterval(interval);
            window.location.href = 'main.php';
        }
    }, 16);
}
let score = 0;
function eatPellet(pacman, pellet) {
    score += 1;
    document.getElementById('score').textContent = 'Score: ' + score;
    pellet.parentNode.removeChild(pellet);
}

function createPellets(number, parent) {
    const pellets = [];
    const startingLeftPosition = 90;
    const topPosition = 50;

    for (let i = 0; i < number; i++) {
        const pellet = document.createElement('div');
        pellet.classList.add('pellet');
        pellet.style.left = `${startingLeftPosition + i * 50}px`;
        pellet.style.top = `${topPosition}%`;
        pellet.style.display = 'none';
        pellets.push(pellet);
        parent.appendChild(pellet);

        setTimeout(() => {
            pellet.style.display = 'block';
        }, i * 750);
    }
    return pellets;
}

