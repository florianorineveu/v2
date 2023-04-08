let cursorFollower = document.getElementById('cursorFollower');

const onMouseMove = (e) => {
    cursorFollower.style.top = e.pageY + 'px';
    cursorFollower.style.left = e.pageX + 'px';
}

document.addEventListener('mousemove', onMouseMove);
