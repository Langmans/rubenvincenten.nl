Modernizr.load([ {
	// The test: does the browser understand Media Queries?
	test : Modernizr.mq('only all'),
	// If not, load the respond.js file
	nope : '//cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js'
} ]);