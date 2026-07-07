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
	var offcanvasOverlay = document.getElementById('offcanvas-overlay');
	var offcanvasClose = document.getElementById('offcanvas-close');
	var headerMain = document.getElementById('header-main');
	var mainMenu = document.getElementById('menu-main-menu');

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
	 * Open offcanvas menu.
	 */
	function openOffcanvas() {
		document.body.classList.add('off-canvas');
		navToggle.classList.add('open');
		offcanvas.setAttribute('aria-hidden', 'false');
		offcanvasOverlay.classList.add('is-visible');
		offcanvasOverlay.setAttribute('aria-hidden', 'false');
		navToggle.setAttribute('aria-expanded', 'true');
	}

	/**
	 * Close offcanvas menu.
	 */
	function closeOffcanvas() {
		document.body.classList.remove('off-canvas');
		navToggle.classList.remove('open');
		offcanvas.setAttribute('aria-hidden', 'true');
		offcanvasOverlay.classList.remove('is-visible');
		offcanvasOverlay.setAttribute('aria-hidden', 'true');
		navToggle.setAttribute('aria-expanded', 'false');
	}

	/**
	 * Toggle submenu for items with children.
	 *
	 * @param {HTMLElement} parentItem List item element.
	 * @param {HTMLElement|null} arrow    Optional arrow toggle element.
	 */
	function toggleSubmenu(parentItem, arrow) {
		var submenu = parentItem.querySelector(':scope > .sub-menu');
		if (!submenu) {
			return;
		}

		var isOpen = submenu.classList.toggle('is-open');

		if (arrow) {
			arrow.textContent = isOpen ? '↑' : '↓';
			arrow.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
		}
	}

	/**
	 * Append dropdown arrows and bind submenu toggles.
	 */
	function initOffcanvasSubmenus() {
		if (!mainMenu) {
			return;
		}

		var parents = mainMenu.querySelectorAll('.menu-item-has-children');

		parents.forEach(function (item) {
			if (item.querySelector(':scope > .nav-sub')) {
				return;
			}

			var arrow = document.createElement('a');
			arrow.href = '#';
			arrow.className = 'nav-sub';
			arrow.setAttribute('aria-label', 'Toggle submenu');
			arrow.setAttribute('aria-expanded', 'false');
			arrow.textContent = '↓';
			item.appendChild(arrow);

			arrow.addEventListener('click', function (e) {
				e.preventDefault();
				toggleSubmenu(item, arrow);
			});

			var parentLink = item.querySelector(':scope > a');
			if (parentLink) {
				parentLink.addEventListener('click', function (e) {
					e.preventDefault();
					toggleSubmenu(item, arrow);
				});
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

			if (document.body.classList.contains('off-canvas')) {
				closeOffcanvas();
			} else {
				openOffcanvas();
			}
		});

		if (offcanvasClose) {
			offcanvasClose.addEventListener('click', function (e) {
				e.preventDefault();
				closeOffcanvas();
			});
		}

		if (offcanvasOverlay) {
			offcanvasOverlay.addEventListener('click', function (e) {
				e.preventDefault();
				closeOffcanvas();
			});
		}

		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && document.body.classList.contains('off-canvas')) {
				closeOffcanvas();
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
				navToggle.classList.add('fixed', 'show-down');
			} else {
				headerMain.classList.remove('show-down');
				navToggle.classList.remove('show-down');
				if (current <= 200) {
					headerMain.classList.remove('fixed');
					navToggle.classList.remove('fixed');
				}
			}

			lastScroll = current <= 0 ? 0 : current;
		});
	}

	/**
	 * Footer scroll-to-top buttons.
	 */
	function initFooterScrollUp() {
		var upButtons = document.querySelectorAll('#footer-nav-up, #footer-nav-up-mobile');

		upButtons.forEach(function (button) {
			button.addEventListener('click', function (e) {
				e.preventDefault();
				window.scrollTo({ top: 0, behavior: 'smooth' });
			});
		});
	}

	/**
	 * Reserve space so fixed footer does not cover page content.
	 * Matches sonymusic.eu: $("#main").css("margin-bottom", $("#footer").outerHeight())
	 */
	function initFooterSpacing() {
		var footer = document.getElementById('footer');
		var main = document.getElementById('main');

		if (!footer || !main) {
			return;
		}

		function getOuterHeight(el) {
			var style = window.getComputedStyle(el);
			return el.offsetHeight + parseFloat(style.marginTop || 0) + parseFloat(style.marginBottom || 0);
		}

		function applySpacing() {
			var height = getOuterHeight(footer);
			if (height > 0) {
				main.style.marginBottom = height + 'px';
			}
		}

		applySpacing();
		window.addEventListener('resize', applySpacing);
		window.addEventListener('load', applySpacing);

		// Recalculate after accordion sections expand (contact, faq, etc.).
		document.addEventListener('click', function (event) {
			if (event.target.closest('.accordion-section__title')) {
				window.setTimeout(applySpacing, 520);
			}
		});
	}

	initSearch();
	initLangMenu();
	initOffcanvasSubmenus();
	initNavToggle();
	initStickyHeader();
	initFooterScrollUp();
	initFooterSpacing();
})();
