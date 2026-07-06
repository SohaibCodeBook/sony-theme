/**
 * Career / Jobs page interactions.
 */
(function () {
	'use strict';

	function CareerPage() {
		this.filterToggle = document.getElementById('career-filter-toggle');
		this.filterCategories = document.getElementById('career-filter-categories');
		this.searchInput = document.getElementById('search-jobs');
		this.jobList = document.getElementById('career-job-list');
		this.jobItems = this.jobList ? this.jobList.querySelectorAll('.item') : [];
		this.missionBall = document.getElementById('mission-ball');
		this.missionModal = document.getElementById('mission-modal');
		this.missionBackdrop = document.getElementById('mission-modal-backdrop');
		this.missionClose = document.getElementById('mission-modal-close');
		this.activeFilters = {
			departments: [],
			location: [],
			type: []
		};

		this.bindEvents();
	}

	CareerPage.prototype.bindEvents = function () {
		var self = this;

		if (this.filterToggle) {
			this.filterToggle.addEventListener('click', function (e) {
				e.preventDefault();
				self.toggleFilterPanel();
			});
		}

		if (this.filterCategories) {
			this.filterCategories.querySelectorAll('.has-child').forEach(function (link) {
				link.addEventListener('click', function (e) {
					e.preventDefault();
					self.toggleFilterGroup(link.getAttribute('data-id'));
				});
			});

			this.filterCategories.querySelectorAll('.filter-categories__children a').forEach(function (link) {
				link.addEventListener('click', function (e) {
					e.preventDefault();
					self.toggleFilterValue(link);
				});
			});
		}

		if (this.searchInput) {
			this.searchInput.addEventListener('input', function () {
				self.applyFilters();
			});
		}

		if (this.missionBall) {
			this.missionBall.addEventListener('click', function (e) {
				e.preventDefault();
				self.openMissionModal();
			});
		}

		if (this.missionClose) {
			this.missionClose.addEventListener('click', function (e) {
				e.preventDefault();
				self.closeMissionModal();
			});
		}

		if (this.missionBackdrop) {
			this.missionBackdrop.addEventListener('click', function () {
				self.closeMissionModal();
			});
		}

		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') {
				self.closeMissionModal();
			}
		});
	};

	CareerPage.prototype.toggleFilterPanel = function () {
		if (!this.filterCategories || !this.filterToggle) {
			return;
		}

		var isOpen = this.filterCategories.classList.toggle('is-open');
		this.filterToggle.classList.toggle('is-open', isOpen);
		this.filterToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
		var icon = this.filterToggle.querySelector('i');
		if (icon) {
			icon.classList.toggle('is-open', isOpen);
		}
	};

	CareerPage.prototype.toggleFilterGroup = function (groupId) {
		var panel = document.getElementById('children-' + groupId);
		if (!panel) {
			return;
		}
		panel.classList.toggle('is-open');
	};

	CareerPage.prototype.toggleFilterValue = function (link) {
		var group = link.getAttribute('data-filter-group');
		var value = link.getAttribute('data-id');

		if (!group || !value || !this.activeFilters[group]) {
			return;
		}

		link.classList.toggle('is-active');
		var index = this.activeFilters[group].indexOf(value);

		if (index === -1) {
			this.activeFilters[group].push(value);
		} else {
			this.activeFilters[group].splice(index, 1);
		}

		this.applyFilters();
	};

	CareerPage.prototype.applyFilters = function () {
		var query = this.searchInput ? this.searchInput.value.trim().toLowerCase() : '';

		this.jobItems.forEach(function (item) {
			var title = item.textContent.toLowerCase();
			var departments = (item.getAttribute('data-departments') || '').split(/\s+/).filter(Boolean);
			var type = item.getAttribute('data-type') || '';
			var location = item.getAttribute('data-location') || '';
			var visible = true;

			if (query && title.indexOf(query) === -1) {
				visible = false;
			}

			if (visible && this.activeFilters.departments.length) {
				visible = departments.some(function (dept) {
					return this.activeFilters.departments.indexOf(dept) !== -1;
				}, this);
			}

			if (visible && this.activeFilters.type.length) {
				visible = this.activeFilters.type.indexOf(type) !== -1;
			}

			if (visible && this.activeFilters.location.length) {
				visible = this.activeFilters.location.indexOf(location) !== -1;
			}

			item.classList.toggle('is-hidden', !visible);
		}, this);
	};

	CareerPage.prototype.openMissionModal = function () {
		if (!this.missionModal || !this.missionBackdrop) {
			return;
		}
		this.missionModal.hidden = false;
		this.missionBackdrop.hidden = false;
		document.body.classList.add('mission-modal-open');
	};

	CareerPage.prototype.closeMissionModal = function () {
		if (!this.missionModal || !this.missionBackdrop) {
			return;
		}
		this.missionModal.hidden = true;
		this.missionBackdrop.hidden = true;
		document.body.classList.remove('mission-modal-open');
	};

	document.addEventListener('DOMContentLoaded', function () {
		if (document.querySelector('.jobs-container')) {
			new CareerPage();
		}
	});
})();
