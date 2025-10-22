(function () {
	const escapeAttr = (value) =>
		String(value || '')
			.replace(/&/g, '&amp;')
			.replace(/"/g, '&quot;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;')
			.replace(/'/g, '&#039;');

	const escapeHtml = (value) =>
		String(value || '')
			.replace(/&/g, '&amp;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;')
			.replace(/'/g, '&#039;');

	const initMediaField = (field) => {
		const input = field.querySelector('input[type="hidden"]');
		const preview = field.querySelector('[data-preview]');
		const selectBtn = field.querySelector('[data-action="select"]');
		const clearBtn = field.querySelector('[data-action="clear"]');

		if (!input || !preview || !selectBtn) {
			return;
		}

		const placeholderText = preview.dataset.placeholder || '';

		const renderPlaceholder = () => {
			preview.innerHTML = placeholderText
				? `<span class="auriel-media-placeholder">${escapeHtml(placeholderText)}</span>`
				: '';
			field.classList.remove('has-image');
			if (clearBtn) {
				clearBtn.setAttribute('disabled', 'disabled');
			}
		};

		const updatePreview = (attachment) => {
			if (!attachment) {
				renderPlaceholder();
				return;
			}

			const source =
				(attachment.sizes && attachment.sizes.medium && attachment.sizes.medium.url) ||
				attachment.url;

			const alt = attachment.alt || '';

			preview.innerHTML = `<img src="${escapeAttr(source)}" alt="${escapeAttr(alt)}" />`;
			field.classList.add('has-image');
			if (clearBtn) {
				clearBtn.removeAttribute('disabled');
			}
		};

		const populateExisting = () => {
			const currentId = parseInt(input.value, 10);
			if (!currentId || !wp.media || !wp.media.attachment) {
				return;
			}

			const attachment = wp.media.attachment(currentId);
			if (!attachment) {
				return;
			}

			attachment.fetch().then(() => {
				updatePreview(attachment.toJSON());
			});
		};

		let frame = null;

		const openFrame = () => {
			if (frame) {
				frame.open();
				return;
			}

			frame = wp.media({
				title: selectBtn.dataset.modalTitle || '',
				button: {
					text: selectBtn.dataset.modalButton || '',
				},
				library: {
					type: 'image',
				},
				multiple: false,
			});

			frame.on('select', () => {
				const attachment = frame.state().get('selection').first().toJSON();
				input.value = attachment.id;
				updatePreview(attachment);
			});

			frame.open();
		};

		selectBtn.addEventListener('click', (event) => {
			event.preventDefault();
			openFrame();
		});

		if (clearBtn) {
			clearBtn.addEventListener('click', (event) => {
				event.preventDefault();
				input.value = '';
				renderPlaceholder();
			});
		}

		renderPlaceholder();
		populateExisting();
	};

	const bootMediaFields = () => {
		if (typeof wp === 'undefined' || !wp.media) {
			return;
		}

		document
			.querySelectorAll('[data-auriel-media-field]')
			.forEach((field) => initMediaField(field));
	};

	document.addEventListener('DOMContentLoaded', bootMediaFields);
})();
