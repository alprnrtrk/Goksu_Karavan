(() => {
  const hasMediaLibrary = typeof wp !== 'undefined' && wp.media;

  const initMediaPicker = (picker) => {
    if (!hasMediaLibrary) {
      return;
    }

    const previewWrapper = picker.querySelector('.auriel-media-picker__preview');
    const input = picker.querySelector('[data-auriel-media-input]');
    const selectBtn = picker.querySelector('[data-auriel-media-select]');
    const clearBtn = picker.querySelector('[data-auriel-media-clear]');

    if (!previewWrapper || !input || !selectBtn || !clearBtn) {
      return;
    }

    const placeholderText =
      picker.querySelector('.auriel-media-picker__placeholder')?.textContent ||
      previewWrapper.dataset.placeholder ||
      'No image selected';

    const renderPlaceholder = () => {
      previewWrapper.innerHTML = `<div class="auriel-media-picker__placeholder">${placeholderText}</div>`;
      clearBtn.setAttribute('disabled', 'disabled');
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

      previewWrapper.innerHTML = `<img src="${source}" alt="${alt}" class="auriel-media-preview" />`;
      clearBtn.removeAttribute('disabled');
    };

    let frame = null;

    const openMediaFrame = () => {
      if (frame) {
        frame.open();
        return;
      }

      frame = wp.media({
        title: selectBtn.getAttribute('data-modal-title') || selectBtn.textContent || '',
        button: {
          text: selectBtn.getAttribute('data-modal-button') || selectBtn.textContent || '',
        },
        library: {
          type: ['image'],
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

    const populateExisting = () => {
      const current = parseInt(input.value, 10);
      if (!current || !hasMediaLibrary || !wp.media.attachment) {
        renderPlaceholder();
        return;
      }

      const attachment = wp.media.attachment(current);
      if (!attachment) {
        renderPlaceholder();
        return;
      }

      attachment.fetch().then(() => {
        updatePreview(attachment.toJSON());
      });
    };

    selectBtn.addEventListener('click', (event) => {
      event.preventDefault();
      openMediaFrame();
    });

    clearBtn.addEventListener('click', (event) => {
      event.preventDefault();
      input.value = '';
      renderPlaceholder();
    });

    populateExisting();
  };

  document
    .querySelectorAll('[data-auriel-media-picker]')
    .forEach((picker) => initMediaPicker(picker));

  const placeholderMarkup = (wrapper) => {
    const text = wrapper.getAttribute('data-placeholder-text') || 'No image selected';
    return `<div class="auriel-repeater-card__image-placeholder">${text}</div>`;
  };

  document.querySelectorAll('[data-auriel-repeater]').forEach((container) => {
    const list = container.querySelector('[data-auriel-repeater-list]');
    const addButton = container.querySelector('[data-auriel-repeater-add]');
    const templateId = container.getAttribute('data-repeater-template');
    const fieldPrefix = container.getAttribute('data-field-prefix') || '';

    if (!list || !addButton || !templateId || !fieldPrefix) {
      return;
    }

    const template = document.getElementById(templateId);
    if (!template) {
      return;
    }

    const updateFieldNames = () => {
      const cards = list.querySelectorAll('[data-auriel-repeater-card]');
      cards.forEach((card, index) => {
        card.setAttribute('data-index', String(index));

        const updateLabelFor = (oldId, newId) => {
          if (!oldId || !newId || oldId === newId) {
            return;
          }
          card
            .querySelectorAll(`label[for="${oldId}"]`)
            .forEach((label) => label.setAttribute('for', newId));
        };

        const replaceIndexToken = (input) => {
          const name = input.getAttribute('name');
          if (!name || !name.startsWith(fieldPrefix)) {
            return;
          }
          const remainder = name.substring(fieldPrefix.length);
          const updatedRemainder = remainder.replace(/\[(?:__index__|\d+)\]/, `[${index}]`);
          input.setAttribute('name', `${fieldPrefix}${updatedRemainder}`);

          const id = input.getAttribute('id');
          if (id) {
            const newId = id.replace(/(__index__|\d+)/, String(index));
            updateLabelFor(id, newId);
            input.setAttribute('id', newId);
          }
        };

        const fields = card.querySelectorAll('input[name], textarea[name]');
        fields.forEach((field) => {
          replaceIndexToken(field);
        });
      });
    };

    const addCard = () => {
      const fragment = template.content.cloneNode(true);
      const card = fragment.querySelector('[data-auriel-repeater-card]');
      if (!card) {
        return;
      }
      list.appendChild(card);
      updateFieldNames();
    };

    const moveCard = (card, direction) => {
      const sibling = direction < 0 ? card.previousElementSibling : card.nextElementSibling;
      if (!sibling) {
        return;
      }
      if (direction < 0) {
        list.insertBefore(card, sibling);
      } else {
        list.insertBefore(sibling, card);
      }
      updateFieldNames();
    };

    const removeCard = (card) => {
      card.remove();
      updateFieldNames();
    };

    const setImage = (card, attachment) => {
      const previewWrapper = card.querySelector('[data-auriel-repeater-image-preview]');
      const input = card.querySelector('[data-auriel-repeater-image-id]');
      if (!previewWrapper || !input) {
        return;
      }
      const imageMarkup = `<img src="${attachment.url}" alt="${attachment.alt || ''}" class="auriel-repeater-card__image-preview" />`;
      previewWrapper.innerHTML = imageMarkup;
      input.value = attachment.id;
    };

    const clearImage = (card) => {
      const previewWrapper = card.querySelector('[data-auriel-repeater-image-preview]');
      const input = card.querySelector('[data-auriel-repeater-image-id]');
      if (!previewWrapper || !input) {
        return;
      }
      previewWrapper.innerHTML = placeholderMarkup(previewWrapper);
      input.value = '';
    };

    addButton.addEventListener('click', (event) => {
      event.preventDefault();
      addCard();
    });

    list.addEventListener('click', (event) => {
      const removeBtn = event.target.closest('[data-auriel-repeater-remove]');
      if (removeBtn) {
        event.preventDefault();
        const card = removeBtn.closest('[data-auriel-repeater-card]');
        if (card) {
          removeCard(card);
        }
        return;
      }

      const moveUpBtn = event.target.closest('[data-auriel-repeater-move-up]');
      if (moveUpBtn) {
        event.preventDefault();
        const card = moveUpBtn.closest('[data-auriel-repeater-card]');
        if (card) {
          moveCard(card, -1);
        }
        return;
      }

      const moveDownBtn = event.target.closest('[data-auriel-repeater-move-down]');
      if (moveDownBtn) {
        event.preventDefault();
        const card = moveDownBtn.closest('[data-auriel-repeater-card]');
        if (card) {
          moveCard(card, 1);
        }
        return;
      }

      const selectBtn = event.target.closest('[data-auriel-repeater-select-image]');
      if (selectBtn && hasMediaLibrary) {
        event.preventDefault();
        const card = selectBtn.closest('[data-auriel-repeater-card]');
        if (!card) {
          return;
        }
        const frame = wp.media({
          title: selectBtn.getAttribute('data-modal-title') || 'Select image',
          multiple: false,
          library: {
            type: ['image'],
          },
        });

        frame.on('select', () => {
          const attachment = frame.state().get('selection').first().toJSON();
          setImage(card, attachment);
        });

        frame.open();
        return;
      }

      const clearBtn = event.target.closest('[data-auriel-repeater-clear-image]');
      if (clearBtn) {
        event.preventDefault();
        const card = clearBtn.closest('[data-auriel-repeater-card]');
        if (card) {
          clearImage(card);
        }
      }
    });

    updateFieldNames();
  });
})();
