/**
 * Artists page — filter, search, hover images, infinite scroll, sticky letters.
 */
(function () {
	'use strict';

	function throttle(fn) {
		var ticking = false;
		return function () {
			if (ticking) {
				return;
			}
			ticking = true;
			window.requestAnimationFrame(function () {
				fn();
				ticking = false;
			});
		};
	}

	function initArtistsPage() {
		var root = document.querySelector('.artists-container');
		if (!root) {
			return;
		}

		var perPage = parseInt(root.getAttribute('data-per-page'), 10) || 30;
		var filterToggle = document.getElementById('artists-filter-toggle');
		var filterIcon = document.getElementById('artists-filter-icon');
		var filterCats = document.getElementById('artists-filter-categories');
		var labelToggle = document.getElementById('artists-label-toggle');
		var searchInput = document.getElementById('search-artists');
		var list = document.getElementById('artists-list');
		var loadMore = document.getElementById('artists-load-more');
		var items = list ? Array.prototype.slice.call(list.querySelectorAll('.item')) : [];
		var isMobile = window.matchMedia('(max-width: 767px)').matches;

		var state = {
			search: '',
			visibleCount: perPage,
			loading: false,
		};

		function normalize(value) {
			return (value || '').toLowerCase().trim();
		}

		function matchesFilters(item) {
			var name = normalize(item.getAttribute('data-name'));
			if (state.search && name.indexOf(state.search) === -1) {
				return false;
			}
			return true;
		}

		function getMatchedItems() {
			return items.filter(matchesFilters);
		}

		function setLoadMoreVisible(show) {
			if (!loadMore) {
				return;
			}
			if (show) {
				loadMore.classList.remove('is-hidden');
				loadMore.removeAttribute('hidden');
			} else {
				loadMore.classList.add('is-hidden');
				loadMore.setAttribute('hidden', 'hidden');
			}
		}

		function setLoading(isLoading) {
			state.loading = isLoading;
			if (loadMore) {
				loadMore.classList.toggle('is-loading', isLoading);
			}
		}

		function render() {
			var matched = getMatchedItems();
			var shown = 0;

			items.forEach(function (item) {
				item.classList.add('is-hidden');
				item.setAttribute('hidden', 'hidden');
			});

			matched.forEach(function (item, index) {
				if (index < state.visibleCount) {
					item.classList.remove('is-hidden');
					item.removeAttribute('hidden');
					shown += 1;
				}
			});

			setLoadMoreVisible(shown < matched.length);
			setLoading(false);
			updatePinnedLetters();
		}

		function resetVisible() {
			state.visibleCount = perPage;
			render();
		}

		function loadNextBatch() {
			var matched = getMatchedItems();
			if (state.loading || state.visibleCount >= matched.length) {
				return;
			}

			setLoading(true);
			window.setTimeout(function () {
				state.visibleCount += perPage;
				render();
			}, 1000);
		}

		function updatePinnedLetters() {
			if (isMobile || !list) {
				return;
			}

			var groups = Array.prototype.slice.call(list.querySelectorAll('.item.grouped:not(.is-hidden):not([hidden])'));
			var scrollY = window.scrollY || window.pageYOffset;
			var pinTop = document.body.classList.contains('header-show') || document.getElementById('header-main') && document.getElementById('header-main').classList.contains('show-down')
				? 130
				: 50;
			var listLeft = list.getBoundingClientRect().left;

			groups.forEach(function (group) {
				var letter = group.querySelector('.item__group');
				if (!letter) {
					return;
				}

				letter.classList.remove('is-pinned');
				letter.style.position = '';
				letter.style.top = '';
				letter.style.left = '';
			});

			groups.forEach(function (group, index) {
				var letter = group.querySelector('.item__group');
				if (!letter) {
					return;
				}

				var start = group.getBoundingClientRect().top + scrollY;
				var next = groups[index + 1];
				var end = next
					? next.getBoundingClientRect().top + scrollY - 40
					: (list.getBoundingClientRect().bottom + scrollY);

				if (scrollY + pinTop >= start && scrollY + pinTop < end) {
					letter.classList.add('is-pinned');
					letter.style.position = 'fixed';
					letter.style.top = pinTop + 'px';
					letter.style.left = listLeft + 'px';
				}
			});
		}

		if (filterToggle && filterCats) {
			filterToggle.addEventListener('click', function (e) {
				e.preventDefault();
				var isOpen = filterCats.classList.toggle('open');
				filterCats.hidden = !isOpen;
				filterToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
				if (filterIcon) {
					filterIcon.classList.toggle('filter-opened', isOpen);
				}
			});
		}

		if (filterCats) {
			filterCats.addEventListener('click', function (e) {
				var link = e.target.closest('a');
				if (!link) {
					return;
				}
				e.preventDefault();

				if (link.classList.contains('has-child') || link === labelToggle) {
					var childWrap = filterCats.querySelector('.filter-categories__children[data-parent="label"]');
					var wasOpen = childWrap && childWrap.classList.contains('open');
					if (childWrap) {
						if (wasOpen) {
							childWrap.classList.remove('open');
							childWrap.hidden = true;
							link.classList.remove('show');
						} else {
							childWrap.classList.add('open');
							childWrap.hidden = false;
							link.classList.add('show');
						}
					}
					return;
				}

				Array.prototype.forEach.call(filterCats.querySelectorAll('.filter-categories__children a'), function (el) {
					el.classList.remove('active');
				});
				link.classList.add('active');
			});
		}

		if (searchInput) {
			var searchTimer = null;
			searchInput.addEventListener('input', function () {
				clearTimeout(searchTimer);
				searchTimer = setTimeout(function () {
					state.search = normalize(searchInput.value);
					resetVisible();
				}, 150);
			});
		}

		if (loadMore) {
			loadMore.addEventListener('click', function (e) {
				var link = e.target.closest('a');
				if (!link) {
					return;
				}
				e.preventDefault();
				loadNextBatch();
			});

			if ('IntersectionObserver' in window) {
				var observer = new IntersectionObserver(
					function (entries) {
						entries.forEach(function (entry) {
							if (entry.isIntersecting) {
								loadNextBatch();
							}
						});
					},
					{ root: null, rootMargin: '200px 0px', threshold: 0 }
				);
				observer.observe(loadMore);
			} else {
				window.addEventListener(
					'scroll',
					function () {
						if (loadMore.classList.contains('is-hidden') || loadMore.hasAttribute('hidden')) {
							return;
						}
						var rect = loadMore.getBoundingClientRect();
						if (rect.top < window.innerHeight + 200) {
							loadNextBatch();
						}
					},
					{ passive: true }
				);
			}
		}

		document.addEventListener('click', function (e) {
			var itemLink = e.target.closest('.artist-item-link');
			if (itemLink) {
				e.preventDefault();
			}
		});

		window.addEventListener('scroll', throttle(updatePinnedLetters), { passive: true });
		window.addEventListener(
			'resize',
			throttle(function () {
				isMobile = window.matchMedia('(max-width: 767px)').matches;
				updatePinnedLetters();
			}),
			{ passive: true }
		);

		render();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initArtistsPage);
	} else {
		initArtistsPage();
	}
})();
