const phone = {
	"label": "phone",
	"width": 320,
	"height": 480
};

const tablet = {
	"label": "tablet",
	"width": 1024,
	"height": 768
};

const screen = {
	"label": "screen",
	"width": 1600,
	"height": 1000
};


const scenario = config => ({
	// anything below did, e.g., not produce "click menu toggler then page tools" reliably on my machine
	postInteractionWait: 200,
	misMatchThreshold: 0,
	// hide "This page was last edited on ..."
	hideSelectors: ["div#footer-info div"],
	...config
});

module.exports = {
	id: "backstop_default",
	viewports: [phone, tablet, screen],
	onBeforeScript: "puppet/onBefore.js",
	onReadyScript: "puppet/onReady.js",
	scenarios: [{
		label: "Main Page",
		url: "http://wiki.local"
	}, {
		label: "Main Page - click page tools",
		url: "http://wiki.local",
		clickSelector: ".navbar-more-tools",
		viewports: [screen]
	}, {
		label: "Main Page - click menu toggler then page tools",
		url: "http://wiki.local",
		clickSelectors: [".navbar-toggler", ".navbar-more-tools"],
		viewports: [phone, tablet]
	}].map(scenario),
	paths: {
		bitmaps_reference: "backstop_data/bitmaps_reference",
		engine_scripts: "backstop_data/engine_scripts",
		bitmaps_test: "backstop_data/bitmaps_test",
		ci_report: "backstop_data/ci_report",
		html_report: "backstop_data/html_report"
	},
	report: ["browser"],
	engine: "puppeteer",
	engineOptions: {
		args: ["--no-sandbox"]
	},
	asyncCaptureLimit: 5,
	asyncCompareLimit: 50,
	debug: false,
	debugWindow: false
}
