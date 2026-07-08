/**
 * News page — filter toggle, category filter, search, infinite scroll.
 */
(function () {
	'use strict';

	function initNewsPage() {
		var root = document.querySelector('.news-container');
		if (!root) {
			return;
		}

		var perPage = parseInt(root.getAttribute('data-per-page'), 10) || 12;
		var filterToggle = document.getElementById('news-filter-toggle');
		var filterIcon = document.getElementById('news-filter-icon');
		var filterCats = document.getElementById('news-filter-categories');
		var searchInput = document.getElementById('search-news');
		var listRow = document.getElementById('news-list-row');
		var loadMore = document.getElementById('news-load-more');
		var items = listRow ? Array.prototype.slice.call(listRow.querySelectorAll('.item')) : [];

		var state = {
			category: '',
			year: '',
			search: '',
			visibleCount: perPage,
			loading: false,
		};

		function normalize(value) {
			return (value || '').toLowerCase().trim();
		}

		function matchesFilters(item) {
			var category = normalize(item.getAttribute('data-category'));
			var year = item.getAttribute('data-year') || '';
			var title = normalize(item.getAttribute('data-title'));

			if (state.category && state.category !== 'year' && state.category !== 'label') {
				if (category !== state.category) {
					return false;
				}
			}

			if (state.year && year !== state.year) {
				return false;
			}

			if (state.search && title.indexOf(state.search) === -1) {
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

				var filter = link.getAttribute('data-filter') || '';
				var parent = link.getAttribute('data-parent') || '';
				var isParent = link.classList.contains('has-child');

				if (isParent) {
					var childWrap = filterCats.querySelector('.filter-categories__children[data-parent="' + filter + '"]');
					var wasOpen = childWrap && childWrap.classList.contains('open');

					Array.prototype.forEach.call(filterCats.querySelectorAll('.filter-categories__children'), function (el) {
						el.classList.remove('open');
						el.hidden = true;
					});

					Array.prototype.forEach.call(filterCats.querySelectorAll('.has-child'), function (el) {
						el.classList.remove('show');
					});

					if (childWrap && !wasOpen) {
						childWrap.classList.add('open');
						childWrap.hidden = false;
						link.classList.add('show');
					}

					if (filter === 'year') {
						state.category = 'year';
					} else if (filter === 'label') {
						state.category = 'label';
					}

					return;
				}

				if (parent === 'year') {
					Array.prototype.forEach.call(filterCats.querySelectorAll('.filter-categories__children a'), function (el) {
						el.classList.remove('active');
					});
					link.classList.add('active');
					state.year = filter;
					state.category = '';
					Array.prototype.forEach.call(filterCats.querySelectorAll('.filter-categories > a'), function (el) {
						if (!el.classList.contains('has-child')) {
							el.classList.remove('active');
						}
					});
					resetVisible();
					return;
				}

				if (parent === 'label') {
					Array.prototype.forEach.call(filterCats.querySelectorAll('.filter-categories__children a'), function (el) {
						el.classList.remove('active');
					});
					link.classList.add('active');
					state.category = 'label';
					state.year = '';
					Array.prototype.forEach.call(filterCats.querySelectorAll('.filter-categories > a'), function (el) {
						if (!el.classList.contains('has-child')) {
							el.classList.remove('active');
						}
					});
					resetVisible();
					return;
				}

				Array.prototype.forEach.call(filterCats.querySelectorAll('.filter-categories > a'), function (el) {
					el.classList.remove('active');
				});
				Array.prototype.forEach.call(filterCats.querySelectorAll('.filter-categories__children a'), function (el) {
					el.classList.remove('active');
				});
				Array.prototype.forEach.call(filterCats.querySelectorAll('.filter-categories__children'), function (el) {
					el.classList.remove('open');
					el.hidden = true;
				});
				Array.prototype.forEach.call(filterCats.querySelectorAll('.has-child'), function (el) {
					el.classList.remove('show');
				});

				if (state.category === filter && !state.year) {
					state.category = '';
					link.classList.remove('active');
				} else {
					state.category = filter;
					state.year = '';
					link.classList.add('active');
				}

				resetVisible();
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
					{
						root: null,
						rootMargin: '200px 0px',
						threshold: 0,
					}
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
			var itemLink = e.target.closest('.news-item-link');
			if (itemLink) {
				e.preventDefault();
			}
		});

		render();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initNewsPage);
	} else {
		initNewsPage();
	}
})();
