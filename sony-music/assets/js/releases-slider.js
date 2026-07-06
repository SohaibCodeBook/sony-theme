/**
 * New Releases block slider — vanilla JS synced slider.
 */
(function () {
	'use strict';

	function BlockSlider(root) {
		this.root = root;
		this.speed = parseInt(root.getAttribute('data-speed'), 10) || 1500;
		this.textTrack = root.querySelector('#slider-text-releases .slider-track');
		this.pageTrack = root.querySelector('#slider-page-releases .slider-track');
		this.imageTrack = root.querySelector('#slider-image-releases .slider-track');
		this.textItems = root.querySelectorAll('#slider-text-releases .slide-item');
		this.nextBtn = root.querySelector('.btn-next');
		this.current = 0;
		this.total = this.textItems.length;
		this.isAnimating = false;

		if (!this.textTrack || this.total < 2) {
			return;
		}

		[this.textTrack, this.pageTrack, this.imageTrack].forEach(function (track) {
			if (track) {
				track.style.transitionDuration = this.speed + 'ms';
			}
		}, this);

		this.bindEvents();
		this.update(false);
	}

	BlockSlider.prototype.bindEvents = function () {
		var self = this;

		if (this.nextBtn) {
			this.nextBtn.addEventListener('click', function (e) {
				e.preventDefault();
				self.next();
			});
		}

		this.textItems.forEach(function (item, index) {
			item.addEventListener('click', function () {
				self.goTo(index);
			});
		});

		var imageItems = this.root.querySelectorAll('#slider-image-releases .slide-item');
		imageItems.forEach(function (item) {
			item.addEventListener('click', function () {
				self.next();
			});
		});
	};

	BlockSlider.prototype.next = function () {
		this.goTo((this.current + 1) % this.total);
	};

	BlockSlider.prototype.goTo = function (index) {
		if (this.isAnimating || index === this.current) {
			return;
		}

		this.isAnimating = true;
		this.current = index;
		this.update(true);

		var self = this;
		window.setTimeout(function () {
			self.isAnimating = false;
		}, this.speed);
	};

	BlockSlider.prototype.update = function (animate) {
		var offset = -(this.current * 100) + '%';
		var transition = animate ? this.speed + 'ms' : '0ms';

		[this.textTrack, this.pageTrack, this.imageTrack].forEach(function (track) {
			if (!track) {
				return;
			}
			track.style.transitionDuration = transition;
			track.style.transform = 'translate3d(' + offset + ', 0, 0)';
		});
	};

	document.addEventListener('DOMContentLoaded', function () {
		var block = document.getElementById('block-slider-releases');
		if (block) {
			new BlockSlider(block);
		}
	});
})();
