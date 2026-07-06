/**
 * Homepage hero news slider — vanilla JS (matches sonymusic.eu behavior).
 */
(function () {
	'use strict';

	function HeroSlider(newsSlider, imageSlider) {
		this.newsSlider = newsSlider;
		this.imageSlider = imageSlider;
		this.track = newsSlider.querySelector('.slider-track');
		this.items = Array.from(newsSlider.querySelectorAll('.slide-item'));
		this.images = imageSlider ? Array.from(imageSlider.querySelectorAll('.slide')) : [];
		this.arrowsContainer = newsSlider.closest('.slider-container').querySelector('.arrows-container');
		this.arrowButton = this.arrowsContainer ? this.arrowsContainer.querySelector('.arrow') : null;
		this.current = 0;
		this.timer = null;
		this.isAnimating = false;
		this.autoplaySpeed = parseInt(newsSlider.getAttribute('data-autoplay'), 10) || 4000;
		this.transitionSpeed = parseInt(newsSlider.getAttribute('data-speed'), 10) || 1500;

		if (!this.track || this.items.length < 2) {
			return;
		}

		this.track.style.transitionDuration = this.transitionSpeed + 'ms';
		this.bindEvents();
		this.update(false);
		this.startAutoplay();
	}

	HeroSlider.prototype.getSlidesToShow = function () {
		return window.innerWidth < 768 ? 1 : 2;
	};

	HeroSlider.prototype.bindEvents = function () {
		var self = this;

		window.addEventListener('resize', function () {
			self.update(false);
		});

		this.items.forEach(function (item, index) {
			var link = item.querySelector('a');
			if (!link) {
				return;
			}

			link.addEventListener('click', function (e) {
				if (!item.classList.contains('is-current')) {
					e.preventDefault();
					self.goTo(index);
				}
			});
		});

		if (this.arrowButton) {
			this.arrowButton.addEventListener('click', function (e) {
				e.preventDefault();
				self.next();
			});

			this.arrowButton.addEventListener('keydown', function (e) {
				if (e.key === 'Enter' || e.key === ' ') {
					e.preventDefault();
					self.next();
				}
			});
		}

		this.newsSlider.addEventListener('mouseenter', function () {
			self.stopAutoplay();
		});

		this.newsSlider.addEventListener('mouseleave', function () {
			self.startAutoplay();
		});
	};

	HeroSlider.prototype.startAutoplay = function () {
		var self = this;
		this.stopAutoplay();
		this.timer = window.setInterval(function () {
			self.next();
		}, this.autoplaySpeed);
	};

	HeroSlider.prototype.stopAutoplay = function () {
		if (this.timer) {
			window.clearInterval(this.timer);
			this.timer = null;
		}
	};

	HeroSlider.prototype.next = function () {
		this.goTo((this.current + 1) % this.items.length);
	};

	HeroSlider.prototype.goTo = function (index) {
		if (this.isAnimating || index === this.current) {
			return;
		}

		this.isAnimating = true;
		this.newsSlider.classList.add('hide-arrow');

		if (this.arrowsContainer) {
			this.arrowsContainer.classList.add('is-visible');
		}

		this.current = index;
		this.update(true);

		var self = this;
		window.setTimeout(function () {
			self.newsSlider.classList.remove('hide-arrow');
			if (self.arrowsContainer) {
				self.arrowsContainer.classList.remove('is-visible');
			}
			self.isAnimating = false;
		}, this.transitionSpeed);
	};

	HeroSlider.prototype.update = function (animate) {
		var slidesToShow = this.getSlidesToShow();
		var offset = this.current * (100 / slidesToShow);

		this.track.style.transitionDuration = animate ? this.transitionSpeed + 'ms' : '0ms';
		this.track.style.transform = 'translate3d(-' + offset + '%, 0, 0)';

		this.items.forEach(function (item, index) {
			item.classList.toggle('is-current', index === this.current);
		}, this);

		this.images.forEach(function (image, index) {
			image.classList.toggle('is-active', index === this.current);
		}, this);

		this.newsSlider.setAttribute('data-slides-to-show', slidesToShow);
	};

	document.addEventListener('DOMContentLoaded', function () {
		var newsSlider = document.getElementById('hero-news-slider');
		var imageSlider = document.getElementById('hero-image-slider');

		if (newsSlider) {
			new HeroSlider(newsSlider, imageSlider);
		}
	});
})();
