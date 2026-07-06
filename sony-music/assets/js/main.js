/**
 * Sony Music theme — main JavaScript.
 */
(function () {
	'use strict';

	var searchWrap = document.getElementById('top-search');
	var searchToggle = document.getElementById('search-toggle');
	var searchInput = document.getElementById('ts-search');
	var langWrap = document.getElementById('menu-lang');
	var navToggle = document.getElementById('nav-toggle');
	var offcanvas = document.getElementById('offcanvas-nav');
	var headerMain = document.getElementById('header-main');

	/**
	 * Toggle expandable search field.
	 */
	function initSearch() {
		if (!searchWrap || !searchToggle || !searchInput) {
			return;
		}

		searchToggle.addEventListener('click', function (e) {
			e.preventDefault();
			var isOpen = searchWrap.classList.toggle('opened');
			searchToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');

			if (isOpen) {
				searchInput.focus();
			} else {
				searchInput.value = '';
			}
		});

		searchInput.addEventListener('keydown', function (e) {
			if (e.key === 'Enter' && searchInput.value.trim()) {
				window.location.href = sonyMusic.homeUrl + '?s=' + encodeURIComponent(searchInput.value.trim());
			}

			if (e.key === 'Escape') {
				searchWrap.classList.remove('opened');
				searchToggle.setAttribute('aria-expanded', 'false');
				searchInput.blur();
			}
		});

		document.addEventListener('click', function (e) {
			if (!searchWrap.contains(e.target) && searchWrap.classList.contains('opened')) {
				searchWrap.classList.remove('opened');
				searchToggle.setAttribute('aria-expanded', 'false');
			}
		});
	}

	/**
	 * Toggle language dropdown on click.
	 */
	function initLangMenu() {
		if (!langWrap) {
			return;
		}

		langWrap.addEventListener('click', function (e) {
			var link = e.target.closest('a');
			if (!link) {
				return;
			}

			var firstItem = langWrap.querySelector('.menu li:first-child');
			if (link.closest('li') === firstItem) {
				e.preventDefault();
				langWrap.classList.toggle('opened');
			}
		});

		document.addEventListener('click', function (e) {
			if (!langWrap.contains(e.target)) {
				langWrap.classList.remove('opened');
			}
		});
	}

	/**
	 * Offcanvas navigation toggle.
	 */
	function initNavToggle() {
		if (!navToggle || !offcanvas) {
			return;
		}

		navToggle.addEventListener('click', function (e) {
			e.preventDefault();
			var isOpen = document.body.classList.toggle('nav-open');
			navToggle.classList.toggle('open', isOpen);
			offcanvas.classList.toggle('is-open', isOpen);
			navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
			offcanvas.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
		});

		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && document.body.classList.contains('nav-open')) {
				document.body.classList.remove('nav-open');
				navToggle.classList.remove('open');
				offcanvas.classList.remove('is-open');
				navToggle.setAttribute('aria-expanded', 'false');
				offcanvas.setAttribute('aria-hidden', 'true');
			}
		});
	}

	/**
	 * Sticky header on scroll (matches reference behavior).
	 */
	function initStickyHeader() {
		if (!headerMain) {
			return;
		}

		var lastScroll = 0;

		window.addEventListener('scroll', function () {
			var current = window.pageYOffset || document.documentElement.scrollTop;

			if (current > 200 && current < lastScroll) {
				headerMain.classList.add('fixed', 'show-down');
			} else {
				headerMain.classList.remove('show-down');
				if (current <= 200) {
					headerMain.classList.remove('fixed');
				}
			}

			lastScroll = current <= 0 ? 0 : current;
		});
	}

	initSearch();
	initLangMenu();
	initNavToggle();
	initStickyHeader();
})();
