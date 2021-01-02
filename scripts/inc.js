
        function valid(f) {
            !(/^[A-zÑñ0-9]*$/i).test(f.value)?f.value = f.value.replace(/[^A-zÑñ0-9]/ig,''):null;
        } 



Spry.Utils.addLoadListener(function() {
	Spry.$$("#input1").addEventListener('keyup', function(e){ valid(this) }, false);
	Spry.$$("#input1").addEventListener('blur', function(e){ valid(this) }, false);
});
