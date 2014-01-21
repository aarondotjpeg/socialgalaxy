jQuery(function($) {
	function getwpwhosonline(){
		toggleUpdates();
		var queryString = wpwhosonline.ajaxUrl +'?action=wpwhosonline_ajax_update&load_time=' + wpwhosonline.wpwhosonlineLoadTime + '&frontpage=' + wpwhosonline.isFirstFrontPage;
		ajaxCheckAuthors = $.getJSON(queryString, function(response){
			if(typeof response.latestupdate != 'undefined') {
				wpwhosonline.wpwhosonlineLoadTime = response.latestupdate;
				for(var i = 0; i < response.users.length; i++) {
					var current = response.users[i],
						$o = $('#wpwhosonline-' + current.user_id);
					console.dir(current.user_id, current.timestamp);
					if( $o.length == 0 ) {
						$o = $('<li/>').attr('id', 'wpwhosonline-' + current.user_id).
							addClass( 'wpwhosonline-row wpwhosonline-active' ).
							prependTo( '.wpwhosonline-list' );
						console.log($o);
					}
					$o.html( current.html ).
						data('wpwhosonline', current.timestamp);
				}
			}
			console.log('Done');
		});
		toggleUpdates();
		updateRecents();
	};
	function formatDate(formatDate, formatString) {
		if(formatDate instanceof Date) {
			var months = new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
			var yyyy = formatDate.getFullYear();
			var yy = yyyy.toString().substring(2);
			var m = formatDate.getMonth();
			var mm = m < 10 ? "0" + m : m;
			var mmm = months[m];
			var d = formatDate.getDate();
			var dd = d < 10 ? "0" + d : d;
			var h = formatDate.getHours();
			var hh = h < 10 ? "0" + h : h;
			var n = formatDate.getMinutes();
			var nn = n < 10 ? "0" + n : n;
			var s = formatDate.getSeconds();
			var ss = s < 10 ? "0" + s : s;
			formatString = formatString.replace(/yyyy/i, yyyy);
			formatString = formatString.replace(/yy/i, yy);
			formatString = formatString.replace(/mmm/i, mmm);
			formatString = formatString.replace(/mm/i, mm);
			formatString = formatString.replace(/m/i, m);
			formatString = formatString.replace(/dd/i, dd);
			formatString = formatString.replace(/d/i, d);
			formatString = formatString.replace(/hh/i, hh);
			formatString = formatString.replace(/h/i, h);
			formatString = formatString.replace(/nn/i, nn);
			formatString = formatString.replace(/n/i, n);
			formatString = formatString.replace(/ss/i, ss);
			formatString = formatString.replace(/s/i, s);
			return formatString;
		} else {
			return "";
		}
	}
	function updateRecents(){
		var now = Math.round(new Date().getTime()/1000.0);
		var active = 120; // 2 minutes
		var recent = 600; // 10 minutes
		var ancient = 7200; // 2 hours
		$('.wpwhosonline-row').each(function(){
			var $o = $(this);
			var since, oclass, remove;
			var last = $o.data('wpwhosonline');
			since = now - last;
			if(since > ancient) {
				oclass = "wpwhosonline-ancient";
				remove = "wpwhosonline-recent wpwhosonline-active";
			} else if(since > recent) {
				oclass = "wpwhosonline-recent";
				remove = "wpwhosonline-ancient wpwhosonline-active";
			} else {
				oclass = "wpwhosonline-active";
				remove = "wpwhosonline-ancient wpwhosonline-recent";
				if(since > active && $o.text() == 'Online now!' ) {
					var theDate = new Date(last * 1000);
					$o.text( formatDate(theDate, 'dd mmm yyyy HH:MM:ss') );
				}
			}
			$o.addClass( oclass ).removeClass( remove );
		});
	}
	function toggleUpdates() {
		if (0 == wpwhosonline.getwpwhosonlineUpdate) {
			wpwhosonline.getwpwhosonlineUpdate = setInterval(getwpwhosonline, 30000);
		} else {
			clearInterval(wpwhosonline.getwpwhosonlineUpdate);
			wpwhosonline.getwpwhosonlineUpdate = '0';
		}
	}
	toggleUpdates();
	updateRecents();
});