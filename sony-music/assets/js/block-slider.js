/**
 * Generic block slider — synced text, pagination, and image tracks.
 */
(function () {
	'use strict';

	function BlockSlider(root) {
		this.root = root;
		this.sliderId = root.getAttribute('data-slider-id');
		this.speed = parseInt(root.getAttribute('data-speed'), 10) || 1500;
		this.textTrack = root.querySelector('#slider-text-' + this.sliderId + ' .slider-track');
		this.pageTrack = root.querySelector('#slider-page-' + this.sliderId + ' .slider-track');
		this.imageTrack = root.querySelector('#slider-image-' + this.sliderId + ' .slider-track');
		this.textItems = root.querySelectorAll('#slider-text-' + this.sliderId + ' .slide-item');
		this.nextBtn = root.querySelector('.btn-next');
		this.videoWrapper = document.getElementById('slider-video-wrapper-' + this.sliderId);
		this.current = 0;
		this.total = this.textItems.length;
		this.isAnimating = false;

		if (!this.textTrack || this.total < 1) {
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
			item.addEventListener('click', function (e) {
				if (e.target.closest('.slide-btn')) {
					return;
				}
				self.goTo(index);
			});
		});

		var imageItems = this.root.querySelectorAll('#slider-image-' + this.sliderId + ' .slide-item');
		imageItems.forEach(function (item) {
			item.addEventListener('click', function () {
				self.next();
			});
		});

		var playButtons = this.root.querySelectorAll('.slide-btn a[data-type="video"]');
		playButtons.forEach(function (btn) {
			btn.addEventListener('click', function (e) {
				e.preventDefault();
				e.stopPropagation();
				self.openVideo(btn.getAttribute('href'));
			});
		});

		if (this.videoWrapper) {
			var closeBtn = this.videoWrapper.querySelector('.video-close');
			if (closeBtn) {
				closeBtn.addEventListener('click', function (e) {
					e.preventDefault();
					self.closeVideo();
				});
			}
		}
	};

	BlockSlider.prototype.openVideo = function (url) {
		if (!this.videoWrapper || !url) {
			return;
		}

		var videoInner = this.videoWrapper.querySelector('.video-wrapper');
		if (!videoInner) {
			return;
		}

		videoInner.innerHTML =
			'<iframe src="' + url + '" title="Video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';

		this.videoWrapper.style.display = 'block';
		this.root.style.display = 'none';
	};

	BlockSlider.prototype.closeVideo = function () {
		if (!this.videoWrapper) {
			return;
		}

		var videoInner = this.videoWrapper.querySelector('.video-wrapper');
		if (videoInner) {
			videoInner.innerHTML = '';
		}

		this.videoWrapper.style.display = 'none';
		this.root.style.display = '';
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
		document.querySelectorAll('.block-slider[data-slider-id]').forEach(function (root) {
			new BlockSlider(root);
		});
	});
})();
