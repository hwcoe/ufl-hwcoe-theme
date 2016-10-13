/*!
 * UFL Audience Cookies
 * Requires js.cookie.js 
 */
function ufl_audience_preference_set_html(ufl_cookie) {
	if (ufl_cookie) {
		ufl_audience_html_url = $('.audience-link[data-ufl-audience-preference="'+ufl_cookie+'"]').attr('href');
		ufl_audience_html_text = $('.audience-link[data-ufl-audience-preference="'+ufl_cookie+'"]').text();
		if (ufl_audience_html_url && ufl_audience_html_text) {
			$('.cur-audience').attr('href', ufl_audience_html_url).text(ufl_audience_html_text);
		}
	}
}
function ufl_audience_cookie() {
	ufl_cookie = Cookies.get('ufl_audience_preference');
	if (ufl_cookie) {
		ufl_audience_preference_set_html(ufl_cookie);
	}
	$('.audience-nav-wrap .audience-link').click(function(e) {
		ufl_audience_preference = $(this).data('ufl-audience-preference');
		Cookies.set('ufl_audience_preference', ufl_audience_preference, { expires: 90 });
		ufl_audience_preference_set_html(ufl_audience_preference);
	});
}