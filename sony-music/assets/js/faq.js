/**
 * FAQ accordion toggle — vanilla JS, matches sonymusic.eu behavior.
 */
(function () {
	'use strict';

	function toggleSection(section) {
		var content = section.querySelector('.accordion-section__content');
		var title = section.querySelector('.accordion-section__title');
		var isExpanded = section.classList.contains('expanded');

		if (isExpanded) {
			content.style.display = 'none';
			content.hidden = true;
			section.classList.remove('expanded');
			if (title) {
				title.setAttribute('aria-expanded', 'false');
			}
			return;
		}

		content.style.display = 'block';
		content.hidden = false;
		section.classList.add('expanded');
		if (title) {
			title.setAttribute('aria-expanded', 'true');
		}
	}

	function initAccordion() {
		var titles = document.querySelectorAll('.block-accordion .accordion-section__title');

		titles.forEach(function (title) {
			title.addEventListener('click', function () {
				toggleSection(title.parentElement);
			});

			title.addEventListener('keydown', function (event) {
				if (event.key === 'Enter' || event.key === ' ') {
					event.preventDefault();
					toggleSection(title.parentElement);
				}
			});
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initAccordion);
	} else {
		initAccordion();
	}
})();
