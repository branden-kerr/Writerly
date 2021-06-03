function csshero_initialize_animations(array){
	//console.log('load anims')
	var prevel = document.querySelectorAll('*[data-aos]')
	for (i = 0; i < prevel.length; ++i) {
		prevel[i].removeAttribute('data-aos')	
	}
	for (var v in array){
		var els = document.querySelectorAll(v), i;		
		for (i = 0; i < els.length; ++i) {
			for (var y in array[v]){
				els[i].setAttribute(y,array[v][y]);
			}
		}
	}
	AOS.init();
}

document.addEventListener("DOMContentLoaded", function() {
	if (typeof csshero_animations_json !== 'undefined') csshero_initialize_animations(JSON.parse(csshero_animations_json));
});