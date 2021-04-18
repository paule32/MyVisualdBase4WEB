window.__global_namespace__ = {}

window.__global_namespace__._lockIntro = false;

function enterFullscreen(element)
{
	if (element.requestFullscreen)       { element.requestFullscreen      (); } else
	if (element.mozRequestFullScreen)    { element.mozRequestFullScreen   (); } else
	if (element.msRequestFullscreen)     { element.msRequestFullscreen    (); } else
	if (element.webkitRequestFullscreen) { element.webkitRequestFullscreen(); }
}
	
function check_mousepos()
{
	const amigaos = document.getElementById('amigaos');
	const hpc64os = document.getElementById('hpc64os');
	const mswinos = document.getElementById('mswinos');
	
	amigaos.addEventListener('click', function() {
		enterFullscreen(document.documentElement);
        location.href = "../applications/web_amiga/index/index.php";
    });
	
	hpc64os.addEventListener('click', function() {
		enterFullscreen(document.documentElement);
        location.href = "../applications/web_hpc64/index/index.php";
    });
	
	mswinos.addEventListener('click', function() {
		enterFullscreen(document.documentElement);
        location.href = "../applications/web_mswin/index/index.php";
    });
}

function on_ready() {

    document.body.style.overflow = 'auto';

    if (window.__global_namespace__._lockIntro == false) {
        window.__global_namespace__._lockIntro = true;
        console.log("start...");
        check_mousepos();
    }
}
